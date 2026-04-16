<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ajouter un film') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <form action="{{ route('films.store') }}" method="POST" class="space-y-6">
                        @csrf

                        {{-- Titre --}}
                        <div>
                            <x-input-label for="title" :value="__('Titre')" />
                            <x-text-input id="title" name="title" type="text"
                                          class="mt-1 block w-full"
                                          :value="old('title')" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        {{-- Année de sortie --}}
                        <div>
                            <x-input-label for="release_year" :value="__('Année de sortie')" />
                            <x-text-input id="release_year" name="release_year" type="number"
                                          class="mt-1 block w-full"
                                          :value="old('release_year')"
                                          min="1888" :max="date('Y') + 5" required />
                            <x-input-error :messages="$errors->get('release_year')" class="mt-2" />
                        </div>

                        {{-- Synopsis --}}
                        <div>
                            <x-input-label for="synopsis" :value="__('Synopsis')" />
                            <textarea id="synopsis" name="synopsis" rows="5"
                                      class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                      required>{{ old('synopsis') }}</textarea>
                            <x-input-error :messages="$errors->get('synopsis')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>Enregistrer</x-primary-button>
                            <a href="{{ route('films.index') }}"
                               class="text-sm text-gray-600 dark:text-gray-400 hover:underline">
                                Annuler
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
