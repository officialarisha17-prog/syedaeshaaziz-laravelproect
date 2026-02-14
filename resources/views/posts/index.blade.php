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
                <th width="180">Actions</th>
            </tr>
        </thead>

        <!-- <tbody> -->
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
        <!-- </tbody>
        <tbody id="postsTableBody"> -->
        </tbody>
    </table>

    {{-- Pagination --}}
      <!-- <div class="mt-3"> -->
        {{ $posts->links() }}
    </div>
    <div class="mt-3" id="paginationLinks"></div>
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

    });
</script>
@endpush