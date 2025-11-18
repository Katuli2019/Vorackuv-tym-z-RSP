<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'recenzent') {
    header("Location: login.html");
    exit;
}

$id = intval($_POST['id'] ?? 0);
if ($id <= 0) { die("Bad id"); }

$file = __DIR__ . '/uploads/articles.json';
$articles = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

$found = false;
for ($i=0;$i<count($articles);$i++){
    if ((int)$articles[$i]['id'] === $id){
        $found = true;
        $articles[$i]['review'] = [
            'expertise'=>$_POST['expertise']??'',
            'originality'=>$_POST['originality']??'',
            'timeliness'=>$_POST['timeliness']??'',
            'structure'=>$_POST['structure']??'',
            'language'=>$_POST['language']??'',
            'overall'=>$_POST['overall']??'',
            'comment'=>$_POST['comment']??'',
            'result'=>$_POST['result']??'',
            'reviewer_name'=> $_SESSION['username'] ?? ($_SESSION['user_name'] ?? 'Recenzent'),
            'reviewed_at'=> date('Y-m-d H:i:s')
        ];
        // Меняем статус в зависимости от результата
        $res = $_POST['result'] ?? '';
        if ($res === 'approve') $articles[$i]['status'] = 'prijat';
        elseif ($res === 'changes') $articles[$i]['status'] = 'recenze'; // требует правок
        elseif ($res === 'reject') $articles[$i]['status'] = 'zamitnut';
        else $articles[$i]['status'] = $articles[$i]['status'] ?? 'recenze';
        break;
    }
}
if (!$found) die("Article not found");

file_put_contents($file, json_encode($articles, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
header("Location: recenzent.php");
exit;
