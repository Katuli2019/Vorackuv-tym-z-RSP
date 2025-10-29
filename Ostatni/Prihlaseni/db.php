<?php
$host = "localhost";
$user = "khairosh";
$password = "Tis2025*16799";
$database = "khairosh";

$conn = new mysqli($host, $user, $password, $database);

// Проверка соединения
if ($conn->connect_error) {
    die("Cannot connect: " . $conn->connect_error);
}

// Устанавливаем кодировку (важно для чешских и русских символов)
$conn->set_charset("utf8mb4");
?>