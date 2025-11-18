<?php
// get_messages.php
$id = intval($_GET['id'] ?? 0);
if ($id <= 0) { echo json_encode([]); exit; }
$file = __DIR__ . "/uploads/chat_{$id}.json";
if (!file_exists($file)) { echo json_encode([]); exit; }
$out = json_decode(file_get_contents($file), true) ?: [];
// вернуть последние N (или все)
echo json_encode($out, JSON_UNESCAPED_UNICODE);