<?php

namespace App\Http\Controllers;

use App\Models\Film;

class FilmLocationController extends Controller
{
    public function index(Film $film)
    {
        return response()->json([
            'film' => [
                'id'           => $film->id,
                'title'        => $film->title,
                'release_year' => $film->release_year,
                'synopsis'     => $film->synopsis,
            ],
            'locations' => $film->locations->map(fn($location) => [
                'id'          => $location->id,
                'name'        => $location->name,
                'city'        => $location->city,
                'country'     => $location->country,
                'description' => $location->description,
                'upvotes'     => $location->upvotes_count,
            ]),
        ]);
    }
}
