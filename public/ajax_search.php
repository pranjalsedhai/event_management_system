<?php
// public/ajax_search.php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/validation.php';
require_once __DIR__ . '/../config/db.php';

// for the browser to know the content type
header('Content-Type: application/json');

// get the search value and store in query
$query = $_GET['q'] ?? '';

if (strlen($query) < 2) {
    echo json_encode([]);
    exit;
}

// use the function to search the event
$results = search_events($pdo, $query);

// using higher ordered function to callback and store data in a single variable
$output = array_map(function($event) {
    return [
        'id' => $event['id'],
        'title' => $event['title'],
        'date' => $event['date'],
        'location' => $event['location']
    ];
}, $results);

// making the array json string
echo json_encode($output);