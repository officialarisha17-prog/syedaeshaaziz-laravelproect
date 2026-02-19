@extends('layouts.main_layout')

@section('title', 'Create Post')

@section('content')
<div class="container">
    <h1>Create New Post</h1>

    <div class="alert alert-success d-none" id="successMessage"></div>
    <div class="alert alert-danger d-none" id="errorMessage"></div>

    <!-- <form id="postForm"> -->
    <form id="postForm" enctype="multipart/form-data">
        @csrf

        {{-- Title --}}
        <div class="mb-3">
            <label for="title">Title</label>
            <input 
                type="text"
                name="title"
                id="title"
                class="form-control"
                placeholder="Enter post title"
            >
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
                placeholder="Write your post content..."
            ></textarea>
            <div class="text-danger mt-1 d-none" id="contentError"></div>
        </div>

        {{-- Image Field Added --}}
        <div class="mb-3">
            <label for="image">Post Image</label>
            <input 
                type="file"
                name="image"
                id="image"
                class="form-control"
            >
            <div class="text-danger mt-1 d-none" id="imageError"></div>
        </div>

        <button type="submit" id="postBtn" class="btn btn-primary">
            Create Post
        </button>
    </form>
</div>
@endsection


@push('scripts')
<script>
$(document).ready(function() {

    $('#postForm').on('submit', function(e) {
        e.preventDefault();

        let postBtn = $('#postBtn');
        postBtn.prop('disabled', true).text('Creating Post...');

        let successMessage = $('#successMessage');
        let errorMessage = $('#errorMessage');
        let formData = new FormData(this);
        let titleError = $('#titleError');
        let contentError = $('#contentError');
        let imageError = $('#imageError');

        $.ajax({
            url: "/api/posts",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                "Authorization": "Bearer " + "{{ auth()->user()->createToken('auth_token')->plainTextToken }}"
            },
            success: function(response) {

                if (response.success) {
                    successMessage.removeClass('d-none')
                                  .text(response.message);

                    $('#postForm')[0].reset();

                    window.location.href = response.page;
                } else {
                    errorMessage.removeClass('d-none')
                                .text(response.message);
                }

                postBtn.prop('disabled', false).text('Create Post');
            },
            error: function(xhr) {

                if(xhr.responseJSON.errors) {

                    if(xhr.responseJSON.errors.title) {
                        titleError.removeClass('d-none')
                                  .text(xhr.responseJSON.errors.title[0]);
                    } else {
                        titleError.addClass('d-none').text('');
                    }

                    if(xhr.responseJSON.errors.content) {
                        contentError.removeClass('d-none')
                                    .text(xhr.responseJSON.errors.content[0]);
                    } else {
                        contentError.addClass('d-none').text('');
                    }

                    if(xhr.responseJSON.errors.image) {
                        imageError.removeClass('d-none')
                                  .text(xhr.responseJSON.errors.image[0]);
                    } else {
                        imageError.addClass('d-none').text('');
                    }
                }

                postBtn.prop('disabled', false).text('Create Post');
            }
        });

    });

});
</script>
@endpush
