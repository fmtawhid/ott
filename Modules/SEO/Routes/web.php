<?php

use Illuminate\Support\Facades\Route;
use Modules\SEO\Http\Controllers\SEOController;

// SEO Settings Routes
// Route::get('admin/seo', [SEOController::class, 'index'])->name('seo.index'); // URL: /admin/seo
Route::get('app/setting/seo-settings', [SEOController::class, 'index'])->name('Seo.seo-settings'); // URL: /app/setting/seo-settings

// SEO Save/Update Routes
Route::post('admin/seo/store', [SEOController::class, 'store'])->name('seo.store');     // URL: /admin/seo/store
Route::get('admin/seo/edit/{id}', [SEOController::class, 'edit'])->name('seo.edit');     // URL: /admin/seo/edit/{id}
Route::post('admin/seo/update/{id}', [SEOController::class, 'update'])->name('seo.update'); // URL: /admin/seo/update/{id}
Route::delete('seo/{id}', [SeoController::class, 'destroy'])->name('seo.destroy');
