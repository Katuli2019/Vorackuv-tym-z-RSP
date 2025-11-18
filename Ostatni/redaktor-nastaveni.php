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

      .card {
        background: var(--white);
        border-radius: var(--radius);
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04);
        padding: 1.8rem;
        max-width: 700px;
        margin: 0 auto;
        border: 1px solid rgba(0, 0, 0, 0.05);
      }

      h2 {
        font-family: "Playfair Display", serif;
        margin-bottom: 1rem;
        color: var(--green-dark);
      }

      label {
        display: block;
        margin-top: 1rem;
        font-weight: 500;
      }

      input,
      select {
        width: 100%;
        padding: 0.8rem;
        border-radius: 10px;
        border: 1px solid #ccc;
        font-family: inherit;
        margin-top: 0.4rem;
      }

      button {
        margin-top: 1.5rem;
        background: var(--beige);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 0.8rem 1.4rem;
        font-weight: 600;
        cursor: pointer;
        transition: 0.25s;
      }

      button:hover {
        background: #b8824a;
      }
    </style>
  </head>

  <body>
    <aside>
      <h2>Redaktor</h2>
      <nav>
        <a href="redaktor.php">📊 Dashboard</a>
        <a href="redaktor-nastaveni.php" class="active">👤 Profil</a>
      </nav>
    </aside>

    <div style="flex: 1; display: flex; flex-direction: column">
      <header>
        <h1>Nastavení – GaČas Jihlava</h1>
        <nav>
          <a href="hlavnist.php">Domů</a>
          <a href="login.html">Odhlásit se</a>
        </nav>
      </header>

      <main>
        <div class="card">
          <h2>👤 Profil redaktora</h2>
          <label>Jméno</label>
          <input type="text" value="Maksym Pirizhkov" />

          <label>E-mail</label>
          <input type="email" value="redaktor1@vspj.cz" />

          <label>Odborné zaměření</label>
          <input type="text" value="Regionální gastronomie" />

          <label>Notifikace</label>
          <select>
            <option>Všechny zprávy</option>
            <option selected>Jen nové články</option>
            <option>Žádné</option>
          </select>

          <button>💾 Uložit změny</button>
        </div>
      </main>
    </div>
  </body>
</html>
