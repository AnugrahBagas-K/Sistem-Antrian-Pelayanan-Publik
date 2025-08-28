<?php

use App\Http\Controllers\Welcome;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('/', [Welcome::class, 'index']);

