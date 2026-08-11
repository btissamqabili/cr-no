<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mes rendez-vous
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @forelse($rendezVous as $rdv)
                    <div class="flex justify-between items-center border-b py-4">
                        <div>
                            <p class="font-medium">{{ $rdv->creneau->date->format('d/m/Y') }} à {{ substr($rdv->creneau->heure_debut, 0, 5) }}</p>
                            <p class="text-sm text-gray-600">Statut : <span class="font-semibold">{{ $rdv->statut }}</span></p>
                        </div>

                        @if($rdv->statut !== 'annule')
                            <form action="{{ route('client.annuler', $rdv) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment annuler ce rendez-vous ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                    Annuler
                                </button>
                            </form>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500">Vous n’avez aucun rendez-vous.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>