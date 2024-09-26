<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('user/auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('password/forgot', [AuthController::class, 'recover']);
    Route::post('otp/verify', [AuthController::class, 'otpVerify']);
    Route::post('password/reset', [AuthController::class, 'newPassword']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('password/change', [AuthController::class, 'changePassword']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('remove/image', [AuthController::class, 'removeImage']);
        Route::get('delete', [AuthController::class, 'deleteAccount']);
    });
});

Route::prefix('user/')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('edit/profile', [UserController::class, 'updateUser']);
        Route::get('get/profile', [UserController::class, 'getUser']);
        Route::get('category/{type}', [UserController::class, 'category']);
        Route::get('home/{main_type}/{sub_type}', [UserController::class, 'home']);
        Route::get('transcription/list', [UserController::class, 'transcriptionList']);
        Route::get('translation/list', [UserController::class, 'translationList']);
        Route::get('content/list', [UserController::class, 'contentList']);
        Route::get('data-entry/list', [UserController::class, 'dataEntryList']);
        Route::get('paid-survey/check', [UserController::class, 'paidSurveyCheck']);
        Route::get('app-test/check', [UserController::class, 'appTestCheck']);
        Route::get('writing/check', [UserController::class, 'writingCheck']);

        Route::post('contact-us', [UserController::class, 'contactUs']);
        Route::post('subscribe', [UserController::class, 'subscribe']);

        Route::prefix('request/')->group(function () {
            Route::post('employment', [UserController::class, 'employmentRequest']);
            Route::post('internship', [UserController::class, 'internshipRequest']);
            Route::post('apprenticeship', [UserController::class, 'apprenticeshipRequest']);
            Route::post('transcription', [UserController::class, 'transcriptionRequest']);
            Route::post('translation', [UserController::class, 'translationRequest']);
            Route::post('content/{id}', [UserController::class, 'contentRequest']);
            Route::post('data-entry/{id}', [UserController::class, 'dataEntryRequest']);
            Route::post('paid-survey', [UserController::class, 'paidSurveyRequest']);
            Route::post('app-test', [UserController::class, 'appTestRequest']);
            Route::post('writing', [UserController::class, 'writingRequest']);
            Route::get('cancel/{type}/{id}', [UserController::class, 'cancelRequest']);
        });
    });
});
