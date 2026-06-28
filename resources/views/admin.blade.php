<x-layout>
    <x-slot:heading>Admin Dashboard</x-slot:heading>

    @include('partials.lp-theme')

    {{-- ===================== LIGHT MODE – „Sportfest-Poster“ ===================== --}}
    <style>
        /* Reskin der geteilten Form-Components im Poster-Stil (nur Light Mode) */
        .lp-form input[type="text"],
        .lp-form input[type="number"],
        .lp-form input[type="password"],
        .lp-form input[type="email"],
        .lp-form select,
        .lp-form textarea {
            border: 2px solid var(--lp-ink) !important;
            border-radius: 12px !important;
            background: #fff !important;
            color: var(--lp-ink) !important;
            box-shadow: none !important;
            font-weight: 600;
        }

        .lp-form input:focus,
        .lp-form select:focus,
        .lp-form textarea:focus {
            outline: none !important;
            border-color: var(--lp-ink) !important;
            box-shadow: 4px 4px 0 0 var(--lp-gold) !important;
        }

        .lp-form label,
        .lp-form legend {
            color: var(--lp-ink) !important;
            font-weight: 700;
        }

        .lp-form input[type="checkbox"],
        .lp-form input[type="radio"] {
            accent-color: var(--lp-accent);
        }

        .lp-form button[type="submit"] {
            background: var(--lp-ink) !important;
            background-image: none !important;
            color: var(--lp-paper) !important;
            border: 2px solid var(--lp-ink) !important;
            border-radius: 9999px !important;
            font-weight: 800 !important;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            box-shadow: 4px 4px 0 0 var(--lp-accent);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .lp-form button[type="submit"]:hover {
            transform: translate(-2px, -2px);
            box-shadow: 6px 6px 0 0 var(--lp-accent);
        }
    </style>

    <div class="light-mode-only -mt-10">
        <section class="lp-sec-paper relative overflow-hidden pt-16 md:pt-28 pb-20 min-h-screen">
            <div class="lp-lanes absolute inset-0 pointer-events-none" aria-hidden="true"></div>

            <div class="container mx-auto px-4 relative z-10 max-w-6xl"
                 x-data="{
                     activePanel: null,
                     openPanel(name) {
                         this.activePanel = name;
                         history.pushState({ adminPanel: name }, '', '?panel=' + name);
                         window.scrollTo({ top: 0, behavior: 'smooth' });
                     }
                 }"
                 x-init="
                     const panel = new URLSearchParams(window.location.search).get('panel');
                     if (panel) {
                         activePanel = panel;
                     }
                     window.addEventListener('popstate', (e) => {
                         activePanel = (e.state && e.state.adminPanel) ? e.state.adminPanel : null;
                         window.scrollTo({ top: 0, behavior: 'smooth' });
                     });
                 ">

                {{-- Flash: Erfolg --}}
                @if(session('success'))
                    <div class="lp-card lp-shadow p-5 mb-8" role="alert" style="border-color: var(--lp-pine);">
                        <p class="font-extrabold"><span class="lp-chip mr-2" style="background: var(--lp-pine); color: #fff;">Erfolg</span>{{ session('success') }}</p>

                        @if(session('user_created'))
                            <div class="mt-4 pt-4 border-t-2 border-dashed" style="border-color: rgba(22, 29, 39, 0.2);">
                                <p class="lp-display text-base">Anmeldedaten für die Klasse</p>
                                <div class="mt-2 grid sm:grid-cols-2 gap-2">
                                    <div class="bg-white border-2 lp-bord rounded-xl px-3 py-2">
                                        <span class="lp-muted text-[0.6rem] font-bold uppercase tracking-[0.2em] block">Benutzername</span>
                                        <span class="font-mono font-bold break-all">{{ session('username') }}</span>
                                    </div>
                                    <div class="bg-white border-2 lp-bord rounded-xl px-3 py-2">
                                        <span class="lp-muted text-[0.6rem] font-bold uppercase tracking-[0.2em] block">Passwort</span>
                                        <span class="font-mono font-bold break-all">{{ session('password') }}</span>
                                    </div>
                                </div>
                                <p class="lp-muted text-xs mt-2">Bitte notieren – diese Daten werden nur einmal angezeigt!</p>
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Flash: Fehler --}}
                @if ($errors->any())
                    <div class="lp-card lp-shadow p-5 mb-8" role="alert" style="border-color: var(--lp-accent);">
                        <p class="font-extrabold"><span class="lp-chip lp-chip-accent mr-2">Fehler</span>Bitte überprüfe die Eingaben in den Formularen.</p>
                        <ul class="lp-muted text-sm mt-2 list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Kachelmenü --}}
                <div x-show="activePanel === null"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100">

                    <div class="flex justify-center">
                        <span class="lp-kicker lp-reveal">Kommandozentrale</span>
                    </div>
                    <h1 class="lp-display lp-h2 mt-3 text-center lp-reveal lp-d1">
                        Was möchtest <span class="lp-outline">du tun?</span>
                    </h1>

                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-5 mt-10">
                        @php
                            $lpTiles = [
                                ['nachricht', '📨', 'Nachricht', 'Broadcast senden'],
                                ['punktesystem', '⚙️', 'Punktesystem', 'Wertung anpassen'],
                                ['schulen', '🏫', 'Schulen', 'Anlegen & verwalten'],
                                ['klassen', '👥', 'Klassen', 'Anlegen & verwalten'],
                                ['teams', '🏆', 'Teams', 'Anlegen & verwalten'],
                                ['disziplinen', '⚡', 'Disziplinen', 'Anlegen & verwalten'],
                                ['archiv', '📚', 'Archiv', 'Snapshot anlegen'],
                                ['urkunden', '📜', 'Urkunden', 'PDF drucken'],
                            ];
                        @endphp
                        @foreach ($lpTiles as $i => [$key, $emoji, $label, $sub])
                            <button type="button" @click="openPanel('{{ $key }}')"
                                    class="lp-card lp-shadow flex flex-col items-center justify-center gap-2 p-6 transition-transform duration-200 hover:-translate-y-1.5 cursor-pointer text-center lp-reveal lp-d{{ min(intdiv($i, 2) + 1, 5) }}">
                                <span class="text-3xl" aria-hidden="true">{{ $emoji }}</span>
                                <span class="lp-display text-lg leading-tight">{{ $label }}</span>
                                <span class="lp-muted text-[0.62rem] font-bold uppercase tracking-[0.14em] leading-tight">{{ $sub }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Zurück-Button --}}
                <div x-show="activePanel !== null" class="mb-8">
                    <button type="button" @click="activePanel = null; history.pushState({ adminPanel: null }, '', '?')"
                            class="lp-btn-ghost text-xs px-5 py-2.5">
                        ← Zurück zur Übersicht
                    </button>
                </div>

                {{-- PANEL: Nachricht --}}
                <div x-show="activePanel === 'nachricht'"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    <span class="lp-kicker">Broadcast</span>
                    <h2 class="lp-display text-2xl md:text-3xl mt-3 mb-6">Nachricht senden</h2>

                    <div class="lp-card lp-shadow p-6 lp-form max-w-2xl">
                        <form action="{{ route('admin.broadcast') }}" method="POST" class="space-y-5">
                            @csrf
                            <div>
                                <label for="lp_admin_message" class="block text-sm mb-2">Nachricht *</label>
                                <textarea id="lp_admin_message"
                                          name="message"
                                          rows="4"
                                          maxlength="500"
                                          required
                                          placeholder="Kurze Nachricht an die ausgewählten Gruppen..."
                                          class="w-full px-3 py-2.5">{{ old('message') }}</textarea>
                            </div>
                            <div>
                                <span class="block text-sm font-bold mb-2">Empfänger *</span>
                                @php($oldTargets = old('targets', []))
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <label class="flex items-center gap-2 text-sm font-bold bg-white border-2 lp-bord rounded-xl px-3 py-2.5 cursor-pointer">
                                        <input type="checkbox" name="targets[]" value="teachers"
                                            {{ in_array('teachers', $oldTargets, true) ? 'checked' : '' }}>
                                        Lehrer
                                    </label>
                                    <label class="flex items-center gap-2 text-sm font-bold bg-white border-2 lp-bord rounded-xl px-3 py-2.5 cursor-pointer">
                                        <input type="checkbox" name="targets[]" value="klasses"
                                            {{ in_array('klasses', $oldTargets, true) ? 'checked' : '' }}>
                                        Klassen
                                    </label>
                                    <label class="flex items-center gap-2 text-sm font-bold bg-white border-2 lp-bord rounded-xl px-3 py-2.5 cursor-pointer">
                                        <input type="checkbox" name="targets[]" value="guests"
                                            {{ in_array('guests', $oldTargets, true) ? 'checked' : '' }}>
                                        Gäste
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="w-full py-3 px-4 text-sm">
                                Nachricht senden
                            </button>
                        </form>
                    </div>
                </div>

                {{-- PANEL: Punktesystem --}}
                <div x-show="activePanel === 'punktesystem'"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    <span class="lp-kicker">Wertung</span>
                    <h2 class="lp-display text-2xl md:text-3xl mt-3 mb-6">Punktesystem</h2>
                    <div class="lp-form">
                        <x-scoresystem-form :scoresystem="$scoresystem" :autoSchoolTeams="$autoSchoolTeams"/>
                    </div>
                </div>

                {{-- PANEL: Schulen --}}
                <div x-show="activePanel === 'schulen'"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    <span class="lp-kicker">Stammdaten</span>
                    <h2 class="lp-display text-2xl md:text-3xl mt-3 mb-6">Schulen</h2>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                        <div class="lp-card lp-shadow p-6 lp-form">
                            <h3 class="lp-display text-lg mb-4">Neue Schule anlegen</h3>
                            <x-school-form/>
                        </div>
                        <div class="lp-card lp-shadow p-6">
                            <h3 class="lp-display text-lg mb-4">Vorhandene Schulen</h3>
                            @if($schools->count() > 0)
                                <ul class="space-y-3">
                                    @foreach($schools as $school)
                                        <li class="bg-white border-2 lp-bord rounded-xl p-3.5">
                                            <div class="flex items-center justify-between gap-3">
                                                <span class="font-extrabold break-words min-w-0">
                                                    <span class="inline-block w-2.5 h-2.5 rounded-full {{ \App\Services\SchoolColorService::getColorClasses($school->id)['dot'] }} border border-black/30 align-middle mr-1.5"></span>{{ $school->name }}
                                                </span>
                                                <form action="{{ route('schools.destroy', $school->id) }}" method="POST"
                                                      onsubmit="return confirm('Schule {{ $school->name }} wirklich löschen? Alle zugehörigen Klassen, Teams und Disziplinen werden ebenfalls gelöscht!');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="shrink-0 w-8 h-8 grid place-items-center rounded-lg border-2 lp-bord text-sm font-extrabold transition-colors hover:text-white"
                                                            onmouseover="this.style.background='var(--lp-accent)'" onmouseout="this.style.background=''"
                                                            title="Schule löschen">✕</button>
                                                </form>
                                            </div>
                                            <details class="mt-2">
                                                <summary class="cursor-pointer text-xs font-bold uppercase tracking-[0.12em] lp-muted hover:text-[color:var(--lp-accent)]">Bearbeiten</summary>
                                                <form action="{{ route('schools.update', $school->id) }}" method="POST" class="mt-3 grid grid-cols-1 gap-2 lp-form">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="text" name="name" value="{{ old('name', $school->name) }}" required maxlength="255"
                                                           class="w-full px-3 py-2 text-sm">
                                                    <button type="submit" class="py-2 px-3 text-xs">Änderungen speichern</button>
                                                </form>
                                            </details>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="lp-muted italic text-sm">Keine Schulen vorhanden.</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- PANEL: Klassen --}}
                <div x-show="activePanel === 'klassen'"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    <span class="lp-kicker">Stammdaten</span>
                    <h2 class="lp-display text-2xl md:text-3xl mt-3 mb-6">Klassen</h2>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                        <div class="lp-card lp-shadow p-6 lp-form">
                            <h3 class="lp-display text-lg mb-4">Neue Klasse anlegen</h3>
                            @if($schools->count() > 0)
                                <x-klasse-form :schools="$schools"/>
                            @else
                                <p class="text-sm font-bold italic" style="color: var(--lp-accent);">Bitte zuerst eine Schule anlegen!</p>
                            @endif
                        </div>
                        <div class="lp-card lp-shadow p-6">
                            <h3 class="lp-display text-lg mb-4">Vorhandene Klassen</h3>
                            @if($klasses->count() > 0)
                                <ul class="space-y-3">
                                    @foreach($klasses as $klasse)
                                        <li class="bg-white border-2 lp-bord rounded-xl p-3.5">
                                            <div class="flex items-start justify-between gap-3">
                                                <div class="min-w-0">
                                                    <span class="font-extrabold break-words">
                                                        <span class="inline-block w-2.5 h-2.5 rounded-full {{ \App\Services\SchoolColorService::getColorClasses($klasse->school_id ?? 0)['dot'] }} border border-black/30 align-middle mr-1.5"></span>{{ $klasse->name }}
                                                    </span>
                                                    <span class="lp-muted text-xs block mt-0.5">{{ $klasse->school->name ?? 'Keine Schule' }}</span>
                                                    <span class="inline-flex items-center gap-1.5 mt-1.5 font-mono text-xs font-bold bg-white border-2 lp-bord rounded-lg px-2 py-0.5" data-pw-container>PW:&nbsp;<span data-pw-mask>••••••••</span><button type="button" data-pw-toggle data-klasse="{{ $klasse->id }}" class="leading-none" title="Passwort anzeigen" aria-label="Passwort anzeigen">👁</button></span>
                                                </div>
                                                <form action="{{ route('klasses.destroy', $klasse->id) }}" method="POST"
                                                      onsubmit="return confirm('Klasse {{ $klasse->name }} wirklich löschen? Alle zugehörigen Teams und Disziplinen werden ebenfalls gelöscht!');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="shrink-0 w-8 h-8 grid place-items-center rounded-lg border-2 lp-bord text-sm font-extrabold transition-colors hover:text-white"
                                                            onmouseover="this.style.background='var(--lp-accent)'" onmouseout="this.style.background=''"
                                                            title="Klasse löschen">✕</button>
                                                </form>
                                            </div>
                                            <details class="mt-2">
                                                <summary class="cursor-pointer text-xs font-bold uppercase tracking-[0.12em] lp-muted hover:text-[color:var(--lp-accent)]">Bearbeiten</summary>
                                                <form action="{{ route('klasses.update', $klasse->id) }}" method="POST" class="mt-3 grid grid-cols-1 gap-2 lp-form">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="text" name="klasse_name" value="{{ old('klasse_name', $klasse->name) }}" required maxlength="255"
                                                           class="w-full px-3 py-2 text-sm">
                                                    <select name="school_id" required class="w-full px-3 py-2 text-sm">
                                                        @foreach($schools as $schoolOption)
                                                            <option value="{{ $schoolOption->id }}" {{ (int) old('school_id', $klasse->school_id) === (int) $schoolOption->id ? 'selected' : '' }}>{{ $schoolOption->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type="submit" class="py-2 px-3 text-xs">Änderungen speichern</button>
                                                </form>
                                            </details>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="lp-muted italic text-sm">Keine Klassen vorhanden.</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- PANEL: Teams --}}
                <div x-show="activePanel === 'teams'"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    <span class="lp-kicker">Stammdaten</span>
                    <h2 class="lp-display text-2xl md:text-3xl mt-3 mb-6">Teams</h2>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                        <div class="lp-card lp-shadow p-6 lp-form">
                            <h3 class="lp-display text-lg mb-4">Neues Team anlegen</h3>
                            @if($klasses->count() > 0)
                                <x-team-form :klasses="$klasses"/>
                            @else
                                <p class="text-sm font-bold italic" style="color: var(--lp-accent);">Bitte zuerst eine Klasse anlegen!</p>
                            @endif
                        </div>
                        <div class="lp-card lp-shadow p-6">
                            <h3 class="lp-display text-lg mb-4">Vorhandene Teams</h3>
                            @if($teams->count() > 0)
                                <ul class="space-y-3">
                                    @foreach($teams as $team)
                                        <li class="bg-white border-2 lp-bord rounded-xl p-3.5">
                                            <div class="flex items-center justify-between gap-3">
                                                <div class="min-w-0">
                                                    <span class="font-extrabold break-words">
                                                        <span class="inline-block w-2.5 h-2.5 rounded-full {{ \App\Services\SchoolColorService::getColorClasses($team->klasse->school_id ?? 0)['dot'] }} border border-black/30 align-middle mr-1.5"></span>{{ $team->name }}
                                                    </span>
                                                    <span class="lp-muted text-xs block mt-0.5">{{ $team->klasse->name ?? 'Keine Klasse' }}</span>
                                                </div>
                                                <form action="{{ route('teams.destroy', $team->id) }}" method="POST"
                                                      onsubmit="return confirm('Team {{ $team->name }} wirklich löschen?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="shrink-0 w-8 h-8 grid place-items-center rounded-lg border-2 lp-bord text-sm font-extrabold transition-colors hover:text-white"
                                                            onmouseover="this.style.background='var(--lp-accent)'" onmouseout="this.style.background=''"
                                                            title="Team löschen">✕</button>
                                                </form>
                                            </div>
                                            <details class="mt-2">
                                                <summary class="cursor-pointer text-xs font-bold uppercase tracking-[0.12em] lp-muted hover:text-[color:var(--lp-accent)]">Bearbeiten</summary>
                                                <form action="{{ route('teams.update', $team->id) }}" method="POST" class="mt-3 grid grid-cols-1 gap-2 lp-form">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="text" name="team_name" value="{{ old('team_name', $team->name) }}" required maxlength="255"
                                                           class="w-full px-3 py-2 text-sm">
                                                    <select name="klasse_id" required class="w-full px-3 py-2 text-sm">
                                                        @foreach($klasses as $klasseOption)
                                                            <option value="{{ $klasseOption->id }}" {{ (int) old('klasse_id', $team->klasse_id) === (int) $klasseOption->id ? 'selected' : '' }}>{{ $klasseOption->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <textarea name="members" rows="3" placeholder="Mitglieder (pro Zeile ein Name)"
                                                              class="w-full px-3 py-2 text-sm">{{ old('members', is_array($team->members) ? implode("\n", $team->members) : '') }}</textarea>
                                                    <button type="submit" class="py-2 px-3 text-xs">Änderungen speichern</button>
                                                </form>
                                            </details>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="lp-muted italic text-sm">Keine Teams vorhanden.</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- PANEL: Disziplinen --}}
                <div x-show="activePanel === 'disziplinen'"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    <span class="lp-kicker">Stationen</span>
                    <h2 class="lp-display text-2xl md:text-3xl mt-3 mb-6">Disziplinen</h2>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                        <div class="lp-card lp-shadow p-6 lp-form">
                            <h3 class="lp-display text-lg mb-4">Neue Disziplin anlegen</h3>
                            @if($klasses->count() > 0)
                                <x-discipline-form :disciplineklasses="$disciplineklasses"/>
                            @else
                                <p class="text-sm font-bold italic" style="color: var(--lp-accent);">Bitte zuerst eine Klasse anlegen!</p>
                            @endif
                        </div>
                        <div class="lp-card lp-shadow p-6">
                            <h3 class="lp-display text-lg mb-4">Vorhandene Disziplinen</h3>
                            @if($disciplines->count() > 0)
                                <ul class="space-y-3">
                                    @foreach($disciplines as $discipline)
                                        <li class="bg-white border-2 lp-bord rounded-xl p-3.5">
                                            <div class="flex items-start justify-between gap-3">
                                                <div class="min-w-0">
                                                    <span class="font-extrabold break-words">{{ $discipline->name }}</span>
                                                    <span class="lp-muted text-xs block mt-0.5">{{ $discipline->klasse->name ?? 'Keine Klasse' }}</span>
                                                    <span class="lp-chip text-[0.58rem] mt-1.5"
                                                          style="{{ $discipline->higher_is_better ? 'background: var(--lp-pine); color: #fff;' : 'background: var(--lp-accent); color: #fff;' }}">
                                                        {{ $discipline->higher_is_better ? '▲ Höher gewinnt' : '▼ Niedriger gewinnt' }}
                                                    </span>
                                                </div>
                                                <form action="{{ route('disciplines.destroy', $discipline->id) }}" method="POST"
                                                      onsubmit="return confirm('Disziplin {{ $discipline->name }} wirklich löschen?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="shrink-0 w-8 h-8 grid place-items-center rounded-lg border-2 lp-bord text-sm font-extrabold transition-colors hover:text-white"
                                                            onmouseover="this.style.background='var(--lp-accent)'" onmouseout="this.style.background=''"
                                                            title="Disziplin löschen">✕</button>
                                                </form>
                                            </div>
                                            <details class="mt-2">
                                                <summary class="cursor-pointer text-xs font-bold uppercase tracking-[0.12em] lp-muted hover:text-[color:var(--lp-accent)]">Bearbeiten</summary>
                                                <form action="{{ route('disciplines.update', $discipline->id) }}" method="POST" class="mt-3 grid grid-cols-1 gap-2 lp-form">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="text" name="discipline_name" value="{{ old('discipline_name', $discipline->name) }}" required maxlength="255"
                                                           class="w-full px-3 py-2 text-sm">
                                                    <select name="klasse_id" required class="w-full px-3 py-2 text-sm">
                                                        @foreach($klasses as $klasseOption)
                                                            <option value="{{ $klasseOption->id }}" {{ (int) old('klasse_id', $discipline->klasse_id) === (int) $klasseOption->id ? 'selected' : '' }}>{{ $klasseOption->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <select name="higher_is_better" required class="w-full px-3 py-2 text-sm">
                                                        <option value="1" {{ (string) old('higher_is_better', (int) $discipline->higher_is_better) === '1' ? 'selected' : '' }}>Höher ist besser</option>
                                                        <option value="0" {{ (string) old('higher_is_better', (int) $discipline->higher_is_better) === '0' ? 'selected' : '' }}>Niedriger ist besser</option>
                                                    </select>
                                                    <input type="text" name="description" value="{{ old('description', $discipline->description) }}" maxlength="255"
                                                           placeholder="Beschreibung (optional)" class="w-full px-3 py-2 text-sm">
                                                    <button type="submit" class="py-2 px-3 text-xs">Änderungen speichern</button>
                                                </form>
                                            </details>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="lp-muted italic text-sm">Keine Disziplinen vorhanden.</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- PANEL: Archiv --}}
                <div x-show="activePanel === 'archiv'"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    <span class="lp-kicker">Ruhmeshalle</span>
                    <h2 class="lp-display text-2xl md:text-3xl mt-3 mb-6">Archiv</h2>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                        <div class="lp-card lp-shadow p-6 lp-form">
                            <h3 class="lp-display text-lg mb-2">Neues Archiv erstellen</h3>
                            <p class="lp-muted text-sm mb-4">Friert alle aktuellen Daten der CampusOlympiade als Snapshot ein.</p>
                            <form action="{{ route('archive.store') }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="lp_archive_name" class="block text-sm mb-2">Archiv-Name *</label>
                                    <input type="text" id="lp_archive_name" name="name" required placeholder="z.B. CampusOlympiade {{ date('Y') }}"
                                           class="w-full px-3 py-2.5">
                                </div>
                                <div>
                                    <label for="lp_archive_description" class="block text-sm mb-2">Beschreibung (optional)</label>
                                    <textarea id="lp_archive_description" name="description" rows="3" placeholder="Zusätzliche Informationen zum Archiv..."
                                              class="w-full px-3 py-2.5"></textarea>
                                </div>
                                <button type="submit" class="w-full py-3 px-4 text-sm">Archiv erstellen</button>
                            </form>
                        </div>
                        <div class="lp-card lp-shadow p-6">
                            <h3 class="lp-display text-lg mb-4">Vorhandene Archive</h3>
                            @if($archives->count() > 0)
                                <ul class="space-y-3">
                                    @foreach($archives as $archive)
                                        <li class="bg-white border-2 lp-bord rounded-xl p-3.5">
                                            <div class="flex items-start justify-between gap-3">
                                                <div class="min-w-0">
                                                    <a href="{{ route('archive.show', $archive->id) }}"
                                                       class="font-extrabold break-words hover:text-[color:var(--lp-accent)] transition-colors">
                                                        {{ $archive->name }} →
                                                    </a>
                                                    <span class="lp-muted text-xs block mt-0.5">
                                                        {{ $archive->archived_date->format('d.m.Y') }}
                                                        @if($archive->description)
                                                            · {{ Str::limit($archive->description, 50) }}
                                                        @endif
                                                    </span>
                                                </div>
                                                <form action="{{ route('archive.destroy', $archive->id) }}" method="POST"
                                                      onsubmit="return confirm('Archiv {{ $archive->name }} wirklich löschen? Diese Aktion kann nicht rückgängig gemacht werden!');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="shrink-0 w-8 h-8 grid place-items-center rounded-lg border-2 lp-bord text-sm font-extrabold transition-colors hover:text-white"
                                                            onmouseover="this.style.background='var(--lp-accent)'" onmouseout="this.style.background=''"
                                                            title="Archiv löschen">✕</button>
                                                </form>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="lp-muted italic text-sm">Keine Archive vorhanden.</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- PANEL: Urkunden --}}
                <div x-show="activePanel === 'urkunden'"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    <span class="lp-kicker">Siegerehrung</span>
                    <h2 class="lp-display text-2xl md:text-3xl mt-3 mb-6">Urkunden & Zertifikate</h2>
                    <div class="max-w-xl">
                        <div class="lp-card lp-shadow p-6 lp-form">
                            <livewire:certificate-generator/>
                        </div>
                        <p class="lp-muted mt-4 text-sm">
                            Hinweis: Die Urkunden werden als PDF generiert. Bitte stelle sicher, dass Popups erlaubt sind.
                        </p>
                    </div>
                </div>

                {{-- Activity Log --}}
                <div class="mt-12 lp-card lp-shadow p-5">
                    <livewire:activity-log/>
                </div>
            </div>
        </section>
        <div class="lp-checker h-4 border-t-2 lp-bord" aria-hidden="true"></div>
    </div>

    {{-- ===================== DARK MODE – unverändert ===================== --}}
    <div class="dark-mode-only">
    <div class="bg-gradient-to-br from-blue-100 to-green-100 transition-colors duration-300 dark:bg-none">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100 transition-colors duration-300">

                @if(session('success'))
                    <div
                        class="mb-6 p-4 text-sm text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded-lg border border-green-200 dark:border-green-700 shadow-sm dark:shadow-gray-900/50 transition-colors duration-300"
                        role="alert">
                        <span class="font-medium">Erfolg!</span> {{ session('success') }}

                        @if(session('user_created'))
                            <div
                                class="mt-2 p-3 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 rounded transition-colors duration-300">
                                <p class="font-medium text-blue-700 dark:text-blue-400 transition-colors duration-300">
                                    Anmeldedaten für die Klasse wurden erstellt:</p>
                                <div class="mt-1 grid grid-cols-2 gap-2">
                                    <div>
                                        <span class="font-medium">Benutzername:</span>
                                        <span
                                            class="font-mono bg-white night-card dark:bg-gray-700 px-2 py-1 rounded border border-gray-200 dark:border-gray-600 transition-colors duration-300">{{ session('username') }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium">Passwort:</span>
                                        <span
                                            class="font-mono bg-white night-card dark:bg-gray-700 px-2 py-1 rounded border border-gray-200 dark:border-gray-600 transition-colors duration-300">{{ session('password') }}</span>
                                    </div>
                                </div>
                                <p class="mt-2 text-xs text-gray-600 dark:text-gray-400 transition-colors duration-300">
                                    Bitte notieren Sie sich diese Daten, sie werden nur einmal angezeigt!</p>
                            </div>
                        @endif
                    </div>
                @endif

                @if ($errors->any())
                    <div
                        class="mb-6 p-4 text-sm text-red-700 dark:text-red-400 bg-red-100 dark:bg-red-900/30 rounded-lg border border-red-200 dark:border-red-700 shadow-sm dark:shadow-gray-900/50 transition-colors duration-300"
                        role="alert">
                        <span class="font-medium">Fehler!</span> Bitte überprüfe die Eingaben in den Formularen.
                        <ul class="mt-1.5 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Admin Kachelmenü + Panels --}}
                <div x-data="{
                         activePanel: null,
                         openPanel(name) {
                             this.activePanel = name;
                             history.pushState({ adminPanel: name }, '', '?panel=' + name);
                             window.scrollTo({ top: 0, behavior: 'smooth' });
                         }
                     }"
                     x-init="
                         const panel = new URLSearchParams(window.location.search).get('panel');
                         if (panel) {
                             activePanel = panel;
                         }
                         window.addEventListener('popstate', (e) => {
                             activePanel = (e.state && e.state.adminPanel) ? e.state.adminPanel : null;
                             window.scrollTo({ top: 0, behavior: 'smooth' });
                         });
                     ">

                    {{-- Kachelmenü --}}
                    <div x-show="activePanel === null"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100">

                        <h2 class="display-font text-2xl font-semibold mb-6 text-center text-gray-800 dark:text-gray-200 transition-colors duration-300">
                            Was möchtest du tun?
                        </h2>

                        <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-8 gap-4">

                            {{-- Nachricht --}}
                            <button @click="openPanel('nachricht')"
                                class="group flex flex-col items-center justify-center gap-3 p-5 rounded-2xl bg-white dark:bg-gray-800 border-2 border-blue-200 dark:border-blue-700 hover:border-blue-500 dark:hover:border-blue-400 hover:shadow-lg dark:shadow-gray-900/50 hover:scale-105 transition-all duration-200 cursor-pointer text-center">
                                <span class="text-3xl">📨</span>
                                <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">Nachricht</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 leading-tight">Broadcast senden</span>
                            </button>

                            {{-- Punktesystem --}}
                            <button @click="openPanel('punktesystem')"
                                class="group flex flex-col items-center justify-center gap-3 p-5 rounded-2xl bg-white dark:bg-gray-800 border-2 border-amber-200 dark:border-amber-700 hover:border-amber-500 dark:hover:border-amber-400 hover:shadow-lg dark:shadow-gray-900/50 hover:scale-105 transition-all duration-200 cursor-pointer text-center">
                                <span class="text-3xl">⚙️</span>
                                <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">Punktesystem</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 leading-tight">Wertung anpassen</span>
                            </button>

                            {{-- Schulen --}}
                            <button @click="openPanel('schulen')"
                                class="group flex flex-col items-center justify-center gap-3 p-5 rounded-2xl bg-white dark:bg-gray-800 border-2 border-purple-200 dark:border-purple-700 hover:border-purple-500 dark:hover:border-purple-400 hover:shadow-lg dark:shadow-gray-900/50 hover:scale-105 transition-all duration-200 cursor-pointer text-center">
                                <span class="text-3xl">🏫</span>
                                <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">Schulen</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 leading-tight">Schule erstellen</span>
                            </button>

                            {{-- Klassen --}}
                            <button @click="openPanel('klassen')"
                                class="group flex flex-col items-center justify-center gap-3 p-5 rounded-2xl bg-white dark:bg-gray-800 border-2 border-green-200 dark:border-green-700 hover:border-green-500 dark:hover:border-green-400 hover:shadow-lg dark:shadow-gray-900/50 hover:scale-105 transition-all duration-200 cursor-pointer text-center">
                                <span class="text-3xl">👥</span>
                                <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">Klassen</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 leading-tight">Klasse erstellen</span>
                            </button>

                            {{-- Teams --}}
                            <button @click="openPanel('teams')"
                                class="group flex flex-col items-center justify-center gap-3 p-5 rounded-2xl bg-white dark:bg-gray-800 border-2 border-pink-200 dark:border-pink-700 hover:border-pink-500 dark:hover:border-pink-400 hover:shadow-lg dark:shadow-gray-900/50 hover:scale-105 transition-all duration-200 cursor-pointer text-center">
                                <span class="text-3xl">🏆</span>
                                <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">Teams</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 leading-tight">Team erstellen</span>
                            </button>

                            {{-- Disziplinen --}}
                            <button @click="openPanel('disziplinen')"
                                class="group flex flex-col items-center justify-center gap-3 p-5 rounded-2xl bg-white dark:bg-gray-800 border-2 border-orange-200 dark:border-orange-700 hover:border-orange-500 dark:hover:border-orange-400 hover:shadow-lg dark:shadow-gray-900/50 hover:scale-105 transition-all duration-200 cursor-pointer text-center">
                                <span class="text-3xl">⚡</span>
                                <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">Disziplinen</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 leading-tight">Disziplin erstellen</span>
                            </button>

                            {{-- Archiv --}}
                            <button @click="openPanel('archiv')"
                                class="group flex flex-col items-center justify-center gap-3 p-5 rounded-2xl bg-white dark:bg-gray-800 border-2 border-indigo-200 dark:border-indigo-700 hover:border-indigo-500 dark:hover:border-indigo-400 hover:shadow-lg dark:shadow-gray-900/50 hover:scale-105 transition-all duration-200 cursor-pointer text-center">
                                <span class="text-3xl">📚</span>
                                <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">Archiv</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 leading-tight">Archiv anlegen</span>
                            </button>

                            {{-- Urkunden --}}
                            <button @click="openPanel('urkunden')"
                                class="group flex flex-col items-center justify-center gap-3 p-5 rounded-2xl bg-white dark:bg-gray-800 border-2 border-teal-200 dark:border-teal-700 hover:border-teal-500 dark:hover:border-teal-400 hover:shadow-lg dark:shadow-gray-900/50 hover:scale-105 transition-all duration-200 cursor-pointer text-center">
                                <span class="text-3xl">📜</span>
                                <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">Urkunden</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 leading-tight">Urkunde drucken</span>
                            </button>

                        </div>
                    </div>

                    {{-- Zurück-Button (sichtbar wenn Panel offen) --}}
                    <div x-show="activePanel !== null" class="mb-6">
                        <button @click="activePanel = null; history.pushState({ adminPanel: null }, '', '?')"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-400 dark:hover:border-gray-500 transition-all duration-200 shadow-sm font-medium text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Zurück zur Übersicht
                        </button>
                    </div>

                    {{-- PANEL: Nachricht --}}
                    <div x-show="activePanel === 'nachricht'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <h2 class="display-font text-3xl sm:text-2xl font-semibold mb-8 sm:mb-6 text-center text-gray-800 dark:text-gray-200 border-b-2 border-blue-500 dark:border-blue-600 pb-4 transition-colors duration-300">
                            Nachricht senden
                        </h2>
                        <div class="bg-gray-50 night-panel dark:bg-gray-800 p-6 rounded-lg shadow dark:shadow-gray-900/50 border border-gray-200 dark:border-gray-600 transition-colors duration-300">
                            <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200 transition-colors duration-300">Schnellnachricht</h3>
                            <form action="{{ route('admin.broadcast') }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="admin_message"
                                           class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 transition-colors duration-300">
                                        Nachricht *
                                    </label>
                                    <textarea id="admin_message"
                                              name="message"
                                              rows="4"
                                              maxlength="500"
                                              required
                                              placeholder="Kurze Nachricht an die ausgewählten Gruppen..."
                                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 transition-colors duration-300">{{ old('message') }}</textarea>
                                </div>
                                <div>
                                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 transition-colors duration-300">
                                        Empfaenger *
                                    </span>
                                    @php($oldTargets = old('targets', []))
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                        <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-md px-3 py-2 transition-colors duration-300">
                                            <input type="checkbox" name="targets[]" value="teachers"
                                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                                {{ in_array('teachers', $oldTargets, true) ? 'checked' : '' }}>
                                            Lehrer
                                        </label>
                                        <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-md px-3 py-2 transition-colors duration-300">
                                            <input type="checkbox" name="targets[]" value="klasses"
                                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                                {{ in_array('klasses', $oldTargets, true) ? 'checked' : '' }}>
                                            Klassen
                                        </label>
                                        <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-md px-3 py-2 transition-colors duration-300">
                                            <input type="checkbox" name="targets[]" value="guests"
                                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                                {{ in_array('guests', $oldTargets, true) ? 'checked' : '' }}>
                                            Guests
                                        </label>
                                    </div>
                                </div>
                                <button type="submit"
                                        class="w-full bg-gradient-to-r from-blue-500 to-indigo-500 dark:from-blue-600 dark:to-indigo-600 text-white py-2 px-4 rounded-lg hover:from-blue-600 hover:to-indigo-600 dark:hover:from-blue-700 dark:hover:to-indigo-700 transition-colors duration-200 font-medium shadow-md dark:shadow-gray-900/50">
                                    Nachricht senden
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- PANEL: Punktesystem --}}
                    <div x-show="activePanel === 'punktesystem'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <h2 class="display-font text-3xl sm:text-2xl font-semibold mb-8 sm:mb-6 text-center text-gray-800 dark:text-gray-200 border-b-2 border-amber-500 dark:border-amber-600 pb-4 transition-colors duration-300">
                            ⚙️ Punktesystem
                        </h2>
                        <x-scoresystem-form :scoresystem="$scoresystem" :autoSchoolTeams="$autoSchoolTeams"/>
                    </div>

                    {{-- PANEL: Schulen --}}
                    <div x-show="activePanel === 'schulen'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <h2 class="display-font text-3xl sm:text-2xl font-semibold mb-8 sm:mb-6 text-center text-gray-800 dark:text-gray-200 border-b-2 border-purple-400 dark:border-purple-600 pb-4 transition-colors duration-300">
                            🏫 Schulen
                        </h2>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <div class="bg-gray-50 night-panel dark:bg-gray-800 p-6 rounded-lg shadow dark:shadow-gray-900/50 border border-gray-200 dark:border-gray-600 transition-colors duration-300">
                                <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200 transition-colors duration-300">Neue Schule anlegen</h3>
                                <x-school-form/>
                            </div>
                            <div class="bg-gray-50 night-panel dark:bg-gray-800 p-6 rounded-lg shadow dark:shadow-gray-900/50 border border-gray-200 dark:border-gray-600 transition-colors duration-300">
                                <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200 transition-colors duration-300">Vorhandene Schulen</h3>
                                @if($schools->count() > 0)
                                    <ul class="space-y-2">
                                        @foreach($schools as $school)
                                            <li class="bg-white night-card dark:bg-gray-700 p-3 rounded shadow-sm dark:shadow-gray-900/50 border border-gray-100 dark:border-gray-600 transition-colors duration-300">
                                                <div class="flex items-center justify-between gap-3">
                                                    <span class="text-gray-700 dark:text-gray-200 transition-colors duration-300">{{ $school->name }}</span>
                                                    <form action="{{ route('schools.destroy', $school->id) }}" method="POST"
                                                          onsubmit="return confirm('Schule {{ $school->name }} wirklich löschen? Alle zugehörigen Klassen, Teams und Disziplinen werden ebenfalls gelöscht!');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 transition-colors duration-150 p-1 rounded hover:bg-red-100 dark:hover:bg-red-900/30"
                                                                title="Schule löschen">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                                <details class="mt-3">
                                                    <summary class="cursor-pointer text-xs text-blue-600 dark:text-blue-400 hover:underline">Bearbeiten</summary>
                                                    <form action="{{ route('schools.update', $school->id) }}" method="POST" class="mt-2 grid grid-cols-1 gap-2">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="text" name="name" value="{{ old('name', $school->name) }}" required maxlength="255"
                                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                                        <button type="submit"
                                                                class="inline-flex justify-center rounded-md bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-700">
                                                            Änderungen speichern
                                                        </button>
                                                    </form>
                                                </details>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="italic text-gray-500 dark:text-gray-400 transition-colors duration-300">Keine Schulen vorhanden.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- PANEL: Klassen --}}
                    <div x-show="activePanel === 'klassen'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <h2 class="display-font text-3xl sm:text-2xl font-semibold mb-8 sm:mb-6 text-center text-gray-800 dark:text-gray-200 border-b-2 border-green-500 dark:border-green-600 pb-4 transition-colors duration-300">
                            👥 Klassen
                        </h2>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <div class="bg-gray-50 night-panel dark:bg-gray-800 p-6 rounded-lg shadow dark:shadow-gray-900/50 border border-gray-200 dark:border-gray-600 transition-colors duration-300">
                                <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200 transition-colors duration-300">Neue Klasse anlegen</h3>
                                @if($schools->count() > 0)
                                    <x-klasse-form :schools="$schools"/>
                                @else
                                    <p class="text-red-600 dark:text-red-400 italic transition-colors duration-300">Bitte zuerst eine Schule anlegen!</p>
                                @endif
                            </div>
                            <div class="bg-gray-50 night-panel dark:bg-gray-800 p-6 rounded-lg shadow dark:shadow-gray-900/50 border border-gray-200 dark:border-gray-600 transition-colors duration-300">
                                <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200 transition-colors duration-300">Vorhandene Klassen</h3>
                                @if($klasses->count() > 0)
                                    <ul class="space-y-2">
                                        @foreach($klasses as $klasse)
                                            <li class="bg-white night-card dark:bg-gray-700 p-3 rounded shadow-sm dark:shadow-gray-900/50 border border-gray-100 dark:border-gray-600 transition-colors duration-300">
                                                <div class="flex items-center justify-between gap-3">
                                                    <div>
                                                        <span class="text-gray-700 dark:text-gray-200 transition-colors duration-300">{{ $klasse->name }}</span>
                                                        <span class="text-xs text-gray-500 dark:text-gray-400 ml-2 transition-colors duration-300">({{ $klasse->school->name ?? 'Keine Schule' }})</span>
                                                        <br>
                                                        <span class="text-xs text-blue-500 dark:text-blue-400 ml-2 transition-colors duration-300 inline-flex items-center gap-1.5" data-pw-container>Password:&nbsp;<span data-pw-mask>••••••••</span><button type="button" data-pw-toggle data-klasse="{{ $klasse->id }}" title="Passwort anzeigen" aria-label="Passwort anzeigen">👁</button></span>
                                                    </div>
                                                    <form action="{{ route('klasses.destroy', $klasse->id) }}" method="POST"
                                                          onsubmit="return confirm('Klasse {{ $klasse->name }} wirklich löschen? Alle zugehörigen Teams und Disziplinen werden ebenfalls gelöscht!');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 transition-colors duration-150 p-1 rounded hover:bg-red-100 dark:hover:bg-red-900/30"
                                                                title="Klasse löschen">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                                <details class="mt-3">
                                                    <summary class="cursor-pointer text-xs text-blue-600 dark:text-blue-400 hover:underline">Bearbeiten</summary>
                                                    <form action="{{ route('klasses.update', $klasse->id) }}" method="POST" class="mt-2 grid grid-cols-1 gap-2">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="text" name="klasse_name" value="{{ old('klasse_name', $klasse->name) }}" required maxlength="255"
                                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                                        <select name="school_id" required
                                                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                                            @foreach($schools as $schoolOption)
                                                                <option value="{{ $schoolOption->id }}" {{ (int) old('school_id', $klasse->school_id) === (int) $schoolOption->id ? 'selected' : '' }}>{{ $schoolOption->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <button type="submit"
                                                                class="inline-flex justify-center rounded-md bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-700">
                                                            Änderungen speichern
                                                        </button>
                                                    </form>
                                                </details>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="italic text-gray-500 dark:text-gray-400 transition-colors duration-300">Keine Klassen vorhanden.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- PANEL: Teams --}}
                    <div x-show="activePanel === 'teams'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <h2 class="display-font text-3xl sm:text-2xl font-semibold mb-8 sm:mb-6 text-center text-gray-800 dark:text-gray-200 border-b-2 border-pink-500 dark:border-pink-600 pb-4 transition-colors duration-300">
                            🏆 Teams
                        </h2>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <div class="bg-gray-50 night-panel dark:bg-gray-800 p-6 rounded-lg shadow dark:shadow-gray-900/50 border border-gray-200 dark:border-gray-600 transition-colors duration-300">
                                <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200 transition-colors duration-300">Neues Team anlegen</h3>
                                @if($klasses->count() > 0)
                                    <x-team-form :klasses="$klasses"/>
                                @else
                                    <p class="text-red-600 dark:text-red-400 italic transition-colors duration-300">Bitte zuerst eine Klasse anlegen!</p>
                                @endif
                            </div>
                            <div class="bg-gray-50 night-panel dark:bg-gray-800 p-6 rounded-lg shadow dark:shadow-gray-900/50 border border-gray-200 dark:border-gray-600 transition-colors duration-300">
                                <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200 transition-colors duration-300">Vorhandene Teams</h3>
                                @if($teams->count() > 0)
                                    <ul class="space-y-2">
                                        @foreach($teams as $team)
                                            <li class="bg-white night-card dark:bg-gray-700 p-3 rounded shadow-sm dark:shadow-gray-900/50 border border-gray-100 dark:border-gray-600 transition-colors duration-300">
                                                <div class="flex items-center justify-between gap-3">
                                                    <div>
                                                        <span class="text-gray-700 dark:text-gray-200 transition-colors duration-300">{{ $team->name }}</span>
                                                        <span class="text-xs text-gray-500 dark:text-gray-400 ml-2 transition-colors duration-300">({{ $team->klasse->name ?? 'Keine Klasse' }})</span>
                                                    </div>
                                                    <form action="{{ route('teams.destroy', $team->id) }}" method="POST"
                                                          onsubmit="return confirm('Team {{ $team->name }} wirklich löschen?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 transition-colors duration-150 p-1 rounded hover:bg-red-100 dark:hover:bg-red-900/30"
                                                                title="Team löschen">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                                <details class="mt-3">
                                                    <summary class="cursor-pointer text-xs text-blue-600 dark:text-blue-400 hover:underline">Bearbeiten</summary>
                                                    <form action="{{ route('teams.update', $team->id) }}" method="POST" class="mt-2 grid grid-cols-1 gap-2">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="text" name="team_name" value="{{ old('team_name', $team->name) }}" required maxlength="255"
                                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                                        <select name="klasse_id" required
                                                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                                            @foreach($klasses as $klasseOption)
                                                                <option value="{{ $klasseOption->id }}" {{ (int) old('klasse_id', $team->klasse_id) === (int) $klasseOption->id ? 'selected' : '' }}>{{ $klasseOption->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <textarea name="members" rows="3"
                                                                  placeholder="Mitglieder (pro Zeile ein Name)"
                                                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">{{ old('members', is_array($team->members) ? implode("\n", $team->members) : '') }}</textarea>
                                                        <button type="submit"
                                                                class="inline-flex justify-center rounded-md bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-700">
                                                            Änderungen speichern
                                                        </button>
                                                    </form>
                                                </details>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="italic text-gray-500 dark:text-gray-400 transition-colors duration-300">Keine Teams vorhanden.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- PANEL: Disziplinen --}}
                    <div x-show="activePanel === 'disziplinen'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <h2 class="display-font text-3xl sm:text-2xl font-semibold mb-8 sm:mb-6 text-center text-gray-800 dark:text-gray-200 border-b-2 border-orange-400 dark:border-orange-600 pb-4 transition-colors duration-300">
                            ⚡ Disziplinen
                        </h2>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <div class="bg-gray-50 night-panel dark:bg-gray-800 p-6 rounded-lg shadow dark:shadow-gray-900/50 border border-gray-200 dark:border-gray-600 transition-colors duration-300">
                                <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200 transition-colors duration-300">Neue Disziplin anlegen</h3>
                                @if($klasses->count() > 0)
                                    <x-discipline-form :disciplineklasses="$disciplineklasses"/>
                                @else
                                    <p class="text-red-600 dark:text-red-400 italic transition-colors duration-300">Bitte zuerst eine Klasse anlegen!</p>
                                @endif
                            </div>
                            <div class="bg-gray-50 night-panel dark:bg-gray-800 p-6 rounded-lg shadow dark:shadow-gray-900/50 border border-gray-200 dark:border-gray-600 transition-colors duration-300">
                                <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200 transition-colors duration-300">Vorhandene Disziplinen</h3>
                                @if($disciplines->count() > 0)
                                    <ul class="space-y-2">
                                        @foreach($disciplines as $discipline)
                                            <li class="bg-white night-card dark:bg-gray-700 p-3 rounded shadow-sm dark:shadow-gray-900/50 border border-gray-100 dark:border-gray-600 transition-colors duration-300">
                                                <div class="flex items-center justify-between gap-3">
                                                    <div>
                                                        <span class="text-gray-700 dark:text-gray-200 transition-colors duration-300">{{ $discipline->name }}</span>
                                                        <span class="text-xs text-gray-500 dark:text-gray-400 ml-2 transition-colors duration-300">({{ $discipline->klasse->name ?? 'Keine Klasse' }})</span>
                                                        <br>
                                                        @if($discipline->higher_is_better)
                                                            <p class="text-xs text-green-500 dark:text-green-400 transition-colors duration-300">Höher ist besser</p>
                                                        @else
                                                            <p class="text-xs text-red-500 dark:text-red-400 transition-colors duration-300">Niedriger ist besser</p>
                                                        @endif
                                                    </div>
                                                    <form action="{{ route('disciplines.destroy', $discipline->id) }}" method="POST"
                                                          onsubmit="return confirm('Disziplin {{ $discipline->name }} wirklich löschen?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 transition-colors duration-150 p-1 rounded hover:bg-red-100 dark:hover:bg-red-900/30"
                                                                title="Disziplin löschen">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                                <details class="mt-3">
                                                    <summary class="cursor-pointer text-xs text-blue-600 dark:text-blue-400 hover:underline">Bearbeiten</summary>
                                                    <form action="{{ route('disciplines.update', $discipline->id) }}" method="POST" class="mt-2 grid grid-cols-1 gap-2">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="text" name="discipline_name" value="{{ old('discipline_name', $discipline->name) }}" required maxlength="255"
                                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                                        <select name="klasse_id" required
                                                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                                            @foreach($klasses as $klasseOption)
                                                                <option value="{{ $klasseOption->id }}" {{ (int) old('klasse_id', $discipline->klasse_id) === (int) $klasseOption->id ? 'selected' : '' }}>{{ $klasseOption->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <select name="higher_is_better" required
                                                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                                            <option value="1" {{ (string) old('higher_is_better', (int) $discipline->higher_is_better) === '1' ? 'selected' : '' }}>Höher ist besser</option>
                                                            <option value="0" {{ (string) old('higher_is_better', (int) $discipline->higher_is_better) === '0' ? 'selected' : '' }}>Niedriger ist besser</option>
                                                        </select>
                                                        <input type="text" name="description" value="{{ old('description', $discipline->description) }}" maxlength="255"
                                                               placeholder="Beschreibung (optional)"
                                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                                        <button type="submit"
                                                                class="inline-flex justify-center rounded-md bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-700">
                                                            Änderungen speichern
                                                        </button>
                                                    </form>
                                                </details>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="italic text-gray-500 dark:text-gray-400 transition-colors duration-300">Keine Disziplinen vorhanden.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- PANEL: Archiv --}}
                    <div x-show="activePanel === 'archiv'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <h2 class="display-font text-3xl sm:text-2xl font-semibold mb-8 sm:mb-6 text-center text-gray-800 dark:text-gray-200 border-b-2 border-indigo-500 dark:border-indigo-600 pb-4 transition-colors duration-300">
                            📚 Archiv
                        </h2>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <div class="bg-gray-50 night-panel dark:bg-gray-800 p-6 rounded-lg shadow dark:shadow-gray-900/50 border border-gray-200 dark:border-gray-600 transition-colors duration-300">
                                <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200 transition-colors duration-300">Neues Archiv erstellen</h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm transition-colors duration-300">Erstellen Sie ein Archiv mit allen aktuellen Daten der CampusOlympiade.</p>
                                <form action="{{ route('archive.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="archive_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 transition-colors duration-300">Archiv Name *</label>
                                        <input type="text" id="archive_name" name="name" required placeholder="z.B. CampusOlympiade 2024"
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 transition-colors duration-300">
                                    </div>
                                    <div class="mb-4">
                                        <label for="archive_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 transition-colors duration-300">Beschreibung (optional)</label>
                                        <textarea id="archive_description" name="description" rows="3" placeholder="Zusätzliche Informationen zum Archiv..."
                                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 transition-colors duration-300"></textarea>
                                    </div>
                                    <button type="submit"
                                            class="w-full bg-gradient-to-r from-indigo-500 to-blue-500 dark:from-indigo-600 dark:to-blue-600 text-white py-2 px-4 rounded-lg hover:from-indigo-600 hover:to-blue-600 dark:hover:from-indigo-700 dark:hover:to-blue-700 transition-colors duration-200 font-medium shadow-md dark:shadow-gray-900/50">
                                        📚 Archiv erstellen
                                    </button>
                                </form>
                            </div>
                            <div class="bg-gray-50 night-panel dark:bg-gray-800 p-6 rounded-lg shadow dark:shadow-gray-900/50 border border-gray-200 dark:border-gray-600 transition-colors duration-300">
                                <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200 transition-colors duration-300">Vorhandene Archive</h3>
                                @if($archives->count() > 0)
                                    <ul class="space-y-2">
                                        @foreach($archives as $archive)
                                            <li class="flex items-center justify-between bg-white night-card dark:bg-gray-700 p-3 rounded shadow-sm dark:shadow-gray-900/50 border border-gray-100 dark:border-gray-600 transition-colors duration-300">
                                                <div class="flex-1">
                                                    <div class="flex items-center gap-2">
                                                        <span class="text-gray-700 dark:text-gray-200 font-medium transition-colors duration-300">{{ $archive->name }}</span>
                                                        <a href="{{ route('archive.show', $archive->id) }}"
                                                           class="text-blue-500 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors duration-150"
                                                           title="Archiv anzeigen">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 transition-colors duration-300">
                                                        {{ $archive->archived_date->format('d.m.Y') }}
                                                        @if($archive->description)
                                                            <br>{{ Str::limit($archive->description, 50) }}
                                                        @endif
                                                    </div>
                                                </div>
                                                <form action="{{ route('archive.destroy', $archive->id) }}" method="POST"
                                                      onsubmit="return confirm('Archiv {{ $archive->name }} wirklich löschen? Diese Aktion kann nicht rückgängig gemacht werden!');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 transition-colors duration-150 p-1 rounded hover:bg-red-100 dark:hover:bg-red-900/30"
                                                            title="Archiv löschen">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="italic text-gray-500 dark:text-gray-400 transition-colors duration-300">Keine Archive vorhanden.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- PANEL: Urkunden --}}
                    <div x-show="activePanel === 'urkunden'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <h2 class="display-font text-3xl sm:text-2xl font-semibold mb-8 sm:mb-6 text-center text-gray-800 dark:text-gray-200 border-b-2 border-teal-500 dark:border-teal-600 pb-4 transition-colors duration-300">
                            📜 Urkunden & Zertifikate
                        </h2>
                        <div class="max-w-xl mx-auto">
                            <livewire:certificate-generator/>
                            <p class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400">
                                Hinweis: Die Urkunden werden als PDF generiert. Bitte stellen Sie sicher, dass Popups erlaubt sind.
                            </p>
                        </div>
                    </div>

                </div>

                {{-- Activity Log --}}
                <div class="mt-10 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-xl p-5 shadow-sm dark:shadow-gray-900/50 transition-colors duration-300">
                    <livewire:activity-log />
                </div>

            </div>
        </div>
    </div>
    </div>
    <script>
        // Klassen-Passwort: wird erst beim Klick aufs Auge vom Server
        // entschlüsselt nachgeladen und beim erneuten Klick wieder verborgen.
        document.addEventListener('click', async function (e) {
            const btn = e.target.closest('[data-pw-toggle]');
            if (!btn) return;

            const container = btn.closest('[data-pw-container]');
            const mask = container && container.querySelector('[data-pw-mask]');
            if (!mask) return;

            // Bereits sichtbar -> verbergen (Klartext verlässt das DOM wieder)
            if (btn.dataset.shown === '1') {
                mask.textContent = '••••••••';
                btn.dataset.shown = '0';
                btn.title = 'Passwort anzeigen';
                return;
            }

            mask.textContent = '…';
            try {
                const res = await fetch('/klasses/' + btn.dataset.klasse + '/password', {
                    headers: { 'Accept': 'application/json' }
                });
                if (!res.ok) throw new Error('HTTP ' + res.status);
                const data = await res.json();
                mask.textContent = data.password ?? '';
                btn.dataset.shown = '1';
                btn.title = 'Passwort verbergen';
            } catch (err) {
                mask.textContent = 'Fehler';
            }
        });
    </script>
</x-layout>
