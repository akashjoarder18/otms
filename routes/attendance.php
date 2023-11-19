<?php

use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\BatchController;
use App\Http\Controllers\API\ScheduleController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth.jwt', 'localization']], function () {
    Route::group(['middleware' => []], function () {
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

    Route::group(['middleware' => []], function () {
        Route::group(['prefix' => 'attendance'], function () {
            Route::get('/batch-list', [AttendanceController::class, 'batchList'])->name('attendance.batch-list');
            Route::post('/start-class', [AttendanceController::class, 'start'])->name('attendance.start');
            Route::post('/end-class', [AttendanceController::class, 'end'])->name('attendance.end');
            Route::post('/take', [AttendanceController::class, 'take'])->name('attendance.take');
        });
    });
});
