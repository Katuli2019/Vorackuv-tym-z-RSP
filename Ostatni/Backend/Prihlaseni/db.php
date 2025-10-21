<?php
$host = "localhost";
$user = "khairosh";
$password = "Tis2025*16799";
$database = "khairosh";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Spojeni selhalo: " . $conn->connect_error);
}
?>