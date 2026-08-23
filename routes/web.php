<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DistribuidorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SeoController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/nosotros', [HomeController::class, 'nosotros'])->name('nosotros');
Route::get('/productos', [HomeController::class, 'productos'])->name('productos');
Route::get('/encuentra-un-distribuidor', [DistribuidorController::class, 'index'])->name('encuentra-un-distribuidor');
Route::post('/encuentra-un-distribuidor/catalogo', [DistribuidorController::class, 'downloadCatalog'])
    ->middleware('throttle:10,1')
    ->name('distribuidores.catalogo');
Route::get('/inspirate', [HomeController::class, 'comingSoon'])->name('inspirate');
Route::get('/hazlo-tu-mismo', [HomeController::class, 'hazloTuMismo'])->name('hazlo-tu-mismo');
Route::get('/aviso-de-privacidad', [HomeController::class, 'avisoPrivacidad'])->name('aviso-de-privacidad');

Route::post('/leads', [LeadController::class, 'store'])->name('leads.store');
Route::post('/contacto', [ContactController::class, 'store'])->name('contacto.store');
Route::get('/catalogo/descargar', [CatalogController::class, 'download'])->name('catalogo.descargar');

Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
