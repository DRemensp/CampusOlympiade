<?php

namespace App\Console\Commands;

use App\Models\Comment;
use Illuminate\Console\Command;

class PruneCommentIpAddresses extends Command
{
    /**
     * Aufbewahrungsfrist der IP-Adresse in Tagen.
     *
     * WICHTIG: Muss mit der Angabe in der Datenschutzerklärung
     * (resources/views/legal/privacy.blade.php, §4 und §5) übereinstimmen.
     */
    private const RETENTION_DAYS = 30;

    protected $signature = 'comments:prune-ips';

    protected $description = 'Anonymisiert die IP-Adressen von Kommentaren, die älter als die Aufbewahrungsfrist sind (DSGVO). Der Kommentar selbst bleibt erhalten.';

    public function handle(): int
    {
        $cutoff = now()->subDays(self::RETENTION_DAYS);

        $count = Comment::whereNotNull('ip_address')
            ->where('created_at', '<', $cutoff)
            ->update(['ip_address' => null]);

        $this->info("{$count} IP-Adresse(n) anonymisiert (Kommentare älter als " . self::RETENTION_DAYS . " Tage).");

        return self::SUCCESS;
    }
}
