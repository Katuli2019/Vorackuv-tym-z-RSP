<?php
$host = "localhost";
$user = "khairosh";
$password = "Tis2025*16799";
$database = "khairosh";

$conn = new mysqli($host, $user, $password, $database);

// �������� ����������
if ($conn->connect_error) {
    die("Cannot connect: " . $conn->connect_error);
}

// ������������� ��������� (����� ��� ������� � ������� ��������)
$conn->set_charset("utf8mb4");
?>