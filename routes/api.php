<?php

use App\Http\Controllers\Api\CandidateController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')
    ->group(function () {

        Route::prefix('candidate')
            ->as('api-candidate.')
            ->controller(CandidateController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');

                Route::post('/', 'store')->name('store');
                Route::post('/edu', 'storeEdu')->name('store-edu');
                Route::post('/fam', 'storeFam')->name('store-fam');
                Route::post('/train', 'storeTrain')->name('store-train');
                Route::post('/job-exp', 'storeJobExp')->name('store->jobexp');
                Route::post('/org', 'storeOrg')->name('store-org');
                Route::post('/reff', 'storeReff')->name('store-reff');
                Route::post('/attach', 'storeAttach')->name('store-attach');
            });

    });