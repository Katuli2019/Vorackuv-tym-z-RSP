<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // �������� ������ �� �����
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // ������� ��������
    if (empty($username) || empty($email) || empty($password)) {
        echo "Chyba: vsechna pole jsou povinna.";
        exit;
    }

    // �������� ������
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // ���������, ���� �� ��� ����� email
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "Tento e-mail je jiz zaregistrovan.";
        exit;
    }

    $check->close();

    // ��������� ������ ������������
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