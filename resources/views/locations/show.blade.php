<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $location->name }}
            </h2>

            @can('update', $location)
            <div class="flex gap-2 shrink-0">
                <a href="{{ route('locations.edit', $location) }}"
                    class="inline-flex items-center px-3 py-1.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md text-xs font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-50 transition">
                    Modifier
                </a>
                <form action="{{ route('locations.destroy', $location) }}" method="POST"
                        onsubmit="return confirm('Supprimer ce lieu ?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center px-3 py-1.5 bg-red-600 border border-transparent rounded-md text-xs font-semibold text-white hover:bg-red-500 transition">
                        Supprimer
                    </button>
                </form>
            </div>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 bg-green-100 dark:bg-green-900 border border-green-400 text-green-800 dark:text-green-200 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            
            @if (session('error'))
                <div class="p-4 bg-red-100 dark:bg-red-900 border border-red-400 text-red-800 dark:text-red-200 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-5">

                {{-- Breadcrumb --}}
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    <a href="{{ route('films.index') }}" class="hover:underline">Films</a>
                    <span class="mx-1">›</span>
                    <a href="{{ route('films.show', $location->film) }}" class="hover:underline">{{ $location->film->title }}</a>
                    <span class="mx-1">›</span>
                    <span>{{ $location->name }}</span>
                </div>

                {{-- Localisation --}}
                <div class="flex items-center gap-3">
                    <span class="text-2xl">📍</span>
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-gray-100 text-lg">{{ $location->name }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $location->city }}, {{ $location->country }}</p>
                    </div>
                </div>

                {{-- Description --}}
                <div>
                    <h3 class="font-medium text-gray-800 dark:text-gray-200 mb-1">Description</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">{{ $location->description }}</p>
                </div>

                {{-- Meta --}}
                <div class="flex items-center justify-between border-t border-gray-100 dark:border-gray-700 pt-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Ajouté par <span class="font-medium text-gray-700 dark:text-gray-300">{{ $location->user->name ?? 'Inconnu' }}</span>
                        · {{ $location->created_at->diffForHumans() }}
                    </p>

                    {{-- Upvote --}}
                    <form action="{{ route('locations.upvote', $location) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-50 dark:bg-indigo-900/50 hover:bg-indigo-100 dark:hover:bg-indigo-900 border border-indigo-200 dark:border-indigo-800 text-indigo-700 dark:text-indigo-300 font-semibold rounded-lg transition text-sm">
                            ▲ {{ $location->upvotes_count }} upvote{{ $location->upvotes_count !== 1 ? 's' : '' }}
                        </button>
                    </form>
                </div>

            </div>

            <div>
                <a href="{{ route('films.show', $location->film) }}"
                   class="text-sm text-gray-500 dark:text-gray-400 hover:underline">
                    ← Retour à {{ $location->film->title }}
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
