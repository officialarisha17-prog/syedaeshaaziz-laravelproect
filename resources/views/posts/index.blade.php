@extends('layouts.main_layout')

@section('title', 'List Posts')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Posts</h1>
        <a href="{{ route('posts.create') }}" class="btn btn-primary">
            + Create Post
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="alert alert-success d-none" id="successMessage"></div>

    {{-- Posts Table --}}
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Slug</th>
                <th>Author</th>
                <th>Guard</th>
                <th>Created At</th>
                 <th>Image</th>
                <th width="180">Actions</th>
            </tr>
        </thead>

        <!-- <tbody>
            @forelse($posts as $post)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->slug }}</td>
                    <td>{{ $post->user->name ?? 'N/A' }}</td>
                    <td>{{ $post->guard_used ?? 'N/A' }}</td>
                    <td>{{ $post->created_at->format('d M Y') }}</td>
                    <td>
                      
                    </td>
                    <td>
                    <a href="{{ route('posts.edit', $post) }}" 
                    class="btn btn-sm btn-warning">
                        Edit
                    </a>

                    <form action="{{ route('posts.destroy', $post) }}" 
                        method="POST" 
                        class="d-inline">
                        @csrf
                        @method('DELETE')

                        <button type="submit" 
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure?')">
                            Delete
                        </button>
                    </form>
                </td>

                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">
                        No posts found.
                    </td>
                </tr>
            @endforelse
        </tbody> -->
        <tbody id="postsTableBody">
        </tbody>
    </table>

    {{-- Pagination --}}
      <!-- <div class="mt-3">
        {{ $posts->links() }}
    </div> -->
    <div class="mt-3" id="paginationLinks"></div>

    <!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                Are you sure you want to delete this post?
            </div>

            <div class="modal-footer">
                <button type="button" 
                        class="btn btn-secondary" 
                        data-bs-dismiss="modal">
                    Cancel
                </button>

                <button type="button" 
                        class="btn btn-danger" 
                        id="confirmDeleteBtn">
                    Yes, Delete
                </button>
            </div>

        </div>
    </div>
</div>

</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {

        fetchPosts();

        function fetchPosts(page = 1) {
            $.ajax({
                url: "/api/posts?page=" + page,
                type: "GET",
                headers: {
                    "Authorization": "Bearer " + "{{ auth()->user()->createToken('auth_token')->plainTextToken }}"
                },
                success: function (response) {

                    let rows = '';
                    let index = (response.current_page - 1) * response.per_page;

                    if(response.data.length > 0){
                        $.each(response.data, function (key, post) {
                            index++;

                            rows += `
                                <tr>
                                    <td>${index}</td>
                                    <td>${post.title}</td>
                                    <td>${post.slug}</td>
                                    <td>${post.user ? post.user.name : 'N/A'}</td>
                                    <td>${post.guard_used ?? 'N/A'}</td>
                                    <td>${formatDate(post.created_at)}</td>
                                    <td>
                                        ${post.media.length > 0
                                        ? `<img src="${post.media[0].original_url}" width="60" height="60" style="object-fit:cover;">`
                                        : 'No Image'}
                                    </td>
                                    <td>
                                        <a href="/posts/${post.id}/edit" 
                                        class="btn btn-sm btn-warning">
                                        Edit
                                        </a>

                                        <button 
                                            class="btn btn-sm btn-danger deletePost"
                                            data-id="${post.id}">
                                            Delete
                                        </button>
                                    </td>
                                    
                                </tr>
                                
                            `;
                        });
                    } else {
                        rows = `
                            <tr>
                                <td colspan="7" class="text-center">
                                    No posts found.
                                </td>
                            </tr>
                        `;
                    }

                    $("#postsTableBody").html(rows);

                    buildPagination(response);
                }
            });
        }

        function buildPagination(response) {
            let pagination = '';

            for(let i = 1; i <= response.last_page; i++){
                pagination += `
                    <button class="btn btn-sm ${i == response.current_page ? 'btn-primary' : 'btn-outline-primary'} page-btn"
                            data-page="${i}">
                        ${i}
                    </button>
                `;
            }

            $("#paginationLinks").html(pagination);
        }

        $(document).on("click", ".page-btn", function(){
            let page = $(this).data("page");
            fetchPosts(page);
        });

        function formatDate(dateString) {
            let date = new Date(dateString);
            return date.toLocaleDateString('en-GB', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });
        }
let deletePostId = null;
      $(document).on("click", ".deletePost", function () {
            deletePostId = $(this).data("id");

            let modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        });

    $("#confirmDeleteBtn").on("click", function () {

            if (!deletePostId) return;

            $.ajax({
                url: "/api/posts/" + deletePostId,
                type: "DELETE",
                headers: {
                    "Authorization": "Bearer " + "{{ auth()->user()->createToken('auth_token')->plainTextToken }}"
                },
                success: function (response) {

                    let modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
                    modal.hide();

                    $('#successMessage')
                        .removeClass('d-none')
                        .text(response.message);

                    fetchPosts();
                }
            });
        });

    });
</script>
@endpush