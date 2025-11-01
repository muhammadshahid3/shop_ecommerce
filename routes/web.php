<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|

| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

include("frontend_routes.php");


include('backend_routes.php');


// clear all caches
Route::get('reset/caches', function () {
  Artisan::call('cache:clear');
  Artisan::call('route:clear');
  Artisan::call('config:clear');
  Artisan::call('config:cache');
  Artisan::call('view:clear');
  echo 'all caches cleared';
});