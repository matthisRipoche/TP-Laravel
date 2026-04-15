<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Modifier le lieu « {{ $location->name }} »
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <form action="{{ route('locations.update', $location) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        {{-- Film --}}
                        <div>
                            <x-input-label for="film_id" :value="__('Film')" />
                            <select id="film_id" name="film_id" required
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 rounded-md shadow-sm">
                                @foreach ($films as $film)
                                    <option value="{{ $film->id }}"
                                        @selected(old('film_id', $location->film_id) == $film->id)>
                                        {{ $film->title }} ({{ $film->release_year }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('film_id')" class="mt-2" />
                        </div>

                        {{-- Nom --}}
                        <div>
                            <x-input-label for="name" :value="__('Nom du lieu')" />
                            <x-text-input id="name" name="name" type="text"
                                          class="mt-1 block w-full"
                                          :value="old('name', $location->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- Ville + Pays --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="city" :value="__('Ville')" />
                                <x-text-input id="city" name="city" type="text"
                                              class="mt-1 block w-full"
                                              :value="old('city', $location->city)" required />
                                <x-input-error :messages="$errors->get('city')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="country" :value="__('Pays')" />
                                <x-text-input id="country" name="country" type="text"
                                              class="mt-1 block w-full"
                                              :value="old('country', $location->country)" required />
                                <x-input-error :messages="$errors->get('country')" class="mt-2" />
                            </div>
                        </div>

                        {{-- Description --}}
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="4"
                                      class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                      required>{{ old('description', $location->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>Mettre à jour</x-primary-button>
                            <a href="{{ route('locations.show', $location) }}"
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
