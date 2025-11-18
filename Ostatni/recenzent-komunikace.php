<?php
// recenzent-komunikace.php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'recenzent') {
    header("Location: login.html");
    exit;
}

$article_id = intval($_GET['id'] ?? 0);
if ($article_id <= 0) {
    die("❌ Neplatné article_id.");
}

$articlesFile = __DIR__ . '/uploads/articles.json';
$article = null;
if (file_exists($articlesFile)) {
    $all = json_decode(file_get_contents($articlesFile), true) ?: [];
    foreach ($all as $a) {
        if ((int)($a['id'] ?? 0) === $article_id) { $article = $a; break; }
    }
}
if (!$article) die("❌ Článek nenalezen.");

// проверка принадлежности рецензенту (если нужно)
$currentReviewer = $_SESSION['username'] ?? '';
if (!empty($article['reviewer']) && $article['reviewer'] !== '—') {
    if ($article['reviewer'] !== $currentReviewer && $currentReviewer !== 'admin') {
        die("❌ Tento článek není přiřazen vám.");
    }
}

// создаём файл чата (если нет)
$chatFile = __DIR__ . "/uploads/chat_{$article_id}.json";
if (!file_exists($chatFile)) {
    file_put_contents($chatFile, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
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

      .chat-container {
        background: var(--white);
        border-radius: var(--radius);
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04);
        padding: 1.5rem;
        max-width: 900px;
        margin: 0 auto;
      }

      .message {
        padding: 1rem;
        border-radius: 12px;
        margin-bottom: 1rem;
        width: fit-content;
        max-width: 80%;
      }

      .message.editor {
        background: #1f4a3b;
        color: white;
      }

      .message.recenzent {
        background: #f0ede8;
        margin-left: auto;
      }

      .message small {
        display: block;
        margin-top: 0.4rem;
        font-size: 0.75rem;
        opacity: 0.8;
      }

      textarea {
        width: 100%;
        margin-top: 1rem;
        padding: 1rem;
        border-radius: 10px;
        border: 1px solid #ccc;
        resize: none;
        font-family: inherit;
      }

      button {
        background: var(--beige);
        color: white;
        border: none;
        padding: 0.8rem 1.4rem;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        margin-top: 0.8rem;
        transition: 0.25s;
      }

      button:hover {
        background: #b8824a;
      }
    </style>
  </head>

  <body>
    <aside>
      <h2>Recenzent</h2>
      <nav>
        <a href="recenzent.php">📊 Dashboard</a>
        <a href="recenzent-komunikace.php" class="active">💬 Komunikace</a>
        <a href="recenzent-nastaveni.php">⚙️ Nastavení</a>
      </nav>
    </aside>

    <div style="flex: 1; display: flex; flex-direction: column">
      <header>
        <h1>Komunikace – GaČas Jihlava</h1>
        <nav>
          <a href="hlavnist.php">Domů</a>
          <a href="logout.php">Odhlásit se</a>
        </nav>
      </header>
</main>
      <header><h1>Komunikace – <?= htmlspecialchars($article['title']) ?></h1></header>

<div class="chat-header">
  <h2><?= htmlspecialchars($article['title']) ?></h2>
  <p>Autor: <strong><?= htmlspecialchars($article['author_name'] ?? 'Neznámý') ?></strong> • Stav: <strong><?= htmlspecialchars($article['status'] ?? '-') ?></strong></p>
</div>

<div class="chat-container">
  <div class="messages" id="chat"></div>

  <textarea id="msg" placeholder="Napište zprávu redaktorovi..."></textarea>
  <button id="sendBtn">Odeslat</button>
</div>
</main>

<script>
const articleId = <?= (int)$article_id ?>;
async function loadMessages(){
  try{
    const res = await fetch('get_messages.php?id=' + articleId);
    const msgs = await res.json();
    const chat = document.getElementById('chat');
    chat.innerHTML = '';
    msgs.forEach(m=>{
      const div = document.createElement('div');
      div.className = 'message ' + (m.sender_role === 'redaktor' ? 'redaktor' : 'recenzent');
      div.innerHTML = `<div>${escapeHtml(m.text)}</div><small>${escapeHtml(m.sender_name)} • ${m.time}</small>`;
      chat.appendChild(div);
    });
    chat.scrollTop = chat.scrollHeight;
  }catch(e){ console.error(e) }
}
async function sendMessage(){
  const text = document.getElementById('msg').value.trim();
  if(!text) return;
  const res = await fetch('save_message.php', { method:'POST', body: new URLSearchParams({ id: articleId, text }) });
  const json = await res.json();
  if(json.ok){ document.getElementById('msg').value=''; loadMessages(); } else alert('Chyba při odesílání');
}
function escapeHtml(s){ return s.replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c])); }
document.getElementById('sendBtn').addEventListener('click', sendMessage);
setInterval(loadMessages, 2500);
loadMessages();
</script>
  </body>
</html>
