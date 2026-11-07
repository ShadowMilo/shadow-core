<?php

use App\Http\Controllers\Api\getlevel;
use App\Http\Controllers\Api\levelload;
use App\Http\Controllers\Api\uploadlevel;
use App\Http\Controllers\Api\likelevel;
use Illuminate\Support\Facades\Route;

Route::post('/getGJLevels.php', [getlevel::class, 'index']);

Route::get('/getGJLevels.php', [getlevel::class, 'wrongMethod']);

Route::post('/downloadGJLevel.php', [levelload::class, 'index']);

Route::get('/downloadGJLevel.php', [getlevel::class, 'wrongMethod']);

Route::post('/uploadGJLevel.php', [uploadlevel::class, 'index']);

Route::get('/uploadGJLevel.php', [getlevel::class, 'wrongMethod']);

Route::post('/likeGJLevel.php', [likelevel::class, 'index']);

Route::get('/uploadGJLevel.php', [getlevel::class, 'wrongMethod']);


