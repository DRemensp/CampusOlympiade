<x-layout>
    <x-slot:heading>
        📚 Archiv der CampusOlympiade
    </x-slot:heading>

    @include('partials.lp-theme')

    {{-- ===================== LIGHT MODE – „Sportfest-Poster“ ===================== --}}
    <div class="light-mode-only -mt-10">
        <section class="lp-sec-paper relative overflow-hidden pt-16 md:pt-32 pb-20 min-h-screen">
            <div class="lp-lanes absolute inset-0 pointer-events-none" aria-hidden="true"></div>
            <span class="lp-display lp-outline lp-watermark hidden lg:block absolute -right-8 top-16 pointer-events-none"
                  aria-hidden="true">Archiv</span>

            <div class="container mx-auto px-4 relative z-10">
                <div class="max-w-2xl">
                    <span class="lp-kicker lp-reveal">Ruhmeshalle</span>
                    <h1 class="lp-display lp-h2 mt-4 lp-reveal lp-d1">
                        Vergangene<br><span class="lp-outline">Wettkämpfe</span>
                    </h1>
                    <p class="lp-muted mt-4 lp-reveal lp-d2">
                        Jedes Archiv ist ein eingefrorener Moment: Ranglisten, Disziplinen und
                        Bestleistungen – festgehalten für die Ewigkeit.
                    </p>
                    <p class="lp-stamp mt-6 lp-reveal lp-d2">
                        {{ $archives->count() }} {{ $archives->count() === 1 ? 'Snapshot' : 'Snapshots' }}
                    </p>
                </div>

                @if($archives->isEmpty())
                    <div class="max-w-md mx-auto mt-16 lp-card lp-shadow p-8 text-center -rotate-1 lp-reveal lp-d3">
                        <p class="lp-display text-3xl">Noch leer</p>
                        <p class="lp-muted mt-3 text-sm leading-relaxed">
                            Archive werden vom Administrator nach dem Wettkampf erstellt –
                            hier entsteht die Geschichte der CampusOlympiade.
                        </p>
                        <div class="lp-barcode mt-6"></div>
                    </div>
                @else
                    <div class="grid gap-6 md:gap-8 sm:grid-cols-2 lg:grid-cols-3 mt-12">
                        @foreach($archives as $archive)
                            <a href="{{ route('archive.show', $archive) }}"
                               class="lp-card lp-shadow relative block p-6 pt-7 transition-transform duration-200 hover:-translate-y-1.5 group lp-reveal lp-d{{ min($loop->iteration, 5) }}">
                                <span class="lp-display lp-lane-index absolute top-4 right-5"
                                      aria-hidden="true">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>

                                <span class="lp-stamp text-[0.62rem]">{{ $archive->archived_date->format('d.m.Y') }}</span>

                                <h3 class="lp-display text-2xl mt-5 pr-12 break-words">{{ $archive->name }}</h3>

                                @if($archive->description)
                                    <p class="lp-muted text-sm mt-2 break-words">{{ $archive->description }}</p>
                                @endif

                                <div class="flex items-end gap-7 mt-6 pt-4 border-t-2 border-dashed"
                                     style="border-color: rgba(22, 29, 39, 0.2);">
                                    <div>
                                        <p class="lp-display text-3xl leading-none">{{ $archive->data['total_schools'] ?? 0 }}</p>
                                        <p class="lp-muted text-[0.62rem] font-bold uppercase tracking-[0.2em] mt-1.5">Schulen</p>
                                    </div>
                                    <div>
                                        <p class="lp-display text-3xl leading-none">{{ $archive->data['total_teams'] ?? 0 }}</p>
                                        <p class="lp-muted text-[0.62rem] font-bold uppercase tracking-[0.2em] mt-1.5">Teams</p>
                                    </div>
                                    <span class="ml-auto text-xl font-extrabold transition-transform duration-200 group-hover:translate-x-1.5"
                                          aria-hidden="true">→</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
        <div class="lp-checker h-4 border-t-2 lp-bord" aria-hidden="true"></div>
    </div>

    {{-- ===================== DARK MODE – unverändert ===================== --}}
    <div class="dark-mode-only">
        <div class="bg-gradient-to-br from-purple-100 to-blue-100 min-h-screen transition-colors duration-200 dark:bg-none">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

                @if($archives->isEmpty())
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4">📚</div>
                        <h2 class="display-font text-2xl font-semibold text-gray-600 dark:text-gray-300 mb-2 transition-colors duration-200">Noch keine Archive vorhanden</h2>
                        <p class="text-gray-500 dark:text-gray-400 transition-colors duration-200">Archive werden vom Administrator erstellt.</p>
                    </div>
                @else
                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($archives as $archive)
                            <div class="bg-white night-panel dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700">
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="display-font text-xl font-bold text-gray-800 dark:text-gray-100 transition-colors duration-200">{{ $archive->name }}</h3>
                                        <span class="bg-purple-100 dark:bg-purple-500/20 text-purple-800 dark:text-purple-200 text-xs font-medium px-2.5 py-0.5 rounded-full transition-colors duration-200">
                                            {{ $archive->archived_date->format('d.m.Y') }}
                                        </span>
                                    </div>

                                    @if($archive->description)
                                        <p class="text-gray-600 dark:text-gray-300 mb-4 text-sm transition-colors duration-200">{{ $archive->description }}</p>
                                    @endif

                                    <div class="grid grid-cols-2 gap-4 mb-4 text-center">
                                        <div class="bg-blue-50 dark:bg-blue-500/15 p-3 rounded-lg transition-colors duration-200">
                                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-300 transition-colors duration-200">{{ $archive->data['total_schools'] ?? 0 }}</div>
                                            <div class="text-xs text-blue-500 dark:text-blue-200 transition-colors duration-200">Schulen</div>
                                        </div>
                                        <div class="bg-green-50 dark:bg-green-500/15 p-3 rounded-lg transition-colors duration-200">
                                            <div class="text-2xl font-bold text-green-600 dark:text-green-300 transition-colors duration-200">{{ $archive->data['total_teams'] ?? 0 }}</div>
                                            <div class="text-xs text-green-500 dark:text-green-200 transition-colors duration-200">Teams</div>
                                        </div>
                                    </div>

                                    <a href="{{ route('archive.show', $archive) }}"
                                       class="w-full bg-gradient-to-r from-purple-500 to-blue-500 dark:from-purple-600 dark:to-blue-600 text-white py-2 px-4 rounded-lg hover:from-purple-600 hover:to-blue-600 dark:hover:from-purple-700 dark:hover:to-blue-700 transition-all duration-200 text-center block font-medium">
                                        🔍 Archiv ansehen
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>
