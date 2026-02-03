<!-- Using the layout of main.blade.php -->
@extends('layouts.main')
<!-- Use the title as "Register" -->
@section('title', 'Register')

<!-- Main section of the page -->
@section('content')
<div class="auth-wrapper">
    <div class="auth-container">
        <div class="auth-form">
            <h2>Register</h2>

            <!-- if any errors, listed in unordered list -->
            @if(!empty($errors))
            <div class="errors">
                <ul>
                    @foreach($errors as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- If the registration is successful, redirects to login -->
            @if($success)
            <div class="success">
                Registration successful! <a href="/login.php">Login here</a>
            </div>
            @else
            <form method="POST" action="/register.php" style="padding: 0; border: none;">
                <input type="hidden" name="csrf_token" value="{{ $csrf_token }}">
                
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                    <div id="email-error" class="error"></div>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                
                <button type="submit" style="width: 100%;">Register</button>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="/assets/js/main.js"></script>
@endsection