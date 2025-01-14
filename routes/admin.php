<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EnterpriseController;
use App\Http\Controllers\Admin\JobController as AdminJobController;
use App\Http\Controllers\Admin\MajorController as AdminMajorController;
use App\Http\Controllers\Admin\SubAdminController;
use App\Http\Controllers\Admin\UniversityController;
use App\Http\Controllers\Admin\WorkshopController as AdminWorkshopController;
use App\Http\Controllers\Auth\ApprovalController;
use App\Http\Controllers\Enterprise\CollaborationController;
use App\Http\Controllers\Enterprise\JobController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\University\ProfileController;
use App\Http\Controllers\Enterprise\ProfileController as ProfileEnterpriseController;
use App\Http\Controllers\University\UserController as UserUniversityController;
use App\Http\Controllers\Enterprise\DashboardController as DashboardEnterprise;
use App\Http\Controllers\Enterprise\NotificationController;
use App\Http\Controllers\Enterprise\UserController as EnterpriseUserController;
use App\Http\Controllers\University\DashboardController as UniversityDashboardController;
use App\Http\Controllers\University\CollaborationController as UniversityCollaborationController;
use App\Http\Controllers\University\MajorController;
use App\Http\Controllers\University\WorkshopController;

Route::middleware(['auth', 'verified'])->group(function () {
    // route system-admin
    Route::prefix('system-admin')
        ->as('system-admin.')
        ->middleware('check.role:super-admin')
        ->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            // route sub-admin
            Route::resource('sub-admin', SubAdminController::class);

            // route approve account university
            Route::prefix('university')->as('university.')->group(function () {
                Route::get('/', [UniversityController::class, 'index'])->name('users');
                Route::get('/detail/{id}', [UniversityController::class, 'detail'])->name('detal')->where('id', '[0-9]+');
                Route::post('/approve/{id}', [UniversityController::class, 'approve'])->name('approve')->where('id', '[0-9]+');
                Route::post('/reject/{id}', [UniversityController::class, 'reject'])->name('reject')->where('id', '[0-9]+');
            });

            // route approve workshop university
            Route::prefix('workshop')->as('workshop.')->group(function () {
                Route::get('/', [AdminWorkshopController::class, 'index'])->name('list');
                Route::get('/detail/{id}', [AdminWorkshopController::class, 'detail'])->name('detal')->where('id', '[0-9]+');
                Route::post('/approve/{id}', [AdminWorkshopController::class, 'approve'])->name('approve')->where('id', '[0-9]+');
                Route::post('/reject/{id}', [AdminWorkshopController::class, 'reject'])->name('reject')->where('id', '[0-9]+');
            });

            // route approve major university
            Route::prefix('major')->as('major.')->group(function () {
                Route::get('/', [AdminMajorController::class, 'index'])->name('list');
                Route::post('store', [AdminMajorController::class, 'store'])->name('store');
                Route::get('/detail/{id}', [AdminMajorController::class, 'detail'])->name('detal')->where('id', '[0-9]+');
                Route::post('/approve/{id}', [AdminMajorController::class, 'approve'])->name('approve')->where('id', '[0-9]+');
                Route::post('/reject/{id}', [AdminMajorController::class, 'reject'])->name('reject')->where('id', '[0-9]+');
            });

            // route approve account enterprise
            Route::prefix('enterprise')->as('enterprise.')->group(function () {
                Route::get('', [EnterpriseController::class, 'index'])->name('index');
                Route::get('/show/{id}', [EnterpriseController::class, 'show'])->name('show');
                Route::put('/approve/{id}', [EnterpriseController::class, 'approve'])->name('approve');
                Route::put('/un-approve/{id}', [EnterpriseController::class, 'unApprove'])->name('un-approve');
                Route::delete('/destroy/{id}', [EnterpriseController::class, 'destroy'])->name('destroy');
            });

            // route approve job enterprise
            Route::prefix('job')->as('job.')->group(function () {
                Route::get('', [AdminJobController::class, 'index'])->name('index');
                Route::get('/show/{id}', [AdminJobController::class, 'show'])->name('show');
                Route::put('/approve/{id}', [AdminJobController::class, 'approve'])->name('approve');
                Route::put('/un-approve/{id}', [AdminJobController::class, 'unApprove'])->name('un-approve');
                Route::delete('/destroy/{id}', [AdminJobController::class, 'destroy'])->name('destroy');
            });
        });

    // route enterprise admin
    Route::prefix('enterprise')->as('enterprise.')->middleware('check.role:enterprise')->group(function () {
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('edit', [ProfileEnterpriseController::class, 'edit'])->name('edit');
            Route::put('update', [ProfileEnterpriseController::class, 'update'])->name('update');
        });

        Route::middleware('approved')->group(function () {
            Route::get('/dashboard', function () {
                return view('enterprise.dashboard');
            })->name('dashboard');

            Route::put('users/{user}/updateIsActive', [EnterpriseUserController::class, 'updateIsActive'])->name('users.updateIsActive');
            Route::post('users/import', [EnterpriseUserController::class, 'import'])->name('users.import');
            Route::get('users/export', [EnterpriseUserController::class, 'export'])->name('users.export');
            Route::resource('users', EnterpriseUserController::class);

            Route::put('jobs/updateManyStatus', [JobController::class, 'updateManyStatus'])->name('jobs.updateManyStatus');
            Route::resource('jobs', JobController::class);
            Route::put('jobs/{job}/university/{university}/status', [JobController::class, 'updateApplyStatus'])->name('jobs.university');
            Route::resource('jobs', JobController::class);

            Route::prefix('collaborations')
                ->as('collaborations.')
                ->group(function () {
                    Route::get('/', [CollaborationController::class, 'index'])->name('index');
                    Route::put('university/{university}', [CollaborationController::class, 'update'])->name('update');
                    Route::delete('university/{university}', [CollaborationController::class, 'destroy'])->name('destroy');
                });

            Route::get('dashboard', [DashboardEnterprise::class, 'index'])->name('dashboard');
            Route::post('dateDashboard', [DashboardEnterprise::class, 'dateDashboard'])->name('dateDashboard');
            Route::get('exportJob', [DashboardEnterprise::class, 'exportJob'])->name('exportJob');
        });
    });

    // route university admin
    Route::prefix('university')->as('university.')->middleware('check.role:university')->group(function () {

        Route::get('exportWorkshop', [UniversityDashboardController::class, 'exportWorkshop'])->name('exportWorkshop');

        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('edit', [ProfileController::class, 'edit'])->name('edit');
            Route::put('update', [ProfileController::class, 'update'])->name('update');
        });


        Route::middleware('approved')->group(function () {
            Route::get('/dashboard', function () {
                return view('university.dashboard');
            })->name('dashboard');

            // Route major manager
            Route::prefix('major')->name('major.')->group(function () {
                Route::get('/', [MajorController::class, 'index'])->name('index');
                Route::post('store', [MajorController::class, 'store'])->name('store');
                Route::get('edit/{id}', [MajorController::class, 'edit'])->name('edit');
                Route::put('update/{id}', [MajorController::class, 'update'])->name('update');
                Route::delete('destroy/{id}', [MajorController::class, 'destroy'])->name('destroy');
            });

            // Route User University
            Route::get('/', [UserUniversityController::class, 'index'])->name('index');
            Route::get('create', [UserUniversityController::class, 'create'])->name('create');
            Route::post('store', [UserUniversityController::class, 'store'])->name('store');
            Route::get('show/{id}', [UserUniversityController::class, 'show'])->name('show');
            Route::get('edit/{id}', [UserUniversityController::class, 'edit'])->name('edit');
            Route::put('update/{id}', [UserUniversityController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [UserUniversityController::class, 'destroy'])->name('destroy');
            // Route Import and Export file Excel User
            Route::get('exportExcelFile', [UserUniversityController::class, 'exportExcelFile'])->name('exportExcelFile');
            Route::get('exportExcelFileUser', [UserUniversityController::class, 'userExportExcelFileUser'])->name('exportExcelFileUser');
            Route::post('importExcelFile', [UserUniversityController::class, 'importExcelFile'])->name('importExcelFile');

            // Workshop
            Route::prefix('workshop')->name('workshop.')->group(function () {
                Route::get('/', [WorkshopController::class, 'index'])->name('index');
                Route::get('create', [WorkshopController::class, 'create'])->name('create');
                Route::post('store', [WorkshopController::class, 'store'])->name('store');
                Route::get('show/{id}', [WorkshopController::class, 'show'])->name('show');
                Route::get('edit/{id}', [WorkshopController::class, 'edit'])->name('edit');
                Route::put('update/{id}', [WorkshopController::class, 'update'])->name('update');
                Route::delete('destroy/{id}', [WorkshopController::class, 'destroy'])->name('destroy');
            });

            Route::prefix('collaborations')
                ->as('collaborations.')
                ->group(function () {
                    Route::get('/', [UniversityCollaborationController::class, 'index'])->name('index');
                    Route::put('enterprise/{enterprise}', [UniversityCollaborationController::class, 'update'])->name('update');
                    Route::delete('enterprise/{enterprise}', [UniversityCollaborationController::class, 'destroy'])->name('destroy');
                });

            Route::get('/dashboard', [UniversityDashboardController::class, 'index'])->name('dashboard');
        });

        Route::get('/showEnterprise/{id}', [EnterpriseUserController::class, 'show']);
        Route::put('/{workshop}/enterprise/{enterprise}/status', [WorkshopController::class, 'updateApplyStatus'])->name('workshop.enterprise');
    });
});
Route::get('/account/approve', [ApprovalController::class, 'approved'])->name('approve')->middleware(['auth', 'verified']);


Route::prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::prefix('notifications')
            ->as('notifications.')
            ->controller(NotificationController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{id}/show', 'show')->name('show');
                Route::delete('/{id}/delete', 'delete')->name('delete');
                Route::get('/delete-notifications', 'deleteNotifications');
                Route::get('/header', 'header');
                Route::post('/censor', 'censor')->name('censor');
            });
    })->middleware(['auth', 'verified']);
