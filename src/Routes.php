<?php

use Illuminate\Support\Facades\Route;
use ClarionApp\ListsBackend\Http\Controllers\ListController;

Route::group(['middleware'=>['api'], 'prefix'=>'api/clarion-app/lists'], function () {
    Route::resource('lists', ListController::class);
    Route::post('lists/{id}/clone', [ListController::class, 'clone']);
});
