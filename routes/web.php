<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DowntimeController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MesinController;
use App\Http\Controllers\DefectController;
use App\Http\Controllers\NotifikasiController;
use App\Events\NewNotification;
use App\Models\Notifikasi;



// Default Route untuk halaman login
Route::get('/', function () {
    return redirect('/login');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Group routes untuk user yang sudah login
Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Route::delete('/notifications', [NotifikasiController::class, 'markAsRead'])->name('notifications.index');
    Route::get('/notifications', [NotifikasiController::class, 'notifikasi'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotifikasiController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::get('/notifications/count', [NotifikasiController::class, 'getUnreadCount']);
});

// Group routes untuk user dengan role tertentu
Route::group(['middleware' => ['auth', 'role:admin,leader,teknisi,ipqc']], function () {
    // Tambahkan route lain yang memerlukan role tertentu di sini
});

Route::get('/dashboard/defect-chart', [DashboardController::class, 'chart']);


Route::get('/downtime', [DowntimeController::class, 'index'])->name('downtime.index');
Route::get('/downtime/create', [DowntimeController::class, 'create'])->name('downtime.create');
Route::post('/downtime', [DowntimeController::class, 'store'])->name('downtime.store');
Route::get('/downtime/{downtime}', [DowntimeController::class, 'show'])->name('downtime.show');
Route::get('/downtime/{downtime}/edit', [DowntimeController::class, 'edit'])->name('downtime.edit');
Route::put('/downtime/{downtime}', [DowntimeController::class, 'update'])->name('downtime.update');
Route::delete('/downtime/{downtime}', [DowntimeController::class, 'destroy'])->name('downtime.destroy');
Route::post('/downtime/start/{id}', [DowntimeController::class, 'start'])->name('downtime.start');


Route::get('finishdowntime/create', [DowntimeController::class, 'finishDowntimeCreate'])->name('finishdowntime.create');
Route::post('finishdowntime', [DowntimeController::class, 'finishDowntimeStore'])->name('finishdowntime.store');
Route::put('/finishdowntime/{id}', [DowntimeController::class, 'finishDowntimeUpdate'])->name('finishdowntime.update');



Route::get('/Rekapdowntime', [DowntimeController::class, 'RekapIndex'])->name('rekapdowntime.index');
Route::post('/Rekapdowntime', [DowntimeController::class, 'RekapStore'])->name('rekapdowntime.store');
Route::get('/Rekapdowntime/{downtime}/show', [DowntimeController::class, 'RekapShow'])->name('rekapdowntime.show');
Route::get('/Rekapdowntime/{downtime}/edit', [DowntimeController::class, 'RekapEdit'])->name('rekapdowntime.edit');
Route::put('/Rekapdowntime/{downtime}', [DowntimeController::class, 'RekapUpdate'])->name('rekapdowntime.update');
Route::delete('/Rekapdowntime/{downtime}', [DowntimeController::class, 'RekapDestroy'])->name('rekapdowntime.destroy');


// Setup Routes
Route::get('/setup', [SetupController::class, 'index'])->name('setup.index');
Route::get('/setup/create', [SetupController::class, 'create'])->name('setup.create');
Route::post('/setup', [SetupController::class, 'store'])->name('setup.store');
Route::get('/setup/{setup}', [SetupController::class, 'show'])->name('setup.show');
Route::get('/setup/{setup}/edit', [SetupController::class, 'edit'])->name('setup.edit');
Route::put('/setup/{setup}', [SetupController::class, 'update'])->name('setup.update');
Route::delete('/setup/{setup}', [SetupController::class, 'destroy'])->name('setup.destroy');
Route::post('/setup/start/{id}', [SetupController::class, 'start'])->name('setup.start');

// User Routes
Route::get('/datauser', [UserController::class, 'index'])->name('datauser.index');
Route::get('/datauser/create', [UserController::class, 'create'])->name('datauser.create');
Route::post('/datauser', [UserController::class, 'store'])->name('datauser.store');
Route::get('/datauser/{user}', [UserController::class, 'show'])->name('datauser.show');
Route::get('/datauser/{user}/edit', [UserController::class, 'edit'])->name('datauser.edit');
Route::put('/datauser/{user}', [UserController::class, 'update'])->name('datauser.update');
Route::delete('/datauser/{user}', [UserController::class, 'destroy'])->name('datauser.destroy');


// Route::get('finishsetup', [SetupController::class, 'finishSetupIndex'])->name('finishsetup.index');
Route::get('finishsetup/create', [SetupController::class, 'finishSetupCreate'])->name('finishsetup.create');
Route::post('finishsetup', [SetupController::class, 'finishSetupStore'])->name('finishsetup.store');
Route::get('finishsetup/{id}', [SetupController::class, 'finishSetupShow'])->name('finishsetup.show');
Route::get('finishsetup/{finishSetup}/edit', [SetupController::class, 'finishSetupEdit'])->name('finishsetup.edit');
Route::put('finishsetup/{finishSetup}', [SetupController::class, 'finishSetupUpdate'])->name('finishsetup.update');
Route::delete('finishsetup/{finishSetup}', [SetupController::class, 'finishSetupDestroy'])->name('finishsetup.destroy');
    

Route::get('Rekapsetup', [SetupController::class, 'RekapIndex'])->name('rekapsetup.index');
Route::post('/Rekapsetup', [SetupController::class, 'RekapStore'])->name('rekapsetup.store');
Route::get('Rekapsetup/{setup}/show', [SetupController::class, 'RekapShow'])->name('rekapsetup.show');
Route::get('/Rekapsetup/{setup}/edit', [SetupController::class, 'RekapEdit'])->name('rekapsetup.edit');
Route::put('/Rekapsetup/{setup}', [SetupController::class, 'RekapUpdate'])->name('rekapsetup.update');
Route::delete('/Rekapsetup/{setup}', [SetupController::class, 'RekapDestroy'])->name('rekapsetup.destroy');


Route::resource('mesin', MesinController::class);   

Route::resource('defect', DefectController::class);   

Route::get('/downtime/search', [DowntimeController::class, 'search'])->name('downtime.search');
Route::get('/Rekapdowntime/search', [DowntimeController::class, 'RekapSearch'])->name('rekapdowntime.search');

Route::get('/setup/search', [SetupController::class, 'search'])->name('setup.search');
Route::get('/Rekapsetup/search', [SetupController::class, 'RekapSearch'])->name('rekapsetup.search');

Route::post('/rekapdowntime/{id}/approve', [DowntimeController::class, 'approve'])->name('rekapdowntime.approve');
Route::post('/rekapsetup/{id}/approve', [SetupController::class, 'approve'])->name('rekapsetup.approve');
Route::put('qc/update/{id}', [SetupController::class, 'QcUpdate'])->name('qc.update');

Route::get('/dashboard/setup-requests', [DashboardController::class, 'getSetupRequestsCount']);
Route::get('/dashboard/downtime-requests', [DashboardController::class, 'getDowntimeRequestsCount']);

Route::get('/kirim-notifikasi/{userId}', function ($userId) {
    // Dummy notifikasi (biasanya diambil dari DB atau request)
    $notifikasi = new Notifikasi([
        'id' => rand(1000, 9999),
        'title' => 'Pesan Baru!',
        'body' => 'Halo, kamu punya notifikasi baru dari sistem.',
        'user_id' => $userId,
    ]);

    // Kirim event-nya
    event(new NewNotification($notifikasi));

    return "Notifikasi terkirim ke user ID {$userId}!";
});