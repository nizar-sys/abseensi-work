<?php

use App\Http\Controllers\AttendancesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DataTableController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\TimeOffSettingController;
use App\Http\Controllers\UserLogsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

# ------ Unauthenticated routes ------ #
Route::get('/', [AuthenticatedSessionController::class, 'create']);
require __DIR__.'/auth.php';


# ------ Authenticated routes ------ #
Route::middleware('auth')->group(function() {
    Route::get('/dashboard', [RouteController::class, 'dashboard'])->name('home'); # dashboard

    Route::prefix('profile')->group(function(){
        Route::get('/', [ProfileController::class, 'myProfile'])->name('profile');
        Route::put('/change-ava', [ProfileController::class, 'changeFotoProfile'])->name('change-ava');
        Route::put('/change-profile', [ProfileController::class, 'changeProfile'])->name('change-profile');
    }); # profile group

    Route::middleware('roles:admin')->group(function(){
        Route::resource('users', UserController::class);
        Route::resource('user-logs', UserLogsController::class);
        Route::resource('timeoff-settings', TimeOffSettingController::class);
        Route::resource('attendances', AttendancesController::class);
    });

    Route::get('/submissions/conditions', [SubmissionController::class, 'conditions'])->name('submissions.conditions');
    Route::resource('submissions', SubmissionController::class);

    Route::middleware('roles:teacher,tu')->group(function(){
        Route::post('/presences/create', [PresenceController::class, 'create'])->name('presences.create');
        Route::post('/presences/store', [PresenceController::class, 'store'])->name('presences.store');
        Route::post('/presences/post-image', [PresenceController::class, 'postImage'])->name('presences.post-image');

        Route::post('/user-logs/store', [UserLogsController::class, 'store'])->name('user-logs.store');
    });
});
