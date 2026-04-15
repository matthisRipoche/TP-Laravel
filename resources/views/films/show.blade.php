<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $film->title }}
                    <span class="ml-2 text-sm font-normal text-gray-500 dark:text-gray-400">
                        ({{ $film->release_year }})
                    </span>
                </h2>
            </div>
            <div class="flex gap-2 shrink-0">
                @auth
                    <a href="{{ route('films.edit', $film) }}"
                       class="inline-flex items-center px-3 py-1.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md text-xs font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-50 transition">
                        Modifier
                    </a>
                    <form action="{{ route('films.destroy', $film) }}" method="POST"
                          onsubmit="return confirm('Supprimer ce film et tous ses lieux ?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center px-3 py-1.5 bg-red-600 border border-transparent rounded-md text-xs font-semibold text-white hover:bg-red-500 transition">
                            Supprimer
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if (session('success'))
                <div class="p-4 bg-green-100 dark:bg-green-900 border border-green-400 text-green-800 dark:text-green-200 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Synopsis --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Synopsis</h3>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">{{ $film->synopsis }}</p>
            </div>

            {{-- Lieux de tournage --}}
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200">
                        Lieux de tournage
                        <span class="ml-1 text-sm font-normal text-gray-500">({{ $film->locations->count() }})</span>
                    </h3>
                    @auth
                        <a href="{{ route('locations.create', ['film_id' => $film->id]) }}"
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 transition">
                            + Ajouter un lieu
                        </a>
                    @endauth
                </div>

                @if ($film->locations->isEmpty())
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center text-gray-500 dark:text-gray-400">
                        Aucun lieu de tournage renseigné pour ce film.
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($film->locations as $location)
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-5 flex flex-col gap-2">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $location->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $location->city }}, {{ $location->country }}
                                        </p>
                                    </div>
                                    <span class="flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400">
                                        ▲ {{ $location->upvotes_count }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                                    {{ $location->description }}
                                </p>
                                <div class="flex items-center justify-between mt-auto pt-2 border-t border-gray-100 dark:border-gray-700">
                                    <p class="text-xs text-gray-400 dark:text-gray-500">
                                        par {{ $location->user->name ?? 'Inconnu' }}
                                    </p>
                                    <a href="{{ route('locations.show', $location) }}"
                                       class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                                        Voir →
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div>
                <a href="{{ route('films.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:underline">
                    ← Retour aux films
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
