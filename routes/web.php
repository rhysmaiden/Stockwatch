<?php

use App\Http\Admin\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectionController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\DebugController;
use Illuminate\Support\Facades\Route;


Auth::routes([
    'verify'   => true,
    'register' => (env('APP_ENV', 'production') === 'local') //this needs to be removed when we go live
]);
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

//=== LEGAL ===//
Route::get('/privacy', [LegalController::class, 'privacy']);
Route::get('/tos', [LegalController::class, 'tos']);


Route::group(['middleware' => ['auth']], function () {
    Route::get('/', function () {
        return redirect()->route('leaderboard');
    });

    Route::get('/account', [UserController::class, 'account'])->name('account.edit');
    Route::post('/account/update', [UserController::class, 'update'])->name('account.update');

    Route::get('/projections', [ProjectionController::class, 'index']);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/trades', [TradeController::class, 'index'])->name('dashboard');

    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');

    Route::get('/trades', [TradeController::class, 'index'])->name('trade');
    Route::post('/trades/savestocks', [TradeController::class, 'savestocks']);
    Route::get('/landing', [HomeController::class, 'landing']);

});

Route::get('/faq', function () {
   return view('faq');
});

Route::get('/maintenance', function () {
    return view('maintenance');
 });


Route::group(['middleware' => ['local']], function () {
    Route::get('/styleguide', function () {
        return view('styleguide');
    });

    //=== DEBUG ===//
    Route::get('/xyz', [DebugController::class, 'xyz']);
    Route::get('/leaderboard/calculate', [LeaderboardController::class, 'calculate']);
    Route::get('/debug/showme/{blade}', [DebugController::class, 'showme'])->where('blade', '.*');

});

//===


//===SAMPLE ROUTE===//
//Route::get('/route', function () {
//    return view('dir.file');
//});
