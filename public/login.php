<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/validation.php';
require_once __DIR__ . '/../config/db.php';

// starts the session if not started yet
start_session_if_needed();

// if the user is logged in redirect to index.php
if (is_logged_in()) {
    redirect('/index.php');
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf_token = $_POST['csrf_token'] ?? '';
    
    if (!verify_csrf_token($csrf_token)) {
        $errors[] = "Invalid request";
    } else {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        
        // both the email and password must not be empty
        if (!validate_required($email) || !validate_required($password)) {
            $errors[] = "All fields are required";
        } else {
            // if successfully logged in, redirects to home page
            if (login_user($pdo, $email, $password)) {
                redirect('/index.php');
            } else {
                // if the credential does not match
                $errors[] = "Invalid credentials";
            }
        }
    }
}

// initializes the blade, and passes csrf token
$blade = get_blade();
echo $blade->render('auth.login', [
    'errors' => $errors,
    'csrf_token' => generate_csrf_token()
]);