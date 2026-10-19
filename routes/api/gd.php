<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\getlevel;
use App\Http\Controllers\Api\levelload;

Route::post('/getGJLevels.php', [getlevel::class, 'index']);

Route::get('/getGJLevels.php', [getlevel::class, 'wrongMethod']);


Route::post('/downloadGJLevel.php', [levelload::class, 'index']);

Route::get('/downloadGJLevel.php', [getlevel::class, 'wrongMethod']);