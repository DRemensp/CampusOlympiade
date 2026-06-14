<x-layout>
    <x-slot:heading>
        📚 {{ $archive->name }}
    </x-slot:heading>

    @include('partials.lp-theme')

    {{-- ===================== LIGHT MODE – „Sportfest-Poster“ ===================== --}}
    <div class="light-mode-only -mt-10">
        <section class="lp-sec-paper relative overflow-hidden pt-24 md:pt-28 pb-20 min-h-screen">
            <div class="lp-lanes absolute inset-0 pointer-events-none" aria-hidden="true"></div>

            <div class="container mx-auto px-4 relative z-10 max-w-5xl">
                <a href="{{ route('archive.index') }}" class="lp-chip lp-reveal">← Zurück zum Archiv</a>

                <div class="mt-7 flex flex-wrap items-start justify-between gap-5">
                    <div class="max-w-2xl min-w-0">
                        <span class="lp-kicker lp-reveal">Archiv-Snapshot</span>
                        <h1 class="lp-display lp-h2 mt-3 break-words lp-reveal lp-d1">{{ $archive->name }}</h1>
                        @if($archive->description)
                            <p class="lp-muted mt-4 break-words lp-reveal lp-d2">{{ $archive->description }}</p>
                        @endif
                    </div>
                    <span class="lp-stamp lp-reveal lp-d2">{{ $archive->archived_date->format('d.m.Y') }}</span>
                </div>

                {{-- Anzeigetafel des Snapshots --}}
                <div class="lp-board rounded-2xl border-2 lp-bord overflow-hidden mt-9 lp-reveal lp-d3">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-px bg-white/15">
                        <div class="px-4 py-6 text-center" style="background: var(--lp-ink);">
                            <p class="lp-board-num">{{ $archive->data['total_schools'] ?? 0 }}</p>
                            <p class="mt-2.5 text-[0.62rem] font-bold uppercase tracking-[0.25em] text-white/60">Schulen</p>
                        </div>
                        <div class="px-4 py-6 text-center" style="background: var(--lp-ink);">
                            <p class="lp-board-num" style="color: #fff;">{{ $archive->data['total_klasses'] ?? 0 }}</p>
                            <p class="mt-2.5 text-[0.62rem] font-bold uppercase tracking-[0.25em] text-white/60">Klassen</p>
                        </div>
                        <div class="px-4 py-6 text-center" style="background: var(--lp-ink);">
                            <p class="lp-board-num">{{ $archive->data['total_teams'] ?? 0 }}</p>
                            <p class="mt-2.5 text-[0.62rem] font-bold uppercase tracking-[0.25em] text-white/60">Teams</p>
                        </div>
                        <div class="px-4 py-6 text-center" style="background: var(--lp-ink);">
                            <p class="lp-board-num" style="color: #fff;">{{ $archive->data['total_students'] ?? 0 }}</p>
                            <p class="mt-2.5 text-[0.62rem] font-bold uppercase tracking-[0.25em] text-white/60">Schüler</p>
                        </div>
                    </div>
                </div>

                {{-- Tabs --}}
                <div class="flex gap-2 mt-10 overflow-x-auto pb-2 -mx-4 px-4 lp-reveal lp-d4">
                    <button type="button" class="lp-chip lp-tab lp-tab-active" data-lp-tab="schools">Schulen</button>
                    <button type="button" class="lp-chip lp-tab" data-lp-tab="klasses">Klassen</button>
                    <button type="button" class="lp-chip lp-tab" data-lp-tab="teams">Teams</button>
                    <button type="button" class="lp-chip lp-tab" data-lp-tab="disciplines">Disziplinen</button>
                </div>

                {{-- Schulwertung --}}
                <div id="lp-tab-schools" data-lp-tab-content class="mt-7">
                    <h2 class="lp-display text-xl md:text-2xl mb-4">Schulwertung</h2>
                    <div class="border-b-2 lp-bord">
                        @forelse($archive->data['school_ranking'] ?? [] as $school)
                            <div class="lp-row">
                                <span class="lp-rank-badge @if($school['rank'] == 1) lp-rank-1 @elseif($school['rank'] == 2) lp-rank-2 @elseif($school['rank'] == 3) lp-rank-3 @endif">{{ $school['rank'] }}</span>
                                <span class="font-extrabold break-words min-w-0">{{ $school['name'] }}</span>
                                <span class="text-right">
                                    <span class="lp-display text-2xl block leading-none">{{ $school['score'] }}</span>
                                    <span class="lp-muted text-[0.6rem] font-bold uppercase tracking-[0.2em]">Punkte</span>
                                </span>
                            </div>
                        @empty
                            <p class="lp-muted py-8 text-center text-sm">Keine Schulwertung in diesem Archiv.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Klassenwertung --}}
                <div id="lp-tab-klasses" data-lp-tab-content class="mt-7 hidden">
                    <h2 class="lp-display text-xl md:text-2xl mb-4">Klassenwertung</h2>
                    <div class="border-b-2 lp-bord">
                        @forelse($archive->data['klasse_ranking'] ?? [] as $klasse)
                            <div class="lp-row">
                                <span class="lp-rank-badge @if($klasse['rank'] == 1) lp-rank-1 @elseif($klasse['rank'] == 2) lp-rank-2 @elseif($klasse['rank'] == 3) lp-rank-3 @endif">{{ $klasse['rank'] }}</span>
                                <span class="min-w-0">
                                    <span class="font-extrabold break-words block">{{ $klasse['name'] }}</span>
                                    <span class="lp-muted text-xs break-words">{{ $klasse['school_name'] }}</span>
                                </span>
                                <span class="text-right">
                                    <span class="lp-display text-2xl block leading-none">{{ $klasse['score'] }}</span>
                                    <span class="lp-muted text-[0.6rem] font-bold uppercase tracking-[0.2em]">Punkte</span>
                                </span>
                            </div>
                        @empty
                            <p class="lp-muted py-8 text-center text-sm">Keine Klassenwertung in diesem Archiv.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Teamwertung --}}
                <div id="lp-tab-teams" data-lp-tab-content class="mt-7 hidden">
                    <div class="flex items-end justify-between gap-3 mb-4">
                        <h2 class="lp-display text-xl md:text-2xl">Teamwertung</h2>
                        <span class="lp-chip">Top 20</span>
                    </div>
                    <div class="border-b-2 lp-bord">
                        @forelse(collect($archive->data['team_ranking'] ?? [])->take(20) as $team)
                            <div class="lp-row">
                                <span class="lp-rank-badge @if($team['rank'] == 1) lp-rank-1 @elseif($team['rank'] == 2) lp-rank-2 @elseif($team['rank'] == 3) lp-rank-3 @endif">{{ $team['rank'] }}</span>
                                <span class="min-w-0">
                                    <span class="font-extrabold break-words block">{{ $team['name'] }}</span>
                                    <span class="lp-muted text-xs break-words">{{ $team['klasse_name'] }} – {{ $team['school_name'] }}</span>
                                </span>
                                <span class="text-right">
                                    <span class="lp-display text-2xl block leading-none">{{ $team['score'] }}</span>
                                    <span class="lp-muted text-[0.6rem] font-bold uppercase tracking-[0.2em]">Punkte</span>
                                </span>
                            </div>
                        @empty
                            <p class="lp-muted py-8 text-center text-sm">Keine Teamwertung in diesem Archiv.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Disziplinen --}}
                <div id="lp-tab-disciplines" data-lp-tab-content class="mt-7 hidden">
                    <h2 class="lp-display text-xl md:text-2xl mb-4">Beste Teams pro Disziplin</h2>
                    @if(isset($archive->data['best_teams_per_discipline']) && count($archive->data['best_teams_per_discipline']) > 0)
                        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach($archive->data['best_teams_per_discipline'] as $discipline)
                                <div class="lp-card lp-shadow p-5">
                                    <div class="flex items-start justify-between gap-2">
                                        <h3 class="lp-display text-lg break-words min-w-0">{{ $discipline['discipline_name'] }}</h3>
                                        <span class="lp-chip text-[0.58rem] shrink-0"
                                              style="{{ $discipline['higher_is_better'] ? 'background: var(--lp-pine); color: #fff;' : 'background: var(--lp-accent); color: #fff;' }}">
                                            {{ $discipline['higher_is_better'] ? '▲ Höher gewinnt' : '▼ Niedriger gewinnt' }}
                                        </span>
                                    </div>

                                    <p class="lp-display text-4xl mt-4 leading-none">{{ $discipline['best_score'] }}</p>
                                    <p class="lp-muted text-[0.62rem] font-bold uppercase tracking-[0.2em] mt-1">Bestleistung</p>

                                    <div class="mt-4 pt-3 border-t-2 border-dashed" style="border-color: rgba(22, 29, 39, 0.2);">
                                        <p class="font-extrabold text-sm break-words">{{ $discipline['team_name'] }}</p>
                                        <p class="lp-muted text-xs break-words">{{ $discipline['klasse_name'] }} – {{ $discipline['school_name'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="lp-muted py-8 text-center text-sm">Keine Disziplinen-Daten verfügbar.</p>
                    @endif
                </div>
            </div>
        </section>
        <div class="lp-checker h-4 border-t-2 lp-bord" aria-hidden="true"></div>
    </div>

    {{-- ===================== DARK MODE – unverändert ===================== --}}
    <div class="dark-mode-only">
        <div class="bg-gradient-to-br from-blue-100 to-green-100 min-h-screen transition-colors duration-200 dark:bg-none">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

                <!-- Header -->
                <div class="bg-white night-panel dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6 border border-gray-200 dark:border-gray-700 transition-colors duration-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                        <h1 class="display-font text-2xl font-bold bg-gradient-to-r from-indigo-600 to-emerald-600 dark:from-teal-300 dark:to-sky-300 bg-clip-text text-transparent mb-2 sm:mb-0">
                            {{ $archive->name }}
                        </h1>
                        <span class="bg-gradient-to-r from-blue-50 to-green-50 dark:from-slate-900/70 dark:to-slate-900/40 text-gray-700 dark:text-gray-200 px-4 py-2 rounded-full text-sm font-medium shadow-sm border border-gray-200 dark:border-slate-600/60 transition-colors duration-200">
                             {{ $archive->archived_date->format('d.m.Y') }}
                        </span>
                    </div>

                    @if($archive->description)
                        <div class="mb-4 p-3 bg-blue-50 dark:bg-slate-900/70 border border-blue-200 dark:border-sky-400/40 rounded-lg transition-colors duration-200">
                            <p class="text-gray-700 dark:text-gray-200 text-sm leading-relaxed transition-colors duration-200">{{ $archive->description }}</p>
                        </div>
                    @endif

                    <!-- Statistik Cards -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <div class="bg-gradient-to-br from-gray-50 to-indigo-50 dark:from-slate-900/70 dark:to-sky-500/10 p-4 rounded-lg text-center border border-gray-200 dark:border-gray-600 hover:shadow-md transition-all duration-200">
                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-300 mb-1 transition-colors duration-200">{{ $archive->data['total_schools'] ?? 0 }}</div>
                            <div class="text-xs font-medium text-blue-700 dark:text-blue-200 transition-colors duration-200">🏫 Schulen</div>
                        </div>
                        <div class="bg-gradient-to-br from-gray-50 to-indigo-50 dark:from-slate-900/70 dark:to-sky-500/10 p-4 rounded-lg text-center border border-gray-200 dark:border-gray-600 hover:shadow-md transition-all duration-200">
                            <div class="text-2xl font-bold text-green-600 dark:text-green-300 mb-1 transition-colors duration-200">{{ $archive->data['total_klasses'] ?? 0 }}</div>
                            <div class="text-xs font-medium text-green-700 dark:text-green-200 transition-colors duration-200">📚 Klassen</div>
                        </div>
                        <div class="bg-gradient-to-br from-gray-50 to-indigo-50 dark:from-slate-900/70 dark:to-sky-500/10 p-4 rounded-lg text-center border border-gray-200 dark:border-gray-600 hover:shadow-md transition-all duration-200">
                            <div class="text-2xl font-bold text-orange-600 dark:text-orange-300 mb-1 transition-colors duration-200">{{ $archive->data['total_teams'] ?? 0 }}</div>
                            <div class="text-xs font-medium text-orange-700 dark:text-orange-200 transition-colors duration-200">👥 Teams</div>
                        </div>
                        <div class="bg-gradient-to-br from-gray-50 to-indigo-50 dark:from-slate-900/70 dark:to-sky-500/10 p-4 rounded-lg text-center border border-gray-200 dark:border-gray-600 hover:shadow-md transition-all duration-200">
                            <div class="text-2xl font-bold text-purple-600 dark:text-purple-300 mb-1 transition-colors duration-200">{{ $archive->data['total_students'] ?? 0 }}</div>
                            <div class="text-xs font-medium text-purple-700 dark:text-purple-200 transition-colors duration-200">👤 Schüler</div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Tabs -->
                <div class="flex justify-center mb-6">
                    <nav class="bg-white night-card dark:bg-gray-800 rounded-full shadow-lg p-1 border border-gray-200 dark:border-gray-700 transition-colors duration-200">
                        <div class="flex space-x-0.5">
                            <button class="tab-button active night-tab night-tab-active px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 bg-indigo-600 dark:bg-indigo-500 text-white" data-tab="schools">
                                🏫 Schulen
                            </button>
                            <button class="tab-button night-tab px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-slate-800/70" data-tab="klasses">
                                📚 Klassen
                            </button>
                            <button class="tab-button night-tab px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-slate-800/70" data-tab="teams">
                                👥 Teams
                            </button>
                            <button class="tab-button night-tab px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-slate-800/70" data-tab="disciplines">
                                🏆 Disziplinen
                            </button>
                        </div>
                    </nav>
                </div>

                <!-- Content Container -->
                <div class="bg-white night-panel dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700 transition-colors duration-200">

                    <!-- Schulen Ranking -->
                    <div id="schools-tab" class="tab-content p-6">
                        <h3 class="display-font text-xl font-bold text-center mb-6 text-gray-800 dark:text-gray-100 border-b-2 border-indigo-500 dark:border-indigo-400 pb-3 transition-colors duration-200">
                            🏫 Schulen Rangliste
                        </h3>
                        <div class="space-y-3">
                            @foreach($archive->data['school_ranking'] ?? [] as $school)
                                @php
                                    $rankColors = match($school['rank']) {
                                       1 => ['bg' => 'from-yellow-400 to-yellow-500 dark:from-amber-400/70 dark:to-yellow-300/30', 'text' => 'text-yellow-800 dark:text-yellow-100'],
                                        2 => ['bg' => 'from-gray-300 to-gray-400 dark:from-slate-500/60 dark:to-slate-400/30', 'text' => 'text-gray-800 dark:text-slate-100'],
                                        3 => ['bg' => 'from-amber-600 to-amber-700 dark:from-amber-500/70 dark:to-orange-400/30', 'text' => 'text-amber-100 dark:text-amber-100'],
                                        default => ['bg' => 'from-indigo-400 to-indigo-500 dark:from-sky-500/60 dark:to-indigo-400/30', 'text' => 'text-white']
                                    };
                                    $cardBg = $school['rank'] <= 3 ? 'from-gray-50 to-yellow-50 dark:from-slate-900/70 dark:to-amber-500/12' : 'from-gray-50 to-indigo-50 dark:from-slate-900/70 dark:to-sky-500/10';
                                @endphp
                                <div class="flex items-center justify-between p-4 bg-gradient-to-r {{ $cardBg }} rounded-lg border border-gray-200 dark:border-gray-600 hover:shadow-md transition-all duration-200">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-10 h-10 bg-gradient-to-r border border-gray-400 dark:border-gray-500 {{ $rankColors['bg'] }} {{ $rankColors['text'] }} rounded-full flex items-center justify-center font-bold text-sm shadow-sm">
                                            {{ $school['rank'] }}
                                        </div>
                                        <div>
                                            <span class="font-semibold text-base text-gray-800 dark:text-gray-100 transition-colors duration-200">{{ $school['name'] }}</span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-bold text-lg text-gray-900 dark:text-gray-100 transition-colors duration-200">{{ $school['score'] }}</div>
                                        <div class="text-xs text-gray-700 dark:text-gray-300 transition-colors duration-200">Punkte</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Klassen Ranking -->
                    <div id="klasses-tab" class="tab-content p-6 hidden">
                        <h3 class="display-font text-xl font-bold text-center mb-6 text-gray-800 dark:text-gray-100 border-b-2 border-green-500 dark:border-green-400 pb-3 transition-colors duration-200">
                            📚 Klassen Rangliste
                        </h3>
                        <div class="space-y-3">
                            @foreach($archive->data['klasse_ranking'] ?? [] as $klasse)
                                @php
                                    $rankColors = match($klasse['rank']) {
                                        1 => ['bg' => 'from-yellow-400 to-yellow-500 dark:from-amber-400/70 dark:to-yellow-300/30', 'text' => 'text-yellow-800 dark:text-yellow-100'],
                                        2 => ['bg' => 'from-gray-300 to-gray-400 dark:from-slate-500/60 dark:to-slate-400/30', 'text' => 'text-gray-800 dark:text-slate-100'],
                                        3 => ['bg' => 'from-amber-600 to-amber-700 dark:from-amber-500/70 dark:to-orange-400/30', 'text' => 'text-amber-100 dark:text-amber-100'],
                                        default => ['bg' => 'from-indigo-400 to-indigo-500 dark:from-sky-500/60 dark:to-indigo-400/30', 'text' => 'text-white']
                                    };
                                    $cardBg = $klasse['rank'] <= 3 ? 'from-gray-50 to-yellow-50 dark:from-slate-900/70 dark:to-amber-500/12' : 'from-gray-50 to-indigo-50 dark:from-slate-900/70 dark:to-sky-500/10';
                                @endphp
                                <div class="flex items-center justify-between p-4 bg-gradient-to-r {{ $cardBg }} rounded-lg border border-gray-200 dark:border-gray-600 hover:shadow-md transition-all duration-200">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-10 h-10 bg-gradient-to-r border border-gray-400 dark:border-gray-500 {{ $rankColors['bg'] }} {{ $rankColors['text'] }} rounded-full flex items-center justify-center font-bold text-sm shadow-sm">
                                            {{ $klasse['rank'] }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-base text-gray-800 dark:text-gray-100 transition-colors duration-200">{{ $klasse['name'] }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 transition-colors duration-200">{{ $klasse['school_name'] }}</div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-bold text-lg text-gray-900 dark:text-gray-100 transition-colors duration-200">{{ $klasse['score'] }}</div>
                                        <div class="text-xs text-gray-700 dark:text-gray-300 transition-colors duration-200">Punkte</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Teams Ranking -->
                    <div id="teams-tab" class="tab-content p-6 hidden">
                        <h3 class="display-font text-xl font-bold text-center mb-6 text-gray-800 dark:text-gray-100 border-b-2 border-orange-500 dark:border-orange-400 pb-3 transition-colors duration-200">
                            👥 Teams Rangliste (Top 20)
                        </h3>
                        <div class="space-y-3">
                            @foreach(collect($archive->data['team_ranking'] ?? [])->take(20) as $team)
                                @php
                                    $rankColors = match($team['rank']) {
                                        1 => ['bg' => 'from-yellow-400 to-yellow-500 dark:from-amber-400/70 dark:to-yellow-300/30', 'text' => 'text-yellow-800 dark:text-yellow-100'],
                                        2 => ['bg' => 'from-gray-300 to-gray-400 dark:from-slate-500/60 dark:to-slate-400/30', 'text' => 'text-gray-800 dark:text-slate-100'],
                                        3 => ['bg' => 'from-amber-600 to-amber-700 dark:from-amber-500/70 dark:to-orange-400/30', 'text' => 'text-amber-100 dark:text-amber-100'],
                                        default => ['bg' => 'from-indigo-400 to-indigo-500 dark:from-sky-500/60 dark:to-indigo-400/30', 'text' => 'text-white']
                                    };
                                    $cardBg = $team['rank'] <= 3 ? 'from-gray-50 to-yellow-50 dark:from-slate-900/70 dark:to-amber-500/12' : 'from-gray-50 to-indigo-50 dark:from-slate-900/70 dark:to-sky-500/10';
                                @endphp
                                <div class="flex items-center justify-between p-4 bg-gradient-to-r {{ $cardBg }} rounded-lg border border-gray-200 dark:border-gray-600 hover:shadow-md transition-all duration-200">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-10 h-10 bg-gradient-to-r border border-gray-400 dark:border-gray-500 {{ $rankColors['bg'] }} {{ $rankColors['text'] }} rounded-full flex items-center justify-center font-bold text-sm shadow-sm">
                                            {{ $team['rank'] }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-base text-gray-800 dark:text-gray-100 transition-colors duration-200">{{ $team['name'] }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 transition-colors duration-200">{{ $team['klasse_name'] }} - {{ $team['school_name'] }}</div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-bold text-lg text-gray-900 dark:text-gray-100 transition-colors duration-200">{{ $team['score'] }}</div>
                                        <div class="text-xs text-gray-700 dark:text-gray-300 transition-colors duration-200">Punkte</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Disziplinen Übersicht -->
                    <div id="disciplines-tab" class="tab-content p-6 hidden">
                        <h3 class="display-font text-xl font-bold text-center mb-6 text-gray-800 dark:text-gray-100 border-b-2 border-blue-400 pb-3 transition-colors duration-200">
                            🏆 Beste Teams pro Disziplin
                        </h3>
                        @if(isset($archive->data['best_teams_per_discipline']) && count($archive->data['best_teams_per_discipline']) > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($archive->data['best_teams_per_discipline'] as $discipline)
                                    <div class="bg-gradient-to-br from-gray-50 to-indigo-50 dark:from-slate-900/70 dark:to-sky-500/10 p-4 rounded-lg border border-gray-200 dark:border-gray-600 hover:shadow-md transition-all duration-200">
                                        <h4 class="font-semibold text-base text-gray-800 dark:text-gray-100 mb-2 transition-colors duration-200">{{ $discipline['discipline_name'] }}</h4>


                                        <div class="text-xs mb-3 transition-colors duration-200 {{ $discipline['higher_is_better'] ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            @if($discipline['higher_is_better'])
                                                📈 Höher ist besser
                                            @else
                                                📉 Niedriger ist besser
                                            @endif
                                        </div>

                                        <div class="pt-2 border-t border-gray-200 dark:border-gray-600 transition-colors duration-200">
                                            <div class="font-bold text-sm text-yellow-700 dark:text-amber-200 mb-1 transition-colors duration-200">🥇 Beste Leistung: {{ $discipline['best_score'] }}</div>

                                            <div class="text-gray-800 dark:text-gray-100 font-bold transition-colors duration-200">TEAM: {{ $discipline['team_name'] }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 transition-colors duration-200">{{ $discipline['klasse_name'] }} - {{ $discipline['school_name'] }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500 dark:text-gray-400 transition-colors duration-200">Keine Disziplinen-Daten verfügbar.</p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab functionality (Dark Mode, unverändert)
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');

                    // Remove active class from all buttons
                    tabButtons.forEach(btn => {
                        btn.classList.remove('active', 'bg-indigo-600', 'dark:bg-indigo-500', 'text-white', 'night-tab-active');
                        btn.classList.add('text-gray-600', 'dark:text-gray-300');
                    });

                    // Add active class to clicked button
                    this.classList.add('active', 'bg-indigo-600', 'dark:bg-indigo-500', 'text-white', 'night-tab-active');
                    this.classList.remove('text-gray-600', 'dark:text-gray-300');

                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });

                    // Show target tab content
                    document.getElementById(targetTab + '-tab').classList.remove('hidden');
                });
            });

            // Tab-Umschaltung (Light Mode, Poster-Design)
            const lpTabs = document.querySelectorAll('[data-lp-tab]');
            const lpContents = document.querySelectorAll('[data-lp-tab-content]');

            lpTabs.forEach((btn) => {
                btn.addEventListener('click', function () {
                    lpTabs.forEach((b) => b.classList.remove('lp-tab-active'));
                    this.classList.add('lp-tab-active');

                    lpContents.forEach((content) => content.classList.add('hidden'));
                    const target = document.getElementById('lp-tab-' + this.dataset.lpTab);
                    if (target) target.classList.remove('hidden');
                });
            });
        });
    </script>
</x-layout>
