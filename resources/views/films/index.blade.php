<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Films') }}
            </h2>
            <a href="{{ route('films.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 transition ease-in-out duration-150">
                + Ajouter un film
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 dark:bg-green-900 border border-green-400 text-green-800 dark:text-green-200 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if ($films->isEmpty())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center text-gray-500 dark:text-gray-400">
                    Aucun film pour le moment.
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($films as $film)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col">
                            <div class="p-6 flex-1">
                                <div class="flex items-start justify-between gap-2">
                                    <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100 leading-snug">
                                        {{ $film->title }}
                                    </h3>
                                    <span class="shrink-0 text-xs font-semibold bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300 rounded-full px-2 py-0.5">
                                        {{ $film->release_year }}
                                    </span>
                                </div>
                                <p class="mt-3 text-sm text-gray-600 dark:text-gray-400 line-clamp-3">
                                    {{ $film->synopsis }}
                                </p>
                            </div>
                            <div class="px-6 pb-5 flex items-center justify-between">
                                <a href="{{ route('films.show', $film) }}"
                                   class="text-indigo-600 dark:text-indigo-400 text-sm font-medium hover:underline">
                                    Voir les lieux →
                                </a>

                                @if(Auth::user()->is_admin)
                                <div class="flex gap-2">
                                    <a href="{{ route('films.edit', $film) }}"
                                        class="text-xs text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                                        Modifier
                                    </a>
                                    <form action="{{ route('films.destroy', $film) }}" method="POST"
                                            onsubmit="return confirm('Supprimer ce film ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="text-xs text-red-500 hover:text-red-700">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $films->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
