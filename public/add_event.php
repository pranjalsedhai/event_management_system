<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/validation.php';
require_once __DIR__ . '/../config/db.php';

// require admin access in order to add events
require_admin();

$errors = [];
$success = false;

// using POST method to create a new event
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf_token = $_POST['csrf_token'] ?? '';
    
    if (!verify_csrf_token($csrf_token)) {
        $errors[] = "Invalid request";
    } else {
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $date = trim($_POST['date'] ?? '');
        $time = trim($_POST['time'] ?? '');
        $location = trim($_POST['location'] ?? '');
        $capacity = intval($_POST['capacity'] ?? 0);
        
        // validate the event
        $errors = validate_event($title, $description, $date, $time, $location);

        if (empty($errors)) {
            $image = null;
            if (!empty($_FILES['image']['name'])) {
                $new_image = upload_event_image($_FILES['image']);
                if ($new_image === null) {
                    $errors[] = "Image upload failed";
                } else {
                    $image = $new_image;
                }
            }
            
            // gets the user id of the admin, as admin can only add event
            $user_id = get_current_user_id();
            
            try {
                $stmt = $pdo->prepare("
                    INSERT INTO events (title, description, date, time, location, capacity, image, created_by) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                ");
                if ($stmt->execute([$title, $description, $date, $time, $location, $capacity, $image, $user_id])) {
                    redirect('/index.php');
                } else {
                    $errors[] = "Failed to create event";
                }
            } catch (PDOException $e) {
                $errors[] = "Failed to create event";
            }
        }
    }
}

// initializes the blade templating engine instance and parses assoc array to add.blade.php
$blade = get_blade();
echo $blade->render('events.add', [
    'errors' => $errors,
    'csrf_token' => generate_csrf_token(),
    'is_logged_in' => true,
    'is_admin' => true
]);