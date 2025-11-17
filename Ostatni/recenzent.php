<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'recenzent') {
    header("Location: login.php");
    exit;
}
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
        margin: 0;
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

      .welcome h2 {
        font-family: "Playfair Display", serif;
        font-size: 1.6rem;
        margin-bottom: 0.4rem;
      }

      .cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-top: 1.5rem;
      }

      .card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04);
        padding: 1.6rem;
        transition: all 0.25s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
      }

      .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        border-color: var(--beige);
      }

      .card h3 {
        font-family: "Playfair Display", serif;
        margin-bottom: 0.6rem;
        color: var(--green);
        font-size: 1.1rem;
      }

      .card p {
        color: #4f6b5b;
        font-size: 0.92rem;
        line-height: 1.6;
      }

      /* Table */
      table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
      }

      th,
      td {
        text-align: left;
        padding: 0.75rem;
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

      form input,
      form textarea {
        width: 100%;
        padding: 0.7rem;
        border-radius: 10px;
        border: 1px solid #ccc;
        margin-bottom: 0.8rem;
        font-family: inherit;
      }

      button {
        background: var(--beige);
        color: white;
        border: none;
        padding: 0.8rem 1.2rem;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
      }

      button:hover {
        background: #b8824a;
      }
      .rating-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1rem;
        margin-bottom: 1.2rem;
      }
      .rating-item {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 1rem;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
      }
      .rating-item h4 {
        font-family: "Playfair Display", serif;
        color: #1f4a3b;
        font-size: 1rem;
        margin-bottom: 0.5rem;
      }
      .rating-item select {
        width: 100%;
        padding: 0.6rem;
        border-radius: 8px;
        border: 1px solid #ccc;
        background: #f9f7f3;
      }

      .comment-section,
      .result-section {
        margin-top: 1.2rem;
      }

      .comment-section textarea,
      .result-section select {
        width: 100%;
        padding: 0.8rem;
        border-radius: 10px;
        border: 1px solid #ccc;
        font-family: inherit;
        margin-top: 0.4rem;
      }

      .submit-btn {
        margin-top: 1.5rem;
        background: var(--beige);
        color: white;
        border: none;
        padding: 0.9rem 1.4rem;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
      }

      .submit-btn:hover {
        background: #b8824a;
      }

      .accordion {
    cursor: pointer;
    padding: 1rem;
    background: #e8e5df;
    border-radius: 10px;
    margin-bottom: .6rem;
    font-weight: 600;
    transition: .3s;
}

.accordion:hover {
    background: #d7d3cc;
}

.panel {
    display: none;
    margin-top: .5rem;
}

.panel.open {
    display: block;
}

    </style>
  </head>
  <body>
    <aside>
      <h2>Recenzent</h2>
      <nav>
        <a href="#" class="active">📊 Dashboard</a>
        <a href="recenzent-komunikace.php">💬 Komunikace</a>
        <a href="recenzent-nastaveni.php">👤 Profil</a>
      </nav>
    </aside>
    <div style="flex: 1; display: flex; flex-direction: column">
      <header>
        <h1>Recenzenta – Gastro Časopis Jihlava</h1>
        <nav>
          <a href="hlavnist.php">Domů</a>
          <a href="clanek.html">Články</a>
          <a href="login.php">Odhlásit se</a>
        </nav>
      </header>
      <main>
        <?php foreach ($assigned_articles as $article): ?>

<div class="card">

    <div class="accordion" onclick="togglePanel(<?= $article['id'] ?>)">
        📰 <?= htmlspecialchars($article['title']) ?> — klikni pro otevření
    </div>

    <div class="panel" id="panel-<?= $article['id'] ?>">

        <p><strong>Autor:</strong> <?= $article['author'] ?></p>
        <p><strong>Termín:</strong> <?= $article['deadline'] ?></p>
        <p><strong>Stav:</strong> <?= $article['status'] ?></p>

        <hr>

        <form action="save_review.php" method="POST">

            <input type="hidden" name="article_id" value="<?= $article['id'] ?>">

            <div class="rating-grid">
                <?php 
                $fields = ["Odborná úroveň","Originalita","Aktuálnost tématu","Struktura a logika","Jazyková úroveň","Celkový dojem"];
                foreach ($fields as $field): ?>
                    <div class="rating-item">
                        <h4><?= $field ?></h4>
                        <select name="rating[<?= $field ?>]">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="comment-section">
                <label><strong>Komentář:</strong></label>
                <textarea name="comment" rows="4"></textarea>
            </div>

            <div class="result-section">
                <label><strong>Výsledek:</strong></label>
                <select name="result">
                    <option value="">Vyberte...</option>
                    <option value="accepted">Schválit</option>
                    <option value="revision">Úpravy</option>
                    <option value="rejected">Zamítnout</option>
                </select>
            </div>

            <button class="submit-btn">Odeslat recenzi</button>
        </form>

    </div>
</div>

<?php endforeach; ?>

      </main>
    </div>
    <script>
function togglePanel(id) {
    const panel = document.getElementById("panel-" + id);
    panel.classList.toggle("open");
}
</script>

  </body>
</html>
