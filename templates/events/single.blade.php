<!-- Using the layout of main.blade.php -->
@extends('layouts.main')

<!-- Displaying the event title -->
@section('title', $event['title'])

<!-- Main content begins here -->
@section('content')
<div class="event-detail">

    <div class="event-detail-image {{ empty($event['image']) ? 'no-image' : '' }}">
        <!-- checks if there is any image of the event -->
        @if(!empty($event['image']))
            <img src="/assets/images/{{ $event['image'] }}" alt="{{ $event['title'] }}">
        @else
            <!-- if no image found display the below message -->
            Event Image
        @endif
    </div>

    <h2>{{ $event['title'] }}</h2>

    <div class="info">
        <p><strong>Date:</strong> {{ $event['date'] }}</p>

        @if(!empty($event['time']))
            <p><strong>Time:</strong> {{ date('H:i', strtotime($event['time'])) }}</p>
        @endif

        <p><strong>Location:</strong> {{ $event['location'] }}</p>

        @if($event['capacity'] > 0)
            <p><strong>Capacity:</strong> {{ $participant_count }} / {{ $event['capacity'] }}</p>
        @else
            <p><strong>Participants:</strong> {{ $participant_count }}</p>
        @endif

        @if($event['capacity'] > 0 && $participant_count >= $event['capacity'])
            <p class="event-full">Event is Full</p>
        @endif

        <p><strong>Organized by:</strong> {{ $event['creator_name'] }}</p>
    </div>

    <div class="description">
        <h3>Description</h3>
        <p>{{ $event['description'] }}</p>
    </div>

    <!-- if the user is not logged in, they must login to participate the event -->
    @if(!$is_logged_in)

        <div class="login-prompt">
            <p>
                <a href="/login.php">Login</a> or
                <a href="/register.php">Register</a> to join this event.
            </p>
        </div>

    <!-- if the user is logged in and not admin -->
    @elseif($is_logged_in && !$is_admin)

        <!-- if the user has already joined the event -->
        @if($is_participating)
            <form method="POST" action="/participate.php" style="display: inline-block; padding: 0; border: none; margin: 0;">
                <input type="hidden" name="csrf_token" value="{{ $csrf_token }}">
                <input type="hidden" name="event_id" value="{{ $event['id'] }}">
                <input type="hidden" name="action" value="cancel">
                <button type="submit" class="btn-delete">Cancel Participation</button>
            </form>

        <!-- if the user has not joined the event -->
        @else

            <!-- check if event has unlimited capacity or still has available slots -->
            @if($event['capacity'] == 0 || $participant_count < $event['capacity'])
                <form method="POST" action="/participate.php" style="display: inline-block; padding: 0; border: none; margin: 0;">
                    <input type="hidden" name="csrf_token" value="{{ $csrf_token }}">
                    <input type="hidden" name="event_id" value="{{ $event['id'] }}">
                    <input type="hidden" name="action" value="join">
                    <button type="submit">Join Event</button>
                </form>
            @else
                <!-- if event is full -->
                <button disabled style="background: #999; cursor: not-allowed;">
                    Event Full
                </button>
            @endif

        @endif

    @endif

    <!-- if the user is admin -->
    @if($is_admin)
        <div class="admin-actions">
            <h3>Admin Actions</h3>

            <!-- redirects to the edit, so that the admin can update the field -->
            <a href="/edit_event.php?id={{ $event['id'] }}">
                <button type="button">Edit Event</button>
            </a>

            <!-- delete confirmation pops up if admin clicks delete -->
            <form method="POST"
                  action="/delete_event.php"
                  style="display: inline-block; padding: 0; border: none; margin: 0;"
                  onsubmit="return confirm('Are you sure you want to delete this event?');">

                <input type="hidden" name="csrf_token" value="{{ $csrf_token }}">
                <input type="hidden" name="event_id" value="{{ $event['id'] }}">
                <button type="submit" class="btn-delete">Delete Event</button>
            </form>
        </div>
    @endif

</div>
@endsection
