<?php

function get_blade() {
    $views = __DIR__ . '/../templates';
    $cache = __DIR__ . '/../cache';
    
    if (!file_exists($cache)) {
        mkdir($cache, 0755, true);
    }
    
    return new \Jenssegers\Blade\Blade($views, $cache);
}

// redirects to the required url
function redirect($url) {
    header("Location: $url");
    exit;
}

// get all the events with event table and created by column of users
function get_all_events($pdo) {
    try {
        $stmt = $pdo->prepare("
            SELECT e.*, u.name as creator_name 
            FROM events e 
            JOIN users u ON e.created_by = u.id 
            WHERE e.date >= CURDATE()
            ORDER BY e.date DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

// get a specific event by id
function get_event_by_id($pdo, $id) {
    try {
        $stmt = $pdo->prepare("
            SELECT e.*, u.name as creator_name 
            FROM events e 
            JOIN users u ON e.created_by = u.id 
            WHERE e.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return null;
    }
}

// search feature from title, description or locations
function search_events($pdo, $query) {
    try {
        $search = "%$query%";
        $stmt = $pdo->prepare("
            SELECT e.*, u.name as creator_name 
            FROM events e 
            JOIN users u ON e.created_by = u.id 
            WHERE e.title LIKE ? OR e.description LIKE ? OR e.location LIKE ?
            ORDER BY e.date DESC
        ");
        $stmt->execute([$search, $search, $search]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

// create event, only available for admin panel
function create_event($pdo, $title, $description, $date, $location, $created_by) {
    try {
        $stmt = $pdo->prepare("
            INSERT INTO events (title, description, date, location, created_by) 
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$title, $description, $date, $location, $created_by]);
    } catch (PDOException $e) {
        return false;
    }
}

// update event, only available for admin panel
function update_event($pdo, $id, $title, $description, $date, $location) {
    try {
        $stmt = $pdo->prepare("
            UPDATE events 
            SET title = ?, description = ?, date = ?, location = ? 
            WHERE id = ?
        ");
        return $stmt->execute([$title, $description, $date, $location, $id]);
    } catch (PDOException $e) {
        return false;
    }
}

// delete event, only available for admin panel
function delete_event($pdo, $id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
        return $stmt->execute([$id]);
    } catch (PDOException $e) {
        return false;
    }
}

// check whether a pariticular user is participating in a particular event
function is_user_participating($pdo, $user_id, $event_id) {
    try {
        $stmt = $pdo->prepare("
            SELECT COUNT(*) FROM participations 
            WHERE user_id = ? AND event_id = ?
        ");
        $stmt->execute([$user_id, $event_id]);
        return $stmt->fetchColumn() > 0;
    } catch (PDOException $e) {
        return false;
    }
}

// add the participation of user to a specific event
function add_participation($pdo, $user_id, $event_id) {
    try {
        $stmt = $pdo->prepare("
            INSERT INTO participations (user_id, event_id) 
            VALUES (?, ?)
        ");
        return $stmt->execute([$user_id, $event_id]);
    } catch (PDOException $e) {
        return false;
    }
}

// removes user participation from a specific event
function remove_participation($pdo, $user_id, $event_id) {
    try {
        $stmt = $pdo->prepare("
            DELETE FROM participations 
            WHERE user_id = ? AND event_id = ?
        ");
        return $stmt->execute([$user_id, $event_id]);
    } catch (PDOException $e) {
        return false;
    }
}

// the total participation count for specific id
function get_participation_count($pdo, $event_id) {
    try {
        $stmt = $pdo->prepare("
            SELECT COUNT(*) FROM participations WHERE event_id = ?
        ");
        $stmt->execute([$event_id]);
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        return 0;
    }
}

// for uploading image
function upload_event_image($file) {
    if (empty($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $filename = $file['name'];
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    
    if (!in_array($ext, $allowed)) {
        return null;
    }
    
    $new_filename = uniqid() . '.' . $ext;
    $upload_path = __DIR__ . '/../public/assets/images/' . $new_filename;
    
    if (move_uploaded_file($file['tmp_name'], $upload_path)) {
        return $new_filename;
    }
    
    return null;
}