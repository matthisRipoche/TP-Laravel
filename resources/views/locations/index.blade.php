<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Lieux de tournage
            </h2>
            @auth
                <a href="{{ route('locations.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 transition">
                    + Ajouter un lieu
                </a>
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 bg-green-100 dark:bg-green-900 border border-green-400 text-green-800 dark:text-green-200 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Filtre par film --}}
            <form method="GET" action="{{ route('locations.index') }}" class="flex items-center gap-3">
                <label for="film_id" class="text-sm font-medium text-gray-700 dark:text-gray-300">Filtrer par film :</label>
                <select id="film_id" name="film_id"
                        onchange="this.form.submit()"
                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                    <option value="">— Tous —</option>
                    @foreach ($films as $film)
                        <option value="{{ $film->id }}" @selected(request('film_id') == $film->id)>
                            {{ $film->title }} ({{ $film->release_year }})
                        </option>
                    @endforeach
                </select>
                @if (request('film_id'))
                    <a href="{{ route('locations.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:underline">
                        Réinitialiser
                    </a>
                @endif
            </form>

            {{-- Liste --}}
            @if ($locations->isEmpty())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center text-gray-500 dark:text-gray-400">
                    Aucun lieu trouvé.
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($locations as $location)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col">
                            <div class="p-5 flex-1">
                                <div class="flex items-start justify-between gap-2 mb-1">
                                    <p class="font-bold text-gray-900 dark:text-gray-100">{{ $location->name }}</p>
                                    <span class="flex items-center gap-1 text-xs text-indigo-600 dark:text-indigo-400 font-semibold shrink-0">
                                        ▲ {{ $location->upvotes_count }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                                    {{ $location->city }}, {{ $location->country }}
                                </p>
                                <a href="{{ route('films.show', $location->film) }}"
                                   class="inline-block mb-3 text-xs bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300 rounded-full px-2 py-0.5 hover:underline">
                                    {{ $location->film->title }}
                                </a>
                                <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                                    {{ $location->description }}
                                </p>
                            </div>
                            <div class="px-5 pb-4 flex items-center justify-between border-t border-gray-100 dark:border-gray-700 pt-3">
                                <p class="text-xs text-gray-400 dark:text-gray-500">par {{ $location->user->name ?? 'Inconnu' }}</p>
                                <a href="{{ route('locations.show', $location) }}"
                                   class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                                    Voir →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $locations->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
