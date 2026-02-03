<?php
// public/register.php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/validation.php';
require_once __DIR__ . '/../config/db.php';

// starts the php session
start_session_if_needed();

// if already logged in, redirects to home page
if (is_logged_in()) {
    redirect('/index.php');
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf_token = $_POST['csrf_token'] ?? '';
    
    if (!verify_csrf_token($csrf_token)) {
        $errors[] = "Invalid request";
    } else {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';
        
        // validation of credential for registration
        $errors = validate_registration($name, $email, $password, $confirm);
        
        if (empty($errors)) {
            if (email_exists($pdo, $email)) {
                $errors[] = "Email already registered";
            } else {
                if (register_user($pdo, $name, $email, $password)) {
                    $success = true;
                } else {
                    $errors[] = "Registration failed";
                }
            }
        }
    }
}

// initialize blade and pass the data to register.blade.php
$blade = get_blade();
echo $blade->render('auth.register', [
    'errors' => $errors,
    'success' => $success,
    'csrf_token' => generate_csrf_token()
]);