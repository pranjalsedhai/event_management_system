<?php
// public/index.php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/validation.php';
require_once __DIR__ . '/../config/db.php';

// if no session exists, start session
start_session_if_needed();

// get all events, with user if logged in or admin
$events = get_all_events($pdo);
$is_logged = is_logged_in();
$is_admin_user = is_admin();
$user_id = get_current_user_id();

// initializes blade and passes to list.blade.php
$blade = get_blade();
echo $blade->render('events.list', [
    'events' => $events,
    'is_logged_in' => $is_logged,
    'is_admin' => $is_admin_user,
    'user_id' => $user_id
]);