<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UrlFetchingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/test', function(){
    return '<p>sdf<mark class="cdx-marker">sdfsdf </mark>sdfsd fsdf</p>';
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', [HomeController::class, 'home'])->name('home');

    Route::resource('articles', ArticleController::class);

    Route::post('/upload-content-article-image', [ArticleController::class, 'uploadArticleContentImage']);

    Route::get('fetchUrlMeta', [UrlFetchingController::class, 'fetchUrlMeta']);
});
