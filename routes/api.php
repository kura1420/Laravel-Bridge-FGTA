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
            ->as('candidate.')
            ->controller(CandidateController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{id}', 'show')->name('show');

                Route::post('/', 'store')->name('store');

                Route::put('/{id}', 'update')->name('update');

                Route::delete('/{id}', 'destroy')->name('destroy');
            });

    });