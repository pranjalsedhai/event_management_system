<?php
// public/event.php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/validation.php';
require_once __DIR__ . '/../config/db.php';

// starting the php session
start_session_if_needed();

// get the event id
$event_id = $_GET['id'] ?? null;

// if no particular event id is found, redirect to home page
if (!$event_id) {
    redirect('/index.php');
}

// get each event by id
$event = get_event_by_id($pdo, $event_id);
$today = date('Y-m-d');
if ($event['date'] < $today) {
    redirect('/index.php');
}

// if the event does not exist, redirect to home page
if (!$event) {
    redirect('/index.php');
}

// get the user id of the current user
$user_id = get_current_user_id();
// keep the participation false by default
$is_participating = false;


if ($user_id) {
    // stores boolean value if participating
    $is_participating = is_user_participating($pdo, $user_id, $event_id);
}

// stores the participation count for each event
$participant_count = get_participation_count($pdo, $event_id);

// initializes blade and passes the data to single.blade.php
$blade = get_blade();
echo $blade->render('events.single', [
    'event' => $event,
    'is_logged_in' => is_logged_in(),
    'is_admin' => is_admin(),
    'is_participating' => $is_participating,
    'participant_count' => $participant_count,
    'csrf_token' => generate_csrf_token()
]);