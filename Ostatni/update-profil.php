<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'autor') {
    header("Location: login.html");
    exit;
}

$user_id = $_SESSION['user_id'];

$email = trim($_POST['email']);
$password = trim($_POST['password']);
$city = trim($_POST['city']);
$country = trim($_POST['country']);

if (!empty($password)) {
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET email=?, password_hash=?, city=?, country=? WHERE id=?");
    $stmt->bind_param("ssssi", $email, $password_hash, $city, $country, $user_id);
} else {
    $stmt = $conn->prepare("UPDATE users SET email=?, city=?, country=? WHERE id=?");
    $stmt->bind_param("sssi", $email, $city, $country, $user_id);
}

$stmt->execute();
$stmt->close();

header("Location: autor-profil.php?success=1");
exit;