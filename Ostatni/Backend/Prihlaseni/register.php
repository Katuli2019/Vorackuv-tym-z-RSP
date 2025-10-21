<?php
include 'db.php';

$login = $_POST['login'];
$password = $_POST['password'];

$stmt = $conn->prepare("INSERT INTO prihlaseni (login, password) VALUES (?, ?);");
$stmt->bind_param("sii", $login, $password);
$stmt->execute();

//header("Location: main.php");
exit;