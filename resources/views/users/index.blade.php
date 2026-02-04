@extends('layouts.main_layout')
@section('content')
  @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
  @endif

@if(session('success'))
    <div>
        {{ session('success') }}
    </div>
@endif


</table>
      <table class="table table-striped table-bordered">
        <thead class="table-primary">
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $user)
          <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
              <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">Edit</a>
              <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection