<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\ProjectsController;
use App\Http\Controllers\Api\TestimonialsController;
use App\Mail\MessageAdmin;
use Illuminate\Support\Facades\Mail;
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

Route::prefix('auth')->group(function ()
{
    Route::controller(LoginController::class)->group(function ()
    {
        Route::post('login', 'login');
        Route::post('logout', 'logout');
    });
});

Route::middleware(['auth:api'])->group(function ()
{
    Route::prefix('projects')->group(function()
    {
        Route::controller(ProjectsController::class)->group(function ()
        {
            Route::get('/', 'index');
            Route::get('/{project}', 'show');
            Route::post('/', 'store');
            Route::put('/{project}', 'update');
            Route::delete('/', 'destroy');
        });
    });

    Route::prefix('testimonials')->group(function()
    {
        Route::controller(TestimonialsController::class)->group(function ()
        {
            Route::get('/', 'index');
            Route::get('/{testimonial}', 'show');
            Route::post('/', 'store');
            Route::put('/{testimonial}', 'update');
            Route::delete('/', 'destroy');
        });
    });
});