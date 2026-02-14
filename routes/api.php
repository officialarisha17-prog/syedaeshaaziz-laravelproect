<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Post;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('posts', function () {
    $posts = Post::with('user')->latest()->paginate(10);
    return json_encode($posts);
});

// Login API
Route::post('/login', function (Request $request) {

    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if (auth()->attempt([
        'email' => $request->email,
        'password' => $request->password
    ])) {
        return json_encode([
            'success' => true,
            "message" => "You are logged in",
            'data' => [
                'user' => auth()->user(),
                'token' => auth()->user()->createToken('auth_token')->plainTextToken
            ]
        ]);
    }

    return json_encode([
        'success' => false,
        "message" => "Invalid credentials",
    ]);
});

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('posts', function () {
        $posts = Post::with('user')->latest()->paginate(10);
        return json_encode($posts);
    });

    Route::post('posts', function (Request $request) {

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content
        ]);

        if ($post) {
            return json_encode([
                'success' => true,
                "message" => "Post created successfully",
                'data' => $post
            ]);
        }

        return json_encode([
            'success' => false,
            "message" => "Something went wrong",
        ]);
    });
});
Route::get('posts',function(){
        return  Post::with('user')->latest()->paginate(10);
    });
