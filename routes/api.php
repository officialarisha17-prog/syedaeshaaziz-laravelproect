<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Post;

//Route::get('/user', function (Request $request) {
  //  return $request->user();
//})->middleware('auth:sanctum');

Route::get('posts',function(){
    $posts = Post::with('user')->latest()->paginate(10);
    return json_encode($posts);
});
