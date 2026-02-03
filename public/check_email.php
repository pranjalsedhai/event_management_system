<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/validation.php';
require_once __DIR__ . '/../config/db.php';

// for the browser to know the content type
header('Content-Type: application/json');

// get the email
$email = $_GET['email'] ?? '';

// check whether the email field is empty or not
if (empty($email)) {
    echo json_encode(['exists' => false]);
    exit;
}

// check whether the email exists or not
$exists = email_exists($pdo, $email);

// changes the JS to JSON string
echo json_encode(['exists' => $exists]);