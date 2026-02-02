<h1>Edit User {{ $user->name }}</h1>
@extends('layouts.main_layout')

<form action="{{ route('users.update', $user) }}" method="post">
    @csrf
    <label for="">Name</label>
    <input type="text" name="name" placeholder="Name" value="{{ $user->name }}">
    @error('name')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <label for="">Email</label>
    <input type="email" name="email" placeholder="Email" value="{{ $user->email }}">
    @error('email')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
@section('title', 'Edit User')

    <button type="submit">Update</button>
</form>
@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-body">
        <h3 class="card-title mb-4 text-center">
          Edit User – {{ $user->name }}
        </h3>

        <form action="{{ route('users.update', $user) }}" method="post">
          @csrf
          @method('PUT')

          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
            @error('name')
              <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
            @error('email')
              <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
          </div>

          <div class="d-flex justify-content-between">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-success">Update</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
@endsection