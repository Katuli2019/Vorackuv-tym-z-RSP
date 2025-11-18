<?php
session_start();

// Только автор
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'autor') {
    header("Location: login.html");
    exit;
}

// Папки для загрузки
$imageDir = __DIR__ . '/uploads/images/';
$fileDir  = __DIR__ . '/uploads/files/';
$jsonFile = __DIR__ . '/uploads/articles.json';

// Создаём папки, если их нет
if (!is_dir($imageDir)) mkdir($imageDir, 0777, true);
if (!is_dir($fileDir)) mkdir($fileDir, 0777, true);

// Проверяем, можем ли писать в папку uploads
if (!is_writable(__DIR__ . '/uploads')) {
    die("❌ Папка uploads недоступна для записи. Проверьте права.");
}

// Получаем данные формы
$title    = $_POST['title'] ?? '';
$theme    = $_POST['theme'] ?? '';
$autorName = $_POST['autor_name'] ?? '';
$keywords = $_POST['keywords'] ?? '';
$intro    = $_POST['intro'] ?? '';
$content  = $_POST['content'] ?? '';
$note     = $_POST['note'] ?? '';
$userId   = $_SESSION['user_id'];



// Загружаем изображение
$imagePath = '';
if (!empty($_FILES['image']['name'])) {
    $imageName = time().'_'.basename($_FILES['image']['name']);
    $imagePath = 'uploads/images/' . $imageName;
    move_uploaded_file($_FILES['image']['tmp_name'], $imageDir . $imageName);
}

// Загружаем файл PDF/DOCX
$filePath = '';
if (!empty($_FILES['file']['name'])) {
    $fileName = time().'_'.basename($_FILES['file']['name']);
    $filePath = 'uploads/files/' . $fileName;
    move_uploaded_file($_FILES['file']['tmp_name'], $fileDir . $fileName);
}

// Создаём JSON файл, если не существует
if (!file_exists($jsonFile)) {
    file_put_contents($jsonFile, json_encode([], JSON_PRETTY_PRINT));
}

// Читаем текущие статьи
$articles = json_decode(file_get_contents($jsonFile), true);

// Добавляем новую статью
$articles[] = [
    'id'       => time(),
    'user_id'  => $userId,
    'title'    => $title,
    'author_name' => $autorName,
    'theme'    => $theme,
    'keywords' => $keywords,
    'intro'    => $intro,
    'content'  => $content,
    'note'     => $note,
    'image'    => $imagePath,
    'file'     => $filePath,
    'status'   => 'novy',
    'created'  => date('Y-m-d H:i:s')
];

// Сохраняем JSON
$result = file_put_contents($jsonFile, json_encode($articles, JSON_PRETTY_PRINT));
if ($result === false) {
    die("❌ Не удалось записать JSON. Проверьте права и путь: $jsonFile");
}

// Перенаправляем обратно на страницу автора
header("Location: autor-moje-clanky.php");
exit;
