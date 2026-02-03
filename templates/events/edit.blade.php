<!-- Using the layout of main.blade.php -->
@extends('layouts.main')
<!-- adding the title -->
@section('title', 'Edit Event')
<!-- adding the content of the main section -->
@section('content')
<div class="form-wrapper">
    <div class="form-container">
        <h2>Edit Event</h2>
        <!-- check if there is any error while adding an event -->  
        @if(!empty($errors))
        <div class="errors">
            <ul>
                 <!-- display the error in unordered list -->
                @foreach($errors as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="/edit_event.php?id={{ $event['id'] }}" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="{{ $csrf_token }}">
            
            <div class="form-group">
                <label for="title">Event Title</label>
                <input type="text" id="title" name="title" value="{{ $event['title'] }}" required>
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" required>{{ $event['description'] }}</textarea>
            </div>
            
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" id="date" name="date" value="{{ $event['date'] }}" required>
            </div>
            
            <div class="form-group">
                <label for="time">Time</label>
                <input type="time" name="time" id="time" value="{{ substr($event['time'], 0, 5) }}" required>
            </div>
            
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" value="{{ $event['location'] }}" required>
            </div>

            <div class="form-group">
                <label for="capacity">Maximum Participants</label>
                <input type="number" id="capacity" name="capacity" min="0" value="{{ $event['capacity'] ?? 0 }}">
            </div>
            
            <div class="form-group">
                <label for="image">Event Image (optional)</label>
                <!-- If the image exist, shows the image name -->
                @if(!empty($event['image']))
                <p>Current: {{ $event['image'] }}</p>
                @endif
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            
            <button type="submit" style="width: 100%;">Update Event</button>
        </form>
    </div>
</div>
@endsection