<?php
// includes/validation.php

// checks and trims the empty whitespaces
function validate_required($value) {
    return !empty(trim($value));
}

// in-built php function to validate email format
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// checks for minimum required length 
function validate_min_length($value, $min) {
    return strlen(trim($value)) >= $min;
}

// validate whether the date is in Y-m-d format
function validate_date($date) {
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

// validate the timing is within the 24 hour format
function validate_time($time) {
    if (preg_match('/^(?:[01][0-9]|2[0-3]):[0-5][0-9]$/', $time)) {
        return true;
    }
    return false;
}

// prevents xss by url encoding
function sanitize_output($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

// validate if there is any error in registering an account
function validate_registration($name, $email, $password, $confirm_password) {
    $errors = [];
    
    if (!validate_required($name)) {
        $errors[] = "Name is required";
    }
    
    if (!validate_required($email)) {
        $errors[] = "Email is required";
    } elseif (!validate_email($email)) {
        $errors[] = "Invalid email format";
    }
    
    if (!validate_required($password)) {
        $errors[] = "Password is required";
    } elseif (!validate_min_length($password, 6)) {
        $errors[] = "Password must be at least 6 characters";
    }
    
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }
    
    return $errors;
}

// validate if there is any error in events
function validate_event($title, $description, $date, $time, $location) {
    $errors = [];
    
    if (!validate_required($title)) {
        $errors[] = "Title is required";
    }
    
    if (!validate_required($description)) {
        $errors[] = "Description is required";
    }
    
    if (!validate_required($date)) {
        $errors[] = "Date is required";
    } elseif (!validate_date($date)) {
        $errors[] = "Invalid date format";
    }
    
    if (!validate_required($time)) {
        $errors[] = "Time is required";
    } elseif (!validate_time($time)) {
        $errors[] = "Invalid time format. Use 24-hour format (HH:MM), e.g., 09:30 or 14:45";
    }
    
    if (!validate_required($location)) {
        $errors[] = "Location is required";
    }
    
    return $errors;
}