<?php

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

Route::namespace('Api')->group( function(){
    Route::get('propriedade/index', 'PropriedadeController@index');
    Route::post('propriedade/store', 'PropriedadeController@store');
    Route::get('propriedade/destroy/{id?}', 'PropriedadeController@destroy');
    
    Route::get('contrato/index', 'ContratoController@index');
    Route::post('contrato/store', 'ContratoController@store');
});