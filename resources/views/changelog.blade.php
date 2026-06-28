<x-layout>
    <x-slot:heading>Changelog</x-slot:heading>

    @include('partials.lp-theme')

    @php
        // ---------------------------------------------------------------
        // Changelog – hartkodierte Timeline (neueste Änderung oben).
        // Basiert auf den echten Deploy-Daten aus der Git-Historie.
        // Mehrere Uploads desselben Tages sind zusammengefasst;
        // zurückgenommene Änderungen (Reverts) sind bewusst nicht gelistet.
        //
        // Großes Update? 'major' => true und 'version' => '1.0' setzen –
        // dann wird der Eintrag als Meilenstein hervorgehoben.
        //
        // Neuen Eintrag einfach oben hinzufügen:
        //   ['date' => '2026-07-01', 'tag' => 'feature', 'title' => '…',
        //    'points' => ['…', '…']],
        // Erlaubte tags: feature, design, fix, security, maintenance
        // ---------------------------------------------------------------
        $entries = [
            [
                'date' => '2026-06-19', 'tag' => 'security',
                'title' => 'Datenschutz & DSGVO',
                'points' => [
                    'IP-Adressen bei Kommentaren werden nach 30 Tagen automatisch gelöscht, der Kommentar bleibt',
                    'Datenschutzerklärung überarbeitet – steht jetzt klar drin, was die KI-Moderation macht',
                    'Klassen-Passwörter im Admin per Auge ein- und ausblendbar',
                ],
            ],
            [
                'date' => '2026-06-14', 'tag' => 'design', 'major' => true, 'version' => '2.0',
                'title' => 'Neues Design & Live-Feed',
                'points' => [
                    'Startseite komplett neu im Poster-Stil – Ranking, Laufzettel, Archiv, Admin und Login gleich mit',
                    'Live-Bereich mit Podium, Ticker und Uhr, der sich von selbst aktualisiert',
                    'Farbpunkte zeigen sofort, zu welcher Schule ein Team gehört',
                ],
            ],
            [
                'date' => '2026-06-12', 'tag' => 'fix',
                'title' => 'Stabilität & Sicherheit',
                'points' => [
                    'Sicherheit und Performance verbessert',
                    'Zurück-Button und eine kaputte Weiterleitung gefixt',
                ],
            ],
            [
                'date' => '2026-05-22', 'tag' => 'maintenance',
                'title' => 'Technische Wartung',
                'points' => [
                    'Moderation: doppelte Anfragen und ein Anzeigefehler weg',
                    'Code aufgeräumt, Sicherheitsupdate für die Bibliotheken',
                ],
            ],
            [
                'date' => '2026-05-21', 'tag' => 'feature', 'major' => true, 'version' => '1.7',
                'title' => 'Mobile & App-Installation',
                'points' => [
                    'App-Installation überarbeitet – die Seite lässt sich wie eine App aufs Handy legen',
                    'Navbar, Burger-Menü und Besucherzähler gefixt',
                    'Moderation: Filter nach IP und Erkennung gefakter Beiträge',
                ],
            ],
            [
                'date' => '2026-05-04', 'tag' => 'design',
                'title' => 'Navigationsleiste',
                'points' => [
                    'Scroll-Verhalten und Animation der Navbar verbessert',
                ],
            ],
            [
                'date' => '2026-04-05', 'tag' => 'design',
                'title' => 'Performance & Admin-Redesign',
                'points' => [
                    'Großer Performance-Durchgang, läuft spürbar flotter',
                    'Admin-Oberfläche neu gemacht',
                ],
            ],
            [
                'date' => '2026-04-04', 'tag' => 'feature', 'major' => true, 'version' => '1.6',
                'title' => 'Echtzeit-Updates & Aktivitätsprotokoll',
                'points' => [
                    'Live-Updates ohne Neuladen',
                    'Aktivitätsprotokoll für Admins',
                    'Schul-Logos auf den Urkunden, Logo im QR-Code vom Laufzettel',
                    'ein paar Kommentar-Fixes',
                ],
            ],
            [
                'date' => '2026-03-01', 'tag' => 'fix',
                'title' => 'Dark-Mode-Verbesserungen',
                'points' => [
                    'Login-Seite im Dark Mode gefixt',
                    'Karussell-Buttons und Punkt-Anzeige im Admin gerade gezogen',
                ],
            ],
            [
                'date' => '2026-02-26', 'tag' => 'fix',
                'title' => 'Kommentare & mobile Navigation',
                'points' => [
                    'Bug gefixt, durch den die Kommentar-Einwilligung nie griff',
                    'mehr Platz für die Navigation im Handy-Menü',
                ],
            ],
            [
                'date' => '2026-02-16', 'tag' => 'feature', 'major' => true, 'version' => '1.5',
                'title' => 'QR-Code & System-Design',
                'points' => [
                    'QR-Code-Funktion (erstmal experimentell) und ein aufgeräumteres Layout',
                    'neue Option: Hell/Dunkel nach Systemeinstellung',
                ],
            ],
            [
                'date' => '2026-02-12', 'tag' => 'feature', 'major' => true, 'version' => '1.4',
                'title' => 'Urkunden-Druck',
                'points' => [
                    'Urkunden lassen sich jetzt direkt im Admin drucken',
                ],
            ],
            [
                'date' => '2026-02-11', 'tag' => 'feature',
                'title' => 'Broadcast & Sicherheit',
                'points' => [
                    'Broadcast-Nachrichten erweitert, dazu Sicherheitsupdates',
                    'Kommentar-Bug gefixt',
                ],
            ],
            [
                'date' => '2026-02-03', 'tag' => 'feature', 'major' => true, 'version' => '1.3',
                'title' => 'Live-Benachrichtigungen',
                'points' => [
                    'Broadcast eingeführt – Admins können Live-Nachrichten an Gäste, Lehrer und Klassen schicken',
                ],
            ],
            [
                'date' => '2026-02-01', 'tag' => 'maintenance',
                'title' => 'Stabilere Fehlerbehandlung',
                'points' => [
                    'Unerwartete Fehler werden im Hintergrund sauberer abgefangen',
                ],
            ],
            [
                'date' => '2026-01-28', 'tag' => 'design',
                'title' => 'Überarbeiteter Dark Mode',
                'points' => [
                    'Dark Mode neu gestaltet',
                    'Bug beim Absenden von Kommentaren gefixt',
                ],
            ],
            [
                'date' => '2025-10-15', 'tag' => 'feature', 'major' => true, 'version' => '1.2',
                'title' => 'KI-Moderation der Kommentare',
                'points' => [
                    'Kommentare werden automatisch von einer KI auf Beleidigungen geprüft',
                    'Disziplinen im Ranking sind jetzt anklickbar und öffnen eine Detailansicht',
                ],
            ],
            [
                'date' => '2025-08-02', 'tag' => 'feature', 'major' => true, 'version' => '1.1',
                'title' => 'Archiv-Funktion',
                'points' => [
                    'Ganze Wettbewerbe lassen sich als Schnappschuss speichern und später wieder ansehen',
                ],
            ],
            [
                'date' => '2025-07-29', 'tag' => 'fix',
                'title' => 'Punkteberechnung',
                'points' => [
                    'Ranking-Berechnung nachgebessert',
                ],
            ],
            [
                'date' => '2025-07-18', 'tag' => 'design',
                'title' => 'Laufzettel & Startseite',
                'points' => [
                    'Laufzettel und Startseite aufgeräumt',
                ],
            ],
            [
                'date' => '2025-07-16', 'tag' => 'feature',
                'title' => 'Punktesystem-Verwaltung',
                'points' => [
                    'Punktevergabe im Admin frei einstellbar, Schulfarben nachgezogen',
                ],
            ],
            [
                'date' => '2025-07-15', 'tag' => 'feature',
                'title' => 'Laufzettel ausgebaut',
                'points' => [
                    'Laufzettel um Detailwerte und Suche erweitert',
                ],
            ],
            [
                'date' => '2025-07-11', 'tag' => 'design',
                'title' => 'Punktesystem verfeinert',
                'points' => [
                    'Eingabemaske fürs Punktesystem überarbeitet, Navigation verbessert',
                ],
            ],
            [
                'date' => '2025-07-10', 'tag' => 'design',
                'title' => 'Ranking mit Schulfarben',
                'points' => [
                    'Schulfarben im Ranking, Podium neu gemacht',
                ],
            ],
            [
                'date' => '2025-07-08', 'tag' => 'design',
                'title' => 'Ranking & Startseite überarbeitet',
                'points' => [
                    'Ranking und Startseite größer überarbeitet',
                ],
            ],
            [
                'date' => '2025-07-07', 'tag' => 'design',
                'title' => 'Bedienung & Oberfläche ausgebaut',
                'points' => [
                    'Ranking, Dashboard und Handy-Navigation deutlich verbessert',
                    'Eingabe reagiert schneller, Admin-Karussell läuft runder',
                ],
            ],
            [
                'date' => '2025-07-02', 'tag' => 'feature', 'major' => true, 'version' => '1.0',
                'title' => 'Punktesystem eingeführt',
                'points' => [
                    'eigenes Wertungssystem als Grundlage der Punktevergabe',
                    'viel an der Verwaltung von Schulen, Klassen und Disziplinen geschraubt',
                ],
            ],
            [
                'date' => '2025-06-11', 'tag' => 'feature', 'major' => true, 'version' => '0.9',
                'title' => 'Laufzettel & Schulfarben',
                'points' => [
                    'Team-Laufzettel als eigene Übersicht',
                    'Farbsystem, um Schulen auf einen Blick zuzuordnen',
                ],
            ],
            [
                'date' => '2025-06-09', 'tag' => 'feature', 'major' => true, 'version' => '0.8',
                'title' => 'Rollen, Rechte & Besucherzähler',
                'points' => [
                    'Rollen für Admin, Lehrer und Klassen',
                    'Zugangsdaten für neue Klassen werden automatisch erzeugt',
                    'Besucherzähler dazu, Kommentare verbessert',
                ],
            ],
            [
                'date' => '2025-04-22', 'tag' => 'feature',
                'title' => 'Ergebniseingabe für Lehrer',
                'points' => [
                    'Eingabemaske, über die Lehrer alle Ergebnisse zentral eintragen',
                ],
            ],
            [
                'date' => '2025-04-21', 'tag' => 'feature', 'major' => true, 'version' => '0.1',
                'title' => 'Projektstart 🎉',
                'points' => [
                    'die erste Version: Schulen, Klassen, Teams und Disziplinen anlegen',
                    'Ergebnisse erfassen, automatisches Live-Ranking, Kommentar-Board',
                    'Admin- und Login-Bereich',
                ],
            ],
        ];

        $tagMeta = [
            'feature'     => ['label' => 'Neu',        'dot' => 'bg-emerald-500', 'badge' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300'],
            'design'      => ['label' => 'Design',     'dot' => 'bg-violet-500',  'badge' => 'bg-violet-100 text-violet-700 dark:bg-violet-900/40 dark:text-violet-300'],
            'fix'         => ['label' => 'Fix',        'dot' => 'bg-amber-500',   'badge' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300'],
            'security'    => ['label' => 'Sicherheit', 'dot' => 'bg-rose-500',    'badge' => 'bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300'],
            'maintenance' => ['label' => 'Wartung',    'dot' => 'bg-slate-400',   'badge' => 'bg-slate-100 text-slate-600 dark:bg-slate-700/60 dark:text-slate-300'],
        ];

        $months = ['', 'Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'];

        $fmtDate = function (string $date) use ($months) {
            [$y, $m, $d] = explode('-', $date);
            return (int) $d . '. ' . $months[(int) $m] . ' ' . $y;
        };
    @endphp

    {{-- =========================================================== --}}
    {{-- LIGHT MODE – Sportposter-Look                                --}}
    {{-- =========================================================== --}}
    <div class="light-mode-only lp-sec-paper -mt-10">
        <section class="max-w-3xl mx-auto px-4 py-12 sm:py-16">
            <div class="text-center">
                <span class="lp-kicker">Changelog</span>
                <h1 class="lp-display text-4xl sm:text-5xl mt-3">Was ist neu?</h1>
                <p class="lp-muted text-sm sm:text-base mt-4 max-w-xl mx-auto">
                    Die Entwicklung der CampusOlympiade – von den ersten Anfängen im April 2025 bis heute.
                </p>
            </div>

            <ol class="mt-12 relative border-s-2 ms-3" style="border-color: var(--lp-ink);">
                @foreach ($entries as $entry)
                    @php
                        $meta = $tagMeta[$entry['tag']] ?? $tagMeta['feature'];
                        $isMajor = !empty($entry['major']);
                    @endphp
                    <li class="ms-7 {{ $isMajor ? 'mb-12' : 'mb-9' }} last:mb-0">
                        @if ($isMajor)
                            {{-- Meilenstein-Marker (Stern) --}}
                            <span class="absolute -start-[1.1rem] mt-1 grid h-9 w-9 place-items-center rounded-full text-base font-black"
                                  style="background: var(--lp-accent); color: #fff; border: 2px solid var(--lp-ink); box-shadow: 3px 3px 0 0 var(--lp-ink);">★</span>

                            <div class="lp-card lp-shadow p-5 sm:p-6">
                                <div class="flex flex-wrap items-center gap-3">
                                    <span class="lp-stamp">v{{ $entry['version'] }}</span>
                                    <time class="lp-muted text-xs font-extrabold uppercase tracking-[0.18em]">{{ $fmtDate($entry['date']) }}</time>
                                </div>
                                <h2 class="lp-display text-2xl sm:text-3xl mt-3">{{ $entry['title'] }}</h2>
                                <ul class="mt-3 space-y-2 text-sm sm:text-base leading-relaxed" style="color: var(--lp-ink);">
                                    @foreach ($entry['points'] as $point)
                                        <li class="flex gap-2.5">
                                            <span class="mt-1.5 h-2.5 w-2.5 shrink-0 rotate-45" style="background: var(--lp-accent);"></span>
                                            <span>{{ $point }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            {{-- Normaler Eintrag --}}
                            <span class="lp-pin absolute -start-[0.6rem] mt-2"></span>
                            <div class="flex flex-wrap items-center gap-2.5">
                                <time class="lp-muted text-xs font-extrabold uppercase tracking-[0.18em]">{{ $fmtDate($entry['date']) }}</time>
                                <span class="lp-chip"><span class="inline-block h-2 w-2 rounded-full {{ $meta['dot'] }}"></span>{{ $meta['label'] }}</span>
                            </div>
                            <h2 class="text-lg font-extrabold mt-1.5" style="color: var(--lp-ink); font-family: 'Archivo', sans-serif;">{{ $entry['title'] }}</h2>
                            <ul class="mt-2 space-y-1.5 text-sm leading-relaxed" style="color: var(--lp-ink);">
                                @foreach ($entry['points'] as $point)
                                    <li class="flex gap-2">
                                        <span class="mt-2 h-1 w-1 shrink-0 rounded-full" style="background: var(--lp-muted);"></span>
                                        <span>{{ $point }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ol>
        </section>
    </div>

    {{-- =========================================================== --}}
    {{-- DARK MODE – unverändert                                      --}}
    {{-- =========================================================== --}}
    <div class="dark-mode-only">
        <section class="max-w-3xl mx-auto px-4 py-10 sm:py-14">
            <div class="text-center">
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white">Was ist neu?</h1>
                <p class="mt-3 text-sm sm:text-base text-gray-600 dark:text-gray-300">
                    Die Entwicklung der CampusOlympiade – von den ersten Anfängen im April 2025 bis heute.
                </p>
            </div>

            <ol class="mt-10 relative border-s-2 border-gray-200 dark:border-gray-700 ms-3">
                @foreach ($entries as $entry)
                    @php
                        $meta = $tagMeta[$entry['tag']] ?? $tagMeta['feature'];
                        $isMajor = !empty($entry['major']);
                    @endphp
                    <li class="ms-6 {{ $isMajor ? 'mb-12' : 'mb-10' }} last:mb-0">
                        {{-- Timeline-Punkt --}}
                        @if ($isMajor)
                            <span class="absolute -start-[0.95rem] mt-1 grid h-7 w-7 place-items-center rounded-full bg-indigo-600 text-[0.7rem] text-white shadow ring-4 ring-indigo-200 dark:ring-indigo-500/30">★</span>
                        @else
                            <span class="absolute -start-[0.6rem] mt-1.5 h-4 w-4 rounded-full border-2 border-white dark:border-gray-900 {{ $meta['dot'] }}"></span>
                        @endif

                        <div class="{{ $isMajor ? 'rounded-2xl border border-indigo-200 dark:border-indigo-500/30 bg-indigo-50/60 dark:bg-indigo-900/10 p-4 sm:p-5 shadow-sm' : '' }}">
                            <div class="flex flex-wrap items-center gap-2">
                                <time class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">{{ $fmtDate($entry['date']) }}</time>
                                @if ($isMajor)
                                    <span class="inline-flex items-center rounded-full bg-indigo-600 px-2.5 py-0.5 text-xs font-bold text-white">v{{ $entry['version'] }}</span>
                                    <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-300">Meilenstein</span>
                                @else
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $meta['badge'] }}">{{ $meta['label'] }}</span>
                                @endif
                            </div>

                            <h2 class="mt-1.5 font-bold text-gray-900 dark:text-white {{ $isMajor ? 'text-xl sm:text-2xl font-extrabold' : 'text-lg' }}">{{ $entry['title'] }}</h2>

                            <ul class="mt-2 space-y-1.5 leading-relaxed text-gray-700 dark:text-gray-300 {{ $isMajor ? 'text-sm sm:text-base' : 'text-sm' }}">
                                @foreach ($entry['points'] as $point)
                                    <li class="flex gap-2">
                                        <span class="mt-2 h-1 w-1 shrink-0 rounded-full bg-gray-400 dark:bg-gray-500"></span>
                                        <span>{{ $point }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @endforeach
            </ol>
        </section>
    </div>
</x-layout>
