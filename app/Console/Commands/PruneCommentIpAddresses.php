<?php

namespace App\Console\Commands;

use App\Models\Comment;
use Illuminate\Console\Command;

class PruneCommentIpAddresses extends Command
{
    protected $signature = 'comments:prune-ips';

    protected $description = 'Anonymisiert die IP-Adressen von Kommentaren, die älter als die Aufbewahrungsfrist sind (DSGVO). Der Kommentar selbst bleibt erhalten.';

    public function handle(): int
    {
        $cutoff = now()->subDays(Comment::IP_RETENTION_DAYS);

        $count = Comment::whereNotNull('ip_address')
            ->where('created_at', '<', $cutoff)
            ->update(['ip_address' => null]);

        $this->info("{$count} IP-Adresse(n) anonymisiert (Kommentare älter als " . Comment::IP_RETENTION_DAYS . " Tage).");

        return self::SUCCESS;
    }
}
