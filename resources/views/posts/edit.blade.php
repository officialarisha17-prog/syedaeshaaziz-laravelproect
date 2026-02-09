@extends('layouts.main_layout')

@section('title', 'Edit Post')

@section('content')
<div class="container">
    <h1>Edit Post</h1>

    <form action="{{ route('posts.update', $post) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div class="mb-3">
            <label for="title">Title</label>
            <input 
                type="text"
                name="title"
                id="title"
                class="form-control"
                value="{{ old('title', $post->title) }}"
            >
            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

     

        {{-- Content --}}
        <div class="mb-3">
            <label for="content">Content</label>
            <textarea 
                name="content"
                id="content"
                rows="6"
                class="form-control"
            >{{ old('content', $post->content) }}</textarea>
            @error('content')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">
            Update Post
        </button>

        <a href="{{ route('posts.index') }}" class="btn btn-secondary">
            Cancel
        </a>
    </form>
</div>
@endsection