<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'autor') {
    header("Location: login.html");
    exit;
}

// Загружаем все статьи
$jsonFile = __DIR__ . '/uploads/articles.json';
$articles = [];
if (file_exists($jsonFile)) {
    $articles = json_decode(file_get_contents($jsonFile), true);
}

// Фильтруем только статьи текущего автора
$userArticles = array_filter($articles, fn($a) => $a['user_id'] === $_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="cs">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="64x64" href="favicon-64x64.png" />

    <title>GaČas Jihlava</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@400;500;600&display=swap"
      rel="stylesheet"
    />
    <style>
      :root {
        --green: #1f4a3b;
        --green-dark: #0e2921;
        --beige: #c89a5a;
        --bg: #f9f7f3;
        --white: #fff;
        --radius: 14px;
      }

      * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
      }

      body {
        display: flex;
        height: 100vh;
        background: linear-gradient(180deg, #faf8f4 0%, #ffffff 100%);
        font-family: "Poppins", sans-serif;
        color: var(--green-dark);
      }

      /* Sidebar */
      aside {
        width: 250px;
        background: #f3f1ed;
        border-right: 1px solid rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
        padding: 2rem 1.2rem;
      }

      aside h2 {
        font-family: "Playfair Display", serif;
        font-size: 1.4rem;
        color: var(--green);
        margin-bottom: 2.5rem;
        text-align: center;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        padding-bottom: 0.8rem;
      }

      nav a {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        color: var(--green-dark);
        padding: 0.75rem 1rem;
        margin-bottom: 0.3rem;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.25s ease;
      }

      nav a:hover,
      nav a.active {
        background: var(--green);
        color: white;
        transform: translateX(4px);
      }

      /* Header */
      header {
        background: var(--green);
        color: var(--white);
        padding: 1.2rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
      }

      header h1 {
        font-family: "Playfair Display", serif;
        font-size: 1.5rem;
      }

      header nav {
        display: flex;
        gap: 1.5rem;
      }

      header nav a {
        color: var(--white);
        text-decoration: none;
        font-weight: 500;
        transition: 0.3s;
      }

      header nav a:hover {
        text-decoration: underline;
        color: var(--beige);
      }

      /* Main */
      main {
        flex: 1;
        padding: 2rem;
        overflow-y: auto;
      }

      table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
        background: white;
        border-radius: var(--radius);
        overflow: hidden;
      }
      th,
      td {
        text-align: left;
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #ddd;
      }
      th {
        background: var(--bg);
      }
      .status {
        font-weight: 600;
      }
      .status.novy {
        color: #c89a5a;
      }
      .status.recenze {
        color: #1f4a3b;
      }
      .status.prijat {
        color: #4a8c67;
      }
      .status.zamitnut {
        color: #b33a3a;
      }
    </style>
  </head>
  <body>
    <aside>
      <h2>GaČas</h2>
      <nav>
        <a href="autor.php">📊 Dashboard</a>
        <a href="autor-moje-clanky.php" class="active">📝 Moje články</a>
        <a href="autor-profil.php">👤 Profil</a>
      </nav>
    </aside>

    <div style="flex: 1; display: flex; flex-direction: column">
      <header>
        <h1>Autor – GaČas Jihlava</h1>
        <nav>
          <a href="hlavnist.php">Domů</a>
          <a href="clanek.php">Články</a>
          <a href="logout.php">Odhlásit se</a>
        </nav>
      </header>

      <main>
      <h2>📚 Moje články</h2>
     <table>
<thead>
<tr>
<th>Název</th>
<th>Téma</th>
<th>Datum podání</th>
<th>Stav</th>
<th>Poznámka</th>
</tr>
</thead>
<tbody>
<?php if(empty($userArticles)): ?>
<tr><td colspan="5" style="text-align:center;">Žádné články</td></tr>
<?php else: ?>
<?php foreach($userArticles as $a): ?>
<tr>
<td><?= htmlspecialchars($a['title']) ?></td>
<td><?= htmlspecialchars($a['theme']) ?></td>
<td><?= date('j. n. Y', strtotime($a['created'])) ?></td>
<td class="status <?= htmlspecialchars($a['status']) ?>"><?= htmlspecialchars($a['status']) ?></td>
<td><?= htmlspecialchars($a['note']) ?></td>
</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>
</body>
</html>