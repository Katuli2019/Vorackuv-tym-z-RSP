<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'redaktor') {
    header("Location: login.html");
    exit;
}


// ✅ Путь к общему файлу (проверь, что uploads лежит в общем каталоге на сервере)
$jsonFile = __DIR__ . '/uploads/articles.json';
$articles = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];

// ✅ Список рецензентов (в будущем можно брать из users.json)
$reviewers = ['Iryna Rusa', 'Oleh Yanovskyi', '—'];
?>

<!DOCTYPE html>
<html lang="cs">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="64x64" href="favicon-64x64.png" />

    <title>GaČas Jihlava – Redaktor</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />

    <style>
      :root {
        --green: #1f4a3b;
        --green-dark: #0e2921;
        --beige: #c89a5a;
        --bg: #f9f7f3;
        --white: #fff;
        --radius: 14px;
      }

      * { box-sizing: border-box; margin: 0; padding: 0; }

      body {
        display: flex;
        height: 100vh;
        background: linear-gradient(180deg, #faf8f4 0%, #ffffff 100%);
        font-family: "Poppins", sans-serif;
        color: var(--green-dark);
      }

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

      /* === ИСПРАВЛЕНИЕ 1: Стиль применен только к ASIDE NAV === */
      aside nav a {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        color: var(--green-dark);
        padding: 0.75rem 1rem;
        margin-bottom: 0.3rem;
        border-radius: 10px;
        font-weight: 500;
        transition: 0.25s;
      }

      aside nav a:hover, 
      aside nav a.active {
        background: var(--green);
        color: white;
        transform: translateX(4px);
      }

      header {
        background: var(--green);
        color: white;
        padding: 1.2rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
      }

      /* === ИСПРАВЛЕНИЕ 2: Добавлены стили для HEADER NAV === */
      header nav a {
        text-decoration: none;
        color: white;
        font-weight: 500;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        transition: background 0.25s;
        margin-left: 0.5rem;
      }
      header nav a:hover {
        background: rgba(255, 255, 255, 0.15);
      }
      /* ============================================== */

      main { flex: 1; padding: 2rem; overflow-y: auto; }

      .welcome h2 {
        font-family: "Playfair Display", serif;
        font-size: 1.6rem;
        margin-bottom: .4rem;
      }
      .welcome-text {
        margin-top: 0.6rem;
        padding: 1rem 1.4rem;
        background: #ffffff;
        border-left: 4px solid var(--beige);
        border-radius: 10px;
        line-height: 1.55;
        font-size: 0.96rem;
        color: #374c42;
      }


      /* TABULKA */
      table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
        background: white;
        border-radius: var(--radius);
        overflow: hidden;
      }

      th, td {
        text-align: left;
        padding: 0.9rem 1rem;
        border-bottom: 1px solid #e6e6e6;
      }

      th { background: var(--bg); }

      tr:hover { background: #faf7f2; }

      .status {
        display: inline-block;
        font-weight: 600;
        padding: 0.4rem 0.9rem;
        border-radius: 12px;
        color: white;
        min-width: 90px;
        text-align: center;
      }

      .status.novy { background: #c89a5a; }
      .status.recenze { background: #1f4a3b; }
      .status.prijat { background: #4a8c67; }
      .status.zamitnut { background: #b33a3a; }
      .status.upraven { background: #073f01ff; }


      .thumb {
        width: 70px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #ddd;
      }

      .view-btn {
        background: none;
        border: 1px solid var(--beige);
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        cursor: pointer;
      }

      /* === UPLOAD BOX === */
      .upload-box {
        margin-top: 2rem;
        background: white;
        padding: 2rem;
        border-radius: var(--radius);
        border-left: 6px solid var(--beige);
        box-shadow: 0 4px 14px rgba(0,0,0,0.05);
      }

      .upload-box h2 {
        font-family: "Playfair Display", serif;
        font-size: 1.4rem;
        margin-bottom: 1rem;
        color: var(--green);
      }

      .upload-description {
        color: #4f6b5b;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
      }

      .upload-form label {
        display: block;
        font-weight: 600;
        margin-top: 1rem;
        margin-bottom: 0.4rem;
      }

      .upload-form select,
      .upload-form input[type="file"] {
        width: 100%;
        padding: 0.7rem;
        border-radius: 10px;
        border: 1px solid #ccc;
        background: white;
      }

      .upload-form button {
        margin-top: 1rem;
        background: var(--green);
        color: white;
        border: none;
        padding: 0.9rem 1.4rem;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
      }

      .upload-success {
        margin-top: 1rem;
        color: #4a8c67;
      }
      .status-btn {
        background: var(--beige);
        border: 1px solid var(--beige);
        color: var(--white);
        padding: 0.45rem 1.1rem;
        font-size: 0.85rem;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.25s ease;
      }

      .status-btn:hover {
        background: var(--green);
        border-color: var(--green);
        color: var(--white);
        transform: translateY(-2px);
      }

    </style>
  </head>

  <body>
    <aside>
      <h2>Redaktor</h2>
      <nav>
        <a href="redaktor.php" class="active">📊 Dashboard</a>
        <a href="redaktor-nastaveni.php">👤 Profil</a>
      </nav>
    </aside>

    <div style="flex:1; display:flex; flex-direction:column;">
      <header>
        <h1>Redaktor – GaČas Jihlava</h1>
        <nav>
          <a href="hlavnist.php">Domů</a>
          <a href="logout.php">Odhlásit se</a>
        </nav>
      </header>

      <main>
        <div class="welcome">
          <h2>👋 Vítejte zpět, redaktore!</h2>
           <p class="welcome-text">
    Zde můžete spravovat články, úpravy a komunikaci s autory. <br>
    Sledujte stav recenzí, aktualizuj článek a nahrávejte finální verze.
  </p>
        </div>

        <div class="card">
          <h2>📑 Seznam článků</h2>

          <table>
            <thead>
              <tr>
                <th>Název</th>
                <th>Foto</th>
                <th>Autor</th>
                <th>Článek</th>
                <th>Recenzent</th>
                <th>Stav</th>
                <th>Akce</th>
              </tr>
            </thead>

             <tbody>
              <?php foreach ($articles as $a): ?>
          <tr data-id="<?= $a['id'] ?>">
            <td><?= htmlspecialchars($a['title']) ?></td>

            <td>
              <?php if (!empty($a['image']) && file_exists($a['image'])): ?>
                <img src="<?= $a['image'] ?>" class="thumb">
              <?php endif; ?>
            </td>

            <td><?= htmlspecialchars($a['author_name'] ?? 'Autor neznámý') ?></td>

            <td>
              <?php if (!empty($a['file'])): ?>
                <button class="view-btn" onclick="window.open('<?= $a['file'] ?>')">Zobrazit</button>
              <?php else: ?> — <?php endif; ?>
            </td>

            <td>
              <select onchange="updateReviewer(<?= $a['id'] ?>, this.value)">
                <?php foreach($reviewers as $r): ?>
                  <option <?= (($a['reviewer'] ?? '') == $r) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($r) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </td>
            

            <td><span class="status <?= $a['status'] ?>"><?= htmlspecialchars($a['status']) ?></span></td>

            <td>
              <button class="status-btn" onclick="changeStatus(<?= $a['id'] ?>, this)">Změnit stav</button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
          </table>
        </div>

        <div class="upload-box">
    <h2>📤 Nahrát upravený článek</h2>
    <p class="upload-description">Nahraj sem upravenou nebo finální verzi článku po editaci.</p>

    <form class="upload-form" action="upload_edited.php" method="POST" enctype="multipart/form-data">
      <label>Vyber článek</label>
      <select name="article_id" required>
        <option value="">— Vyber článek —</option>
        <?php foreach($articles as $a): ?>
          <option value="<?= $a['id'] ?>">
            <?= htmlspecialchars($a['title']) ?> (<?= htmlspecialchars($a['author_name']) ?>)
          </option>
        <?php endforeach; ?>
      </select>

      <label>Upravený soubor (PDF/DOCX)</label>
      <input type="file" name="edited_file" accept=".pdf,.doc,.docx" required>
<label>Komentář pro autora</label>
<textarea name="editor_comment" rows="4" placeholder="Popište změny, které byly provedeny…" style="
  width: 100%;
  padding: 0.8rem;
  border-radius: 10px;
  border: 1px solid #ccc;
  resize: vertical;
"></textarea>

      <button type="submit">Nahrát verzi</button>

      <?php if (isset($_GET['upload']) && $_GET['upload'] == 'success'): ?>
        <p class="upload-success">✅ Soubor byl úspěšně nahrán.</p>
      <?php endif; ?>
    </form>
  </div>
</main>
</div>

<script>
function changeStatus(id, button) {
  const row = button.closest("tr");
  const statusEl = row.querySelector(".status");
  let status = statusEl.textContent.trim();

  let newStatus = "novy";
  if (status === "novy") newStatus = "recenze";
  else if (status === "recenze") newStatus = "prijat";
  else if (status === "prijat") newStatus = "zamitnut";
  else newStatus = "novy";

  fetch("update_status.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "id=" + id + "&status=" + newStatus
  }).then(() => {
    statusEl.textContent = newStatus;
    statusEl.className = "status " + newStatus;
  });
}

function updateReviewer(id, reviewer) {
  fetch("update_reviewer.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "id=" + id + "&reviewer=" + encodeURIComponent(reviewer)
  });
}
    </script>

  </body>
</html>