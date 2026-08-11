<x-app-layout>

    <div class="min-h-screen bg-slate-50">

        {{-- =========================
             HEADER
        ========================== --}}
        <div class="border-b border-slate-200 bg-white">

            <div class="mx-auto max-w-7xl px-6 py-7 lg:px-8">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm font-medium text-indigo-600">
                            Administration
                        </p>

                        <h1 class="mt-1 text-2xl font-semibold tracking-tight text-slate-900">
                            Tableau de bord
                        </h1>

                        <p class="mt-1 text-sm text-slate-500">
                            Gérez les rendez-vous et les créneaux de réservation.
                        </p>
                    </div>


                    <a href="{{ route('admin.creneaux.index') }}"
                       class="inline-flex items-center gap-2 rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800">

                        <svg class="h-4 w-4"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="2">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>

                        </svg>

                        Gérer les créneaux

                    </a>

                </div>

            </div>

        </div>


        {{-- =========================
             CONTENT
        ========================== --}}
        <main class="mx-auto max-w-7xl px-6 py-8 lg:px-8">


            {{-- =========================
                 STATISTICS
            ========================== --}}
            <div class="grid grid-cols-3 divide-x divide-slate-200 rounded-2xl border border-slate-200 bg-white shadow-sm">


                {{-- TOTAL --}}
                <div class="px-6 py-6">

                    <p class="text-xs font-semibold uppercase tracking-widest text-slate-400">
                        Rendez-vous
                    </p>

                    <div class="mt-3 flex items-end gap-2">

                        <span class="text-3xl font-semibold tracking-tight text-slate-900">
                            {{ $rendezVous->count() }}
                        </span>

                        <span class="mb-1 text-sm text-slate-400">
                            total
                        </span>

                    </div>

                    <p class="mt-1 text-xs text-slate-500">
                        Toutes les réservations
                    </p>

                </div>


                {{-- EN ATTENTE --}}
                <div class="px-6 py-6">

                    <p class="text-xs font-semibold uppercase tracking-widest text-slate-400">
                        En attente
                    </p>

                    <div class="mt-3 flex items-end gap-2">

                        <span class="text-3xl font-semibold tracking-tight text-slate-900">
                            {{ $rendezVous->where('statut', 'en_attente')->count() }}
                        </span>

                        <span class="mb-1 text-sm font-medium text-amber-600">
                            à traiter
                        </span>

                    </div>

                    <p class="mt-1 text-xs text-slate-500">
                        Demandes en attente
                    </p>

                </div>


                {{-- CONFIRMÉS --}}
                <div class="px-6 py-6">

                    <p class="text-xs font-semibold uppercase tracking-widest text-slate-400">
                        Confirmés
                    </p>

                    <div class="mt-3 flex items-end gap-2">

                        <span class="text-3xl font-semibold tracking-tight text-slate-900">
                            {{ $rendezVous->where('statut', 'confirme')->count() }}
                        </span>

                        <span class="mb-1 text-sm font-medium text-emerald-600">
                            validés
                        </span>

                    </div>

                    <p class="mt-1 text-xs text-slate-500">
                        Rendez-vous confirmés
                    </p>

                </div>

            </div>


            {{-- =========================
                 RENDEZ-VOUS TABLE
            ========================== --}}
            <div class="mt-8 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">


                {{-- TABLE HEADER --}}
                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5">

                    <div>

                        <h2 class="text-base font-semibold text-slate-900">
                            Rendez-vous
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Liste des réservations des clients.
                        </p>

                    </div>


                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">

                        {{ $rendezVous->count() }} réservation(s)

                    </span>

                </div>


                {{-- EMPTY --}}
                @if ($rendezVous->isEmpty())

                    <div class="px-6 py-16 text-center">

                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100">

                            <svg class="h-5 w-5 text-slate-400"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>

                            </svg>

                        </div>


                        <h3 class="mt-4 text-sm font-semibold text-slate-900">
                            Aucun rendez-vous
                        </h3>


                        <p class="mt-1 text-sm text-slate-500">
                            Les réservations apparaîtront ici.
                        </p>

                    </div>


                {{-- TABLE --}}
                @else

                    <div class="overflow-x-auto">

                        <table class="min-w-full">

                            {{-- HEAD --}}
                            <thead>

                                <tr class="border-b border-slate-200 bg-slate-50">

                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Client
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Date
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Heure
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Durée
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Statut
                                    </th>

                                </tr>

                            </thead>


                            {{-- BODY --}}
                            <tbody class="divide-y divide-slate-100">


                                @foreach ($rendezVous as $rdv)

                                    <tr class="transition hover:bg-slate-50">


                                        {{-- CLIENT --}}
                                        <td class="px-6 py-4">

                                            <div class="flex items-center gap-3">


                                                {{-- Avatar --}}
                                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-slate-900 text-xs font-semibold text-white">

                                                    {{ strtoupper(substr($rdv->user->name, 0, 1)) }}

                                                </div>


                                                <div>

                                                    <p class="text-sm font-medium text-slate-900">

                                                        {{ $rdv->user->name }}

                                                    </p>

                                                    <p class="text-xs text-slate-500">

                                                        {{ $rdv->user->email }}

                                                    </p>

                                                </div>

                                            </div>

                                        </td>


                                        {{-- DATE --}}
                                        <td class="whitespace-nowrap px-6 py-4">

                                            <span class="text-sm text-slate-700">

                                                {{ \Carbon\Carbon::parse($rdv->creneau->date)->format('d/m/Y') }}

                                            </span>

                                        </td>


                                        {{-- HEURE --}}
                                        <td class="whitespace-nowrap px-6 py-4">

                                            <span class="text-sm font-medium text-slate-700">

                                                {{ \Carbon\Carbon::parse($rdv->creneau->heure_debut)->format('H:i') }}

                                            </span>

                                        </td>


                                        {{-- DUREE --}}
                                        <td class="whitespace-nowrap px-6 py-4">

                                            <span class="text-sm text-slate-600">

                                                {{ $rdv->creneau->duree }} min

                                            </span>

                                        </td>


                                        {{-- STATUT --}}
                                        <td class="whitespace-nowrap px-6 py-4">


                                            @if ($rdv->statut === 'confirme')

                                                <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700">

                                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                                                    Confirmé

                                                </span>


                                            @elseif ($rdv->statut === 'annule')

                                                <span class="inline-flex items-center gap-2 rounded-full bg-red-50 px-3 py-1 text-xs font-medium text-red-700">

                                                    <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>

                                                    Annulé

                                                </span>


                                            @else

                                                <span class="inline-flex items-center gap-2 rounded-full bg-amber-50 px-3 py-1 text-xs font-medium text-amber-700">

                                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>

                                                    En attente

                                                </span>

                                            @endif


                                        </td>

                                    </tr>

                                @endforeach


                            </tbody>

                        </table>

                    </div>

                @endif

            </div>


        </main>

    </div>

</x-app-layout>