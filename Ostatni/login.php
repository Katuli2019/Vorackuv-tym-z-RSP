<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, password_hash, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password_hash'])) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['username'] = $user['username'];


        if ($user['role'] === 'autor') {
            header("Location: autor.php");
            exit;
        } elseif ($user['role'] === 'redaktor') {
            header("Location: redaktor.php");
            exit;
        } elseif ($user['role'] === 'recenzent') {
            header("Location: recenzent.php");
            exit;
        } elseif ($user['role'] === 'admin') {
            header("Location: admin.php");
            exit;
        }

    } else {
        echo "<script>alert('Nesprávný email nebo heslo.'); history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>