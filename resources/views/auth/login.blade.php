@extends('layouts.auth_layout')
@section('auth-layout-content')
<h2 class="text-center mb-4">Login</h2>

<!-- @if(session('error'))
    </div>
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif -->

<div class="alert alert-success d-none" id="successMessage"></div>
<div class="alert alert-danger d-none" id="errorMessage"></div>

<!-- <form action="{{route('auth.store')}}"method="POST"> -->
    <form id="loginForm">
    @csrf 
<div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
        <!-- @error('email')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror -->
    <div class="text-danger mt-1 d-none" id="emailError"></div>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
        <!-- @error('password')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror -->
    <div class="text-danger mt-1 d-none" id="passwordError"></div>
    </div>

    <button type="submit" id="loginBtn" class="btn btn-primary w-100">Login</button>
</form>

<div class="text-center mt-3">
    <a href="{{ route('register') }}">Don't have an account? Register</a>
</div>
@endsection

@push('scripts')

<script>
    $(document).ready(function() {

        $('#loginForm').on('submit', function(e) {
            e.preventDefault(); // stop reload

            let email = $('#email').val();
            let password = $('#password').val();
            let token = $('input[name="_token"]').val();
            let loginBtn = $('#loginBtn'); 
            loginBtn.prop('disabled', true).text('Logging in...');
            let successMessage = $('#successMessage');
            let errorMessage = $('#errorMessage');

            let emailError = $('#emailError'); 
            let passwordError = $('#passwordError');

            $.ajax({
                url: "/api/login",
                type: "POST",
                data: {
                    _token: token,
                    email: email,
                    password: password
                },
                success: function(response) {
                   

                    if (response.success) {

                        // Optional: store token
                        localStorage.setItem('auth_token', response.data.token);
                        // Show success message
                        successMessage.removeClass('d-none').text(response.message);
                        // Redirect
                        window.location.href = response.page;

                    } else {
                        errorMessage.removeClass('d-none').text(response.message);
                    }
                    loginBtn.prop('disabled', false).text('Login');
                },
                error: function(xhr) {

                 if(xhr.responseJSON.errors) { 
                        if(xhr.responseJSON.errors.email) {
                             emailError.removeClass('d-none').text(xhr.responseJSON.errors.email[0]); 
                        } 
                        else { 
                            emailError.addClass('d-none').text('');
                        } 
                        if(xhr.responseJSON.errors.password) {
                            passwordError.removeClass('d-none').text(xhr.responseJSON.errors.password[0]); 
                        } 
                        else { 
                            passwordError.addClass('d-none').text(''); 
                        }
                    } else { 
                            emailError.addClass('d-none').text('');
                            passwordError.addClass('d-none').text(''); 
                    }

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        console.log(errors);
                    } else if (xhr.status === 401) {
                        errorMessage.removeClass('d-none').text(xhr.responseJSON.message);
                    }
                    loginBtn.prop('disabled', false).text('Login');
                }
            });
        });

    });
</script>
@endpush
