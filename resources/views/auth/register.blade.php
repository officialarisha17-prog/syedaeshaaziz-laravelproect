<h1>Create New Account</h1>
@extends('layouts.auth_layout')
@section('auth-layout-content')
<h2 class="text-center mb-4">Create New Account</h2>

<form action="{{ route('register.store') }}" method="post">
@csrf
    <label for="">Name</label>
    <input type="text" name="name" placeholder="Name" value="{{ old('name') }}">
    @error('name')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <label for="">Email</label>
    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
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

    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ old('name') }}">
        @error('name')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
        @error('email')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
        @error('password')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-success w-100">Create Account</button>
</form>

<div class="text-center mt-3">
    <a href="{{ route('login') }}">Already have an account? Login</a>
</div>
@endsection