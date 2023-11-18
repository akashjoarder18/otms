<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\SubCategoryController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\BatchController;
use App\Http\Controllers\API\DivisionController;
use App\Http\Controllers\API\DistrictController;
use App\Http\Controllers\API\UpazilaController;
use App\Http\Controllers\API\ProviderController;
use App\Http\Controllers\API\CommitteeController;
use App\Http\Controllers\API\PreliminarySelectionController;
use App\Http\Controllers\API\ProviderBatchesController;
use App\Http\Controllers\API\TraineeEnrollController;
use App\Http\Controllers\API\TrainingBatchScheduleController;
use App\Http\Controllers\API\TrainerController;
use App\Http\Controllers\API\TrainerEnrollController;
use App\Http\Controllers\API\PermissionController;
use App\Http\Controllers\API\ScheduleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::group(['middleware' => ['auth.jwt']], function () {
    Route::group(['middleware' => ['provider']], function () {
        Route::group(['prefix' => 'batch'], function () {
            Route::get('/list', [BatchController::class, 'batchList'])->name('batch.list');
            Route::get('/{id}/show', [BatchController::class, 'show'])->name('batch.show');
        });
        Route::group(['prefix' => 'schedule'], function () {
            Route::post('/create', [ScheduleController::class, 'store'])->name('schedule.store');
        });
    });
    Route::get('/all-schedule/{schedule_id}', [AttendanceController::class, 'allSchedule'])->name('attendance.all-schedule');

    Route::get('/attendance/{schedule_detail_id}/student-list', [AttendanceController::class, 'studentList'])->name('attendance.student-list');



    Route::group(['middleware' => ['trainer']], function () {
        Route::group(['prefix' => 'attendance'], function () {
            Route::get('/batch-list', [AttendanceController::class, 'batchList'])->name('attendance.batch-list');
            Route::post('/start-class', [AttendanceController::class, 'start'])->name('attendance.start');
            Route::post('/end-class', [AttendanceController::class, 'end'])->name('attendance.end');
            Route::post('/take', [AttendanceController::class, 'take'])->name('attendance.take');
        });
    });
});
