<?php
// public/search.php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/validation.php';
require_once __DIR__ . '/../config/db.php';

// starts the php session even if not logged in
start_session_if_needed();

// passess the query typed in the search bar
$query = $_GET['q'] ?? '';
$events = [];

if (!empty($query)) {
    // the function searches according to the title, description, and location
    $events = search_events($pdo, $query);
}

// intializes blade and passes the data to list.blade.php
$blade = get_blade();
echo $blade->render('events.list', [
    'events' => $events,
    'is_logged_in' => is_logged_in(),
    'is_admin' => is_admin(),
    'user_id' => get_current_user_id(),
    'search_query' => $query
]);