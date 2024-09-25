<?php

use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminContentController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminDataEntryController;
use App\Http\Controllers\Admin\AdminEmploymentController;
use App\Http\Controllers\Admin\AdminPaidSurveyController;
use App\Http\Controllers\Admin\AdminRequestController;
use App\Http\Controllers\Admin\AdminSocialContentController;
use App\Http\Controllers\Admin\AdminTranscriptionController;
use App\Http\Controllers\Admin\AdminTranslationController;
use App\Http\Controllers\Admin\AdminWritingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('dashboard')->middleware('auth')->name('dashboard-')->group(function () {
    Route::get('/', [AdminController::class, 'index']);
    Route::get('users/', [AdminController::class, 'users'])->name('users');
    Route::get('approve/user/{id}', [AdminController::class, 'approveUser'])->name('approve-user');
    Route::get('users/show/{id}', [AdminController::class, 'profile'])->name('profile');
    Route::get('user/delete/{id}', [AdminController::class, 'deleteUser'])->name('user-delete');
    Route::get('users/export/', [AdminController::class, 'exportCSV'])->name('users-export-csv');

    Route::prefix('employment')->name('employment-')->group(function () {});

    Route::prefix('category')->name('category-')->group(function () {
        Route::get('list/{type}', [AdminCategoryController::class, 'list']);
        Route::post('create', [AdminCategoryController::class, 'create'])->name('create');
        Route::post('edit/{id}', [AdminCategoryController::class, 'edit'])->name('edit');
        Route::get('delete/{id}', [AdminCategoryController::class, 'delete'])->name('delete');
        Route::prefix('sub')->name('sub-')->group(function () {
            Route::get('list/{id}', [AdminCategoryController::class, 'sub']);
            Route::post('create', [AdminCategoryController::class, 'subCreate'])->name('create');
        });
    });

    Route::prefix('transcription')->name('transcription-')->group(function () {
        Route::get('/', [AdminTranscriptionController::class, 'list']);
        Route::post('/create', [AdminTranscriptionController::class, 'create'])->name('create');
        Route::post('/edit/{id}', [AdminTranscriptionController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}', [AdminTranscriptionController::class, 'delete'])->name('delete');
    });
    Route::prefix('paid-survey')->name('paid-survey-')->group(function () {
        Route::get('/', [AdminPaidSurveyController::class, 'list']);
        Route::post('/create', [AdminPaidSurveyController::class, 'create'])->name('create');
        Route::post('/edit/{id}', [AdminPaidSurveyController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}', [AdminPaidSurveyController::class, 'delete'])->name('delete');
    });
    Route::prefix('translation')->name('translation-')->group(function () {
        Route::get('/', [AdminTranslationController::class, 'list']);
        Route::post('/create', [AdminTranslationController::class, 'create'])->name('create');
        Route::post('/edit/{id}', [AdminTranslationController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}', [AdminTranslationController::class, 'delete'])->name('delete');
    });
    Route::prefix('content')->name('content-')->group(function () {
        Route::get('/', [AdminSocialContentController::class, 'list']);
        Route::post('/create', [AdminSocialContentController::class, 'create'])->name('create');
        Route::post('/edit/{id}', [AdminSocialContentController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}', [AdminSocialContentController::class, 'delete'])->name('delete');
    });
    Route::prefix('data-entry')->name('data-entry-')->group(function () {
        Route::get('/', [AdminDataEntryController::class, 'list']);
        Route::post('/create', [AdminDataEntryController::class, 'create'])->name('create');
        Route::post('/edit/{id}', [AdminDataEntryController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}', [AdminDataEntryController::class, 'delete'])->name('delete');
    });
    Route::prefix('writing')->name('writing-')->group(function () {
        Route::get('/', [AdminWritingController::class, 'list']);
        Route::post('/create', [AdminWritingController::class, 'create'])->name('create');
        Route::post('/edit/{id}', [AdminWritingController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}', [AdminWritingController::class, 'delete'])->name('delete');
    });

    Route::prefix('request')->name('request-')->group(function () {
        Route::get('/{type}', [AdminRequestController::class, 'list']);
        Route::get('approve/{type}/{id}', [AdminRequestController::class, 'approve'])->name('approve');
        Route::post('cancel/', [AdminRequestController::class, 'cancel'])->name('cancel');
        Route::get('list/approved/{type}', [AdminRequestController::class, 'approveRequests'])->name('approved-list');
    });
});

require __DIR__ . '/auth.php';
