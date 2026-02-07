<?php
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test',[TestController::class,'index'])->name('test.index');

Route ::post('/t',[TestController::class,'store'])->name('test.store');

Route::get('/t/delete/{staff}',[TestController::class,'destroy'])->name('test.destroy');
Route::get('/t/{staff}',[TestController::class,'edit'])->name('test.edit');
Route::post('/t/update/{staff}',[TestController::class,'update'])->name('test.update');


require __DIR__.'/user.php';
require __DIR__.'/auth.php';
require __DIR__.'/auth.php';
require __DIR__.'/post.php';
