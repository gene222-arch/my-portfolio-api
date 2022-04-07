<?php

use App\Http\Controllers\Api\Auth\AccountController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\MessageAdminController;
use App\Http\Controllers\Api\PageReportsController;
use App\Http\Controllers\Api\ProjectsController;
use App\Http\Controllers\Api\TestimonialsController;
use App\Http\Controllers\Api\UserSocialMediaAccountsController;
use App\Http\Controllers\EmailsController;
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

Route::prefix('page-report')->group(function ()
{
    Route::controller(PageReportsController::class)->group(function () 
    {
        Route::get('/{pageReport}', 'show');
        Route::put('/likes/{pageReport}', 'incrementLikes');
        Route::put('/views/{pageReport}', 'incrementViews');
    });
});

Route::middleware(['auth:api'])->group(function ()
{
    Route::prefix('account')->group(function () 
    {
        Route::controller(AccountController::class)->group(function () 
        {
            Route::get('/{user}', 'show');
            Route::put('/details/{user}', 'updateDetails');
            Route::put('/social-media/{user}', 'updateSocialMediaAccount');
        });
    });

    Route::group([
        'prefix' => 'emails',
        'as' => 'emails.'
    ], function ()
    {
        Route::controller(EmailsController::class)->group(function ()
        {
            Route::get('/', 'index')->name('index');
            Route::delete('/', 'destroy')->name('destroy');
            Route::put('restore', 'restore')->name('restore');
        });
    });

    Route::prefix('projects')->group(function ()
    {
        Route::controller(ProjectsController::class)->group(function ()
        {
            Route::get('/', 'index')->withoutMiddleware('auth:api');
            Route::get('/{project}', 'show');
            Route::post('/', 'store');
            Route::post('/image-upload', 'uploadImage');
            Route::put('/{project}', 'update');
            Route::delete('/', 'destroy');
        });
    });

    Route::prefix('testimonials')->group(function ()
    {
        Route::controller(TestimonialsController::class)->group(function ()
        {
            Route::get('/', 'index')->withoutMiddleware('auth:api');;
            Route::get('/{testimonial}', 'show');
            Route::post('/', 'store');
            Route::post('/upload-avatar', 'uploadAvatar');
            Route::put('/{testimonial}', 'update');
            Route::delete('/', 'destroy');
        });
    });

    Route::prefix('social-media-accounts')->group(function ()
    {
        Route::controller(UserSocialMediaAccountsController::class)->group(function ()
        {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::put('/{socialMediaAccount}', 'update');
            Route::delete('/', 'destroy');
        });
    });
});

Route::post('/mail-admin', [MessageAdminController::class, 'mail']);