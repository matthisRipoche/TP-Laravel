<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FilmController extends Controller
{
    public function index(): View
    {
        $films = Film::latest()->paginate(12);

        return view('films.index', compact('films'));
    }

    public function create(): View
    {
        return view('films.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'release_year' => ['required', 'integer', 'min:1888', 'max:' . (date('Y') + 5)],
            'synopsis'     => ['required', 'string'],
        ]);

        $film = Film::create($validated);

        return redirect()
            ->route('films.show', $film)
            ->with('success', 'Film ajouté avec succès.');
    }

    public function show(Film $film): View
    {
        $film->load('locations.user');

        return view('films.show', compact('film'));
    }

    public function edit(Film $film): View
    {
        return view('films.edit', compact('film'));
    }

    public function update(Request $request, Film $film): RedirectResponse
    {
        $validated = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'release_year' => ['required', 'integer', 'min:1888', 'max:' . (date('Y') + 5)],
            'synopsis'     => ['required', 'string'],
        ]);

        $film->update($validated);

        return redirect()
            ->route('films.show', $film)
            ->with('success', 'Film mis à jour avec succès.');
    }

    public function destroy(Film $film): RedirectResponse
    {
        $film->delete();

        return redirect()
            ->route('films.index')
            ->with('success', 'Film supprimé avec succès.');
    }
}
