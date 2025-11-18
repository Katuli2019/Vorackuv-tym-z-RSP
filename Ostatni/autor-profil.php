<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db.php';

// Проверка авторизации
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'autor') {
    header("Location: login.html");
    exit;
}

$user_id = $_SESSION['user_id'];

// Обработка POST-запроса (AJAX)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $city = trim($_POST['city']);
    $country = trim($_POST['country']);

    if (!empty($password)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET email=?, password_hash=?, city=?, country=? WHERE id=?");
        $stmt->bind_param("ssssi", $email, $password_hash, $city, $country, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET email=?, city=?, country=? WHERE id=?");
        $stmt->bind_param("sssi", $email, $city, $country, $user_id);
    }

    $stmt->execute();
    $stmt->close();

    // AJAX-запрос — просто возвращаем пустой ответ
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        echo 'ok';
        exit;
    }

    // Для обычного POST редирект не нужен
    header("Location: autor-profil.php");
    exit;
}

// Получаем данные автора из базы
$stmt = $conn->prepare("SELECT username, email, city, country FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
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

      .card {
        background: white;
        border-radius: var(--radius);
        padding: 2rem;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04);
        max-width: 600px;
        margin: auto;
      }
      input,
      textarea {
        width: 100%;
        padding: 0.7rem;
        border-radius: 10px;
        border: 1px solid #ccc;
        margin-bottom: 1rem;
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
    </style>
  </head>

  <body>
    <aside>
      <h2>GaČas</h2>
      <nav>
        <a href="autor.php">📊 Dashboard</a>
        <a href="autor-moje-clanky.php">📝 Moje články</a>
        <a href="autor-profil.php" class="active">👤 Profil</a>
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
  <div class="card">
    <h2>Osobní údaje</h2>
    <form id="profileForm">
      <label>Uživatelské jméno</label>
      <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" readonly />
      <label>Email</label>
      <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required />
      <label>Heslo</label>
      <input type="password" name="password" placeholder="Změnit heslo" />
      <label>Město</label>
      <input type="text" name="city" value="<?= htmlspecialchars($user['city'] ?? '') ?>" />
      <label>Země</label>
      <input type="text" name="country" value="<?= htmlspecialchars($user['country'] ?? '') ?>" />
      <button type="submit">Uložit změny</button>
    </form>
    <div id="message"></div>
  </div>
</main>
</div>

<script>
const form = document.getElementById('profileForm');
const message = document.getElementById('message');

form.addEventListener('submit', function(e) {
  e.preventDefault();

  const formData = new FormData(form);

  fetch('autor-profil.php', {
    method: 'POST',
    body: formData,
    headers: {
      'X-Requested-With': 'XMLHttpRequest'
    }
  })
  .then(response => response.text())
  .then(data => {
    message.style.color = 'green';
    message.textContent = 'Data byla úspěšně aktualizována!';
  })
  .catch(error => {
    message.style.color = 'red';
    message.textContent = 'Chyba při aktualizaci dat.';
    console.error(error);
  });
});
</script>

</body>
</html>