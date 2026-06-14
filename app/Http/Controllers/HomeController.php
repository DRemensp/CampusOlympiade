<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Klasse;
use App\Models\School;
use App\Models\Team;
use App\Models\VisitCounter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // verhindert doppelte Requests durch redirections, entlastet server erheblich
        $acceptHeader = request()->header('accept', '');

        if (str_contains($acceptHeader, 'image/') && !str_contains($acceptHeader, 'text/html')) {
            abort(404);
        }

        $live = $this->liveHomeData();

        $schoolCount = $live['schoolCount'];
        $klasseCount = $live['klasseCount'];
        $teamCount = $live['teamCount'];
        $studentCount = $live['studentCount'];
        $podium = $live['podium'];
        $tickerItems = $live['ticker'];

        $bibTeam = $this->teamOfTheDay();

        $comments = Comment::all();
        $visitcount = VisitCounter::first() ?? new VisitCounter();

        $ip = request()->ip();
        if (!Cache::has('visit_ip_' . md5($ip))) {
            Cache::forever('visit_ip_' . md5($ip), true);
            $visitcount->total_visits++;
            $visitcount->save();
        }

        // Diese Werte an 'welcome' übergeben
        return view('welcome', compact(
            'schoolCount',
            'klasseCount',
            'teamCount',
            'studentCount',
            'podium',
            'tickerItems',
            'bibTeam',
            'comments',
            'visitcount'));
    }

    /**
     * Leichter JSON-Endpoint für das Live-Polling der Startseite
     * (Anzeigetafel, Podium, Ticker). Daten kommen aus dem 60s-Cache.
     */
    public function liveData()
    {
        $live = $this->liveHomeData();

        return response()->json([
            'stats' => [
                'schools' => (string) $live['schoolCount'],
                'klasses' => (string) $live['klasseCount'],
                'teams' => (string) $live['teamCount'],
                'students' => (string) $live['studentCount'],
                'visits' => number_format(VisitCounter::first()->total_visits ?? 0, 0, ',', '.'),
            ],
            'podium' => array_map(fn ($p) => [
                'name' => $p['name'],
                'meta' => $p['klasse'] . ' · ' . number_format($p['score'], 0, ',', '.') . ' Pkt.',
                'dot' => \App\Services\SchoolColorService::getColorClasses($p['school_id'] ?? 0)['dot'],
            ], $live['podium']),
            'ticker' => $live['ticker'],
        ]);
    }

    /**
     * Gemeinsame Datenbasis für Startseite und Live-Endpoint.
     * 60s-Cache; wird zusätzlich bei jeder Score-Neuberechnung invalidiert.
     */
    private function liveHomeData(): array
    {
        return Cache::remember('home_live_data', 60, function () {
            $teams = Team::with('klasse')->get();

            $schoolCount = School::count();
            $klasseCount = Klasse::count();
            $teamCount = $teams->count();

            // Schüler zählen durch Summierung aller Team-Mitglieder
            // Wenn ein Team keine Mitglieder hat, rechnen wir +5
            $studentCount = $teams->sum(function ($team) {
                return is_array($team->members) && count($team->members) > 0
                    ? count($team->members)
                    : 5;
            });

            $podium = $teams->sortByDesc('score')
                ->take(3)
                ->values()
                ->map(fn ($team) => [
                    'name' => $team->name,
                    'klasse' => $team->klasse->name ?? '–',
                    'score' => (float) $team->score,
                    'school_id' => $team->klasse->school_id ?? 0,
                ])
                ->all();

            $ticker = $this->buildTickerItems();

            return compact('schoolCount', 'klasseCount', 'teamCount', 'studentCount', 'podium', 'ticker');
        });
    }

    /**
     * Ticker-Meldungen aus den zuletzt eingetragenen Ergebnissen.
     */
    private function buildTickerItems(): array
    {
        $rows = DB::table('discipline_team')
            ->join('teams', 'teams.id', '=', 'discipline_team.team_id')
            ->join('disciplines', 'disciplines.id', '=', 'discipline_team.discipline_id')
            ->where(function ($query) {
                $query->whereNotNull('discipline_team.score_1')
                    ->orWhereNotNull('discipline_team.score_2');
            })
            ->orderByDesc('discipline_team.updated_at')
            ->limit(8)
            ->get([
                'teams.name as team_name',
                'disciplines.name as discipline_name',
                'disciplines.higher_is_better',
                'discipline_team.score_1',
                'discipline_team.score_2',
            ]);

        $items = $rows->map(function ($row) {
            $scores = array_map('floatval', array_filter(
                [$row->score_1, $row->score_2],
                fn ($value) => $value !== null
            ));
            $best = $row->higher_is_better ? max($scores) : min($scores);

            $bestFormatted = number_format($best, 2, ',', '.');
            $bestFormatted = rtrim(rtrim($bestFormatted, '0'), ',');

            return $row->discipline_name . ': ' . $row->team_name . ' — ' . $bestFormatted;
        })->all();

        if (empty($items)) {
            $items = ['Der Wettkampf startet bald – noch keine Ergebnisse eingetragen'];
        }

        // Laufband braucht genug Inhalt für eine nahtlose Schleife
        while (count($items) < 6) {
            $items = array_merge($items, $items);
        }

        return array_slice($items, 0, 12);
    }

    /**
     * "Team des Tages" für die Startnummern-Karte im Hero:
     * rotiert deterministisch mit dem Kalendertag durch alle Teams.
     */
    private function teamOfTheDay(): ?Team
    {
        $ids = Team::orderBy('id')->pluck('id');

        if ($ids->isEmpty()) {
            return null;
        }

        return Team::with('klasse.discipline')
            ->find($ids[now()->dayOfYear % $ids->count()]);
    }

    /**
     * Fallback für unbekannte URLs: zurück zur Startseite.
     * Als Controller-Action (statt Closure), damit route:cache funktioniert.
     */
    public function fallback()
    {
        return redirect('/');
    }
}
