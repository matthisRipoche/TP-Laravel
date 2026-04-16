<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Location;
use App\Models\Upvote;
use App\Jobs\UpdateLocationUpvotes;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Illuminate\Auth\Access\AuthorizationException;

class LocationController extends Controller
{
    public function index(Request $request): View
    {
        $locations = Location::with('film', 'user')
            ->when($request->film_id, fn ($q) => $q->where('film_id', $request->film_id))
            ->latest()
            ->paginate(12);

        $films = Film::orderBy('title')->get();

        return view('locations.index', compact('locations', 'films'));
    }

    public function create(Request $request): View
    {
        $this->authorize('create', Location::class);

        $films = Film::orderBy('title')->get();
        $selectedFilm = $request->film_id ? Film::find($request->film_id) : null;

        return view('locations.create', compact('films', 'selectedFilm'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'film_id'     => ['required', 'exists:films,id'],
            'name'        => ['required', 'string', 'max:255'],
            'city'        => ['required', 'string', 'max:255'],
            'country'     => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        $validated['user_id'] = Auth::id();
        $validated['upvotes_count'] = 0;

        $location = Location::create($validated);

        return redirect()
            ->route('locations.show', $location)
            ->with('success', 'Lieu ajouté avec succès.');
    }

    public function show(Location $location): View
    {
        $location->load('film', 'user');

        return view('locations.show', compact('location'));
    }

    public function edit(Location $location): View
    {
        $this->authorize('update', $location);

        $films = Film::orderBy('title')->get();

        return view('locations.edit', compact('location', 'films'));
    }

    public function update(Request $request, Location $location): RedirectResponse
    {
        $this->authorize('update', $location);

        $validated = $request->validate([
            'film_id'     => ['required', 'exists:films,id'],
            'name'        => ['required', 'string', 'max:255'],
            'city'        => ['required', 'string', 'max:255'],
            'country'     => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        $location->update($validated);

        return redirect()
            ->route('locations.show', $location)
            ->with('success', 'Lieu mis à jour avec succès.');
    }

    public function destroy(Location $location): RedirectResponse
    {
        $this->authorize('delete', $location);

        $filmId = $location->film_id;
        $location->delete();

        return redirect()
            ->route('films.show', $filmId)
            ->with('success', 'Lieu supprimé avec succès.');
    }

    public function upvote(Location $location): RedirectResponse 
    {
        // On vérifie si l'utilisateur connecté a deja voté pour ce 
        $alreadyVoted = Upvote::where('user_id', Auth::id())
            ->where('location_id', $location->id)
            ->exists();

        // Si oui on redirige avec le message d'erreur
        if ($alreadyVoted) {
            return redirect()
                ->route('locations.show', $location)
                ->with('error', 'Vous avez déjà voté pour ce lieu.');
        }

        // Sinon on enregistre le vote avec un message de succès
        Upvote::create([
            'user_id'     => Auth::id(),
            'location_id' => $location->id,
        ]);

        UpdateLocationUpvotes::dispatch($location);

        return redirect()
            ->route('locations.show', $location)
          ->with('success', 'Vote enregistré !');

    }
}
