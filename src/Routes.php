<?php

use Illuminate\Support\Facades\Route;
use ClarionApp\ListsBackend\Controllers\ListController;

Route::group(['middleware'=>['auth:api'], 'prefix'=>$this->routePrefix], function () {
    Route::resource('lists', ListController::class);
    Route::post('lists/{id}/clone', [ListController::class, 'clone']);
    Route::delete('lists/{list_id}/items/{item_id}', [ListController::class, 'destroyItem']);
});
