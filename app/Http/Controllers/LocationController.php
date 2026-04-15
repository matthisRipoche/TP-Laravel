<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LocationController extends Controller
{
    /**
     * Liste tous les lieux (optionnellement filtrés par film).
     */
    public function index(Request $request): View
    {
        $locations = Location::with('film', 'user')
            ->when($request->film_id, fn ($q) => $q->where('film_id', $request->film_id))
            ->latest()
            ->paginate(12);

        $films = Film::orderBy('title')->get();

        return view('locations.index', compact('locations', 'films'));
    }

    /**
     * Affiche le formulaire de création.
     */
    public function create(Request $request): View
    {
        $films = Film::orderBy('title')->get();
        $selectedFilm = $request->film_id ? Film::find($request->film_id) : null;

        return view('locations.create', compact('films', 'selectedFilm'));
    }

    /**
     * Enregistre un nouveau lieu.
     */
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

    /**
     * Affiche le détail d'un lieu.
     */
    public function show(Location $location): View
    {
        $location->load('film', 'user');

        return view('locations.show', compact('location'));
    }

    /**
     * Affiche le formulaire d'édition.
     */
    public function edit(Location $location): View
    {
        $this->authorize('update', $location);

        $films = Film::orderBy('title')->get();

        return view('locations.edit', compact('location', 'films'));
    }

    /**
     * Met à jour un lieu.
     */
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

    /**
     * Supprime un lieu.
     */
    public function destroy(Location $location): RedirectResponse
    {
        $this->authorize('delete', $location);

        $filmId = $location->film_id;
        $location->delete();

        return redirect()
            ->route('films.show', $filmId)
            ->with('success', 'Lieu supprimé avec succès.');
    }

    /**
     * Upvote un lieu (+1).
     */
    public function upvote(Location $location): RedirectResponse
    {
        $location->increment('upvotes_count');

        return back()->with('success', 'Upvote enregistré !');
    }
}
