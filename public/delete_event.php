<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/validation.php';
require_once __DIR__ . '/../config/db.php';

// requires admin access to delete an event
require_admin();

// if the request method to delete any event is other than POST, redirect to home page
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('/index.php');
}
// verifies to protect from csrf attack
$csrf_token = $_POST['csrf_token'] ?? '';
if (!verify_csrf_token($csrf_token)) {
    redirect('/index.php');
}

// gets the event id
$event_id = $_POST['event_id'] ?? null;

// deletes the event only for admin
if ($event_id) {
    delete_event($pdo, $event_id);
}

// redirects after the deletion of the page
redirect('/index.php');