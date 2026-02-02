<h1>Login</h1>
@extends('layouts.auth_layout')
@section('auth-layout-content')
<h2 class="text-center mb-4">Login</h2>

@if(session('error'))
    <div>
        {{ session('error') }}
    </div>
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<form action="{{ route('auth.store') }}" method="post">
@csrf
   
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
    <button type="submit">Login</button>
</form>

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

    <button type="submit" class="btn btn-primary w-100">Login</button>
</form>

<div class="text-center mt-3">
    <a href="{{ route('register') }}">Don't have an account? Register</a>
</div>
@endsection