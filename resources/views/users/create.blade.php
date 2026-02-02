<h1>Users Create</h1>

<form action="{{ route('users.store') }}" method="post">
    @csrf
    <label for="">Name</label>
    <input type="text" name="name" placeholder="Name">
    @error('name')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <label for="">Email</label>
    <input type="email" name="email" placeholder="Email">
    @error('email')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <label for="">Password</label>
    <input type="password" name="password" placeholder="Password">
    @error('password')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <button type="submit">Create</button>
</form>
@extends('layouts.main_layout')

@section('title', 'Create User')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-body">
        <h3 class="card-title mb-4 text-center">Create User</h3>

        <form action="{{ route('users.store') }}" method="post">
          @csrf

          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}">
            @error('name')
              <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
            @error('email')
              <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Password">
            @error('password')
              <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
          </div>

          <div class="d-flex justify-content-between">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-primary">Create</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
@endsection