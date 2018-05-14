<?php

use Illuminate\Http\Request;

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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


//Rotas públicas (Que não necessitam de Autenticação e Autorização
Route::group([], function(){
    Route::get('/lista-licitacao-cnpq', 'Captura\LicitacaoCnpqController@buscarLicitacoesCNPQ');
});