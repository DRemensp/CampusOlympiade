<x-layout>
    @include('partials.lp-theme')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Manrope:wght@300;400;500;600;700&display=swap');

        .light-mode-only {
            display: block;
        }
        .dark-mode-only {
            display: none;
        }

        .dark .light-mode-only {
            display: none;
        }

        .dark .dark-mode-only {
            display: block;
        }

        .dark .dark-mode-only {
            --night-0: #0a0f14;
            --night-1: #0f172a;
            --night-2: #141c2b;
            --ink-0: #e6edf7;
            --ink-1: #b5c0d3;
            --accent-teal: #2dd4bf;
            --accent-blue: #60a5fa;
            --accent-amber: #f59e0b;
            --accent-rose: #fb7185;
            --line: rgba(148, 163, 184, 0.2);
            font-family: "Manrope", sans-serif;
            color: var(--ink-0);
        }

        .dark .dark-mode-only .display-font {
            font-family: "Space Grotesk", sans-serif;
            letter-spacing: -0.02em;
        }

        .aurora-sky {
            background: radial-gradient(1200px circle at 12% 0%, rgba(45, 212, 191, 0.18), transparent 60%),
            radial-gradient(900px circle at 90% 12%, rgba(96, 165, 250, 0.22), transparent 55%),
            radial-gradient(700px circle at 30% 85%, rgba(245, 158, 11, 0.16), transparent 60%),
            linear-gradient(180deg, #0a0f14 0%, #0b1320 45%, #0b0f17 100%);
        }

        .aurora-grid {
            background-image: radial-gradient(rgba(148, 163, 184, 0.25) 1px, transparent 1px);
            background-size: 24px 24px;
            opacity: 0.35;
            animation: gridPulse 8s ease-in-out infinite;
        }

        .parallax-layer {
            transform: translate3d(0, 0, 0);
            will-change: transform;
        }

        @keyframes gridPulse {
            0%, 100% {
                opacity: 0.35;
                transform: scale(1);
            }
            50% {
                opacity: 0.5;
                transform: scale(1.02);
            }
        }

        .hero-orb {
            animation: drift 12s ease-in-out infinite;
        }

        .glow-dot {
            position: absolute;
            border-radius: 9999px;
            filter: blur(3px);
            box-shadow: 0 0 30px currentColor, 0 0 60px currentColor, 0 0 90px currentColor;
            animation: glowFloat 6s ease-in-out infinite, glowPulse 3s ease-in-out infinite;
            opacity: 0.8;
        }

        @media (max-width: 767px) {
            .dark .module-carousel-shell {
                position: relative;
                overflow-x: hidden;
                overflow-y: visible;
                perspective: 1200px;
                padding: 0.75rem 1.5rem;
            }

            .dark .module-carousel {
                display: flex;
                flex-wrap: nowrap;
                gap: 1rem;
                transition: transform 0.7s ease;
                will-change: transform;
            }

            .dark .module-carousel .module-card {
                flex: 0 0 78%;
                max-width: 78%;
                transform-origin: center;
                transition: transform 0.7s ease, opacity 0.7s ease;
                animation: none;
            }

            .dark .module-carousel .module-card.is-active {
                opacity: 1;
                transform: translate3d(0, 0, 0) scale(1.05);
            }

            .dark .module-carousel .module-card.is-prev {
                opacity: 0.7;
                transform: translate3d(-6%, 8px, -80px) scale(0.92);
            }

            .dark .module-carousel .module-card.is-next {
                opacity: 0.7;
                transform: translate3d(6%, 8px, -80px) scale(0.92);
            }

            .dark .module-carousel .module-card.is-off {
                opacity: 0;
                pointer-events: none;
                transform: translate3d(0, 16px, -120px) scale(0.9);
            }
        }

        @keyframes glowFloat {
            0%, 100% {
                transform: translate(0, 0);
            }
            25% {
                transform: translate(15px, -15px);
            }
            50% {
                transform: translate(-10px, -20px);
            }
            75% {
                transform: translate(-20px, 10px);
            }
        }

        @keyframes glowPulse {
            0%, 100% {
                opacity: 0.4;
                transform: scale(1);
            }
            50% {
                opacity: 1;
                transform: scale(1.5);
            }
        }

        .dark .pulse-dot {
            background: var(--accent-teal);
            box-shadow: 0 0 0 0 rgba(45, 212, 191, 0.6);
            animation: pulse 2.2s infinite;
        }

        .dark .cta-primary {
            background: linear-gradient(135deg, var(--accent-teal), var(--accent-blue));
        }

        .dark .cta-primary::after {
            content: '';
            position: absolute;
            inset: -100% 0 0 -100%;
            background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.45), transparent);
            transform: translateX(-60%);
            transition: transform 0.7s ease;
            z-index: 0;
        }

        .dark .cta-primary:hover::after {
            transform: translateX(60%);
        }

        .dark .score-cell::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.08), transparent);
            opacity: 0;
            transform: translateX(-40%);
            transition: opacity 0.3s ease, transform 0.6s ease;
        }

        .dark .score-cell:hover::after {
            opacity: 1;
            transform: translateX(40%);
        }

        .dark .tag-chip {
            color: var(--ink-1);
        }

        .dark .section-kicker {
            color: var(--accent-blue);
        }

        .dark .module-card {
            background: linear-gradient(160deg, rgba(15, 23, 42, 0.92), rgba(7, 10, 18, 0.95));
        }

        .dark .module-icon {
            color: var(--accent-teal);
        }

        .dark .flow-card {
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.85), rgba(8, 11, 20, 0.95));
        }

        .dark .community-shell {
            background: linear-gradient(140deg, rgba(12, 18, 30, 0.9), rgba(7, 10, 18, 0.95));
        }

        .dark .scoreboard-panel {
            background: linear-gradient(160deg, rgba(15, 23, 42, 0.9), rgba(7, 10, 18, 0.96));
        }

        .dark .reveal {
            animation: rise 0.9s ease both;
        }

        .dark .delay-1 {
            animation-delay: 0.1s;
        }

        .dark .delay-2 {
            animation-delay: 0.2s;
        }

        .dark .delay-3 {
            animation-delay: 0.3s;
        }

        .dark .delay-4 {
            animation-delay: 0.4s;
        }

        @keyframes drift {
            0%, 100% {
                transform: translateY(0) translateX(0);
            }
            50% {
                transform: translateY(-18px) translateX(10px);
            }
        }

        @keyframes rise {
            0% {
                opacity: 0;
                transform: translateY(18px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(45, 212, 191, 0.6);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(45, 212, 191, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(45, 212, 191, 0);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .dark .hero-orb,
            .dark .reveal,
            .dark .pulse-dot,
            .dark .cta-primary::after {
                animation: none !important;
                transition: none !important;
            }
        }
    </style>

    <div class="light-mode-only -mt-10">

        {{-- ============================ HERO ============================ --}}
        <section class="lp-sec-paper relative overflow-hidden pt-16 md:pt-36 pb-20 md:pb-28">
            <div class="lp-lanes absolute inset-0 pointer-events-none" aria-hidden="true"></div>
            <div class="hidden lg:block absolute -top-12 -right-20 w-[440px] h-[120px] rotate-[-8deg] opacity-70 pointer-events-none"
                 style="background: var(--lp-gold);" aria-hidden="true"></div>

            <div class="container mx-auto px-4 relative z-10">
                <div class="grid lg:grid-cols-12 gap-14 lg:gap-8 items-center">
                    <div class="lg:col-span-7">
                        <div class="lp-kicker lp-reveal">Eigenständige Web-Anwendung · Schulwettkampf</div>

                        <h1 class="lp-display lp-h1 mt-6">
                            <span class="block lp-reveal lp-d1">Campus</span>
                            <span class="block lp-outline lp-reveal lp-d2">Olympiade</span>
                        </h1>

                        <p class="lp-stamp mt-6 lp-reveal lp-d2">Schneller · Höher · Weiter</p>

                        <p class="lp-muted text-lg md:text-xl max-w-xl mt-6 lp-reveal lp-d3">
                            Die Web-Anwendung, die alles kann – vom Anlegen der Schulen, Klassen und
                            Teams bis hin zu Live-Ranglisten, Laufzetteln und Urkunden-Druck.
                        </p>

                        <div class="flex flex-wrap gap-4 mt-8 lp-reveal lp-d4">
                            <a href="{{ url('/ranking') }}" class="lp-btn-primary w-full sm:w-auto justify-center">
                                Zum Live-Ranking
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </a>
                            <a href="{{ url('/login') }}" class="lp-btn-ghost w-full sm:w-auto justify-center">
                                Login für Berechtigte
                            </a>
                        </div>

                    </div>

                    {{-- Startnummern-Karte: echtes "Team des Tages", verlinkt auf den Laufzettel --}}
                    <div class="lg:col-span-5 relative lp-reveal lp-d3 px-4 sm:px-0 pb-8">
                        <div class="hidden sm:flex flex-col items-center absolute -top-8 right-2 lg:right-4 rotate-6 z-0 lp-card lp-shadow-gold px-6 py-4">
                            <span class="lp-display text-4xl leading-none">1.</span>
                            <span class="text-[0.62rem] font-extrabold uppercase tracking-[0.25em] mt-1">Platz</span>
                        </div>

                        @if ($bibTeam)
                            <a href="{{ url('/laufzettel/' . $bibTeam->id) }}"
                               class="lp-bib relative z-10 lp-card lp-shadow max-w-sm mx-auto px-7 pt-7 pb-8 block transition-shadow hover:shadow-none">
                                <span class="lp-pin absolute top-3 left-3"></span>
                                <span class="lp-pin absolute top-3 right-3"></span>
                                <span class="lp-pin absolute bottom-3 left-3"></span>
                                <span class="lp-pin absolute bottom-3 right-3"></span>

                                <div class="flex items-center justify-between text-[0.62rem] font-extrabold uppercase tracking-[0.22em] lp-muted">
                                    <span>Team des Tages</span>
                                    <span>{{ date('Y') }}</span>
                                </div>
                                <div class="mt-3 border-t-2 border-dashed lp-bord opacity-20"></div>

                                <p class="lp-display lp-bib-num text-center mt-4">{{ str_pad($bibTeam->id, 3, '0', STR_PAD_LEFT) }}</p>
                                <p class="text-center font-extrabold uppercase tracking-[0.18em] text-sm mt-2 break-words">
                                    {{ $bibTeam->name }}
                                </p>
                                <p class="lp-muted text-center text-[0.68rem] font-semibold uppercase tracking-[0.22em] mt-1 break-words">
                                    Von der Klasse: {{ $bibTeam->klasse->name ?? '–' }}
                                </p>
                                <p class="lp-muted text-center text-[0.68rem] font-semibold uppercase tracking-[0.22em] mt-1 break-words">
                                    {{ $bibTeam->klasse->school->name ?? '–' }}
                                </p>

                                <div class="lp-barcode mt-6"></div>
                                <p class="lp-muted text-center text-[0.6rem] font-bold uppercase tracking-[0.2em] mt-3 opacity-70">
                                    Zum Laufzettel →
                                </p>
                            </a>
                        @else
                            <div class="lp-bib relative z-10 lp-card lp-shadow max-w-sm mx-auto px-7 pt-7 pb-8">
                                <span class="lp-pin absolute top-3 left-3"></span>
                                <span class="lp-pin absolute top-3 right-3"></span>
                                <span class="lp-pin absolute bottom-3 left-3"></span>
                                <span class="lp-pin absolute bottom-3 right-3"></span>

                                <div class="flex items-center justify-between text-[0.62rem] font-extrabold uppercase tracking-[0.22em] lp-muted">
                                    <span>Campus Olympiade</span>
                                    <span>{{ date('Y') }}</span>
                                </div>
                                <div class="mt-3 border-t-2 border-dashed lp-bord opacity-20"></div>

                                <p class="lp-display lp-bib-num text-center mt-4">001</p>
                                <p class="text-center font-extrabold uppercase tracking-[0.18em] text-sm mt-2">Dein Team?</p>
                                <p class="lp-muted text-center text-[0.68rem] font-semibold uppercase tracking-[0.22em] mt-1">
                                    Die Teams werden bald angelegt
                                </p>

                                <div class="lp-barcode mt-6"></div>
                            </div>
                        @endif

                        <div class="absolute -bottom-1 left-6 sm:left-12 rotate-[-4deg] z-20 inline-flex items-center gap-2 border-2 lp-bord rounded-full px-4 py-1.5 text-[0.68rem] font-extrabold uppercase tracking-[0.18em] text-white"
                             style="background: var(--lp-accent); box-shadow: 4px 4px 0 0 var(--lp-ink);">
                            <span class="lp-live-dot" style="background:#fff;"></span> Live-Auswertung
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ================= ANZEIGETAFEL + LIVE-TICKER ================= --}}
        <section class="lp-board border-y-2 lp-bord">
            <div class="lp-tickerbar relative z-10 flex items-stretch border-b border-white/15">
                <div class="flex items-center gap-2 px-4 py-2.5 text-[0.68rem] font-extrabold uppercase tracking-[0.2em] text-white whitespace-nowrap"
                     style="background: var(--lp-accent);">
                    <span class="lp-live-dot" style="background:#fff;"></span> Live-Ticker
                </div>
                {{-- Zuletzt eingetragene Ergebnisse – aktualisiert sich per Polling --}}
                <div class="relative flex-1 overflow-hidden">
                    <div class="lp-ticker-track" data-lp-ticker>
                        <div class="flex items-center">
                            @foreach ($tickerItems as $item)
                                <span class="lp-tick">{{ $item }}</span>
                            @endforeach
                        </div>
                        <div class="flex items-center" aria-hidden="true">
                            @foreach ($tickerItems as $item)
                                <span class="lp-tick">{{ $item }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mx-auto px-4 py-12 md:py-16 relative z-10">
                <div class="flex flex-wrap items-center justify-between gap-4 mb-10">
                    <div>
                        <p class="text-[0.65rem] font-extrabold uppercase tracking-[0.3em]" style="color: var(--lp-gold);">
                            Anzeigetafel
                        </p>
                        <h2 class="lp-display lp-h2 text-white mt-2">Die Olympiade in Zahlen</h2>
                    </div>
                    <div class="inline-flex items-center gap-3 border border-white/20 rounded-full px-4 py-2 text-[0.68rem] font-bold uppercase tracking-[0.18em] text-white/70">
                        <span class="lp-live-dot"></span> Live · <span data-lp-clock>--:--</span>&nbsp;Uhr
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-5 gap-px bg-white/15 border border-white/15">
                    <div class="px-5 py-7 text-center" style="background: var(--lp-ink);">
                        <p class="lp-board-num" data-lp-stat="schools">{{ $schoolCount }}</p>
                        <p class="mt-3 text-[0.62rem] font-bold uppercase tracking-[0.25em] text-white/60">Schulen</p>
                    </div>
                    <div class="px-5 py-7 text-center" style="background: var(--lp-ink);">
                        <p class="lp-board-num" style="color: #fff;" data-lp-stat="klasses">{{ $klasseCount }}</p>
                        <p class="mt-3 text-[0.62rem] font-bold uppercase tracking-[0.25em] text-white/60">Klassen</p>
                    </div>
                    <div class="px-5 py-7 text-center" style="background: var(--lp-ink);">
                        <p class="lp-board-num" data-lp-stat="teams">{{ $teamCount }}</p>
                        <p class="mt-3 text-[0.62rem] font-bold uppercase tracking-[0.25em] text-white/60">Teams</p>
                    </div>
                    <div class="px-5 py-7 text-center" style="background: var(--lp-ink);">
                        <p class="lp-board-num" style="color: #fff;" data-lp-stat="students">{{ $studentCount }}</p>
                        <p class="mt-3 text-[0.62rem] font-bold uppercase tracking-[0.25em] text-white/60">Schüler</p>
                    </div>
                    <div class="px-5 py-7 text-center col-span-2 md:col-span-1" style="background: var(--lp-ink);">
                        <p class="lp-board-num" style="color: var(--lp-accent);" data-lp-stat="visits">{{ number_format($visitcount->total_visits ?? 0, 0, ',', '.') }}</p>
                        <p class="mt-3 text-[0.62rem] font-bold uppercase tracking-[0.25em] text-white/60">Besuche</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ====================== LAUFBAND-DIVIDER ====================== --}}
        <div class="lp-marquee" aria-hidden="true">
            <div class="lp-marquee-track">
                <span class="lp-marquee-item">Schneller&nbsp;✦&nbsp;Höher&nbsp;✦&nbsp;Weiter&nbsp;✦&nbsp;Campus Olympiade&nbsp;✦&nbsp;</span>
                <span class="lp-marquee-item">Schneller&nbsp;✦&nbsp;Höher&nbsp;✦&nbsp;Weiter&nbsp;✦&nbsp;Campus Olympiade&nbsp;✦&nbsp;</span>
                <span class="lp-marquee-item">Schneller&nbsp;✦&nbsp;Höher&nbsp;✦&nbsp;Weiter&nbsp;✦&nbsp;Campus Olympiade&nbsp;✦&nbsp;</span>
                <span class="lp-marquee-item">Schneller&nbsp;✦&nbsp;Höher&nbsp;✦&nbsp;Weiter&nbsp;✦&nbsp;Campus Olympiade&nbsp;✦&nbsp;</span>
            </div>
        </div>

        {{-- =========================== PODIUM =========================== --}}
        <section class="lp-sec-paper relative overflow-hidden py-16 md:py-24">
            <span class="lp-display lp-outline lp-watermark hidden lg:block absolute -right-6 top-10 pointer-events-none"
                  aria-hidden="true">{{ date('Y') }}</span>

            <div class="container mx-auto px-4 relative z-10">
                <div class="text-center max-w-2xl mx-auto mb-14">
                    <div class="flex justify-center">
                        <span class="lp-kicker">Momentaufnahme</span>
                    </div>
                    <h2 class="lp-display lp-h2 mt-4">Das Podium von heute</h2>
                    <p class="lp-muted mt-4">
                        Die aktuelle Top&nbsp;3 der Teamwertung – aktualisiert sich automatisch.
                    </p>
                </div>

                @php
                    $podiumSlot = fn ($i, $field) => match ($field) {
                        'name' => $podium[$i]['name'] ?? 'Noch offen',
                        'meta' => isset($podium[$i])
                            ? ($podium[$i]['klasse'] . ' · ' . number_format($podium[$i]['score'], 0, ',', '.') . ' Pkt.')
                            : 'Wertung folgt',
                        'dot' => \App\Services\SchoolColorService::getColorClasses($podium[$i]['school_id'] ?? 0)['dot'],
                    };
                @endphp

                <div class="max-w-3xl mx-auto border-b-2 lp-bord">
                    <div class="grid grid-cols-3 gap-3 md:gap-6 items-end">
                        {{-- Platz 2 --}}
                        <div class="min-w-0">
                            <div class="lp-card lp-shadow px-2 py-2.5 md:px-4 md:py-3 text-center mb-5 -rotate-1">
                                <p class="font-extrabold text-sm md:text-base leading-tight break-words"><span class="inline-block w-2 h-2 rounded-full {{ $podiumSlot(1, 'dot') }} border border-black/30 align-middle mr-1" data-lp-podium-dot="1"></span><span data-lp-podium-name="1">{{ $podiumSlot(1, 'name') }}</span></p>
                                <p class="lp-muted text-[0.6rem] md:text-[0.65rem] font-bold uppercase tracking-[0.18em] mt-0.5 break-words" data-lp-podium-meta="1">{{ $podiumSlot(1, 'meta') }}</p>
                            </div>
                            <div class="lp-podium lp-top-silver h-28 md:h-40">
                                <span class="lp-display lp-outline text-5xl md:text-7xl">2</span>
                            </div>
                        </div>
                        {{-- Platz 1 --}}
                        <div class="min-w-0">
                            <div class="text-center mb-3" aria-hidden="true">
                                <span class="lp-display text-2xl md:text-3xl" style="color: var(--lp-gold); -webkit-text-stroke: 1.5px var(--lp-ink);">★</span>
                            </div>
                            <div class="lp-card lp-shadow-gold px-2 py-2.5 md:px-4 md:py-3 text-center mb-5 rotate-1">
                                <p class="font-extrabold text-sm md:text-base leading-tight break-words"><span class="inline-block w-2 h-2 rounded-full {{ $podiumSlot(0, 'dot') }} border border-black/30 align-middle mr-1" data-lp-podium-dot="0"></span><span data-lp-podium-name="0">{{ $podiumSlot(0, 'name') }}</span></p>
                                <p class="lp-muted text-[0.6rem] md:text-[0.65rem] font-bold uppercase tracking-[0.18em] mt-0.5 break-words" data-lp-podium-meta="0">{{ $podiumSlot(0, 'meta') }}</p>
                            </div>
                            <div class="lp-podium lp-top-gold h-40 md:h-56">
                                <span class="lp-display lp-outline text-6xl md:text-8xl">1</span>
                            </div>
                        </div>
                        {{-- Platz 3 --}}
                        <div class="min-w-0">
                            <div class="lp-card lp-shadow px-2 py-2.5 md:px-4 md:py-3 text-center mb-5 rotate-2">
                                <p class="font-extrabold text-sm md:text-base leading-tight break-words"><span class="inline-block w-2 h-2 rounded-full {{ $podiumSlot(2, 'dot') }} border border-black/30 align-middle mr-1" data-lp-podium-dot="2"></span><span data-lp-podium-name="2">{{ $podiumSlot(2, 'name') }}</span></p>
                                <p class="lp-muted text-[0.6rem] md:text-[0.65rem] font-bold uppercase tracking-[0.18em] mt-0.5 break-words" data-lp-podium-meta="2">{{ $podiumSlot(2, 'meta') }}</p>
                            </div>
                            <div class="lp-podium lp-top-bronze h-20 md:h-28">
                                <span class="lp-display lp-outline text-4xl md:text-6xl">3</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-12">
                    <a href="{{ url('/ranking') }}" class="lp-btn-primary">
                        Komplettes Ranking ansehen
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        {{-- ======================= MODULE / BAHNEN ====================== --}}
        <section class="bg-white border-t-2 lp-bord py-16 md:py-24">
            <div class="container mx-auto px-4">
                <div class="flex flex-wrap items-end justify-between gap-6 mb-12">
                    <div>
                        <span class="lp-kicker">Module</span>
                        <h2 class="lp-display lp-h2 mt-4">Sechs Bahnen,<br>ein Wettkampf</h2>
                    </div>
                    <p class="lp-muted max-w-sm">
                        Vom ersten Versuch bis zur Siegerehrung – alles läuft über eine Plattform.
                    </p>
                </div>

                <div class="border-b-2 lp-bord">
                    <a href="{{ url('/ranking') }}" class="lp-lane group">
                        <span class="lp-lane-index">01</span>
                        <span>
                            <span class="lp-display block text-2xl md:text-3xl">Live-Ranking</span>
                            <span class="lp-muted block text-sm md:text-base mt-1">Schulen, Klassen und Teams – jede Wertung sofort sichtbar.</span>
                        </span>
                        <span class="flex items-center gap-4">
                            <span class="lp-chip hidden sm:inline-flex">Live</span>
                            <span class="lp-lane-arrow">→</span>
                        </span>
                    </a>
                    <a href="{{ url('/laufzettel') }}" class="lp-lane group">
                        <span class="lp-lane-index">02</span>
                        <span>
                            <span class="lp-display block text-2xl md:text-3xl">Laufzettel</span>
                            <span class="lp-muted block text-sm md:text-base mt-1">Der Steckbrief deines Teams: Disziplinen, Bestwerte, Platzierung.</span>
                        </span>
                        <span class="flex items-center gap-4">
                            <span class="lp-chip hidden sm:inline-flex">Öffentlich</span>
                            <span class="lp-lane-arrow">→</span>
                        </span>
                    </a>
                    <a href="{{ url('/archive') }}" class="lp-lane group">
                        <span class="lp-lane-index">03</span>
                        <span>
                            <span class="lp-display block text-2xl md:text-3xl">Archiv</span>
                            <span class="lp-muted block text-sm md:text-base mt-1">Abgeschlossene Wettkämpfe als Snapshot für die Ewigkeit.</span>
                        </span>
                        <span class="flex items-center gap-4">
                            <span class="lp-chip hidden sm:inline-flex">Historie</span>
                            <span class="lp-lane-arrow">→</span>
                        </span>
                    </a>
                    <a href="{{ url('/login') }}" class="lp-lane group">
                        <span class="lp-lane-index">04</span>
                        <span>
                            <span class="lp-display block text-2xl md:text-3xl">Punkte erfassen</span>
                            <span class="lp-muted block text-sm md:text-base mt-1">Zwei Versuche pro Team, der Bestwert zählt automatisch.</span>
                        </span>
                        <span class="flex items-center gap-4">
                            <span class="lp-chip hidden sm:inline-flex">Login</span>
                            <span class="lp-lane-arrow">→</span>
                        </span>
                    </a>
                    <a href="{{ url('/login') }}" class="lp-lane group">
                        <span class="lp-lane-index">05</span>
                        <span>
                            <span class="lp-display block text-2xl md:text-3xl">Verwaltung</span>
                            <span class="lp-muted block text-sm md:text-base mt-1">Schulen, Klassen, Teams und Disziplinen zentral gepflegt.</span>
                        </span>
                        <span class="flex items-center gap-4">
                            <span class="lp-chip hidden sm:inline-flex">Admin</span>
                            <span class="lp-lane-arrow">→</span>
                        </span>
                    </a>
                    <a href="#community" class="lp-lane group">
                        <span class="lp-lane-index">06</span>
                        <span>
                            <span class="lp-display block text-2xl md:text-3xl">Community</span>
                            <span class="lp-muted block text-sm md:text-base mt-1">Feuere dein Team an – automatisch moderiertes Diskussionsboard.</span>
                        </span>
                        <span class="flex items-center gap-4">
                            <span class="lp-chip hidden sm:inline-flex">Moderiert</span>
                            <span class="lp-lane-arrow">→</span>
                        </span>
                    </a>
                </div>
            </div>
        </section>

        {{-- ===================== ABLAUF / STAFFEL ====================== --}}
        <section class="lp-sec-paper2 border-t-2 lp-bord py-16 md:py-24">
            <div class="container mx-auto px-4">
                <div class="text-center max-w-2xl mx-auto mb-16">
                    <div class="flex justify-center">
                        <span class="lp-kicker">Ablauf</span>
                    </div>
                    <h2 class="lp-display lp-h2 mt-4">Wie eine Staffel –<br>nur ohne Stolpern</h2>
                </div>

                <div class="relative grid md:grid-cols-3 gap-10 md:gap-6 max-w-5xl mx-auto">
                    <div class="hidden md:block absolute top-1/2 left-[10%] right-[10%] border-t-2 border-dashed lp-bord opacity-30"
                         aria-hidden="true"></div>

                    <div class="lp-card lp-shadow relative z-10 p-7 pt-9">
                        <span class="absolute -top-4 left-6 inline-flex items-center rounded-full border-2 lp-bord px-3.5 py-1 text-[0.65rem] font-extrabold uppercase tracking-[0.18em] text-white"
                              style="background: var(--lp-accent);">Start</span>
                        <p class="lp-display lp-outline text-5xl">01</p>
                        <h3 class="lp-display text-xl mt-4">Ergebnisse eintragen</h3>
                        <p class="lp-muted mt-2 text-sm leading-relaxed">
                            Lehrkräfte und Klassen-Accounts erfassen zwei Versuche pro Team – direkt an der Station.
                        </p>
                    </div>

                    <div class="lp-card lp-shadow relative z-10 p-7 pt-9">
                        <span class="absolute -top-4 left-6 inline-flex items-center rounded-full border-2 lp-bord px-3.5 py-1 text-[0.65rem] font-extrabold uppercase tracking-[0.18em]"
                              style="background: var(--lp-gold);">Wechsel</span>
                        <p class="lp-display lp-outline text-5xl">02</p>
                        <h3 class="lp-display text-xl mt-4">Punkte berechnen</h3>
                        <p class="lp-muted mt-2 text-sm leading-relaxed">
                            Der Bestwert zählt: Das Punktesystem vergibt Plätze und Punkte vollautomatisch.
                        </p>
                    </div>

                    <div class="lp-card lp-shadow relative z-10 p-7 pt-9">
                        <span class="absolute -top-4 left-6 inline-flex items-center rounded-full border-2 lp-bord px-3.5 py-1 text-[0.65rem] font-extrabold uppercase tracking-[0.18em] text-white"
                              style="background: var(--lp-pine);">Ziel</span>
                        <p class="lp-display lp-outline text-5xl">03</p>
                        <h3 class="lp-display text-xl mt-4">Rangliste feiern</h3>
                        <p class="lp-muted mt-2 text-sm leading-relaxed">
                            Schulwertung, Klassenwertung, Teamwertung – live auf jedem Gerät.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ======================== COMMUNITY ========================== --}}
        <section id="community" class="lp-sec-paper border-t-2 lp-bord py-16 md:py-24">
            <div class="container mx-auto px-4">
                <div class="text-center max-w-2xl mx-auto mb-12">
                    <div class="flex justify-center">
                        <span class="lp-kicker">Tribüne</span>
                    </div>
                    <h2 class="lp-display lp-h2 mt-4">Stimmen vom Spielfeldrand</h2>
                    <p class="lp-muted mt-4">
                        Kommentiere den Wettkampf – öffentlich sichtbar und automatisch moderiert.
                    </p>
                </div>
                <div class="max-w-4xl mx-auto lp-card lp-shadow p-4 md:p-8">
                    <livewire:comments/>
                </div>
            </div>
        </section>

        <div class="lp-checker h-4 border-t-2 lp-bord" aria-hidden="true"></div>
    </div>

    <div class="dark-mode-only relative z-0 min-h-screen overflow-x-hidden">
        <div class="relative z-10">
            <section class="relative overflow-hidden pt-8 md:py-24">

                <div class="container mx-auto px-4 relative z-10">
                    <div class="grid lg:grid-cols-[1.1fr,0.9fr] gap-12 items-center">
                        <div class="space-y-8">
                            <div
                                class="hero-kicker reveal inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-slate-900/70 border border-white/25 text-slate-400 uppercase tracking-[0.25em] text-[0.7rem]">
                                <span class="pulse-dot w-2 h-2 rounded-full"></span>
                                Live competition hub
                            </div>
                            <div class="space-y-4">
                                <h1 class="display-font text-5xl md:text-7xl font-semibold leading-tight reveal delay-1">
                                    Campus Olympiade
                                    <span
                                        class="block text-transparent bg-clip-text bg-gradient-to-r from-teal-300 via-sky-300 to-amber-200">Live. Fair. Schnell.</span>
                                </h1>
                                <p class="text-lg md:text-xl text-slate-300 max-w-xl reveal delay-2">
                                    Die Web-Anwendung, die alles kann – vom Anlegen der Schulen, Klassen und
                                    Teams bis hin zu Live-Ranglisten, Laufzetteln und Urkunden-Druck.
                                </p>
                            </div>
                            <div class="flex flex-wrap gap-4 reveal delay-3">
                                <a href="{{ url('/ranking') }}"
                                   class="cta-primary relative isolate overflow-hidden inline-flex items-center gap-3 px-8 py-3.5 rounded-full text-[#0a0f14] font-bold shadow-[0_12px_30px_rgba(45,212,191,0.35)] transition-all duration-300 hover:-translate-y-0.5 hover:scale-[1.01] hover:shadow-[0_18px_40px_rgba(45,212,191,0.45)]">
                                    <span class="relative z-10">Ranking live</span>
                                    <svg class="relative z-10 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="8" r="7"></circle>
                                        <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                                    </svg>
                                </a>
                                <a href="{{ url('/login') }}"
                                   class="inline-flex items-center gap-3 px-8 py-3.5 rounded-full border border-blue-400/45 bg-slate-900/65 text-slate-100 transition-all duration-300 hover:-translate-y-0.5 hover:border-blue-400/80 hover:shadow-[0_12px_28px_rgba(12,18,30,0.6)]">
                                    <span>Login für Berechtigte</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                        <polyline points="10 17 15 12 10 7"></polyline>
                                        <line x1="15" y1="12" x2="3" y2="12"></line>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <div class="relative reveal delay-2">
                            <div
                                class="scoreboard-panel rounded-[32px] border border-white/20 p-8 shadow-[0_30px_80px_rgba(4,6,12,0.7)] backdrop-blur-xl">
                                <div
                                    class="flex items-center justify-between text-xs uppercase tracking-[0.3em] text-slate-400">
                                    <span>Live Teilnehmer</span>
                                    <span
                                        class="tag-chip tag-muted bg-slate-900/40 uppercase tracking-[0.08em] text-[0.7rem] px-3.5 py-1.5 rounded-full border border-white/20">Now</span>
                                </div>
                                <div class="mt-6 grid grid-cols-2 gap-4">
                                    <div
                                        class="score-cell bg-[rgba(12,18,30,0.9)] border border-white/[0.18] rounded-[18px] p-4 relative overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:border-teal-400/35">
                                        <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Schulen</p>
                                        <p class="display-font text-3xl md:text-4xl text-teal-200">{{ $schoolCount }}</p>
                                    </div>
                                    <div
                                        class="score-cell bg-[rgba(12,18,30,0.9)] border border-white/[0.18] rounded-[18px] p-4 relative overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:border-teal-400/35">
                                        <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Klassen</p>
                                        <p class="display-font text-3xl md:text-4xl text-sky-200">{{ $klasseCount }}</p>
                                    </div>
                                    <div
                                        class="score-cell bg-[rgba(12,18,30,0.9)] border border-white/[0.18] rounded-[18px] p-4 relative overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:border-teal-400/35">
                                        <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Teams</p>
                                        <p class="display-font text-3xl md:text-4xl text-emerald-200">{{ $teamCount }}</p>
                                    </div>
                                    <div
                                        class="score-cell bg-[rgba(12,18,30,0.9)] border border-white/[0.18] rounded-[18px] p-4 relative overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:border-teal-400/35">
                                        <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Schüler</p>
                                        <p class="display-font text-3xl md:text-4xl text-amber-200">{{ $studentCount }}</p>
                                    </div>
                                </div>
                                <div class="mt-6 flex items-center justify-between border-t border-white/10 pt-4">
                                    <div class="flex items-center gap-3 text-sm text-slate-400">
                                        <span class="pulse-dot w-2 h-2 rounded-full"></span>
                                        Gesamtbesuche
                                    </div>
                                    <div
                                        class="display-font text-2xl text-amber-200">{{ number_format($visitcount->total_visits ?? 0) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-20 relative">
                <div class="container mx-auto px-4">
                    <div class="flex flex-col lg:flex-row items-start justify-between gap-8">
                        <div class="space-y-4 max-w-2xl">
                            <p class="section-kicker uppercase tracking-[0.3em] text-[0.7rem]">System Module</p>
                            <h2 class="display-font text-3xl md:text-4xl">Alles, was der Wettbewerb braucht</h2>
                            <p class="text-slate-300">Von der Punktaufnahme bis zum Archiv bleibt jedes Team sichtbar.
                                Klar, schnell, professionell.</p>
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ url('/ranking') }}"
                               class="inline-flex items-center gap-3 px-8 py-3.5 rounded-full border border-blue-400/45 bg-slate-900/65 text-slate-100 transition-all duration-300 hover:-translate-y-0.5 hover:border-blue-400/80 hover:shadow-[0_12px_28px_rgba(12,18,30,0.6)]">Zum
                                Ranking</a>
                        </div>
                    </div>

                    <div class="mt-10 module-carousel-shell">
                        <div class="module-carousel grid md:grid-cols-2 lg:grid-cols-3 gap-6" data-module-carousel>
                            <div
                                class="module-card reveal border border-white/20 rounded-3xl p-7 shadow-[0_20px_50px_rgba(4,6,12,0.5)] transition-all duration-[400ms] hover:-translate-y-2 hover:border-teal-400/45 hover:shadow-[0_28px_60px_rgba(4,6,12,0.6)]"
                                data-module-card>
                                <div
                                    class="module-icon mb-5 w-12 h-12 rounded-2xl grid place-items-center bg-slate-900/75 border border-white/25">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="8" r="7"></circle>
                                        <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                                    </svg>
                                </div>
                                <h3 class="display-font text-xl text-slate-100 mb-2">Ranking & Live Auswertung</h3>
                                <p class="text-slate-400">Live Ranglisten für Schulen, Klassen und Teams mit sofortigen
                                    Updates.</p>
                            </div>

                            <div
                                class="module-card reveal delay-1 border border-white/20 rounded-3xl p-7 shadow-[0_20px_50px_rgba(4,6,12,0.5)] transition-all duration-[400ms] hover:-translate-y-2 hover:border-teal-400/45 hover:shadow-[0_28px_60px_rgba(4,6,12,0.6)]"
                                data-module-card>
                                <div
                                    class="module-icon mb-5 w-12 h-12 rounded-2xl grid place-items-center bg-slate-900/75 border border-white/25">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path
                                            d="M12 6V4m0 2a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4m-6 8a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4m12-4a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4M6 6v10M18 6v10"></path>
                                    </svg>
                                </div>
                                <h3 class="display-font text-xl text-slate-100 mb-2">Verwaltung & Stammdaten</h3>
                                <p class="text-slate-400">Disziplinen, Schulen und Teams zentral steuern, inklusive
                                    Score-Regeln.</p>
                            </div>

                            <div
                                class="module-card reveal delay-2 border border-white/20 rounded-3xl p-7 shadow-[0_20px_50px_rgba(4,6,12,0.5)] transition-all duration-[400ms] hover:-translate-y-2 hover:border-teal-400/45 hover:shadow-[0_28px_60px_rgba(4,6,12,0.6)]"
                                data-module-card>
                                <div
                                    class="module-icon mb-5 w-12 h-12 rounded-2xl grid place-items-center bg-slate-900/75 border border-white/25">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="M3 3v18h18"></path>
                                        <path d="M7 14l4-4 3 3 5-6"></path>
                                    </svg>
                                </div>
                                <h3 class="display-font text-xl text-slate-100 mb-2">Punkte erfassen</h3>
                                <p class="text-slate-400">Schnelle Eingabe mit Bestleistung-Logik und sofortiger
                                    Platzierung.</p>
                            </div>

                            <div
                                class="module-card reveal border border-white/20 rounded-3xl p-7 shadow-[0_20px_50px_rgba(4,6,12,0.5)] transition-all duration-[400ms] hover:-translate-y-2 hover:border-teal-400/45 hover:shadow-[0_28px_60px_rgba(4,6,12,0.6)]"
                                data-module-card>
                                <div
                                    class="module-icon mb-5 w-12 h-12 rounded-2xl grid place-items-center bg-slate-900/75 border border-white/25">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path
                                            d="M3 9.75L12 4l9 5.75V20a1 1 0 0 1-1 1h-5.25a.75.75 0 0 1-.75-.75V13.5h-4.5v6.75a.75.75 0 0 1-.75.75H4a1 1 0 0 1-1-1Z"></path>
                                    </svg>
                                </div>
                                <h3 class="display-font text-xl text-slate-100 mb-2">Startseite & Übersicht</h3>
                                <p class="text-slate-400">Aktuelle Teilnehmerzahlen, Gesamtüberblick und Direktzugang zu allen Wettbewerbsbereichen.</p>
                            </div>

                            <div
                                class="module-card reveal delay-1 border border-white/20 rounded-3xl p-7 shadow-[0_20px_50px_rgba(4,6,12,0.5)] transition-all duration-[400ms] hover:-translate-y-2 hover:border-teal-400/45 hover:shadow-[0_28px_60px_rgba(4,6,12,0.6)]"
                                data-module-card>
                                <div
                                    class="module-icon mb-5 w-12 h-12 rounded-2xl grid place-items-center bg-slate-900/75 border border-white/25">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="M9 4h6a2 2 0 0 1 2 2v14l-5-3-5 3V6a2 2 0 0 1 2-2Z"></path>
                                    </svg>
                                </div>
                                <h3 class="display-font text-xl text-slate-100 mb-2">Laufzettel</h3>
                                <p class="text-slate-400">Team-Ergebniszettel mit Gesamtplatzierung, Disziplinplatz und Bestleistung pro Disziplin.</p>
                            </div>

                            <div
                                class="module-card reveal delay-2 border border-white/20 rounded-3xl p-7 shadow-[0_20px_50px_rgba(4,6,12,0.5)] transition-all duration-[400ms] hover:-translate-y-2 hover:border-teal-400/45 hover:shadow-[0_28px_60px_rgba(4,6,12,0.6)]"
                                data-module-card>
                                <div
                                    class="module-icon mb-5 w-12 h-12 rounded-2xl grid place-items-center bg-slate-900/75 border border-white/25">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path
                                            d="M3 7h18M7 7V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2m-8 8h6M5 7v13a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7"></path>
                                    </svg>
                                </div>
                                <h3 class="display-font text-xl text-slate-100 mb-2">Archiv & Historie</h3>
                                <p class="text-slate-400">Vergangene Wettbewerbe, detaillierte Rankings und
                                    Vergleichswerte.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-20 relative">
                <div class="container mx-auto px-4">
                    <div class="text-center max-w-3xl mx-auto space-y-4 mb-12">
                        <p class="section-kicker uppercase tracking-[0.3em] text-[0.7rem]">Flow</p>
                        <h2 class="display-font text-3xl md:text-4xl">Von der Disziplin zur Rangliste in Sekunden</h2>
                        <p class="text-slate-300">Eingabe, Berechnung und Sichtbarkeit greifen ineinander, damit jede
                            Leistung sofort zählt.</p>
                    </div>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div
                            class="flow-card reveal border border-white/20 rounded-3xl p-8 shadow-[0_24px_60px_rgba(5,8,15,0.55)]">
                            <p class="text-sm uppercase tracking-[0.3em] text-slate-400">01</p>
                            <h3 class="display-font text-xl mt-4 mb-3">Ergebnisse erfassen</h3>
                            <p class="text-slate-400">Disziplinen und Teams per Schnellmaske aktualisieren, ohne
                                Umwege.</p>
                        </div>
                        <div
                            class="flow-card reveal delay-1 border border-white/20 rounded-3xl p-8 shadow-[0_24px_60px_rgba(5,8,15,0.55)]">
                            <p class="text-sm uppercase tracking-[0.3em] text-slate-400">02</p>
                            <h3 class="display-font text-xl mt-4 mb-3">Scores berechnen</h3>
                            <p class="text-slate-400">Bestleistungen werden sofort bewertet und auf die Rangliste
                                gelegt.</p>
                        </div>
                        <div
                            class="flow-card reveal delay-2 border border-white/20 rounded-3xl p-8 shadow-[0_24px_60px_rgba(5,8,15,0.55)]">
                            <p class="text-sm uppercase tracking-[0.3em] text-slate-400">03</p>
                            <h3 class="display-font text-xl mt-4 mb-3">Ranking live teilen</h3>
                            <p class="text-slate-400">Schulen, Klassen und Teams sehen die Ergebnisse in Echtzeit.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-20 relative">
                <div class="container mx-auto px-4">
                    <div class="text-center max-w-3xl mx-auto space-y-4 mb-12">
                        <p class="section-kicker uppercase tracking-[0.3em] text-[0.7rem]">Kommentare</p>
                        <h2 class="display-font text-3xl md:text-4xl">Diskussionsboard</h2>
                        <p class="text-slate-300">Kommentiere den Wettbewerb – öffentlich sichtbar und automatisch moderiert.</p>
                    </div>
                    <div
                        class="community-shell border border-white/25 rounded-[32px] p-6 shadow-[0_30px_70px_rgba(5,8,15,0.7)]">
                        <livewire:comments/>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Light mode: Live-Uhr + 60s-Polling für Anzeigetafel, Podium und Ticker
            const lpTicker = document.querySelector('[data-lp-ticker]');
            if (lpTicker) {
                const clockEl = document.querySelector('[data-lp-clock]');

                function lpUpdateClock() {
                    if (clockEl) {
                        clockEl.textContent = new Date().toLocaleTimeString('de-DE', {
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                    }
                }

                lpUpdateClock();
                setInterval(lpUpdateClock, 15000);

                const lpLiveUrl = '{{ route('home.live') }}';

                async function lpRefresh() {
                    // Nicht pollen, wenn Tab im Hintergrund oder Dark Mode aktiv ist
                    if (document.hidden || document.documentElement.classList.contains('dark')) return;
                    try {
                        const res = await fetch(lpLiveUrl, {headers: {'Accept': 'application/json'}});
                        if (!res.ok) return;
                        const data = await res.json();

                        document.querySelectorAll('[data-lp-stat]').forEach((el) => {
                            const value = data.stats ? data.stats[el.dataset.lpStat] : undefined;
                            if (value !== undefined && el.textContent !== value) {
                                el.textContent = value;
                            }
                        });

                        (data.podium || []).forEach((entry, i) => {
                            const nameEl = document.querySelector('[data-lp-podium-name="' + i + '"]');
                            const metaEl = document.querySelector('[data-lp-podium-meta="' + i + '"]');
                            const dotEl = document.querySelector('[data-lp-podium-dot="' + i + '"]');
                            if (nameEl) nameEl.textContent = entry.name;
                            if (metaEl) metaEl.textContent = entry.meta;
                            if (dotEl && entry.dot) {
                                dotEl.className = 'inline-block w-2 h-2 rounded-full border border-black/30 align-middle mr-1 ' + entry.dot;
                            }
                        });

                        if (Array.isArray(data.ticker) && data.ticker.length) {
                            lpTicker.querySelectorAll(':scope > div').forEach((half) => {
                                half.innerHTML = '';
                                data.ticker.forEach((item) => {
                                    const span = document.createElement('span');
                                    span.className = 'lp-tick';
                                    span.textContent = item;
                                    half.appendChild(span);
                                });
                            });
                        }
                    } catch (e) {
                        // Offline o.ä. – beim nächsten Intervall erneut versuchen
                    }
                }

                setInterval(lpRefresh, 60000);
            }

            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            // Dark mode module carousel (mobile)
            const moduleCarousel = document.querySelector('[data-module-carousel]');
            if (moduleCarousel) {
                const cards = Array.from(moduleCarousel.querySelectorAll('[data-module-card]'));
                const shell = moduleCarousel.closest('.module-carousel-shell');
                const mobileQuery = window.matchMedia('(max-width: 767px)');
                let currentIndex = 0;
                let carouselTimer = null;

                function applyModuleClasses() {
                    const total = cards.length;
                    if (!total) return;
                    const prevIndex = (currentIndex - 1 + total) % total;
                    const nextIndex = (currentIndex + 1) % total;
                    cards.forEach((card, index) => {
                        card.classList.remove('is-active', 'is-prev', 'is-next', 'is-off');
                        if (index === currentIndex) {
                            card.classList.add('is-active');
                        } else if (index === prevIndex) {
                            card.classList.add('is-prev');
                        } else if (index === nextIndex) {
                            card.classList.add('is-next');
                        } else {
                            card.classList.add('is-off');
                        }
                    });
                }

                function updateTransform() {
                    const total = cards.length;
                    if (!total) return;
                    const card = cards[currentIndex];
                    const container = shell || moduleCarousel;
                    const containerWidth = container.clientWidth;
                    const shellStyles = shell ? window.getComputedStyle(shell) : null;
                    const paddingLeft = shellStyles ? parseFloat(shellStyles.paddingLeft || '0') : 0;
                    const paddingRight = shellStyles ? parseFloat(shellStyles.paddingRight || '0') : 0;
                    const contentWidth = containerWidth - paddingLeft - paddingRight;
                    const targetCenter = (contentWidth > 0 ? contentWidth : containerWidth) / 2;
                    const cardCenter = card.offsetLeft + (card.offsetWidth / 2);
                    const offset = targetCenter - cardCenter;
                    moduleCarousel.style.transform = `translateX(${offset}px)`;
                    applyModuleClasses();
                }

                function startModuleCarousel() {
                    if (!cards.length) return;
                    updateTransform();
                    if (!reduceMotion && !carouselTimer) {
                        carouselTimer = setInterval(() => {
                            currentIndex = (currentIndex + 1) % cards.length;
                            updateTransform();
                        }, 3200);
                    }
                }

                function stopModuleCarousel() {
                    if (carouselTimer) {
                        clearInterval(carouselTimer);
                        carouselTimer = null;
                    }
                    moduleCarousel.style.removeProperty('transform');
                    cards.forEach((card) => card.classList.remove('is-active', 'is-prev', 'is-next', 'is-off'));
                }

                function updateModuleCarousel() {
                    const isDark = document.documentElement.classList.contains('dark');
                    const shouldRun = isDark && mobileQuery.matches;
                    if (shouldRun) {
                        startModuleCarousel();
                    } else {
                        stopModuleCarousel();
                    }
                }

                updateModuleCarousel();
                window.addEventListener('resize', updateModuleCarousel);
                if (mobileQuery.addEventListener) {
                    mobileQuery.addEventListener('change', updateModuleCarousel);
                }

                const modeObserver = new MutationObserver(updateModuleCarousel);
                modeObserver.observe(document.documentElement, {attributes: true, attributeFilter: ['class']});
            }
        });
    </script>
</x-layout>

