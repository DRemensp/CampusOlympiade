# <span style="color:#2563eb">Campus</span><span style="color:#14b8a6">Olympiade</span>

<p align="center">
  <img alt="Laravel 12" src="https://img.shields.io/badge/Laravel-12-ff2d20?style=flat-square">
  <img alt="Livewire 3" src="https://img.shields.io/badge/Livewire-3-8b5cf6?style=flat-square">
  <img alt="Tailwind CSS" src="https://img.shields.io/badge/Tailwind-3-38bdf8?style=flat-square">
  <img alt="Vite" src="https://img.shields.io/badge/Vite-6-facc15?style=flat-square">
  <img alt="PHP 8.2" src="https://img.shields.io/badge/PHP-8.2-777bb4?style=flat-square">
</p>

Laravel-Plattform zur Organisation und Live-Auswertung von Schulwettbewerben. Teams treten in Disziplinen an, Ergebnisse werden zentral erfasst, automatisch verrechnet und in Echtzeit-Rankings dargestellt.

**Im produktiven Einsatz** beim BSZ Reutlingen mit vier Schulen, ca. 13 Klassen und bis zu 150 Schülern pro Event. Entwickelt und betrieben als Solo-Projekt.

🔗 Live: [campusolympiade.de](https://campusolympiade.de)

---

## Tech-Stack

- **Backend:** Laravel 12, PHP 8.2
- **Frontend:** Livewire 3, Tailwind CSS, Vite
- **Datenbank:** MySQL (MariaDB kompatibel)
- **Cache / Queue:** Redis (optional)
- **Auth & Rollen:** Spatie Permission
- **Moderation:** Google Perspective API (optional)
- **Realtime:** Laravel Reverb (Broadcasts)
- **Weiteres:** PDF-Urkunden, QR-Codes, PWA-Unterstützung, geplante Tasks (Scheduler)

---

## Funktionsübersicht

- **Live-Rankings** über Schulen, Klassen, Teams und Disziplinen, mit Podium, Live-Filter, Disziplin-Detailansichten und einem selbst aktualisierenden Live-Bereich (Ticker & Uhr) während des Events.
- **Faire Punkteberechnung:** bestes von zwei Ergebnissen pro Team, Normalisierung über die Top-N-Teams je Schule, damit unterschiedlich große Schulen vergleichbar bleiben.
- **Rollenbasierte Zugriffskontrolle:** Admin, Lehrkraft und Klassen-Account mit jeweils eigenem Funktionsumfang (Spatie Permission).
- **Audit-Logging mit Anomalie-Erkennung:** jede Score-Eingabe wird mit Zeitstempel und verursachender Person protokolliert. Auffälligkeiten werden im Admin-Panel markiert – etwa ungewöhnlich große Abstände an der Tabellenspitze oder nachträgliche Änderungen, mit Eskalation je nach Zeitpunkt der Änderung. Admin- und Lehrkraft-Logins werden mitgeloggt.
- **Team-Laufzettel:** Echtzeit-Übersicht für jedes Team über Gesamtplatzierung, Disziplin-Positionen und beste Leistungen – inkl. QR-Code für den schnellen Zugriff am Event.
- **Urkunden-Generierung:** automatisch erzeugte PDF-Urkunden für Teams, inklusive Schul-Logos.
- **Community-Board mit mehrstufiger Moderation:** Kommentare werden automatisiert über die Google Perspective API geprüft (approved / pending / blocked), ergänzt um IP-basierte Filter und Schutzmechanismen gegen wiederholten Missbrauch. Admin und Lehrkraft moderieren über ein eigenes Panel.
- **Archiv-Snapshots:** vollständige Wettbewerbsstände werden als JSON archiviert und bleiben mit allen Ranglisten einsehbar.
- **Admin-Broadcasts:** Live-Benachrichtigungen an gezielte Empfängergruppen.
- **Datenschutz by Design:** einwilligungsbasierte Freischaltung des Kommentarbereichs, zweckgebundene Datenspeicherung und automatisierte Anonymisierung gespeicherter IP-Adressen nach 30 Tagen. Vollständige rechtliche Seiten (Datenschutz, Cookies, Nutzungsbedingungen, Impressum).
- **PWA:** die Anwendung lässt sich auf dem Smartphone wie eine native App installieren.
- **Weitere Highlights:** „Team des Tages" auf der Startseite, Besucherzähler, öffentliche Changelog-Seite, Light-/Dark-Mode, schulspezifische Farbakzente, responsives Layout.

---

## Lokales Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed --class=DatabaseSeeder
npm install
npm run dev
php artisan serve
```

> Die Seed-Daten enthalten Demo-Accounts ausschließlich für die lokale Entwicklung. In Produktion sind diese deaktiviert.

### Wichtige .env-Keys

Minimal: `APP_ENV`, `APP_KEY`, `APP_URL`, `DB_*`

Optional:
- `REDIS_*`, `CACHE_STORE`, `SESSION_DRIVER`, `QUEUE_CONNECTION` – Caching / Queues
- `PERSPECTIVE_API_KEY` (+ Schwellenwerte) – Kommentar-Moderation
- `REVERB_*` / `VITE_REVERB_*` – Realtime-Broadcasts

Ohne `PERSPECTIVE_API_KEY` greift ein Fallback (Kommentare werden als *pending* markiert oder durchgelassen).

---

## Produktion

Deployment erfolgt auf einem Linux-Server (DigitalOcean) via Laravel Forge.

Nach dem Deploy:
```bash
php artisan migrate --force
npm run build
php artisan optimize
```

### Sicherheitshinweise
- `APP_DEBUG=false` in Produktion.
- Keine Standard-/Demo-Accounts in Produktion.
- Versehentlich versionierte Secrets (`.env`) rotieren.

---

## Datenmodell (Kurzfassung)

```
School 1—* Klasse 1—* Team
Klasse 1—1 Discipline
Team *—* Discipline   (Pivot: score_1, score_2)
```

Punkteberechnung: bestes von zwei Ergebnissen je Disziplin → Sortierung nach Regel (höher/niedriger besser) → Punktevergabe über konfigurierbares Scoresystem → Bonus → Klassen- und Schul-Aggregation mit Top-N-Normalisierung.
