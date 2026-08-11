<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Créneaux disponibles
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('error'))
                <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">{{ session('error') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @forelse($creneaux as $creneau)
                    <div class="flex justify-between items-center border-b py-4">
                        <div>
                            <p class="font-medium">{{ $creneau->date->format('d/m/Y') }}</p>
                            <p class="text-gray-600">{{ substr($creneau->heure_debut, 0, 5) }} ({{ $creneau->duree }} min)</p>
                        </div>

                        <form action="{{ route('client.reserver') }}" method="POST">
                            @csrf
                            <input type="hidden" name="creneau_id" value="{{ $creneau->id }}">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                Réserver
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="text-gray-500">Aucun créneau disponible pour le moment.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>