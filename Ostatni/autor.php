<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'autor') {
    header("Location: login.html");
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

    <title>Autor – GaČas Jihlava</title>
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
        border: 1px solid rgba(0, 0, 0, 0.05);
      }

      .card:hover {
        border-color: var(--beige);
      }

      form label {
        display: block;
        font-weight: 600;
        margin-top: 1rem;
        margin-bottom: 0.4rem;
        color: var(--green);
      }

      form input,
      form textarea {
        width: 100%;
        padding: 0.8rem;
        border-radius: 10px;
        border: 1px solid #ccc;
        font-family: inherit;
        background: #fff;
      }

      form input:focus,
      form textarea:focus {
        border-color: var(--beige);
        box-shadow: 0 0 0 2px rgba(200, 154, 90, 0.2);
      }

      button {
        background: var(--beige);
        color: white;
        border: none;
        padding: 0.9rem 1.4rem;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
        margin-top: 1rem;
      }

      button:hover {
        background: #b8824a;
      }

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

      .status.novy {
        color: #c89a5a;
      }

      #preview {
        margin-top: 1rem;
        width: 100%;
        max-width: 300px;
        border-radius: 10px;
        display: none;
      }
    </style>
  </head>

  <body>
    <aside>
      <h2>GaČas</h2>
      <nav>
        <a href="autor.php" class="active">📊 Dashboard</a>
        <a href="autor-moje-clanky.php">📝 Moje články</a>
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
        <div class="welcome">
          <h2>👋 Vítejte zpět, <strong>autore!</strong></h2>
          <p>Zde můžeš spravovat své články a komunikovat s redaktorem.</p>
        </div>

        <div class="cards">
          <div class="card">
            <h3>📝 Nový článek</h3>
             <form id="articleForm" method="POST" action="save_article.php" enctype="multipart/form-data">
            <label for="title">Název článku</label>
            <input type="text" name="title" id="title" required />

            <label for="theme">Téma článku</label>
            <input type="text" name="theme" id="theme" required />

            <label for="autor_name">Jméno autora / Pseudonym</label>
            <input type="text" name="autor_name" id="autor_name" placeholder="Vaše jméno nebo pseudonym" required>


            <label for="keywords">Klíčová slova</label>
            <input type="text" name="keywords" id="keywords" placeholder="gastronomie, recepty" />

            <label for="intro">Anotace</label>
            <textarea name="intro" id="intro" rows="3" placeholder="Krátký úvod článku..."></textarea>

            <label for="content">Text článku</label>
            <textarea name="content" id="content" rows="8" placeholder="Zde vložte celý text článku..."></textarea>

            <label for="image">Hlavní fotografie</label>
            <input type="file" name="image" id="image" accept="image/*" />
            <img id="preview" alt="Náhled obrázku" />

            <label for="file">Přiložit soubor (PDF/DOCX – volitelné)</label>
            <input type="file" name="file" id="file" accept=".pdf,.doc,.docx" />

            <label for="note">Poznámka redakci</label>
            <textarea name="note" id="note" rows="3" placeholder="Doplňující informace..."></textarea>

            <button type="submit">Odeslat článek</button>
          </form>
        </div>
      </div>
    </main>
  </div>

  <script>
    const preview = document.getElementById("preview");
    const imageInput = document.getElementById("image");

    imageInput.addEventListener("change", () => {
      const file = imageInput.files[0];
      if (file) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = "block";
      } else {
        preview.style.display = "none";
      }
    });
  </script>
</body>
</html>