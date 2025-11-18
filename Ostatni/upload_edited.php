<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'redaktor') {
    exit("Access denied");
}

$articleId = $_POST['article_id'] ?? '';
$editor_comment = $_POST['editor_comment'] ?? '';

if (empty($articleId) || empty($_FILES['edited_file']['name'])) {
    exit('No file');
}

$jsonFile = __DIR__ . '/uploads/articles.json';
$articles = json_decode(file_get_contents($jsonFile), true);

// === ULOŽENÍ SOUBORU ===
$uploadDir = __DIR__ . '/uploads/edited/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$filename = time() . "_" . basename($_FILES['edited_file']['name']);
$target_file = $uploadDir . $filename;

move_uploaded_file($_FILES['edited_file']['tmp_name'], $target_file);

// === UPDATE JSON ===
foreach ($articles as &$a) {
    if ($a['id'] == $articleId) {
        $a['edited_file'] = 'uploads/edited/' . $filename;
        $a['editor_comment'] = $editor_comment;   // ← KOMENTÁŘ ULOŽEN
        $a['status'] = 'upraven';                 // ← NOVÝ STAV
        break;
    }
}

file_put_contents($jsonFile, json_encode($articles, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

// === REDIRECT ===
header("Location: redaktor.php?upload=success");
exit;

