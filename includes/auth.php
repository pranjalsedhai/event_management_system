<?php

// checking whether the session is active or not, and starting if no session is active
function start_session_if_needed() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

// returns true or false considering whether the user exist
function is_logged_in() {
    start_session_if_needed();
    return isset($_SESSION['user_id']);
}

// checks the role key then checks whether the role is admin or not
function is_admin() {
    start_session_if_needed();
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

// redirects to login page if not logged in
function require_login() {
    if (!is_logged_in()) {
        redirect('public/login.php');
    }
}

// separation of admin panel, protection for admin page
function require_admin() {
    if (!is_admin()) {
        redirect('public/index.php');
    }
}

// gets the user id using null coalescing operator
function get_current_user_id() {
    start_session_if_needed();
    return $_SESSION['user_id'] ?? null;
}

// this function logs in a user according to their role
function login_user($pdo, $email, $password) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            start_session_if_needed();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            return true;
        }
        return false;
    } catch (PDOException $e) {
        return false;
    }
}

// registers new user and encrypt the password with BCRYPT
function register_user($pdo, $name, $email, $password) {
    try {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("
            INSERT INTO users (name, email, password, role) 
            VALUES (?, ?, ?, 'user')
        ");
        return $stmt->execute([$name, $email, $hashed]);
    } catch (PDOException $e) {
        return false;
    }
}

// backend validation for already existing emails
function email_exists($pdo, $email) {
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    } catch (PDOException $e) {
        return false;
    }
}

// clear sessions variable and invalidates the session
function logout_user() {
    start_session_if_needed();
    session_unset();
    session_destroy();
}