<?php
// save_message.php
session_start();
$id = intval($_POST['id'] ?? $_POST['article_id'] ?? 0);
$text = trim($_POST['text'] ?? '');
if ($id <= 0 || $text === '') { echo json_encode(['ok'=>false]); exit; }

$role = $_SESSION['role'] ?? 'guest';
$name = $_SESSION['username'] ?? ($_SESSION['user_name'] ?? ('User' . ($_SESSION['user_id'] ?? '')));

$file = __DIR__ . "/uploads/chat_{$id}.json";
if (!file_exists($file)) file_put_contents($file, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

$messages = json_decode(file_get_contents($file), true) ?: [];
$messages[] = [
  'sender_role' => $role,
  'sender_name' => $name,
  'text' => $text,
  'time' => date('Y-m-d H:i:s')
];
file_put_contents($file, json_encode($messages, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo json_encode(['ok' => true]);
