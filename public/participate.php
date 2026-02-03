<?php
// public/participate.php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/validation.php';
require_once __DIR__ . '/../config/db.php';

// 
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('/index.php');
}

$csrf_token = $_POST['csrf_token'] ?? '';
if (!verify_csrf_token($csrf_token)) {
    redirect('/index.php');
}

$event_id = $_POST['event_id'] ?? null;
$action = $_POST['action'] ?? '';

if (!$event_id) {
    redirect('/index.php');
}

$user_id = get_current_user_id();

if ($action === 'join') {
    // check capacity before allowing join
    $event = get_event_by_id($pdo, $event_id);
    $current_count = get_participation_count($pdo, $event_id);
    
    // if capacity is 0 (unlimited) or there is space, allow join
    if ($event['capacity'] == 0 || $current_count < $event['capacity']) {
        add_participation($pdo, $user_id, $event_id);
    }
} elseif ($action === 'cancel') {
    remove_participation($pdo, $user_id, $event_id);
}

redirect("/event.php?id=$event_id");