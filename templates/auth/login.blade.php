<!-- Using the layout of main.blade.php -->
@extends('layouts.main')
<!-- Using the title 'Login' -->
@section('title', 'Login')
<!-- Main content of the page -->
@section('content')
<div class="auth-wrapper">
    <div class="auth-container">
        <div class="auth-form">
            <h2>Login</h2>
            <!-- if there is any error, list out as unordered list -->
            @if(!empty($errors))
            <div class="errors">
                <ul>
                    @foreach($errors as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            <form method="POST" action="/login.php">
                <input type="hidden" name="csrf_token" value="{{ $csrf_token }}">
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" style="width: 100%;">Login</button>
            </form>
        </div>
    </div>
</div>
@endsection