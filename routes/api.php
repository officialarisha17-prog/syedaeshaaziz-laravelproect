<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;


Route::get('/user', function (Request $request) {
return $request->user();
})->middleware('auth:sanctum');

// Login API
Route::middleware(['web'])->post('/login', function (Request $request) {
// $request->validate([
//     'email' => 'required|email',
//     'password' => 'required'
// ]);

    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'errors' => $validator->errors()
        ], 422);
    }

    if(auth()->attempt(['email' => $request->email,'password' => $request->password])){
        $request->session()->regenerate(); 
            return response()->json([
                'success' => true,
                "message" => "You are logged in",
                'data' => [
                    'user' => auth()->user(),
                    'token' => auth()->user()->createToken('auth_token')->plainTextToken
                ],
                'page' => route('users.index')
            ]);
        }
        return response()->json([
            'success' => false,
            "message" => "Invalid credentials"
        ],401);

});

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('posts',function(StorePostRequest $request){
        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content
        ]);
        if ($request->hasFile('image')) {
        $post->addMediaFromRequest('image')
             ->toMediaCollection('post_image');
    }

        if($post){
            return response()->json([
                'success' => true,
                "message" => "Post created successfully",
                'data' => $post,
                'page' => route('posts.index')
            ]);
        }
        return response()->json([
            'success' => false,
            "message" => "Something went wrong",
        ], 422);
    });

    Route::put('posts/{post}',function(UpdatePostRequest $request, Post $post){
        if(!$post){
            return response()->json([
                'success' => false,
                "message" => "Post not found",
            ], 404);
        }
        $post->title = $request->title;
        $post->content = $request->content;

        if ($request->hasFile('image')) {

    $post->clearMediaCollection('post_image');

    $post->addMediaFromRequest('image')
         ->toMediaCollection('post_image');
}

        if($post->save()){
            return response()->json([
                'success' => true,
                "message" => "Post updated successfully",
                'data' => $post
            ]);
        }
        return response()->json([
            'success' => false,
            "message" => "Something went wrong",
        ], 422);
    });

    Route::delete('posts/{post}',function(Post $post){
        if(!$post){
            return response()->json([
                'success' => false,
                "message" => "Post not found",
            ], 404);
        }
        if($post->delete()){
            return response()->json([
                'success' => true,
                "message" => "Post deleted successfully",
            ]);
        }
        return response()->json([
            'success' => false,
            "message" => "Something went wrong",
        ], 422);
});
});


 Route::get('posts', function () {
    return Post::with(['user','media'])->latest()->paginate(10);
});