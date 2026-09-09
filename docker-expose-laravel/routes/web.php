<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/health', function () {
    $c = cache()->get('hc_count', 0);

    if($c > 4){
        return 'ok';
    }

    cache()->increment('hc_count');

    throw new Exception('failed');
});
