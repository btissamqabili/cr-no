```blade
<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    Gestion des créneaux
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Gérez les créneaux disponibles pour les clients.
                </p>
            </div>

            <a href="{{ route('admin.creneaux.create') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 4v16m8-8H4"/>
                </svg>

                Ajouter un créneau
            </a>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50 py-8">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Messages de succès --}}
            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-green-800 shadow-sm">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>

                    <span class="text-sm font-medium">
                        {{ session('success') }}
                    </span>
                </div>
            @endif


            {{-- Statistiques --}}
            <div class="mb-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">

                {{-- Total --}}
                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">

                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Total des créneaux
                            </p>

                            <p class="mt-2 text-3xl font-bold text-gray-900">
                                {{ $creneaux->count() }}
                            </p>
                        </div>

                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6 text-indigo-600"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>

                        </div>
                    </div>
                </div>


                {{-- Disponibles --}}
                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">

                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Créneaux disponibles
                            </p>

                            <p class="mt-2 text-3xl font-bold text-gray-900">
                                {{ $creneaux->filter(fn($creneau) => $creneau->rendezVous->isEmpty() && \Carbon\Carbon::parse($creneau->date . ' ' . $creneau->heure_debut)->isFuture())->count() }}
                            </p>
                        </div>

                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-50">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6 text-green-600"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M5 13l4 4L19 7"/>
                            </svg>

                        </div>
                    </div>
                </div>


                {{-- Réservés --}}
                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">

                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Créneaux réservés
                            </p>

                            <p class="mt-2 text-3xl font-bold text-gray-900">
                                {{ $creneaux->filter(fn($creneau) => $creneau->rendezVous->isNotEmpty())->count() }}
                            </p>
                        </div>

                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-50">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6 text-orange-600"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>

                        </div>
                    </div>
                </div>

            </div>


            {{-- Tableau --}}
            <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">

                <div class="border-b border-gray-100 px-6 py-5">

                    <div class="flex items-center justify-between">

                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">
                                Liste des créneaux
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                Consultez et gérez tous les créneaux.
                            </p>
                        </div>

                    </div>

                </div>


                @if($creneaux->count())

                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-gray-50">

                                <tr>

                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                        Date
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                        Heure
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                        Durée
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                        Statut
                                    </th>

                                    <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                        Actions
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-gray-100 bg-white">

                                @foreach($creneaux as $creneau)

                                    @php
                                        $dateHeure = \Carbon\Carbon::parse(
                                            $creneau->date . ' ' . $creneau->heure_debut
                                        );

                                        $reserve = $creneau->rendezVous->isNotEmpty();
                                        $passe = $dateHeure->isPast();
                                    @endphp

                                    <tr class="transition hover:bg-gray-50">

                                        {{-- Date --}}
                                        <td class="whitespace-nowrap px-6 py-4">

                                            <div class="flex items-center gap-3">

                                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-50">

                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="h-5 w-5 text-indigo-600"
                                                         fill="none"
                                                         viewBox="0 0 24 24"
                                                         stroke="currentColor"
                                                         stroke-width="2">
                                                        <path stroke-linecap="round"
                                                              stroke-linejoin="round"
                                                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>

                                                </div>

                                                <span class="font-medium text-gray-900">
                                                    {{ \Carbon\Carbon::parse($creneau->date)->format('d/m/Y') }}
                                                </span>

                                            </div>

                                        </td>


                                        {{-- Heure --}}
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700">

                                            <span class="font-medium">
                                                {{ \Carbon\Carbon::parse($creneau->heure_debut)->format('H:i') }}
                                            </span>

                                        </td>


                                        {{-- Durée --}}
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700">

                                            {{ $creneau->duree }} min

                                        </td>


                                        {{-- Statut --}}
                                        <td class="whitespace-nowrap px-6 py-4">

                                            @if($passe)

                                                <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
                                                    Passé
                                                </span>

                                            @elseif($reserve)

                                                <span class="inline-flex rounded-full bg-orange-100 px-3 py-1 text-xs font-semibold text-orange-700">
                                                    Réservé
                                                </span>

                                            @else

                                                <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                                    Disponible
                                                </span>

                                            @endif

                                        </td>


                                        {{-- Actions --}}
                                        <td class="whitespace-nowrap px-6 py-4 text-right">

                                            <div class="flex justify-end gap-2">

                                                {{-- Modifier --}}
                                                <a href="{{ route('admin.creneaux.edit', $creneau) }}"
                                                   class="inline-flex items-center rounded-lg bg-indigo-50 px-3 py-2 text-sm font-medium text-indigo-600 transition hover:bg-indigo-100">

                                                    Modifier

                                                </a>


                                                {{-- Supprimer --}}
                                                <form action="{{ route('admin.creneaux.destroy', $creneau) }}"
                                                      method="POST"
                                                      class="inline">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce créneau ?')"
                                                            class="inline-flex items-center rounded-lg bg-red-50 px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-100">

                                                        Supprimer

                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    {{-- Aucun créneau --}}
                    <div class="px-6 py-16 text-center">

                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gray-100">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-8 w-8 text-gray-400"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 01-2-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>

                        </div>

                        <h3 class="mt-4 text-lg font-semibold text-gray-900">
                            Aucun créneau
                        </h3>

                        <p class="mt-2 text-sm text-gray-500">
                            Commencez par créer votre premier créneau.
                        </p>

                        <a href="{{ route('admin.creneaux.create') }}"
                           class="mt-5 inline-flex items-center rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">

                            Ajouter un créneau

                        </a>

                    </div>

                @endif

            </div>

        </div>

    </div>

</x-app-layout>
```
