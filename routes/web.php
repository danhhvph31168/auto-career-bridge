<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ajax\BaseAjaxController;
// use App\Http\Controllers\UniversityController;
use App\Http\Controllers\University\UserController as UserUniversityController;
use App\Http\Controllers\Client\JobController;
use App\Http\Controllers\Auth\ApprovalController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Client\EnterpriseController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\UniversityController;
use App\Http\Controllers\Client\WorkshopController;
use App\Http\Controllers\Enterprises\Admin\NotificationController;
use App\Http\Controllers\University\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('universities')
    ->as('universities.')
    ->controller(UniversityController::class)
    ->group(function () {
        Route::get('/', 'listUniversities')->name('list');
        Route::get('/{slug}', 'show')->name('show');
        Route::post('/cooperate', 'cooperate')
            ->name('cooperate')->middleware(['auth', 'verified']);

        Route::post('enterprise/{enterprise}', 'sendCollaboration')->middleware('auth')->name('enterprise.send');

        Route::delete('enterprise/{enterprise}', 'unSendCollaboration')->middleware('auth')->name('enterprise.un_send');
    });

Route::get('/users', [UserController::class, 'getAll']);

Auth::routes(['verify' => true]);


Route::get('/users', [UserController::class, 'getAll']);
// Ajax
Route::post('/changeStatus', [\App\Http\Controllers\Ajax\BaseAjaxController::class, 'changeStatus']);

Route::prefix('jobs')->group(function () {
    Route::get('', [JobController::class, 'index'])->name('job.list');
    Route::post('', [JobController::class, 'index'])->name('job.search');
    Route::get('detail/{id}', [JobController::class, 'detail'])->where('id', '[0-9]+')->name('job.detail');
    Route::post('/jobs/apply', [JobController::class, 'apply'])->name('job.apply')->middleware(['auth', 'verified']);;
});
Route::prefix('workshops')->group(function () {
    Route::get('', [WorkshopController::class, 'index'])->name('workshop.list');
    Route::post('', [WorkshopController::class, 'index'])->name('workshop.search');
    Route::get('detail/{id}', [WorkshopController::class, 'detail'])->where('id', '[0-9]+')->name('workshop.detail');
    Route::post('/workshops/apply', [WorkshopController::class, 'apply'])->name('workshop.apply')->middleware(['auth', 'verified']);;
});

Route::prefix('enterprises')
    ->as('enterprises.')
    ->controller(EnterpriseController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');

        Route::get('/{slug}', 'show')->name('show');
    });
// route approve pending
Route::get('/account/approve', [ApprovalController::class, 'approved'])->name('approve')->middleware(['auth', 'verified']);
