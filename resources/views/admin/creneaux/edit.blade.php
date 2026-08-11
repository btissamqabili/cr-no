<x-app-layout>
    <div class="min-h-screen bg-slate-50">

        {{-- Header --}}
        <div class="border-b border-slate-200 bg-white">
            <div class="mx-auto max-w-5xl px-6 py-8">

                <a href="{{ route('admin.creneaux.index') }}"
                   class="mb-4 inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-4 w-4"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M15 19l-7-7 7-7"/>
                    </svg>
                    Retour aux créneaux
                </a>

                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                        Modifier le créneau
                    </h1>

                    <p class="mt-2 text-sm text-slate-500">
                        Mettez à jour les informations de ce créneau.
                    </p>
                </div>

            </div>
        </div>


        {{-- Formulaire --}}
        <div class="mx-auto max-w-5xl px-6 py-10">

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                {{-- Card header --}}
                <div class="border-b border-slate-200 px-8 py-6">
                    <div class="flex items-center gap-4">

                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold text-slate-900">
                                Informations du créneau
                            </h2>

                            <p class="text-sm text-slate-500">
                                Modifiez la date, l'heure ou la durée.
                            </p>
                        </div>

                    </div>
                </div>


                {{-- Form --}}
                <form action="{{ route('admin.creneaux.update', $creneau) }}"
                      method="POST"
                      class="px-8 py-8">

                    @csrf
                    @method('PUT')

                    <div class="grid gap-6 md:grid-cols-2">

                        {{-- Date --}}
                        <div>
                            <label for="date"
                                   class="mb-2 block text-sm font-semibold text-slate-700">
                                Date
                            </label>

                            <div class="relative">
                                <input
                                    id="date"
                                    name="date"
                                    type="date"
                                    value="{{ old('date', \Carbon\Carbon::parse($creneau->date)->format('Y-m-d')) }}"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                                    required
                                >
                            </div>

                            @error('date')
                                <p class="mt-2 text-sm font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        {{-- Heure --}}
                        <div>
                            <label for="heure_debut"
                                   class="mb-2 block text-sm font-semibold text-slate-700">
                                Heure de début
                            </label>

                            <input
                                id="heure_debut"
                                name="heure_debut"
                                type="time"
                                value="{{ old('heure_debut', \Carbon\Carbon::parse($creneau->heure_debut)->format('H:i')) }}"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                                required
                            >

                            @error('heure_debut')
                                <p class="mt-2 text-sm font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        {{-- Durée --}}
                        <div class="md:col-span-2">
                            <label for="duree"
                                   class="mb-2 block text-sm font-semibold text-slate-700">
                                Durée du rendez-vous
                            </label>

                            <select
                                id="duree"
                                name="duree"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                                required
                            >
                                <option value="15"
                                    {{ old('duree', $creneau->duree) == 15 ? 'selected' : '' }}>
                                    15 minutes
                                </option>

                                <option value="30"
                                    {{ old('duree', $creneau->duree) == 30 ? 'selected' : '' }}>
                                    30 minutes
                                </option>

                                <option value="45"
                                    {{ old('duree', $creneau->duree) == 45 ? 'selected' : '' }}>
                                    45 minutes
                                </option>

                                <option value="60"
                                    {{ old('duree', $creneau->duree) == 60 ? 'selected' : '' }}>
                                    1 heure
                                </option>

                                <option value="90"
                                    {{ old('duree', $creneau->duree) == 90 ? 'selected' : '' }}>
                                    1 heure 30
                                </option>

                                <option value="120"
                                    {{ old('duree', $creneau->duree) == 120 ? 'selected' : '' }}>
                                    2 heures
                                </option>
                            </select>

                            @error('duree')
                                <p class="mt-2 text-sm font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>


                    {{-- Error général --}}
                    @if ($errors->any())
                        <div class="mt-6 rounded-xl border border-red-200 bg-red-50 p-4">
                            <div class="flex gap-3">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="mt-0.5 h-5 w-5 shrink-0 text-red-600"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M12 9v3.75m0 3h.008M10.29 3.86l-7.5 13A1.5 1.5 0 004.09 19h15.82a1.5 1.5 0 001.3-2.14l-7.5-13a1.5 1.5 0 00-2.61 0z"/>
                                </svg>

                                <div>
                                    <p class="text-sm font-semibold text-red-800">
                                        Impossible de modifier le créneau
                                    </p>

                                    <ul class="mt-1 list-disc pl-5 text-sm text-red-700">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>

                            </div>
                        </div>
                    @endif


                    {{-- Actions --}}
                    <div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">

                        <a href="{{ route('admin.creneaux.index') }}"
                           class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                            Annuler
                        </a>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-100"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M5 13l4 4L19 7"/>
                            </svg>

                            Enregistrer les modifications
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
</x-app-layout><x-app-layout>

    <div class="min-h-screen bg-slate-50">

        {{-- Header --}}
        <div class="border-b border-slate-200 bg-white">
            <div class="mx-auto max-w-4xl px-6 py-7">

                {{-- Retour --}}
                <a href="{{ route('admin.creneaux.index') }}"
                   class="mb-4 inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-indigo-600">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-4 w-4"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M15 19l-7-7 7-7"/>
                    </svg>

                    Retour aux créneaux
                </a>

                {{-- Titre --}}
                <h1 class="text-2xl font-bold text-slate-900">
                    Modifier le créneau
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Modifiez les informations du créneau sélectionné.
                </p>

            </div>
        </div>


        {{-- Contenu --}}
        <div class="mx-auto max-w-4xl px-6 py-8">

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                {{-- Card header --}}
                <div class="border-b border-slate-200 px-7 py-5">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="2">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>

                            </svg>

                        </div>

                        <div>
                            <h2 class="text-base font-semibold text-slate-900">
                                Informations du créneau
                            </h2>

                            <p class="text-xs text-slate-500">
                                Date, heure de début et durée
                            </p>
                        </div>

                    </div>

                </div>


                {{-- Formulaire --}}
                <form action="{{ route('admin.creneaux.update', $creneau) }}"
                      method="POST"
                      class="px-7 py-7">

                    @csrf
                    @method('PUT')


                    {{-- Champs --}}
                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">


                        {{-- Date --}}
                        <div>

                            <label for="date"
                                   class="mb-2 block text-sm font-semibold text-slate-700">
                                Date
                            </label>

                            <input
                                type="date"
                                id="date"
                                name="date"
                                value="{{ old('date', \Carbon\Carbon::parse($creneau->date)->format('Y-m-d')) }}"
                                required
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                            >

                            @error('date')
                                <p class="mt-1.5 text-xs font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Heure --}}
                        <div>

                            <label for="heure_debut"
                                   class="mb-2 block text-sm font-semibold text-slate-700">
                                Heure de début
                            </label>

                            <input
                                type="time"
                                id="heure_debut"
                                name="heure_debut"
                                value="{{ old('heure_debut', \Carbon\Carbon::parse($creneau->heure_debut)->format('H:i')) }}"
                                required
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                            >

                            @error('heure_debut')
                                <p class="mt-1.5 text-xs font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Durée --}}
                        <div class="md:col-span-2">

                            <label for="duree"
                                   class="mb-2 block text-sm font-semibold text-slate-700">
                                Durée
                            </label>

                            <select
                                id="duree"
                                name="duree"
                                required
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                            >

                                <option value="15"
                                    {{ old('duree', $creneau->duree) == 15 ? 'selected' : '' }}>
                                    15 minutes
                                </option>

                                <option value="30"
                                    {{ old('duree', $creneau->duree) == 30 ? 'selected' : '' }}>
                                    30 minutes
                                </option>

                                <option value="45"
                                    {{ old('duree', $creneau->duree) == 45 ? 'selected' : '' }}>
                                    45 minutes
                                </option>

                                <option value="60"
                                    {{ old('duree', $creneau->duree) == 60 ? 'selected' : '' }}>
                                    1 heure
                                </option>

                                <option value="90"
                                    {{ old('duree', $creneau->duree) == 90 ? 'selected' : '' }}>
                                    1 heure 30
                                </option>

                                <option value="120"
                                    {{ old('duree', $creneau->duree) == 120 ? 'selected' : '' }}>
                                    2 heures
                                </option>

                            </select>

                            @error('duree')
                                <p class="mt-1.5 text-xs font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>


                    {{-- Erreurs générales --}}
                    @if ($errors->any())

                        <div class="mt-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3">

                            <div class="flex gap-3">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-5 w-5 shrink-0 text-red-500"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M12 9v3.75m0 3h.008M10.29 3.86l-7.5 13A1.5 1.5 0 004.09 19h15.82a1.5 1.5 0 001.3-2.14l-7.5-13a1.5 1.5 0 00-2.61 0z"/>

                                </svg>

                                <div>

                                    <p class="text-sm font-semibold text-red-800">
                                        Une erreur est survenue
                                    </p>

                                    <ul class="mt-1 list-disc pl-5 text-xs text-red-700">

                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach

                                    </ul>

                                </div>

                            </div>

                        </div>

                    @endif


                    {{-- Actions --}}
                    <div class="mt-7 flex items-center justify-end gap-2 border-t border-slate-200 pt-5">

                        {{-- Annuler --}}
                        <a href="{{ route('admin.creneaux.index') }}"
                           class="rounded-lg px-3 py-2 text-xs font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">

                            Annuler

                        </a>


                        {{-- Enregistrer --}}
                        <button
                            type="submit"
                            class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-3.5 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-3.5 w-3.5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="2">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M5 13l4 4L19 7"/>

                            </svg>

                            Enregistrer

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>