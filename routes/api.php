<?php

use App\Http\Controllers\Api\AIController;
use App\Http\Controllers\Api\PageBuilderController;
use App\Http\Controllers\Api\MediaUploadController;
use App\Http\Controllers\Api\SectionLibraryController;
use App\Http\Controllers\Api\TemplateController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'throttle:60,1'])->group(function () {
    // Page Builder
    Route::get('/pages/{page}/load', [PageBuilderController::class, 'load']);
    Route::post('/pages/{page}/store', [PageBuilderController::class, 'store']);

    // Media
    Route::post('/media/upload', [MediaUploadController::class, 'upload']);
    Route::get('/media', [MediaUploadController::class, 'index']);
    Route::delete('/media/{path}', [MediaUploadController::class, 'destroy'])->where('path', '.*');

    // Templates
    Route::get('/templates', [TemplateController::class, 'index']);
    Route::get('/templates/{slug}', [TemplateController::class, 'show']);

    // Section Library
    Route::get('/sections', [SectionLibraryController::class, 'index']);
    Route::get('/sections/{id}', [SectionLibraryController::class, 'show']);
    Route::get('/sections/{id}/preview', [SectionLibraryController::class, 'preview']);

    // AI (stricter rate limit)
    Route::middleware('throttle:10,1')->group(function () {
        Route::post('/ai/generate-text', [AIController::class, 'generateText']);
        Route::post('/ai/generate-seo', [AIController::class, 'generateSEO']);
        Route::post('/ai/translate', [AIController::class, 'translate']);
        Route::post('/ai/generate-page', [AIController::class, 'generatePage']);
        Route::post('/ai/generate-variants', [AIController::class, 'generateVariants']);
        Route::post('/ai/regenerate-section', [AIController::class, 'regenerateSection']);
        Route::post('/ai/generate-section', [AIController::class, 'generateSection']);
    });
});
