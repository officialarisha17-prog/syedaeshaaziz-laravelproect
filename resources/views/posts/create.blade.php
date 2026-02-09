@extends('layouts.main_layout')

@section('title', 'Create Post')

@section('content')
<div class="container">
    <h1>Create New Post</h1>

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf

        {{-- Title --}}
        <div class="mb-3">
            <label for="title">Title</label>
            <input 
                type="text"
                name="title"
                id="title"
                value="{{ old('title') }}"
                class="form-control"
                placeholder="Enter post title"
            >
            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        {{-- Slug --}}
        <div class="mb-3">
            <label for="slug">Slug</label>
            <input 
                type="text"
                name="slug"
                id="slug"
                value="{{ old('slug') }}"
                class="form-control"
                placeholder="enter-post-slug"
            >
            @error('slug')
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
                placeholder="Write your post content..."
            >{{ old('content') }}</textarea>
            @error('content')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn btn-primary">
            Create Post
        </button>
    </form>
</div>
@endsection