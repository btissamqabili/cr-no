<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ajouter un créneau
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <h1 class="text-2xl font-bold text-gray-800 mb-6">
                    Nouveau créneau
                </h1>

                @if ($errors->any())
                    <div class="mb-6 bg-red-100 text-red-700 p-4 rounded-lg">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.creneaux.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium text-gray-700 mb-2">
                            Date
                        </label>

                        <input
                            type="date"
                            name="date"
                            value="{{ old('date') }}"
                            class="w-full border-gray-300 rounded-lg"
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-gray-700 mb-2">
                            Heure de début
                        </label>

                        <input
                            type="time"
                            name="heure_debut"
                            value="{{ old('heure_debut') }}"
                            class="w-full border-gray-300 rounded-lg"
                            required
                        >
                    </div>

                    <div class="mb-6">
                        <label class="block font-medium text-gray-700 mb-2">
                            Durée (minutes)
                        </label>

                        <input
                            type="number"
                            name="duree"
                            value="{{ old('duree') }}"
                            min="1"
                            class="w-full border-gray-300 rounded-lg"
                            required
                        >
                    </div>

                    <div class="flex gap-3">

                        <a
                            href="{{ route('admin.creneaux.index') }}"
                            class="px-4 py-2 bg-gray-200 rounded-lg"
                        >
                            Annuler
                        </a>

                        <button
                            type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg"
                        >
                            Ajouter le créneau
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>