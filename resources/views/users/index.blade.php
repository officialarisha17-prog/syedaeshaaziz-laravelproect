<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}
@extends('layouts.main_layout')

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}
@section('title', 'User List')

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
@section('content')
  @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
  @endif

@if(session('success'))
    <div>
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('auth.logout') }}" method="post">
    @csrf
    <button type="submit">Logout</button>
</form>
  <div class="card shadow-sm">
    <div class="card-body">
      <h2 class="card-title mb-4">Users</h2>

<table>
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
     <th>Actions</th>
  </tr>
  @foreach($users as $user)
  <tr>
    <td>{{ $user->id }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
     <td>
        <a href="{{ route('users.edit', $user) }}">Edit</a>
        <a href="{{ route('users.destroy', $user) }}">Delete</a>
     </td>
  </tr>
  @endforeach
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