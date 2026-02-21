@extends('layouts.main_layout')

@section('title', 'Edit Post')

@section('content')
<div class="container">
    <h1>Edit Post</h1>
    <div class="alert alert-success d-none" id="successMessage"></div>
    <div class="alert alert-danger d-none" id="errorMessage"></div>

    <!-- <form action="{{ route('posts.update', $post) }}" method="POST"> -->
        <form id="updatePostForm" enctype="multipart/form-data">
        @csrf
        @method('PUT')
         <input type="hidden" id="post_id" value="{{ $post->id }}">

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
            <!-- @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror -->
            <div class="text-danger mt-1 d-none" id="titleError"></div>
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
            <!-- @error('content')
                <div class="text-danger">{{ $message }}</div>
            @enderror -->
            <div class="text-danger mt-1 d-none" id="contentError"></div>
        </div>

        <button type="submit" id="updateBtn" class="btn btn-success">
            Update Post
        </button>

        <a href="{{ route('posts.index') }}" class="btn btn-secondary">
            Cancel
        </a>
        <div class="mb-3">
    <label for="image">Image</label>
    <input type="file" name="image" id="image" class="form-control">

    <div class="mt-2">
        @if($post->getFirstMediaUrl('post_image'))
            <img src="{{ $post->getFirstMediaUrl('post_image') }}"
                 width="100"
                 style="object-fit:cover;">
        @endif
    </div>

    <div class="text-danger mt-1 d-none" id="imageError"></div>
    </form>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {

    $('#updatePostForm').on('submit', function(e) {
        e.preventDefault();

        let postId = $('#post_id').val();
        let formData = new FormData(this); // IMPORTANT for image upload
        let updateBtn = $('#updateBtn');

        updateBtn.prop('disabled', true).text('Updating Post...');

        $('#titleError').addClass('d-none').text('');
        $('#contentError').addClass('d-none').text('');
        $('#imageError').addClass('d-none').text('');
        $('#errorMessage').addClass('d-none').text('');

        $.ajax({
            url: "/api/posts/" + postId,
            type: "POST", 
            data: formData,
            processData: false,   
            contentType: false,   
            headers: {
                "Authorization": "Bearer {{ auth()->user()->createToken('auth_token')->plainTextToken }}"
            },
            success: function(response) {

                if (response.success) {

                    $('#successMessage')
                        .removeClass('d-none')
                        .text(response.message);

                    setTimeout(function () {
                        window.location.href = "{{ route('posts.index') }}";
                    }, 1000);

                } else {

                    $('#errorMessage')
                        .removeClass('d-none')
                        .text(response.message);
                }

                updateBtn.prop('disabled', false).text('Update Post');
            },
            error: function(xhr) {

                if (xhr.responseJSON && xhr.responseJSON.errors) {

                    if (xhr.responseJSON.errors.title) {
                        $('#titleError')
                            .removeClass('d-none')
                            .text(xhr.responseJSON.errors.title[0]);
                    }

                    if (xhr.responseJSON.errors.content) {
                        $('#contentError')
                            .removeClass('d-none')
                            .text(xhr.responseJSON.errors.content[0]);
                    }

                    if (xhr.responseJSON.errors.image) {
                        $('#imageError')
                            .removeClass('d-none')
                            .text(xhr.responseJSON.errors.image[0]);
                    }
                }

                updateBtn.prop('disabled', false).text('Update Post');
            }
        });
    });

});
</script>
@endpush

