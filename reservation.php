<?php
// reservation.php

header('Content-Type: application/json');

// Database connection
$host = 'localhost';
$dbname = 'hotel_reservation';
$username = 'root'; // Replace with your MySQL username
$password = '';     // Replace with your MySQL password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $guest_name = $_POST['guest_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $check_in_date = $_POST['check_in_date'] ?? '';
    $check_out_date = $_POST['check_out_date'] ?? '';
    $room_type = $_POST['room_type'] ?? '';

    // Validate input
    if (empty($guest_name) || empty($email) || empty($phone) || empty($check_in_date) || empty($check_out_date) || empty($room_type)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    // Insert data into the database
    $stmt = $pdo->prepare("
        INSERT INTO reservations (guest_name, email, phone, check_in_date, check_out_date, room_type) 
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    if ($stmt->execute([$guest_name, $email, $phone, $check_in_date, $check_out_date, $room_type])) {
        echo json_encode(['success' => true, 'message' => 'Reservation saved successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save reservation.']);
    }
}
?>