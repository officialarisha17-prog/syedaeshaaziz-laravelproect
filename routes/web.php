<?php
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test',[TestController::class,'index']);

Route ::post('/t',[TestController::class,'store'])->name('test.store');

Route::get('/t/{staff}',[TestController::class,'destroy'])->name('test.destroy');