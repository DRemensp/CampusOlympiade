<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            // Nullable, damit die IP nach Ablauf der Aufbewahrungsfrist
            // anonymisiert (auf NULL gesetzt) werden kann (DSGVO, siehe
            // App\Console\Commands\PruneCommentIpAddresses).
            $table->string('ip_address', 45)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->string('ip_address', 45)->nullable(false)->change();
        });
    }
};
