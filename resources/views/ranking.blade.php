@php use App\Services\SchoolColorService; @endphp
<x-layout>
    <x-slot:heading>Live Rangliste</x-slot:heading>

    @include('partials.lp-theme')

    {{-- ===================== LIGHT MODE – „Sportfest-Poster“ ===================== --}}
    @php
        $lpSections = [
            'schools' => [
                'label' => 'Schulen',
                'title' => 'Schulwertung',
                'items' => $schools->values()->map(fn ($s) => [
                    'name' => $s->name,
                    'sub' => null,
                    'score' => $s->score,
                    'school_id' => $s->id,
                ]),
            ],
            'klasses' => [
                'label' => 'Klassen',
                'title' => 'Klassenwertung',
                'items' => $klasses->values()->map(fn ($k) => [
                    'name' => $k->name,
                    'sub' => $k->school->name ?? null,
                    'score' => $k->score,
                    'school_id' => $k->school_id ?? 0,
                ]),
            ],
            'teams' => [
                'label' => 'Teams',
                'title' => 'Teamwertung',
                'items' => $teams->values()->map(fn ($t) => [
                    'name' => $t->name,
                    'sub' => $t->klasse->name ?? null,
                    'score' => $t->score,
                    'school_id' => $t->klasse->school_id ?? 0,
                ]),
            ],
        ];
    @endphp

    <div class="light-mode-only -mt-10">
        <section class="lp-sec-paper relative overflow-hidden pt-24 md:pt-28 pb-20 min-h-screen">
            <div class="lp-lanes absolute inset-0 pointer-events-none" aria-hidden="true"></div>

            <div class="container mx-auto px-4 relative z-10 max-w-5xl">
                <div class="flex flex-wrap items-start justify-between gap-5">
                    <div class="min-w-0">
                        <span class="lp-kicker lp-reveal">Live-Wertung</span>
                        <h1 class="lp-display lp-h2 mt-3 lp-reveal lp-d1">
                            Die <span class="lp-outline">Rangliste</span>
                        </h1>
                    </div>
                    <span class="lp-chip lp-chip-accent mt-2 lp-reveal lp-d2">
                        <span class="lp-live-dot" style="background:#fff;"></span> Live
                    </span>
                </div>

                {{-- Punkteberechnung --}}
                <div class="lp-card lp-shadow p-5 mt-8 lp-reveal lp-d2">
                    <p class="lp-display text-lg">So werden die Punkte berechnet</p>
                    <ul class="lp-muted text-sm mt-2 space-y-1.5 leading-relaxed">
                        <li><strong class="text-[color:var(--lp-ink)]">Teams</strong> erhalten Punkte nach ihrer Platzierung in jeder Disziplin.</li>
                        <li><strong class="text-[color:var(--lp-ink)]">Klassen & Schulen</strong> werten den Durchschnitt aller ihrer Teams.</li>
                        <li>Psst: Jede Schule hat ihre eigene Farbe – achte auf die Punkte <span aria-hidden="true">●</span></li>
                    </ul>
                </div>

                {{-- Tabs --}}
                <div class="flex gap-2 mt-10 overflow-x-auto pb-2 -mx-4 px-4 lp-reveal lp-d3">
                    @foreach ($lpSections as $key => $sec)
                        <button type="button"
                                class="lp-chip lp-tab {{ $loop->first ? 'lp-tab-active' : '' }}"
                                data-lp-ranking-tab
                                onclick="lpShowSection('{{ $key }}', this)">{{ $sec['label'] }}</button>
                    @endforeach
                    <button type="button" class="lp-chip lp-tab" data-lp-ranking-tab
                            onclick="lpShowSection('disciplines', this)">Disziplinen</button>
                </div>

                {{-- Schulen / Klassen / Teams --}}
                @foreach ($lpSections as $key => $sec)
                    <div id="lp-{{ $key }}-section" class="lp-ranking-section mt-8 {{ $loop->first ? '' : 'hidden' }}">
                        <h2 class="lp-display text-xl md:text-2xl mb-6">{{ $sec['title'] }}</h2>

                        @if ($sec['items']->isEmpty())
                            <p class="lp-muted py-10 text-center text-sm">Noch keine Wertung – die Ergebnisse kommen mit den ersten Eintragungen.</p>
                        @else
                            @php
                                $p1 = $sec['items'][0] ?? null;
                                $p2 = $sec['items'][1] ?? null;
                                $p3 = $sec['items'][2] ?? null;
                            @endphp

                            {{-- Podium --}}
                            <div class="max-w-2xl mx-auto border-b-2 lp-bord mb-8">
                                <div class="grid grid-cols-3 gap-3 md:gap-5 items-end">
                                    {{-- Platz 2 --}}
                                    <div class="min-w-0">
                                        @if ($p2)
                                            <div class="lp-card lp-shadow px-2 py-2 md:px-3 md:py-2.5 text-center mb-4 -rotate-1">
                                                <p class="font-extrabold text-xs md:text-sm leading-tight break-words">{{ $p2['name'] }}</p>
                                                @if ($p2['sub'])
                                                    <p class="lp-muted text-[0.58rem] md:text-[0.62rem] font-bold uppercase tracking-[0.12em] mt-0.5 break-words">{{ $p2['sub'] }}</p>
                                                @endif
                                                <p class="text-[0.62rem] font-extrabold uppercase tracking-[0.14em] mt-1">
                                                    <span class="inline-block w-2.5 h-2.5 rounded-full {{ SchoolColorService::getColorClasses($p2['school_id'])['dot'] }} border border-black/30 align-middle mr-1"></span>{{ $p2['score'] }} P
                                                </p>
                                            </div>
                                            <div class="lp-podium lp-top-silver h-24 md:h-36">
                                                <span class="lp-display lp-outline text-4xl md:text-6xl">2</span>
                                            </div>
                                        @endif
                                    </div>
                                    {{-- Platz 1 --}}
                                    <div class="min-w-0">
                                        @if ($p1)
                                            <div class="text-center mb-2" aria-hidden="true">
                                                <span class="lp-display text-xl md:text-2xl" style="color: var(--lp-gold); -webkit-text-stroke: 1.5px var(--lp-ink);">★</span>
                                            </div>
                                            <div class="lp-card lp-shadow-gold px-2 py-2 md:px-3 md:py-2.5 text-center mb-4 rotate-1">
                                                <p class="font-extrabold text-xs md:text-sm leading-tight break-words">{{ $p1['name'] }}</p>
                                                @if ($p1['sub'])
                                                    <p class="lp-muted text-[0.58rem] md:text-[0.62rem] font-bold uppercase tracking-[0.12em] mt-0.5 break-words">{{ $p1['sub'] }}</p>
                                                @endif
                                                <p class="text-[0.62rem] font-extrabold uppercase tracking-[0.14em] mt-1">
                                                    <span class="inline-block w-2.5 h-2.5 rounded-full {{ SchoolColorService::getColorClasses($p1['school_id'])['dot'] }} border border-black/30 align-middle mr-1"></span>{{ $p1['score'] }} P
                                                </p>
                                            </div>
                                            <div class="lp-podium lp-top-gold h-36 md:h-48">
                                                <span class="lp-display lp-outline text-5xl md:text-7xl">1</span>
                                            </div>
                                        @endif
                                    </div>
                                    {{-- Platz 3 --}}
                                    <div class="min-w-0">
                                        @if ($p3)
                                            <div class="lp-card lp-shadow px-2 py-2 md:px-3 md:py-2.5 text-center mb-4 rotate-2">
                                                <p class="font-extrabold text-xs md:text-sm leading-tight break-words">{{ $p3['name'] }}</p>
                                                @if ($p3['sub'])
                                                    <p class="lp-muted text-[0.58rem] md:text-[0.62rem] font-bold uppercase tracking-[0.12em] mt-0.5 break-words">{{ $p3['sub'] }}</p>
                                                @endif
                                                <p class="text-[0.62rem] font-extrabold uppercase tracking-[0.14em] mt-1">
                                                    <span class="inline-block w-2.5 h-2.5 rounded-full {{ SchoolColorService::getColorClasses($p3['school_id'])['dot'] }} border border-black/30 align-middle mr-1"></span>{{ $p3['score'] }} P
                                                </p>
                                            </div>
                                            <div class="lp-podium lp-top-bronze h-16 md:h-24">
                                                <span class="lp-display lp-outline text-3xl md:text-5xl">3</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Plätze ab 4 --}}
                            @if ($sec['items']->count() > 3)
                                <div class="border-b-2 lp-bord">
                                    @foreach ($sec['items']->slice(3) as $i => $it)
                                        <div class="lp-row">
                                            <span class="lp-rank-badge">{{ $i + 1 }}</span>
                                            <span class="min-w-0">
                                                <span class="font-extrabold break-words block">
                                                    <span class="inline-block w-2.5 h-2.5 rounded-full {{ SchoolColorService::getColorClasses($it['school_id'])['dot'] }} border border-black/30 align-middle mr-1.5"></span>{{ $it['name'] }}
                                                </span>
                                                @if ($it['sub'])
                                                    <span class="lp-muted text-xs break-words">{{ $it['sub'] }}</span>
                                                @endif
                                            </span>
                                            <span class="text-right">
                                                <span class="lp-display text-2xl block leading-none">{{ $it['score'] }}</span>
                                                <span class="lp-muted text-[0.6rem] font-bold uppercase tracking-[0.2em]">Punkte</span>
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endif

                        {{-- Team-Suche (nur im Teams-Tab) --}}
                        @if ($key === 'teams')
                            <div class="max-w-xl mx-auto mt-12">
                                <div class="lp-card lp-shadow p-5">
                                    <label for="lp-team-search" class="lp-display text-lg block">Team suchen</label>
                                    <input type="text"
                                           id="lp-team-search"
                                           placeholder="Teamname eingeben …"
                                           autocomplete="off"
                                           class="w-full mt-3 px-4 py-3 rounded-xl border-2 lp-bord bg-white text-base font-semibold placeholder:font-normal placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[color:var(--lp-accent)]">
                                </div>
                                <div id="lp-team-search-results" class="mt-4 space-y-3"></div>
                            </div>
                        @endif
                    </div>
                @endforeach

                {{-- Disziplinen --}}
                <div id="lp-disciplines-section" class="lp-ranking-section mt-8 hidden">
                    <div class="flex items-end justify-between gap-3 mb-6">
                        <h2 class="lp-display text-xl md:text-2xl">Beste Teams pro Disziplin</h2>
                        <span class="lp-chip hidden sm:inline-flex">Antippen für Details</span>
                    </div>

                    @if (!empty($bestTeamsPerDiscipline))
                        <div class="grid gap-5 sm:grid-cols-2">
                            @foreach ($bestTeamsPerDiscipline as $champion)
                                <button type="button"
                                        onclick="lpOpenDisciplineModal({{ $champion['discipline_id'] }})"
                                        class="lp-card lp-shadow p-5 text-left w-full transition-transform duration-200 hover:-translate-y-1 group">
                                    <div class="flex items-start justify-between gap-2">
                                        <h3 class="lp-display text-lg break-words min-w-0">{{ $champion['discipline_name'] ?? 'Disziplin ' . $champion['discipline_id'] }}</h3>
                                        <span class="text-lg font-extrabold shrink-0 transition-transform duration-200 group-hover:translate-x-1" aria-hidden="true">→</span>
                                    </div>

                                    <p class="lp-display text-4xl mt-3 leading-none">{{ $champion['best_score'] }}</p>
                                    <p class="lp-muted text-[0.62rem] font-bold uppercase tracking-[0.2em] mt-1">Bestleistung</p>

                                    <div class="mt-4 pt-3 border-t-2 border-dashed" style="border-color: rgba(22, 29, 39, 0.2);">
                                        <p class="font-extrabold text-sm break-words">
                                            <span class="inline-block w-2.5 h-2.5 rounded-full {{ SchoolColorService::getColorClasses($champion['team_school_id'] ?? 0)['dot'] }} border border-black/30 align-middle mr-1.5"></span>{{ $champion['team_name'] ?? 'Team ' . $champion['team_id'] }}
                                        </p>
                                        <p class="lp-muted text-xs mt-1.5">Antippen für die komplette Rangliste →</p>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    @else
                        <p class="lp-muted py-10 text-center text-sm">Noch keine Disziplinen-Ergebnisse eingetragen.</p>
                    @endif
                </div>
            </div>

            {{-- Disziplin-Modal (Light Mode) --}}
            <div id="lp-discipline-modal"
                 class="fixed inset-0 z-50 hidden items-center justify-center p-4"
                 style="background: rgba(22, 29, 39, 0.65);"
                 onclick="lpCloseDisciplineModal(event)">
                <div class="lp-card lp-shadow w-full max-w-2xl max-h-[85vh] flex flex-col overflow-hidden"
                     style="background: var(--lp-paper);"
                     onclick="event.stopPropagation()">
                    <div class="flex items-center justify-between gap-3 px-5 py-4" style="background: var(--lp-ink);">
                        <div class="min-w-0">
                            <h3 id="lp-modal-title" class="lp-display text-xl md:text-2xl text-white break-words"></h3>
                            <p id="lp-modal-dir" class="text-[0.62rem] font-bold uppercase tracking-[0.2em] text-white/60 mt-0.5"></p>
                        </div>
                        <button type="button" onclick="lpCloseDisciplineModal()"
                                class="shrink-0 w-9 h-9 grid place-items-center rounded-full border-2 border-white/40 text-white text-lg font-extrabold hover:border-white transition-colors">
                            ×
                        </button>
                    </div>
                    <div id="lp-modal-content" class="p-5 overflow-y-auto"></div>
                </div>
            </div>
        </section>
        <div class="lp-checker h-4 border-t-2 lp-bord" aria-hidden="true"></div>
    </div>

    {{-- ===================== DARK MODE – unverändert ===================== --}}
    <div class="dark-mode-only">
    <div class="min-h-screen bg-gradient-to-br from-blue-100 to-green-100 py-8 transition-colors duration-300 dark:bg-none">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Hero Section -->
            <div class="text-center mb-12">
                <div class="bg-white night-panel dark:bg-gray-800 rounded-2xl shadow-xl p-5 mb-8 transition-colors duration-300">
                    <h1 class="display-font text-4xl font-bold bg-gradient-to-r from-indigo-600 to-emerald-600 dark:from-teal-300 dark:to-sky-300 bg-clip-text text-transparent mb-4">
                        Live Rangliste
                    </h1>
                    <div class="max-w-3xl mx-auto bg-blue-50 dark:bg-slate-900/70 border border-blue-200 dark:border-sky-400/40 p-4 rounded-lg flex items-start space-x-3 transition-colors duration-300">
                        <svg class="h-6 w-6 text-blue-500 dark:text-sky-300 mt-0.5 flex-shrink-0 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
                        </svg>
                        <div class="text-sm text-blue-800 dark:text-slate-200 text-left transition-colors duration-300">
                            <p class="font-semibold mb-1">Wie werden die Punkte berechnet?</p>
                            <ul class="list-disc ml-4 space-y-1 text-blue-700 dark:text-slate-300 transition-colors duration-300">
                                <li><strong>Teams:</strong> Erhalten Punkte basierend auf ihrer Platzierung in jeder Disziplin.</li>
                                <li><strong>Klassen & Schulen:</strong> Der Gesamtscore ergibt sich aus dem Durchschnitt der Punkte aller zugehörigen Teams.</li>
                                <li><strong>psstt:</strong> kleiner Tipp, Jede Schule besitzt ihre eigene Farbe!</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Tabs -->
            <div class="flex justify-center mb-8 ">
                <nav class="bg-white night-card dark:bg-gray-800 rounded-full shadow-lg p-1 border border-gray-200 dark:border-gray-700 transition-colors duration-300">
                    <div class="flex space-x-0.5">
                        <button onclick="showSection('schools')" class="ranking-tab night-tab night-tab-active px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 bg-indigo-600 text-white">
                            Schulen
                        </button>
                        <button onclick="showSection('klasses')" class="ranking-tab night-tab px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                            Klassen
                        </button>
                        <button onclick="showSection('teams')" class="ranking-tab night-tab px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                            Teams
                        </button>
                        <button onclick="showSection('disciplines')" class="ranking-tab night-tab px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                            Disziplinen
                        </button>
                    </div>
                </nav>
            </div>

            <!-- Schulen Ranking -->
            @if($schools->count() > 0)
                <div id="schools-section" class="ranking-section">
                    <div class="bg-white night-panel dark:bg-gray-800 rounded-2xl shadow-xl p-8 mb-8 transition-colors duration-300">
                        <h2 class="display-font text-2xl font-bold text-center mb-8 text-gray-800 dark:text-gray-100 transition-colors duration-300">🏫 Schulen Rangliste</h2>

                        <!-- Podium für Top 3 -->
                        <div class="flex justify-center mb-12">
                            <div class="flex items-end space-x-4" style="height: 208px;">
                                <!-- 2. Platz (Links) -->
                                <div class="flex flex-col items-center" style="width: 96px;">
                                    @if(isset($schools[1]))
                                        @php $colors = SchoolColorService::getColorClasses($schools[1]->id); @endphp
                                        <div class="text-4xl mb-3">🥈</div>
                                        <div class="bg-gradient-to-t {{ $colors['bg'] }} rounded-t-lg border-4 {{ $colors['border'] }} flex flex-col justify-end p-3 shadow-lg" style="height: 128px; width: 96px;">
                                            <div class="text-center">
                                                <div class="text-xs font-bold {{ $colors['text-subtle'] }} mb-1 transition-colors duration-300">2.</div>
                                                <div class="text-xs font-semibold text-gray-800 dark:text-gray-200 break-words leading-tight transition-colors duration-300">{{ $schools[1]->name }}</div>
                                                <div class="text-xs {{ $colors['text-points'] }} font-bold mt-1 transition-colors duration-300">{{ $schools[1]->score }}P</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- 1. Platz (Mitte) -->
                                <div class="flex flex-col items-center" style="width: 96px;">
                                    @if(isset($schools[0]))
                                        @php $colors = SchoolColorService::getColorClasses($schools[0]->id); @endphp
                                        <div class="text-4xl mb-3">🥇</div>
                                        <div class="bg-gradient-to-t {{ $colors['bg'] }} rounded-t-lg border-4 {{ $colors['border'] }} flex flex-col justify-end p-3 shadow-lg" style="height: 160px; width: 96px;">
                                            <div class="text-center">
                                                <div class="text-xs font-bold {{ $colors['text-subtle'] }} mb-1 transition-colors duration-300">1.</div>
                                                <div class="text-xs font-semibold text-gray-800 dark:text-gray-200 break-words leading-tight transition-colors duration-300">{{ $schools[0]->name }}</div>
                                                <div class="text-xs {{ $colors['text-points'] }} font-bold mt-1 transition-colors duration-300">{{ $schools[0]->score }}P</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- 3. Platz (Rechts) -->
                                <div class="flex flex-col items-center" style="width: 96px;">
                                    @if(isset($schools[2]))
                                        @php $colors = SchoolColorService::getColorClasses($schools[2]->id); @endphp
                                        <div class="text-4xl mb-3">🥉</div>
                                        <div class="bg-gradient-to-t {{ $colors['bg'] }} rounded-t-lg border-4 {{ $colors['border'] }} flex flex-col justify-end p-3 shadow-lg" style="height: 112px; width: 96px;">
                                            <div class="text-center">
                                                <div class="text-xs font-bold {{ $colors['text-subtle'] }} mb-1 transition-colors duration-300">3.</div>
                                                <div class="text-xs font-semibold text-gray-800 dark:text-gray-200 break-words leading-tight transition-colors duration-300">{{ $schools[2]->name }}</div>
                                                <div class="text-xs {{ $colors['text-points'] }} font-bold mt-1 transition-colors duration-300">{{ $schools[2]->score }}P</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Weitere Schulen -->
                        @if($schools->count() > 3)
                            <div class="space-y-3">
                                @foreach($schools->slice(3) as $index => $school)
                                    @php $colors = SchoolColorService::getColorClasses($school->id); @endphp
                                    <div class="flex items-center justify-between p-4 rounded-lg {{ $colors['bg-light'] }} border-l-4 {{ $colors['border-light'] }} hover:shadow-md transition-all duration-300">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-8 h-8 bg-white dark:bg-slate-900/70 rounded-full flex items-center justify-center font-bold text-gray-700 dark:text-gray-200 text-sm transition-colors duration-300">
                                                {{ $index + 1 }}
                                            </div>
                                            <span class="font-medium text-gray-800 dark:text-gray-200 transition-colors duration-300">{{ $school->name }}</span>
                                        </div>
                                        <div class="text-right">
                                            <div class="font-bold {{ $colors['text-points'] }} transition-colors duration-300">{{ $school->score }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 transition-colors duration-300">Punkte</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Klassen Ranking -->
            @if($klasses->count() > 0)
                <div id="klasses-section" class="ranking-section hidden">
                    <div class="bg-white night-panel dark:bg-gray-800 rounded-2xl shadow-xl p-8 mb-8 transition-colors duration-300">
                        <h2 class="display-font text-2xl font-bold text-center mb-8 text-gray-800 dark:text-gray-100 transition-colors duration-300">👥 Klassen Rangliste</h2>

                        <!-- Podium für Top 3 -->
                        <div class="flex justify-center mb-12">
                            <div class="flex items-end space-x-4" style="height: 208px;">
                                <!-- 2. Platz (Links) -->
                                <div class="flex flex-col items-center" style="width: 96px;">
                                    @if(isset($klasses[1]))
                                        @php $colors = SchoolColorService::getColorClasses($klasses[1]->school_id ?? 0); @endphp
                                        <div class="text-4xl mb-3">🥈</div>
                                        <div class="bg-gradient-to-t {{ $colors['bg'] }} rounded-t-lg border-4 {{ $colors['border'] }} flex flex-col justify-end p-3 shadow-lg" style="height: 128px; width: 96px;">
                                            <div class="text-center">
                                                <div class="text-xs font-bold {{ $colors['text-subtle'] }} mb-1 transition-colors duration-300">2.</div>
                                                <div class="text-xs font-semibold text-gray-800 dark:text-gray-200 break-words leading-tight transition-colors duration-300">{{ $klasses[1]->name }}</div>
                                                <div class="text-xs {{ $colors['text-points'] }} font-bold mt-1 transition-colors duration-300">{{ $klasses[1]->score }}P</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- 1. Platz (Mitte) -->
                                <div class="flex flex-col items-center" style="width: 96px;">
                                    @if(isset($klasses[0]))
                                        @php $colors = SchoolColorService::getColorClasses($klasses[0]->school_id ?? 0); @endphp
                                        <div class="text-4xl mb-3">🥇</div>
                                        <div class="bg-gradient-to-t {{ $colors['bg'] }} rounded-t-lg border-4 {{ $colors['border'] }} flex flex-col justify-end p-3 shadow-lg" style="height: 160px; width: 96px;">
                                            <div class="text-center">
                                                <div class="text-xs font-bold {{ $colors['text-subtle'] }} mb-1 transition-colors duration-300">1.</div>
                                                <div class="text-xs font-semibold text-gray-800 dark:text-gray-200 break-words leading-tight transition-colors duration-300">{{ $klasses[0]->name }}</div>
                                                <div class="text-xs {{ $colors['text-points'] }} font-bold mt-1 transition-colors duration-300">{{ $klasses[0]->score }}P</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- 3. Platz (Rechts) -->
                                <div class="flex flex-col items-center" style="width: 96px;">
                                    @if(isset($klasses[2]))
                                        @php $colors = SchoolColorService::getColorClasses($klasses[2]->school_id ?? 0); @endphp
                                        <div class="text-4xl mb-3">🥉</div>
                                        <div class="bg-gradient-to-t {{ $colors['bg'] }} rounded-t-lg border-4 {{ $colors['border'] }} flex flex-col justify-end p-3 shadow-lg" style="height: 112px; width: 96px;">
                                            <div class="text-center">
                                                <div class="text-xs font-bold {{ $colors['text-subtle'] }} mb-1 transition-colors duration-300">3.</div>
                                                <div class="text-xs font-semibold text-gray-800 dark:text-gray-200 break-words leading-tight transition-colors duration-300">{{ $klasses[2]->name }}</div>
                                                <div class="text-xs {{ $colors['text-points'] }} font-bold mt-1 transition-colors duration-300">{{ $klasses[2]->score }}P</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Weitere Klassen -->
                        @if($klasses->count() > 3)
                            <div class="space-y-3">
                                @foreach($klasses->slice(3) as $index => $klasse)
                                    @php $colors = SchoolColorService::getColorClasses($klasse->school_id ?? 0); @endphp
                                    <div class="flex items-center justify-between p-4 rounded-lg {{ $colors['bg-light'] }} border-l-4 {{ $colors['border-light'] }} hover:shadow-md transition-all duration-300">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-8 h-8 bg-white dark:bg-slate-900/70 rounded-full flex items-center justify-center font-bold text-gray-700 dark:text-gray-200 text-sm transition-colors duration-300">
                                                {{ $index + 1 }}
                                            </div>
                                            <span class="font-medium text-gray-800 dark:text-gray-200 transition-colors duration-300">{{ $klasse->name }}</span>
                                        </div>
                                        <div class="text-right">
                                            <div class="font-bold {{ $colors['text-points'] }} transition-colors duration-300">{{ $klasse->score }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 transition-colors duration-300">Punkte</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Teams Ranking -->
            @if($teams->count() > 0)
                <div id="teams-section" class="ranking-section hidden">
                    <div class="bg-white night-panel dark:bg-gray-800 rounded-2xl shadow-xl p-8 mb-8 transition-colors duration-300">
                        <h2 class="display-font text-2xl font-bold text-center mb-8 text-gray-800 dark:text-gray-100 transition-colors duration-300">🏆 Teams Rangliste</h2>

                        <!-- Podium für Top 3 -->
                        <div class="flex justify-center mb-12">
                            <div class="flex items-end space-x-4" style="height: 208px;">
                                <!-- 2. Platz (Links) -->
                                <div class="flex flex-col items-center" style="width: 96px;">
                                    @if(isset($teams[1]))
                                        @php $colors = SchoolColorService::getColorClasses($teams[1]->klasse->school_id ?? 0); @endphp
                                        <div class="text-4xl mb-3">🥈</div>
                                        <div class="bg-gradient-to-t {{ $colors['bg'] }} rounded-t-lg border-4 {{ $colors['border'] }} flex flex-col justify-end p-3 shadow-lg" style="height: 128px; width: 96px;">
                                            <div class="text-center">
                                                <div class="text-xs font-bold {{ $colors['text-subtle'] }} mb-1 transition-colors duration-300">2.</div>
                                                <div class="text-xs font-semibold text-gray-800 dark:text-gray-200 break-words leading-tight transition-colors duration-300">{{ $teams[1]->name }}</div>
                                                <div class="text-xs text-gray-600 dark:text-gray-400 break-words leading-tight transition-colors duration-300">{{ $teams[1]->klasse->name ?? 'N/A' }}</div>
                                                <div class="text-xs {{ $colors['text-points'] }} font-bold mt-1 transition-colors duration-300">{{ $teams[1]->score }}P</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- 1. Platz (Mitte) -->
                                <div class="flex flex-col items-center" style="width: 96px;">
                                    @if(isset($teams[0]))
                                        @php $colors = SchoolColorService::getColorClasses($teams[0]->klasse->school_id ?? 0); @endphp
                                        <div class="text-4xl mb-3">🥇</div>
                                        <div class="bg-gradient-to-t {{ $colors['bg'] }} rounded-t-lg border-4 {{ $colors['border'] }} flex flex-col justify-end p-3 shadow-lg" style="height: 160px; width: 96px;">
                                            <div class="text-center">
                                                <div class="text-xs font-bold {{ $colors['text-subtle'] }} mb-1 transition-colors duration-300">1.</div>
                                                <div class="text-xs font-semibold text-gray-800 dark:text-gray-200 break-words leading-tight transition-colors duration-300">{{ $teams[0]->name }}</div>
                                                <div class="text-xs text-gray-600 dark:text-gray-400 break-words leading-tight transition-colors duration-300">{{ $teams[0]->klasse->name ?? 'N/A' }}</div>
                                                <div class="text-xs {{ $colors['text-points'] }} font-bold mt-1 transition-colors duration-300">{{ $teams[0]->score }}P</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- 3. Platz (Rechts) -->
                                <div class="flex flex-col items-center" style="width: 96px;">
                                    @if(isset($teams[2]))
                                        @php $colors = SchoolColorService::getColorClasses($teams[2]->klasse->school_id ?? 0); @endphp
                                        <div class="text-4xl mb-3">🥉</div>
                                        <div class="bg-gradient-to-t {{ $colors['bg'] }} rounded-t-lg border-4 {{ $colors['border'] }} flex flex-col justify-end p-3 shadow-lg" style="height: 112px; width: 96px;">
                                            <div class="text-center">
                                                <div class="text-xs font-bold {{ $colors['text-subtle'] }} mb-1 transition-colors duration-300">3.</div>
                                                <div class="text-xs font-semibold text-gray-800 dark:text-gray-200 break-words leading-tight transition-colors duration-300">{{ $teams[2]->name }}</div>
                                                <div class="text-xs text-gray-600 dark:text-gray-400 break-words leading-tight transition-colors duration-300">{{ $teams[2]->klasse->name ?? 'N/A' }}</div>
                                                <div class="text-xs {{ $colors['text-points'] }} font-bold mt-1 transition-colors duration-300">{{ $teams[2]->score }}P</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Weitere Teams -->
                        @if($teams->count() > 3)
                            <div class="space-y-3">
                                @foreach($teams->slice(3) as $index => $team)
                                    @php $colors = SchoolColorService::getColorClasses($team->klasse->school_id ?? 0); @endphp
                                    <div class="flex items-center justify-between p-4 rounded-lg {{ $colors['bg-light'] }} border-l-4 {{ $colors['border-light'] }} hover:shadow-md transition-all duration-300">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-8 h-8 bg-white dark:bg-slate-900/70 rounded-full flex items-center justify-center font-bold text-gray-700 dark:text-gray-200 text-sm transition-colors duration-300">
                                                {{ $index + 1 }}
                                            </div>
                                            <div>
                                                <span class="font-medium text-gray-800 dark:text-gray-200 transition-colors duration-300">{{ $team->name }}</span>
                                                <div class="text-xs text-gray-500 dark:text-gray-400 transition-colors duration-300">{{ $team->klasse->name ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="font-bold {{ $colors['text-points'] }} transition-colors duration-300">{{ $team->score }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 transition-colors duration-300">Punkte</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Team-Suche -->
                        <div class="max-w-2xl mx-auto mt-12">
                            <div class="bg-white night-card dark:bg-gray-800 rounded-lg shadow-md p-6 border-2 border-gray-300 dark:border-gray-700 transition-colors duration-300">
                                <label for="team-search-input" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 transition-colors duration-300">
                                    Team suchen:
                                </label>
                                <input type="text"
                                       id="team-search-input"
                                       placeholder="Teamname eingeben..."
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 transition-colors duration-300">
                            </div>

                            {{--suchergebnisse --}}
                            <div id="team-search-results" class="mt-4">

                            </div>
                        </div>

                    </div>
                </div>
            @endif

            <!-- Disziplinen Ranking -->
            @if(!empty($bestTeamsPerDiscipline))
                <div id="disciplines-section" class="ranking-section hidden">
                    <div class="bg-white night-panel dark:bg-gray-800 rounded-2xl shadow-xl p-8 transition-colors duration-300">
                        <h2 class="display-font text-2xl font-bold text-center mb-8 text-gray-800 dark:text-gray-100 transition-colors duration-300">🎯 Beste Teams pro Disziplin</h2>

                        <div class="space-y-4">
                            @foreach($bestTeamsPerDiscipline as $champion)
                                @php $colors = SchoolColorService::getColorClasses($champion['team_school_id'] ?? 0); @endphp
                                <div onclick="openDisciplineModal({{ $champion['discipline_id'] }})" class="group relative overflow-hidden rounded-xl bg-gradient-to-r {{ $colors['gradient'] }} border {{ $colors['border-light'] }} hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer">
                                    <div class="absolute top-4 right-4 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600 dark:text-gray-400 group-hover:text-gray-800 dark:group-hover:text-gray-200 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>

                                    <div class="p-6">
                                        <div class="flex items-start space-x-4">
                                            <div class="flex-1 min-w-0">
                                                <h3 class="display-font text-xl font-bold text-gray-800 dark:text-gray-200 mb-1 group-hover:text-gray-900 dark:group-hover:text-gray-100 transition-colors duration-300">
                                                    {{ $champion['discipline_name'] ?? 'Disziplin ' . $champion['discipline_id'] }}
                                                </h3>
                                                <p class="text-lg font-semibold {{ $colors['text'] }} mb-2 transition-colors duration-300">
                                                    Team: {{ $champion['team_name'] ?? 'Team ' . $champion['team_id'] }}
                                                </p>
                                                <div class="flex items-center space-x-1">
                                                    <svg class="w-4 h-4 {{ $colors['text-subtle'] }} transition-colors duration-300" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                    <span class="text-lg font-bold {{ $colors['text-points'] }} transition-colors duration-300">{{ $champion['best_score'] }}</span>
                                                    <span class="text-2xl">🏆</span>
                                                    <span class="text-sm text-gray-500 dark:text-gray-400 transition-colors duration-300">Bestleistung</span>
                                                </div>
                                                <div class="mt-2 text-sm text-gray-600 dark:text-gray-400 group-hover:text-gray-800 dark:group-hover:text-gray-300 transition-colors duration-300">
                                                    → Klicken für Details und vollständige Rangliste
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <!-- Modal für Disziplin-Details -->
    <div id="disciplineModal" class="fixed inset-0 bg-black bg-opacity-50 dark:bg-opacity-70 hidden items-center justify-center z-50 transition-all duration-300" onclick="closeDisciplineModal(event)">
        <div class="bg-white night-panel dark:bg-gray-800 rounded-2xl shadow-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-hidden transition-colors duration-300" onclick="event.stopPropagation()">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-teal-500 dark:to-sky-500 px-6 py-4 flex justify-between items-center transition-colors duration-300">
                <h3 id="modalTitle" class="display-font text-2xl font-bold text-white"></h3>
                <button onclick="closeDisciplineModal()" class="text-white hover:text-gray-200 dark:hover:text-gray-300 transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 overflow-y-auto max-h-[calc(90vh-80px)]">
                <div id="modalContent"></div>
            </div>
        </div>
    </div>
    </div>

    <!-- JavaScript für Tab-Navigation und externe Suchfunktionalität -->
    <script>
        // Daten für laufzettel-search.js bereitstellen
        const allTeamsData = @json($teamsForJs ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
        const colorMap = @json($colorMapForJs ?? ['default' => []]);
        const disciplineDetails = @json($disciplineDetailsForJs ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

        // Tab Navigation
        function showSection(sectionName) {
            // Hide all sections
            document.querySelectorAll('.ranking-section').forEach(section => {
                section.classList.add('hidden');
            });

            // Show selected section
            document.getElementById(sectionName + '-section').classList.remove('hidden');

            // Update tab styles
            document.querySelectorAll('.ranking-tab').forEach(tab => {
                tab.classList.remove('bg-indigo-600', 'dark:bg-indigo-500', 'text-white', 'night-tab-active');
                tab.classList.add('text-gray-600', 'hover:text-indigo-600');
            });

            // Highlight active tab
            event.target.classList.remove('text-gray-600', 'hover:text-indigo-600');
            event.target.classList.add('bg-indigo-600', 'dark:bg-indigo-500', 'text-white', 'night-tab-active');
        }

        // Modal Funktionen
        function openDisciplineModal(disciplineId) {
            const discipline = disciplineDetails[disciplineId];
            if (!discipline) return;

            const modal = document.getElementById('disciplineModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalContent = document.getElementById('modalContent');

            modalTitle.textContent = discipline.name;

            // Simpel: Liste der Teams mit Platz und Score
            let html = '<div class="space-y-3">';

            if (discipline.teams.length === 0) {
                html += '<p class="text-gray-600 dark:text-gray-400 text-center py-8 transition-colors duration-300">Keine Teams haben an dieser Disziplin teilgenommen.</p>';
                html += '</div>';
                modalContent.innerHTML = html;
            } else {
                html += '</div>';
                modalContent.innerHTML = html;

                const container = modalContent.querySelector('.space-y-3');
                discipline.teams.forEach(team => {
                    const colors = getColorForSchool(team.school_id);
                    const medal = team.rank === 1 ? '🥇' : team.rank === 2 ? '🥈' : team.rank === 3 ? '🥉' : '';

                    const row = document.createElement('div');
                    row.className = `flex items-center justify-between p-4 bg-gradient-to-r ${colors.bgLight} border-l-4 ${colors.borderLight} rounded-lg hover:shadow-md transition-all duration-300`;

                    const left = document.createElement('div');
                    left.className = 'flex items-center gap-4';

                    const rankBox = document.createElement('div');
                    rankBox.className = `flex items-center justify-center w-10 h-10 ${medal ? '' : 'bg-white dark:bg-slate-900/70 rounded-full transition-colors duration-300'}`;
                    if (medal) {
                        const medalSpan = document.createElement('span');
                        medalSpan.className = 'text-2xl';
                        medalSpan.textContent = medal;
                        rankBox.appendChild(medalSpan);
                    } else {
                        const rankSpan = document.createElement('span');
                        rankSpan.className = 'font-bold text-gray-700 dark:text-gray-200 text-lg transition-colors duration-300';
                        rankSpan.textContent = team.rank;
                        rankBox.appendChild(rankSpan);
                    }

                    const info = document.createElement('div');
                    const teamName = document.createElement('div');
                    teamName.className = 'font-semibold text-gray-900 dark:text-gray-100 transition-colors duration-300';
                    teamName.textContent = team.team_name;
                    const klasseName = document.createElement('div');
                    klasseName.className = 'text-sm text-gray-600 dark:text-gray-400 transition-colors duration-300';
                    klasseName.textContent = team.klasse_name;
                    info.appendChild(teamName);
                    info.appendChild(klasseName);

                    left.appendChild(rankBox);
                    left.appendChild(info);

                    const right = document.createElement('div');
                    right.className = 'text-right';
                    const score = document.createElement('div');
                    score.className = `text-xl font-bold ${colors.textPoints} transition-colors duration-300`;
                    score.textContent = team.best_score;
                    right.appendChild(score);

                    row.appendChild(left);
                    row.appendChild(right);
                    container.appendChild(row);
                });
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeDisciplineModal(event) {
            if (event && event.target !== event.currentTarget) return;
            const modal = document.getElementById('disciplineModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function getColorForSchool(schoolId) {
            const colors = colorMap[schoolId] || colorMap['default'];
            return {
                bgLight: colors['bg-light'] || 'from-gray-50 to-gray-100',
                borderLight: colors['border-light'] || 'border-gray-300',
                textPoints: colors['text-points'] || 'text-gray-700'
            };
        }

        // ===================== Light Mode (Poster-Design) =====================

        // Tab-Umschaltung
        function lpShowSection(sectionName, btn) {
            document.querySelectorAll('.lp-ranking-section').forEach((section) => {
                section.classList.add('hidden');
            });
            const target = document.getElementById('lp-' + sectionName + '-section');
            if (target) target.classList.remove('hidden');

            document.querySelectorAll('[data-lp-ranking-tab]').forEach((tab) => {
                tab.classList.remove('lp-tab-active');
            });
            btn.classList.add('lp-tab-active');
        }

        // Farb-Punkt für eine Schule (nutzt die bestehende colorMap)
        function lpSchoolDot(schoolId) {
            const colors = colorMap[schoolId] || colorMap['default'] || {};
            const dot = document.createElement('span');
            dot.className = 'inline-block w-2.5 h-2.5 rounded-full ' + (colors['dot'] || 'bg-gray-400') + ' border border-black/30 align-middle mr-1.5';
            return dot;
        }

        // Disziplin-Modal
        function lpOpenDisciplineModal(disciplineId) {
            const discipline = disciplineDetails[disciplineId];
            if (!discipline) return;

            const modal = document.getElementById('lp-discipline-modal');
            const content = document.getElementById('lp-modal-content');

            document.getElementById('lp-modal-title').textContent = discipline.name;
            document.getElementById('lp-modal-dir').textContent = discipline.higher_is_better
                ? '▲ Höher gewinnt'
                : '▼ Niedriger gewinnt';

            content.innerHTML = '';

            if (!discipline.teams.length) {
                const empty = document.createElement('p');
                empty.className = 'lp-muted text-center text-sm py-8';
                empty.textContent = 'Keine Teams haben an dieser Disziplin teilgenommen.';
                content.appendChild(empty);
            } else {
                const list = document.createElement('div');
                list.className = 'border-b-2 lp-bord';

                discipline.teams.forEach((team) => {
                    const row = document.createElement('div');
                    row.className = 'lp-row';

                    const badge = document.createElement('span');
                    badge.className = 'lp-rank-badge' + (team.rank <= 3 ? ' lp-rank-' + team.rank : '');
                    badge.textContent = team.rank;

                    const info = document.createElement('span');
                    info.className = 'min-w-0';
                    const name = document.createElement('span');
                    name.className = 'font-extrabold break-words block';
                    name.appendChild(lpSchoolDot(team.school_id));
                    name.appendChild(document.createTextNode(team.team_name));
                    const klasse = document.createElement('span');
                    klasse.className = 'lp-muted text-xs break-words';
                    klasse.textContent = team.klasse_name;
                    info.appendChild(name);
                    info.appendChild(klasse);

                    const score = document.createElement('span');
                    score.className = 'lp-display text-xl text-right';
                    score.textContent = team.best_score;

                    row.appendChild(badge);
                    row.appendChild(info);
                    row.appendChild(score);
                    list.appendChild(row);
                });

                content.appendChild(list);
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function lpCloseDisciplineModal(event) {
            if (event && event.target !== event.currentTarget) return;
            const modal = document.getElementById('lp-discipline-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Team-Suche (Light Mode)
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('lp-team-search');
            const results = document.getElementById('lp-team-search-results');
            if (!input || !results) return;

            const laufzettelBase = '{{ url('/laufzettel') }}';

            input.addEventListener('input', function () {
                const query = this.value.trim().toLowerCase();
                results.innerHTML = '';
                if (query.length < 2) return;

                const matches = allTeamsData
                    .filter((team) => team.name.toLowerCase().includes(query))
                    .slice(0, 8);

                if (!matches.length) {
                    const empty = document.createElement('p');
                    empty.className = 'lp-muted text-center text-sm py-4';
                    empty.textContent = 'Kein Team gefunden.';
                    results.appendChild(empty);
                    return;
                }

                matches.forEach((team) => {
                    const link = document.createElement('a');
                    link.href = laufzettelBase + '/' + team.id;
                    link.className = 'lp-card lp-shadow block p-4 transition-transform duration-200 hover:-translate-y-0.5';

                    const top = document.createElement('div');
                    top.className = 'flex items-center justify-between gap-3';

                    const name = document.createElement('span');
                    name.className = 'font-extrabold break-words min-w-0';
                    name.appendChild(lpSchoolDot(team.school_id));
                    name.appendChild(document.createTextNode(team.name));

                    const score = document.createElement('span');
                    score.className = 'lp-display text-xl shrink-0';
                    score.textContent = team.score + ' P';

                    top.appendChild(name);
                    top.appendChild(score);

                    const sub = document.createElement('p');
                    sub.className = 'lp-muted text-xs mt-1 break-words';
                    sub.textContent = team.klasse_name + ' – ' + team.school_name + (team.disciplines_list ? ' · ' + team.disciplines_list : '');

                    link.appendChild(top);
                    link.appendChild(sub);
                    results.appendChild(link);
                });
            });
        });
    </script>

    <!-- Import der laufzettel-search.js für Suchfunktionalität -->
    @push('scripts')
        @vite(['resources/js/laufzettel-search.js'])
    @endpush
</x-layout>
