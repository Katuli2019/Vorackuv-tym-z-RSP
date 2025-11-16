<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo "Chyba: vyplnte prihlasovaci udaje.";
        exit;
    }

    // Получаем id, email, пароль и роль
    $stmt = $conn->prepare("SELECT id, email, password_hash, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        // Редиректы по роли
        if ($user['role'] === 'autor') {
            header("Location: autor.html");
            exit;
        } 
        elseif ($user['role'] === 'redaktor') {
            header("Location: redaktor.html");
            exit;
        } 
        else {
            // fallback – неизвестная роль
            header("Location: main.html");
            exit;
        }

    } else {
        echo "Nespravne uzivatelske jmeno nebo heslo.";
    }

    $stmt->close();
    $conn->close();
}
?>