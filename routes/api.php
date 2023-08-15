<?php

use App\Http\Controllers\SMS\SendCodeController;
use Illuminate\Http\Request;
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

Route::group([
    'as'         => 'api.', 
    'namespace'  => 'App\Http\Controllers\SMS',
    'middleware' => 'client.auth'
], function () {
    Route::post('sms', 'CreateController')->name('sms.create');
    Route::get('sms', 'FetchController')->name('sms.fetch');
});

Route::get('send/code', SendCodeController::class);