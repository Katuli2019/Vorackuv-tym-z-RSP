<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Простая проверка
    if (empty($username) || empty($email) || empty($password)) {
        echo "Chyba: vsechna pole jsou povinna.";
        exit;
    }

    // Хешируем пароль
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Проверяем, есть ли уже такой email
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "Tento e-mail je jiz zaregistrovan.";
        exit;
    }

    $check->close();

    // Вставляем нового пользователя
    $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $passwordHash);

    if ($stmt->execute()) {
        echo "Uspesna registrace";
    } else {
        echo "Chyba pri registraci: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>