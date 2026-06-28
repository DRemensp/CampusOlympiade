<?php

use App\Http\Controllers\ScoresystemController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\KlasseController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TeamTableController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminBroadcastController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaufzettelController;
use App\Http\Controllers\CertificateController;

Route::get('/dashboard', [DashboardController::class, 'home'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


Route::delete('/klasses/{klasseId}', [KlasseController::class, 'destroy'])
    ->middleware(['auth'])
    ->name('klasses.destroy');
Route::patch('/klasses/{klasse}', [KlasseController::class, 'update'])
    ->middleware(['auth'])
    ->name('klasses.update');
Route::post('/klasses', [KlasseController::class, 'store'])
    ->middleware(['auth'])
    ->name('klasses.store');
Route::get('/klasses/{klasse}/password', [KlasseController::class, 'password'])
    ->middleware(['auth'])
    ->name('klasses.password');


require __DIR__.'/auth.php';


Route::get('/', [HomeController::class, 'index'])
    ->name('welcome');

Route::get('/home/live', [HomeController::class, 'liveData'])
    ->middleware('throttle:60,1')
    ->name('home.live');

Route::view('/changelog', 'changelog')->name('changelog');

Route::view('/datenschutz', 'legal.privacy')->name('legal.privacy');
Route::view('/cookies', 'legal.cookies')->name('legal.cookies');
Route::view('/nutzungsbedingungen', 'legal.terms')->name('legal.terms');
Route::view('/impressum', 'legal.imprint')->name('legal.imprint');

Route::get('/teacher', [TeacherController::class, 'index'])
    ->middleware(['auth', 'role:admin|teacher'])
    ->name('teacher.index');


Route::get('/admin', [AdminController::class, 'index'])
    ->middleware(['auth', 'role:admin'])
    ->name('admin.index');

Route::post('/admin/broadcast', [AdminBroadcastController::class, 'store'])
    ->middleware(['auth'])
    ->name('admin.broadcast');


Route::post('/disciplines-teams', [TeamTableController::class, 'storeOrUpdate'])
    ->middleware(['auth'])
    ->name('teamTable.storeOrUpdate');


Route::post('/ranking/recalculate', [RankingController::class, 'recalculateAllScores'])
    ->middleware(['auth', 'role:admin'])
    ->name('ranking.recalculate');
Route::get('/ranking', [RankingController::class, 'index'])
    ->name('ranking.index');


Route::get('/laufzettel', [LaufzettelController::class, 'index'])
    ->name('laufzettel.index');
Route::get('/laufzettel/{team}', [LaufzettelController::class, 'show'])
    ->name('laufzettel.show');


Route::get('/archive', [App\Http\Controllers\ArchiveController::class, 'index'])
    ->name('archive.index');

Route::get('/archive/{archive}', [App\Http\Controllers\ArchiveController::class, 'show'])
    ->name('archive.show');

Route::post('/archive', [App\Http\Controllers\ArchiveController::class, 'store'])
    ->middleware(['auth'])
    ->name('archive.store');

Route::delete('/archive/{archive}', [App\Http\Controllers\ArchiveController::class, 'destroy'])
    ->middleware(['auth'])
    ->name('archive.destroy');

Route::post('/scoresystem', [ScoresystemController::class, 'store'])
    ->middleware(['auth'])
    ->name('scoresystem.store');

Route::post('/team/{team}/toggle-bonus', [LaufzettelController::class, 'toggleBonus'])
    ->middleware(['auth'])
    ->name('team.toggle-bonus');

// Moderation Routes (nur für Admin & Teacher)
Route::get('/moderation', [App\Http\Controllers\ModerationController::class, 'index'])
    ->middleware(['auth'])
    ->name('moderation.index');
Route::delete('/moderation/{comment}', [App\Http\Controllers\ModerationController::class, 'destroy'])
    ->middleware(['auth'])
    ->name('moderation.destroy');
Route::post('/moderation/{comment}/approve', [App\Http\Controllers\ModerationController::class, 'approve'])
    ->middleware(['auth'])
    ->name('moderation.approve');
Route::post('/moderation/{comment}/block', [App\Http\Controllers\ModerationController::class, 'block'])
    ->middleware(['auth'])
    ->name('moderation.block');
Route::post('/moderation/toggle-comments', [App\Http\Controllers\ModerationController::class, 'toggleComments'])
    ->middleware(['auth'])
    ->name('moderation.toggle');

// Innerhalb deiner auth/admin middleware gruppe:
Route::get('/certificate/generate', [CertificateController::class, 'generate'])
    ->middleware(['auth']) // <--- Das hier noch ergänzen
    ->name('certificate.generate');
//nicht wundern wenn manche Index nicht in Ressourcen angezeigt wird, hatte ganz komischen bug und fehler nicht gefunden,
//also einfach sepperat gemacht

// Nur die tatsächlich implementierten Resource-Methoden registrieren.
// Frühere Vollregistrierung erzeugte u.a. ein unauthentifiziertes GET /teachers
// (Lehrer-Panel) sowie 500er auf nicht existierende Methoden (z.B. GET /teams).
// teamTable/rankings haben eigene explizite Routen (teamTable.storeOrUpdate, /ranking).
Route::resource('schools', SchoolController::class)->only(['index', 'store', 'update', 'destroy']);
Route::resource('disciplines', DisciplineController::class)->only(['index', 'store', 'update', 'destroy']);
Route::resource('teams', TeamController::class)->only(['store', 'update', 'destroy']);

Route::fallback([HomeController::class, 'fallback']);
