<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Abonnement Premium</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow p-8 text-center">
            <h3 class="text-2xl font-bold mb-2">Abonnement Premium</h3>
            <p class="text-gray-500 mb-6">Accédez à l'API des emplacements de films.</p>
            <p class="text-4xl font-bold mb-6">9,99 € <span class="text-base font-normal text-gray-500">/ mois</span></p>

            @if(auth()->user()->is_subscribed)
                <p class="text-green-600 font-semibold">Vous êtes déjà abonné ✓</p>
            @else
                <form method="POST" action="{{ route('subscription.checkout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full bg-indigo-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-indigo-700">
                        S'abonner avec Stripe
                    </button>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>
