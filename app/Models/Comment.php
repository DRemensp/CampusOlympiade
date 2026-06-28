<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * Aufbewahrungsfrist der IP-Adresse in Tagen (DSGVO).
     *
     * WICHTIG: Muss mit der Angabe in der Datenschutzerklärung
     * (resources/views/legal/privacy.blade.php, §4 und §5) übereinstimmen.
     */
    public const IP_RETENTION_DAYS = 30;

    protected $fillable = [
        'message',
        'author_name',
        'ip_address',
        'moderation_status',
        'moderation_scores',
        'moderation_reason',
        'moderated_at'
    ];

    protected $casts = [
        'moderation_scores' => 'array',
        'moderated_at' => 'datetime',
    ];

    /**
     * Wurde die IP-Adresse durch die DSGVO-Aufbewahrungsfrist anonymisiert?
     * True, wenn keine IP mehr vorhanden ist und der Kommentar älter als
     * die Aufbewahrungsfrist ist (im Gegensatz zu nie erfassten IPs).
     */
    public function ipExpired(): bool
    {
        return $this->ip_address === null
            && $this->created_at !== null
            && $this->created_at->lt(now()->subDays(self::IP_RETENTION_DAYS));
    }

    /**
     * Scope für nur genehmigte Kommentare
     */
    public function scopeApproved($query)
    {
        return $query->where('moderation_status', 'approved');
    }

    /**
     * Scope für ausstehende Moderation
     */
    public function scopePending($query)
    {
        return $query->where('moderation_status', 'pending');
    }

    /**
     * Scope für blockierte Kommentare
     */
    public function scopeBlocked($query)
    {
        return $query->where('moderation_status', 'blocked');
    }
}
