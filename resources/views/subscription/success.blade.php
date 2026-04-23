<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Abonnement</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow p-8 text-center">
            @if($paid)
                <p class="text-5xl mb-4">✓</p>
                <h3 class="text-2xl font-bold text-green-600 mb-2">Paiement réussi !</h3>
                <p class="text-gray-500 mb-6">Votre abonnement est maintenant actif.</p>
            @else
                <p class="text-5xl mb-4">✗</p>
                <h3 class="text-2xl font-bold text-red-600 mb-2">Paiement non confirmé</h3>
                <p class="text-gray-500 mb-6">Veuillez réessayer.</p>
            @endif
            <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:underline">Retour au dashboard</a>
        </div>
    </div>
</x-app-layout>
