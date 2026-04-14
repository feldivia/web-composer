<?php

use App\Http\Controllers\Public\ContactFormController;
use App\Http\Controllers\Public\PageController;
use App\Http\Controllers\Public\BlogController;
use Illuminate\Support\Facades\Route;

// Sitemap
Route::get('/sitemap.xml', [\App\Http\Controllers\Public\SitemapController::class, 'index'])->name('sitemap');

// RSS Feed
Route::get('/feed.xml', [BlogController::class, 'feed'])->name('blog.feed');

// Blog routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Contact form submission (rate limited: 5 per hour per IP)
Route::post('/contact', [ContactFormController::class, 'store'])
    ->middleware('throttle:5,60')
    ->name('contact.store');

// Template gallery & preview (authenticated)
Route::middleware('auth')->group(function () {
    Route::get('/templates', [\App\Http\Controllers\Public\TemplatePreviewController::class, 'index'])->name('templates.index');
    Route::get('/templates/{slug}/preview', [\App\Http\Controllers\Public\TemplatePreviewController::class, 'show'])->name('templates.preview');
    Route::get('/preview/page/{page}', [PageController::class, 'preview'])->name('page.preview');
});

// Builder (authenticated)
Route::middleware('auth')->group(function () {
    Route::get('/builder/{page}', [\App\Http\Controllers\Builder\EditorController::class, 'editor'])->name('builder.editor');
    Route::get('/builder/{page}/templates', [\App\Http\Controllers\Builder\EditorController::class, 'templatePicker'])->name('builder.templates');
    Route::get('/builder/{page}/wizard', [\App\Http\Controllers\Builder\AIWizardController::class, 'show'])->name('builder.wizard');
    Route::post('/builder/{page}/wizard/generate', [\App\Http\Controllers\Builder\AIWizardController::class, 'generate'])->name('builder.wizard.generate');
    Route::get('/builder/{page}/sections', [\App\Http\Controllers\Builder\SectionEditorController::class, 'show'])->name('builder.sections');
    Route::post('/builder/{page}/sections/add', [\App\Http\Controllers\Builder\SectionEditorController::class, 'addSection'])->name('builder.sections.add');
    Route::post('/builder/{page}/sections/render', [\App\Http\Controllers\Builder\SectionEditorController::class, 'renderSection'])->name('builder.sections.render');
    Route::get('/builder/{page}/sections/{sectionId}/edit', [\App\Http\Controllers\Builder\SectionEditorController::class, 'editSection'])->name('builder.sections.edit');
    Route::post('/api/heartbeat', [\App\Http\Controllers\Api\SessionController::class, 'heartbeat'])->name('api.heartbeat');
});

// CMS pages - catch-all (MUST be last)
Route::get('/', [PageController::class, 'homepage'])->name('page.home');
Route::get('/{slug}', [PageController::class, 'show'])->where('slug', '^(?!admin|api|blog).*$')->name('page.show');
