<?php
// recenze-detail.php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'recenzent') {
    header("Location: login.html");
    exit;
}

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) die("❌ Neplatné id.");

$articlesFile = __DIR__ . '/uploads/articles.json';
if (!file_exists($articlesFile)) die("❌ Soubor článků nenalezen.");

$articles = json_decode(file_get_contents($articlesFile), true) ?: [];
$article = null;
foreach ($articles as $a) { if ((int)$a['id'] === $id) { $article = $a; break; } }
if (!$article) die("❌ Článek nenalezen.");
?>
<!DOCTYPE html>
<html lang="cs">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Detail – <?= htmlspecialchars($article['title']) ?></title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="recenze-detail.css">

</head>
<body>
<aside>
  <h2>Recenzent</h2>
  <nav>
    <a href="recenzent.php">📑 Moje články</a>
    <a href="recenzent-komunikace.php?id=<?= $id ?>">💬 Komunikace</a>
    <a href="logout.php">🚪 Odhlásit se</a>
  </nav>
</aside>

<main>
  <div class="card">
    <h2><?= htmlspecialchars($article['title']) ?></h2>
    <p><strong>Autor:</strong> <?= htmlspecialchars($article['author_name'] ?? '-') ?></p>
    <p><strong>Editor:</strong> <?= htmlspecialchars($article['editor_name'] ?? '-') ?></p>
    <p><strong>Stav:</strong> <?= htmlspecialchars($article['status'] ?? '-') ?></p>
    <hr>
    <p><strong>Anotace:</strong> <?= nl2br(htmlspecialchars($article['intro'] ?? '')) ?></p>
    <p><strong>Obsah (krátce):</strong> <?= nl2br(htmlspecialchars(mb_substr($article['content'] ?? '',0,1000))) ?>...</p>

    <p>
      <?php if (!empty($article['file']) && file_exists($article['file'])): ?>
        <a href="<?= htmlspecialchars($article['file']) ?>" target="_blank"><button class="upload-btn">Stáhnout článek (původní)</button></a>
      <?php else: ?>
        <em>File not found.</em>
      <?php endif; ?>
      <?php if (!empty($article['image']) && file_exists($article['image'])): ?>
        <div style="margin-top:1rem;"><img src="<?= htmlspecialchars($article['image']) ?>" style="max-width:200px;border-radius:8px;border:1px solid #ddd"></div>
      <?php endif; ?>
    </p>
  </div>

  <div class="card" style="margin-top:1rem;">
    <h3>📝 Hodnocení</h3>
    <form action="submit_review.php" method="POST">
      <input type="hidden" name="id" value="<?= $id ?>">
      <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:10px;">
        <div><label>Odborná úroveň</label><select name="expertise"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></div>
        <div><label>Originalita</label><select name="originality"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></div>
        <div><label>Aktuálnost</label><select name="timeliness"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></div>
        <div><label>Struktura</label><select name="structure"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></div>
        <div><label>Jazyk</label><select name="language"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></div>
        <div><label>Celkově</label><select name="overall"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></div>
      </div>
      <div style="margin-top:1rem;">
        <label for="comment">Komentář:</label>
        <textarea id="comment" name="comment" rows="4"></textarea>
      </div>
      <div style="margin-top:1rem;">
        <label for="result">Výsledek recenze</label>
        <select id="result" name="result">
          <option value="">Vyberte výsledek...</option>
          <option value="approve">✅ Schválit k publikaci</option>
          <option value="changes">✏️ Vyžaduje úpravy</option>
          <option value="reject">❌ Zamítnout</option>
        </select>
      </div>
      <button type="submit" class="upload-btn" style="margin-top:1rem;">Odeslat recenzi</button>
    </form>
  </div>
</main>
</body>
</html>
