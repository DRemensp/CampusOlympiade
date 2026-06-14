{{-- „Sportfest-Poster“ Design-System (Light Mode) – geteilt von Startseite, Archiv, ... --}}
<style>
    @import url('https://fonts.googleapis.com/css2?family=Anton&family=Archivo:ital,wght@0,400;0,500;0,600;0,700;0,800;1,700&display=swap');

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

    /* =================================================================
       LIGHT MODE — „Sportfest-Poster“ Redesign
       Papier, Tinte, Signalrot, Medaillen-Gold. Harte Offset-Schatten,
       Startnummern, Ticker und Ziellinien-Muster.
       ================================================================= */
    .light-mode-only {
        --lp-paper: #FAF5EB;
        --lp-paper-2: #F1E9D6;
        --lp-ink: #161D27;
        --lp-muted: #5A6271;
        --lp-accent: #E8472B;
        --lp-gold: #F0B428;
        --lp-pine: #19705A;
        font-family: 'Archivo', 'Segoe UI', sans-serif;
        color: var(--lp-ink);
        background: var(--lp-paper);
    }

    .lp-display {
        font-family: 'Anton', 'Archivo', sans-serif;
        text-transform: uppercase;
        letter-spacing: 0.015em;
        font-weight: 400;
    }

    .lp-h1 {
        font-size: clamp(3.4rem, 9vw, 6.6rem);
        line-height: 0.92;
    }

    .lp-h2 {
        font-size: clamp(2.1rem, 4.5vw, 3.3rem);
        line-height: 1.02;
    }

    .lp-outline {
        color: transparent;
        -webkit-text-stroke: 2.5px var(--lp-ink);
    }

    @media (max-width: 640px) {
        .lp-outline {
            -webkit-text-stroke-width: 1.6px;
        }
    }

    @supports not ((-webkit-text-stroke: 2px black)) {
        .lp-outline,
        .lp-lane-index {
            color: var(--lp-ink);
        }
    }

    .lp-muted {
        color: var(--lp-muted);
    }

    .lp-sec-paper {
        background: var(--lp-paper);
    }

    .lp-sec-paper2 {
        background: var(--lp-paper-2);
    }

    .lp-bord {
        border-color: var(--lp-ink);
    }

    .lp-kicker {
        display: inline-flex;
        align-items: center;
        gap: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.28em;
        font-size: 0.7rem;
        font-weight: 800;
    }

    .lp-kicker::before {
        content: '';
        width: 2.2rem;
        height: 3px;
        background: var(--lp-accent);
        flex-shrink: 0;
    }

    .lp-card {
        background: #fff;
        border: 2px solid var(--lp-ink);
        border-radius: 14px;
    }

    .lp-shadow {
        box-shadow: 7px 7px 0 0 var(--lp-ink);
    }

    .lp-shadow-gold {
        box-shadow: 7px 7px 0 0 var(--lp-gold);
    }

    .lp-btn-primary,
    .lp-btn-ghost {
        display: inline-flex;
        align-items: center;
        gap: 0.7rem;
        padding: 0.95rem 1.9rem;
        border: 2px solid var(--lp-ink);
        border-radius: 9999px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-size: 0.85rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    }

    .lp-btn-primary {
        background: var(--lp-ink);
        color: var(--lp-paper);
        box-shadow: 5px 5px 0 0 var(--lp-accent);
    }

    .lp-btn-primary:hover {
        transform: translate(-2px, -2px);
        box-shadow: 8px 8px 0 0 var(--lp-accent);
    }

    .lp-btn-primary:active {
        transform: translate(2px, 2px);
        box-shadow: 2px 2px 0 0 var(--lp-accent);
    }

    .lp-btn-ghost {
        background: transparent;
        color: var(--lp-ink);
        box-shadow: 5px 5px 0 0 rgba(22, 29, 39, 0.18);
    }

    .lp-btn-ghost:hover {
        background: #fff;
        transform: translate(-2px, -2px);
        box-shadow: 8px 8px 0 0 rgba(22, 29, 39, 0.22);
    }

    .lp-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.4rem 0.85rem;
        border: 2px solid var(--lp-ink);
        border-radius: 9999px;
        background: #fff;
        font-size: 0.68rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.14em;
        white-space: nowrap;
    }

    .lp-chip-accent {
        background: var(--lp-accent);
        color: #fff;
    }

    .lp-stamp {
        display: inline-block;
        transform: rotate(-2deg);
        background: #fff;
        border: 2px solid var(--lp-ink);
        border-radius: 8px;
        padding: 0.4rem 1rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.18em;
        font-size: 0.72rem;
        box-shadow: 4px 4px 0 0 var(--lp-gold);
    }

    .lp-lanes {
        background-image: repeating-linear-gradient(90deg, transparent 0 170px, rgba(22, 29, 39, 0.06) 170px 172px);
    }

    .lp-checker {
        background: conic-gradient(var(--lp-ink) 90deg, var(--lp-paper) 90deg 180deg, var(--lp-ink) 180deg 270deg, var(--lp-paper) 270deg);
        background-size: 16px 16px;
    }

    .lp-live-dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 9999px;
        background: var(--lp-accent);
        animation: lpBlink 1.6s ease-in-out infinite;
        flex-shrink: 0;
    }

    @keyframes lpBlink {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.25;
        }
    }

    .lp-ticker-track,
    .lp-marquee-track {
        display: flex;
        align-items: center;
        width: max-content;
        animation: lpTicker 30s linear infinite;
    }

    .lp-marquee-track {
        animation-duration: 24s;
    }

    .lp-tickerbar:hover .lp-ticker-track,
    .lp-marquee:hover .lp-marquee-track {
        animation-play-state: paused;
    }

    @keyframes lpTicker {
        to {
            transform: translateX(-50%);
        }
    }

    .lp-tick {
        display: inline-flex;
        align-items: center;
        padding: 0.6rem 0;
        font-size: 0.74rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        font-weight: 600;
        white-space: nowrap;
        color: rgba(250, 245, 235, 0.85);
    }

    .lp-tick::after {
        content: '///';
        margin: 0 1.3rem;
        color: var(--lp-accent);
        font-weight: 800;
        letter-spacing: 0.05em;
    }

    .lp-marquee {
        background: var(--lp-gold);
        border-top: 2px solid var(--lp-ink);
        border-bottom: 2px solid var(--lp-ink);
        overflow: hidden;
    }

    .lp-marquee-item {
        font-family: 'Anton', sans-serif;
        text-transform: uppercase;
        font-size: 1.35rem;
        padding: 0.55rem 0;
        white-space: nowrap;
        letter-spacing: 0.05em;
    }

    .lp-board {
        background: var(--lp-ink);
        color: var(--lp-paper);
        position: relative;
    }

    .lp-board::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(250, 245, 235, 0.07) 1px, transparent 1px);
        background-size: 14px 14px;
        pointer-events: none;
    }

    .lp-board-num {
        font-family: 'Anton', sans-serif;
        font-variant-numeric: tabular-nums;
        font-size: clamp(2.4rem, 5vw, 3.6rem);
        line-height: 1;
        color: var(--lp-gold);
    }

    .lp-bib {
        transform: rotate(-2.5deg);
        animation: lpSway 7s ease-in-out infinite;
    }

    @keyframes lpSway {
        0%, 100% {
            transform: rotate(-2.5deg);
        }
        50% {
            transform: rotate(-1deg);
        }
    }

    .lp-bib-num {
        font-size: clamp(5rem, 12vw, 6.5rem);
        line-height: 1;
    }

    .lp-pin {
        display: block;
        width: 13px;
        height: 13px;
        border-radius: 9999px;
        border: 2px solid var(--lp-ink);
        background: var(--lp-paper);
        box-shadow: inset 0 0 0 2px #fff;
    }

    .lp-barcode {
        height: 36px;
        background-image: repeating-linear-gradient(90deg, var(--lp-ink) 0 2px, transparent 2px 5px, var(--lp-ink) 5px 7px, transparent 7px 12px, var(--lp-ink) 12px 13px, transparent 13px 16px);
        opacity: 0.85;
    }

    .lp-lane {
        display: grid;
        grid-template-columns: 3.2rem 1fr auto;
        gap: 1.1rem;
        align-items: center;
        padding: 1.3rem 0.35rem;
        border-top: 2px solid var(--lp-ink);
        transition: background 0.25s ease, padding-left 0.25s ease;
    }

    @media (min-width: 768px) {
        .lp-lane {
            grid-template-columns: 5rem 1fr auto;
            gap: 1.5rem;
        }
    }

    .lp-lane:hover {
        background: var(--lp-paper);
        padding-left: 1rem;
    }

    .lp-lane-index {
        font-family: 'Anton', sans-serif;
        font-size: 2rem;
        color: transparent;
        -webkit-text-stroke: 1.5px var(--lp-ink);
        opacity: 0.45;
        transition: opacity 0.25s ease;
    }

    @media (min-width: 768px) {
        .lp-lane-index {
            font-size: 2.8rem;
        }
    }

    .lp-lane:hover .lp-lane-index {
        opacity: 1;
        -webkit-text-stroke-color: var(--lp-accent);
    }

    .lp-lane-arrow {
        font-size: 1.4rem;
        font-weight: 800;
        transition: transform 0.25s ease, color 0.25s ease;
    }

    .lp-lane:hover .lp-lane-arrow {
        transform: translateX(6px);
        color: var(--lp-accent);
    }

    .lp-podium {
        background: #fff;
        border: 2px solid var(--lp-ink);
        border-bottom: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .lp-top-gold {
        border-top: 12px solid var(--lp-gold);
    }

    .lp-top-silver {
        border-top: 12px solid #C3C8CF;
    }

    .lp-top-bronze {
        border-top: 12px solid #C97E4A;
    }

    .lp-demo-tag {
        display: inline-block;
        vertical-align: middle;
        margin-left: 0.4rem;
        padding: 0.15rem 0.5rem;
        border: 1.5px dashed var(--lp-ink);
        border-radius: 6px;
        font-size: 0.6rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.14em;
        opacity: 0.55;
        white-space: nowrap;
    }

    .lp-watermark {
        font-size: clamp(6rem, 14vw, 11rem);
        line-height: 1;
        opacity: 0.07;
        user-select: none;
    }

    .lp-reveal {
        opacity: 0;
        transform: translateY(24px);
        animation: lpRise 0.85s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .lp-d1 {
        animation-delay: 0.1s;
    }

    .lp-d2 {
        animation-delay: 0.22s;
    }

    .lp-d3 {
        animation-delay: 0.34s;
    }

    .lp-d4 {
        animation-delay: 0.48s;
    }

    .lp-d5 {
        animation-delay: 0.62s;
    }

    @keyframes lpRise {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ---------- Listen, Rang-Badges & Tabs (Archiv, Rankings, ...) ---------- */
    .lp-row {
        display: grid;
        grid-template-columns: auto 1fr auto;
        gap: 1rem;
        align-items: center;
        padding: 0.9rem 0.5rem;
        border-top: 2px solid var(--lp-ink);
        transition: background 0.2s ease, padding-left 0.2s ease;
    }

    .lp-row:hover {
        background: var(--lp-paper-2);
        padding-left: 1rem;
    }

    .lp-rank-badge {
        width: 2.7rem;
        height: 2.7rem;
        display: grid;
        place-items: center;
        border: 2px solid var(--lp-ink);
        border-radius: 12px;
        font-family: 'Anton', 'Archivo', sans-serif;
        font-size: 1.05rem;
        background: #fff;
        flex-shrink: 0;
    }

    .lp-rank-1 {
        background: var(--lp-gold);
    }

    .lp-rank-2 {
        background: #C3C8CF;
    }

    .lp-rank-3 {
        background: #C97E4A;
        color: #fff;
    }

    .lp-tab {
        cursor: pointer;
        transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
    }

    .lp-tab:hover {
        transform: translateY(-1px);
    }

    .lp-tab-active {
        background: var(--lp-ink);
        color: var(--lp-paper);
    }

    /* ---------- Form-Reskin für geteilte Components (.lp-form-Wrapper) ---------- */
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

    /* ---------- Seiten-Reskin für geteilte Funktionsseiten (.lp-skin) ----------
       Teacher & Klassen-Dashboard behalten EIN Markup (wegen JS/QR-Scanner-IDs);
       diese Regeln greifen ausschließlich im Light Mode (html:not(.dark)). */
    html:not(.dark) .lp-skin {
        --lp-paper: #FAF5EB;
        --lp-paper-2: #F1E9D6;
        --lp-ink: #161D27;
        --lp-muted: #5A6271;
        --lp-accent: #E8472B;
        --lp-gold: #F0B428;
        --lp-pine: #19705A;
        font-family: 'Archivo', 'Segoe UI', sans-serif;
        color: var(--lp-ink);
        background: var(--lp-paper) !important;
        background-image: repeating-linear-gradient(90deg, transparent 0 170px, rgba(22, 29, 39, 0.06) 170px 172px) !important;
        /* zieht das Papier über das pt-10 des Layouts und sorgt für Navbar-Abstand (nur Light Mode) */
        margin-top: -2.5rem;
        padding-top: 5.5rem;
        min-height: 100vh;
    }

    html:not(.dark) .lp-skin .display-font {
        font-family: 'Anton', 'Archivo', sans-serif;
        font-weight: 400 !important;
        text-transform: uppercase;
        letter-spacing: 0.015em;
        color: var(--lp-ink) !important;
        -webkit-text-fill-color: var(--lp-ink);
        background: none !important;
    }

    html:not(.dark) .lp-skin .night-panel {
        background: #fff !important;
        background-image: none !important;
        border: 2px solid var(--lp-ink) !important;
        border-radius: 14px !important;
        box-shadow: 7px 7px 0 0 var(--lp-ink) !important;
    }

    html:not(.dark) .lp-skin .night-card {
        background: #fff !important;
        background-image: none !important;
        border: 2px solid var(--lp-ink) !important;
        border-radius: 12px !important;
        box-shadow: none !important;
    }

    html:not(.dark) .lp-skin input[type="text"],
    html:not(.dark) .lp-skin input[type="number"],
    html:not(.dark) .lp-skin input[type="password"],
    html:not(.dark) .lp-skin select,
    html:not(.dark) .lp-skin textarea {
        border: 2px solid var(--lp-ink) !important;
        border-radius: 12px !important;
        background: #fff !important;
        color: var(--lp-ink) !important;
        box-shadow: none !important;
        font-weight: 600;
    }

    html:not(.dark) .lp-skin input:focus,
    html:not(.dark) .lp-skin select:focus,
    html:not(.dark) .lp-skin textarea:focus {
        outline: none !important;
        border-color: var(--lp-ink) !important;
        box-shadow: 4px 4px 0 0 var(--lp-gold) !important;
    }

    html:not(.dark) .lp-skin label,
    html:not(.dark) .lp-skin label span {
        color: var(--lp-ink) !important;
    }

    html:not(.dark) .lp-skin label .text-red-500 {
        color: var(--lp-accent) !important;
    }

    html:not(.dark) .lp-skin button[type="submit"],
    html:not(.dark) .lp-skin #open-qr-camera-modal {
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

    html:not(.dark) .lp-skin button[type="submit"]:hover,
    html:not(.dark) .lp-skin #open-qr-camera-modal:hover {
        transform: translate(-2px, -2px);
        box-shadow: 6px 6px 0 0 var(--lp-accent);
    }

    html:not(.dark) .lp-skin [role="alert"] {
        background: #fff !important;
        background-image: none !important;
        border: 2px solid var(--lp-ink) !important;
        border-radius: 14px !important;
        color: var(--lp-ink) !important;
        box-shadow: 5px 5px 0 0 var(--lp-ink);
    }

    html:not(.dark) .lp-skin [role="alert"].bg-green-100 {
        box-shadow: 5px 5px 0 0 var(--lp-pine);
    }

    html:not(.dark) .lp-skin [role="alert"].bg-red-100 {
        box-shadow: 5px 5px 0 0 var(--lp-accent);
    }

    html:not(.dark) .lp-skin .text-indigo-700,
    html:not(.dark) .lp-skin .text-green-700,
    html:not(.dark) .lp-skin .text-green-600,
    html:not(.dark) .lp-skin .text-blue-600,
    html:not(.dark) .lp-skin .text-blue-800 {
        color: var(--lp-ink) !important;
    }

    html:not(.dark) .lp-skin .h-1 {
        background: var(--lp-accent) !important;
        background-image: none !important;
    }

    html:not(.dark) .lp-skin #qr-score-modal > div,
    html:not(.dark) .lp-skin #qr-camera-modal > div {
        background: var(--lp-paper) !important;
        border: 2px solid var(--lp-ink) !important;
        border-radius: 14px !important;
        box-shadow: 7px 7px 0 0 var(--lp-ink) !important;
    }

    /* Handy: primäre Buttons volle Breite = große Tap-Fläche im Stadion (nur Light Mode) */
    @media (max-width: 640px) {
        html:not(.dark) .lp-skin button[type="submit"],
        html:not(.dark) .lp-skin #open-qr-camera-modal {
            width: 100%;
            justify-content: center;
        }
    }

    /* ---------- Login (guest-Layout, nur Light Mode auf der Login-Route) ---------- */
    html:not(.dark) .lp-auth {
        --lp-paper: #FAF5EB;
        --lp-paper-2: #F1E9D6;
        --lp-ink: #161D27;
        --lp-muted: #5A6271;
        --lp-accent: #E8472B;
        --lp-gold: #F0B428;
        --lp-pine: #19705A;
        font-family: 'Archivo', 'Segoe UI', sans-serif;
        color: var(--lp-ink);
        background: var(--lp-paper) !important;
        background-image: repeating-linear-gradient(90deg, transparent 0 170px, rgba(22, 29, 39, 0.06) 170px 172px) !important;
    }

    html:not(.dark) .lp-auth-card {
        background: #fff !important;
        border: 2px solid var(--lp-ink) !important;
        border-radius: 16px !important;
        box-shadow: 8px 8px 0 0 var(--lp-ink) !important;
    }

    html:not(.dark) .lp-auth label {
        color: var(--lp-ink) !important;
        font-weight: 700;
    }

    html:not(.dark) .lp-auth input[type="text"],
    html:not(.dark) .lp-auth input[type="password"],
    html:not(.dark) .lp-auth input[type="email"] {
        border: 2px solid var(--lp-ink) !important;
        border-radius: 12px !important;
        background: #fff !important;
        color: var(--lp-ink) !important;
        box-shadow: none !important;
        font-weight: 600;
        padding: 0.6rem 0.85rem !important;
    }

    html:not(.dark) .lp-auth input:focus {
        outline: none !important;
        border-color: var(--lp-ink) !important;
        box-shadow: 4px 4px 0 0 var(--lp-gold) !important;
    }

    html:not(.dark) .lp-auth button[type="submit"] {
        background: var(--lp-ink) !important;
        background-image: none !important;
        color: var(--lp-paper) !important;
        border: 2px solid var(--lp-ink) !important;
        border-radius: 9999px !important;
        padding: 0.7rem 1.6rem !important;
        font-weight: 800 !important;
        letter-spacing: 0.08em;
        box-shadow: 4px 4px 0 0 var(--lp-accent);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    html:not(.dark) .lp-auth button[type="submit"]:hover {
        transform: translate(-2px, -2px);
        box-shadow: 6px 6px 0 0 var(--lp-accent);
    }

    html:not(.dark) .lp-auth a {
        color: var(--lp-muted) !important;
    }

    @media (prefers-reduced-motion: reduce) {
        .lp-ticker-track,
        .lp-marquee-track,
        .lp-bib,
        .lp-live-dot {
            animation: none !important;
        }

        .lp-reveal {
            animation: none;
            opacity: 1;
            transform: none;
        }
    }
</style>
