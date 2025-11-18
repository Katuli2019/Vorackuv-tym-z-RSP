<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit;
$id = $_POST['id'] ?? '';
$status = $_POST['status'] ?? '';

$file = __DIR__ . '/uploads/articles.json';
if (!file_exists($file)) exit;

$articles = json_decode(file_get_contents($file), true);
foreach ($articles as &$a) {
  if ($a['id'] == $id) {
    $a['status'] = $status;
    break;
  }
}
file_put_contents($file, json_encode($articles, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
