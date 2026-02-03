<?php
// public/edit_event.php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/validation.php';
require_once __DIR__ . '/../config/db.php';

// require admin role to perform edit event
require_admin();

// get the event id
$event_id = $_GET['id'] ?? null;

// if event id does not exist redirect to home page
if (!$event_id) {
    redirect('/index.php');
}

// get a specific event to edit the data
$event = get_event_by_id($pdo, $event_id);

// if event does not exist return to home page
if (!$event) {
    redirect('/index.php');
}

$errors = [];

// POST method to update the data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf_token = $_POST['csrf_token'] ?? '';
    
    // verify csrf token
    if (!verify_csrf_token($csrf_token)) {
        $errors[] = "Invalid request";
    } else {
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $date = trim($_POST['date'] ?? '');
        $time = trim($_POST['time'] ?? '');
        $location = trim($_POST['location'] ?? '');
        $capacity = intval($_POST['capacity'] ?? 0);
        
        // check whether there is any error while editing the event
        $errors = validate_event($title, $description, $date, $time, $location);
                
        // if there is no error proceed with the image if any
        if (empty($errors)) {
            $image = $event['image'];
            if (!empty($_FILES['image']['name'])) {
                $new_image = upload_event_image($_FILES['image']);
                if ($new_image) {
                    $image = $new_image;
                }
            }
            
            // handle the errors and update the contents of the event
            try {
                $stmt = $pdo->prepare("
                    UPDATE events 
                    SET title = ?, description = ?, date = ?, time = ?, location = ?, capacity = ?, image = ? 
                    WHERE id = ?
                ");
                if ($stmt->execute([$title, $description, $date, $time, $location, $capacity, $image, $event_id])) {
                    redirect('/index.php');
                } else {
                    $errors[] = "Failed to update event";
                }
            } catch (PDOException $e) {
                $errors[] = "Failed to update event";
            }
        }
    }
}

// initializing blade instance and passing the data to edit.blade.php
$blade = get_blade();
echo $blade->render('events.edit', [
    'event' => $event,
    'errors' => $errors,
    'csrf_token' => generate_csrf_token(),
    'is_logged_in' => true,
    'is_admin' => true
]);