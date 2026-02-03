<!-- Using the layout of main.blade.php -->
@extends('layouts.main')
<!-- adding the title -->
@section('title', 'Events')
<!-- adding the content of the main section -->
@section('content')
<div class="search-bar">
    <input type="text" id="search-input" placeholder="Search events...">
    <button type="button" id="search-button">Search</button>
    <div id="search-results"></div>
</div>
<!-- if user searches events with no title, description or location match -->
@if(empty($events))
<p>No events found.</p>
@else
<div class="events-grid">
    @foreach($events as $event)
    <div class="event-card">
        <div class="event-card-image {{ empty($event['image']) ? 'no-image' : '' }}">
            <!-- if image is kept, show image -->
            @if(!empty($event['image']))
            <img src="/assets/images/{{ $event['image'] }}" alt="{{ $event['title'] }}" loading="lazy">
            @else
            <!-- if no image exists -->
            Event Image
            @endif
        </div>
        <!-- a card of an event consist these data -->
        <div class="event-card-content">
            <h3>{{ $event['title'] }}</h3>
            <p><strong>Date:</strong> {{ $event['date'] }}</p>
            @if(!empty($event['time']))
            <p><strong>Time:</strong> {{ date('H:i', strtotime($event['time'])) }}</p>
            @endif
            <p><strong>Location:</strong> {{ $event['location'] }}</p>
            <p class="event-description">
                {{ strlen($event['description']) > 100 ? substr($event['description'], 0, 100) . '...' : $event['description'] }}
            </p>
        </div>
        <div class="event-card-footer">
            <a href="/event.php?id={{ $event['id'] }}">View Details</a>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection

@section('scripts')
<script src="/assets/js/main.js"></script>
@endsection