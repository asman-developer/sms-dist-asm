<?php

use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Admin\Dashboard\IndexController as DashboardIndexController;
use App\Http\Controllers\Admin\Auth\{
    LoginController,
    LogoutController
};
use App\Http\Controllers\Admin\SMS\{
    ListController as SMSListController,
    ResendController as SMSResendController,
    UpdateStatusController as SMSUpdateStatusController
};
use App\Http\Controllers\Admin\Distribution\{
    ListController as DistributionListController,
    StoreController as DistributionStoreController,
    DeleteController as DistributionDeleteController,
    ResendController as DistributionResendController
};
use App\Http\Controllers\Admin\Staff\{
    ListController as StaffListController,
    StoreController as StaffStoreController,
    DeleteController as StaffDeleteController,
    UpdateController as StaffUpdateController
};
use App\Http\Controllers\Admin\Service\{
    ListController as ServiceListController,
    StoreController as ServiceStoreController,
    DeleteController as ServiceDeleteController,
    UpdateController as ServiceUpdateController
};
use App\Http\Controllers\Admin\USB\{
    ListController as UsbListController,
    StoreController as UsbStoreController,
    DeleteController as UsbDeleteController,
    UpdateController as UsbUpdateController
};
use App\Http\Controllers\Admin\FileManager\FileManagerController;
use Illuminate\Support\Facades\Route;

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

// AUTH
Route::group([
    'prefix' => 'auth',
    'as'     => 'auth.',
], static function (){
    Route::get('login', fn() => view('pages.auth.login'))->name('login.page');
    Route::post('login', LoginController::class)->name('login');
    Route::post('logout', LogoutController::class)->name('logout');
});

// LOCALE
Route::get('language/{lang}', function ($locale) {
    app()->setLocale($locale);
    Cookie::queue('lang', $locale);
    return back();
})->name('set.locale');

// DASHBOARD
Route::group([
    'middleware' => ['admin.auth']
], static function () {

    Route::group([
        'prefix' => 'dashboard',
        'as'     => 'dashboard.',
    ], static function (){
        Route::get('/', DashboardIndexController::class)->name('index');
    });

    Route::group([
        'prefix' => 'sms',
        'as'     => 'sms.',
    ], static function (){
        Route::get('/', SMSListController::class)->name('list');
        Route::post('{id}/status/update', SMSUpdateStatusController::class)->name('update-status');
        Route::post('{id}/resend', SMSResendController::class)->name('resend');
    });

    Route::group([
        'prefix' => 'distribution',
        'as'     => 'distribution.',
    ], static function (){
        Route::get('/', DistributionListController::class)->name('list');
        Route::post('/store', DistributionStoreController::class)->name('store');
        Route::post('{id}/resend', DistributionResendController::class)->name('resend');
        Route::delete('{id}/delete', DistributionDeleteController::class)->name('delete');
    });

    Route::get('/filemanager', FileManagerController::class)->name('filemanager');

    Route::group([
        'prefix' => 'staff',
        'as'     => 'staff.',
    ], static function (){
        Route::get('/', StaffListController::class)->name('list');
        Route::post('/store', StaffStoreController::class)->name('store');
        Route::post('{id}/update', StaffUpdateController::class)->name('update');
        Route::delete('{id}/delete', StaffDeleteController::class)->name('delete');
    });

    Route::group([
        'prefix' => 'settings',
        'as'     => 'settings.',
    ], static function (){

        Route::group([
            'prefix' => 'service',
            'as'     => 'service.',
        ], static function (){
            Route::get('/', ServiceListController::class)->name('list');
            Route::post('/store', ServiceStoreController::class)->name('store');
            Route::post('{id}/update', ServiceUpdateController::class)->name('update');
            Route::delete('{id}/delete', ServiceDeleteController::class)->name('delete');
        });

        Route::group([
            'prefix' => 'usb',
            'as'     => 'usb.',
        ], static function (){
            Route::get('/', UsbListController::class)->name('list');
            Route::post('/store', UsbStoreController::class)->name('store');
            Route::post('{id}/update', UsbUpdateController::class)->name('update');
            Route::delete('{id}/delete', UsbDeleteController::class)->name('delete');
        });
    });
});
