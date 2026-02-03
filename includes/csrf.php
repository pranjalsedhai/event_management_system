<?php

// generates a random csrf token
function generate_csrf_token() {
    start_session_if_needed();
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// checks whether the user passed tokens matches with the server generated tokens
function verify_csrf_token($token) {
    start_session_if_needed();
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}