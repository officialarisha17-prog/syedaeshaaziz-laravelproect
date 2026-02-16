@extends('layouts.main_layout')

@section('title', 'Create Post')

@section('content')
<div class="container">
    <h1>Create New Post</h1>

    <div class="alert alert-success d-none" id="successMessage"></div>
<div class="alert alert-danger d-none" id="errorMessage"></div>
    <!-- <form action="{{ route('posts.store') }}" method="POST"> -->
        <form id= "postForm">
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
                placeholder="Write your post content..."
            >{{ old('content') }}</textarea>
            <!-- @error('content')
                <div class="text-danger">{{ $message }}</div>
            @enderror -->
            <div class="text-danger mt-1 d-none" id="contentError"></div>
        </div>

        {{-- Submit --}}
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
            e.preventDefault(); // stop reload

            let title = $('#title').val();
            let content = $('#content').val();
            let token = $('input[name="_token"]').val();
            let postBtn = $('#postBtn'); 
            postBtn.prop('disabled', true).text('Creating Post...');
            let successMessage = $('#successMessage');
            let errorMessage = $('#errorMessage');

            let titleError = $('#titleError'); 
            let contentError = $('#contentError');

            $.ajax({
                url: "/api/posts",
                type: "POST",
                data: {
                    _token: token,
                    title: title,
                    content: content
                },
                headers: {
                    "Authorization": "Bearer " + "{{ auth()->user()->createToken('auth_token')->plainTextToken }}"
                },
                success: function(response) {
                   

                    if (response.success) {
                        // Show success message
                        successMessage.removeClass('d-none').text(response.message);
                        // clear form
                        $('#title').val('');
                        $('#content').val('');

                        window.location.href = response.page;

                    } else {
                        errorMessage.removeClass('d-none').text(response.message);
                    }
                    postBtn.prop('disabled', false).text('Create Post');
                },
                error: function(xhr) {

                 if(xhr.responseJSON.errors) { 
                        if(xhr.responseJSON.errors.title) {
                             titleError.removeClass('d-none').text(xhr.responseJSON.errors.title[0]); 
                        } 
                        else { 
                            titleError.addClass('d-none').text('');
                        } 
                        if(xhr.responseJSON.errors.content) {
                            contentError.removeClass('d-none').text(xhr.responseJSON.errors.content[0]); 
                        } 
                        else { 
                            contentError.addClass('d-none').text(''); 
                        }
                    } else { 
                            titleError.addClass('d-none').text('');
                            contentError.addClass('d-none').text(''); 
                    }

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        console.log(errors);
                    } else if (xhr.status === 401) {
                        errorMessage.removeClass('d-none').text(xhr.responseJSON.message);
                    }
                    postBtn.prop('disabled', false).text('Create Post');
                }
            });
        });

    });
</script>
@endpush