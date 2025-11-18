<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'redaktor') {
    header("Location: login.html");
    exit;
}

$articleId = $_GET['article'] ?? '';
if (empty($articleId)) {
    die("❌ Neplatné article_id.");
}

$articlesFile = __DIR__ . '/uploads/articles.json';
if (!file_exists($articlesFile)) {
    die("❌ Soubor článků nenalezen.");
}

$articles = json_decode(file_get_contents($articlesFile), true);
$article = null;
foreach ($articles as $a) {
    if ($a['id'] == $articleId) {
        $article = $a;
        break;
    }
}
if (!$article) {
    die("❌ Článek nebyl nalezen.");
}

// Soubor pro chat
$chatFile = __DIR__ . "/uploads/chat_{$articleId}.json";
if (!file_exists($chatFile)) {
    file_put_contents($chatFile, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}
?>
<!DOCTYPE html>
<html lang="cs">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Redaktor komunikace</title>
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
      * { box-sizing: border-box; margin: 0; padding: 0; }
      body {
        display: flex;
        height: 100vh;
        background: var(--bg);
        font-family: "Poppins", sans-serif;
        color: var(--green-dark);
      }
      aside {
        width: 250px;
        background: #f3f1ed;
        border-right: 1px solid rgba(0,0,0,0.05);
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
        border-bottom: 1px solid rgba(0,0,0,0.1);
        padding-bottom: .8rem;
      }
      nav a {
        display: block;
        text-decoration: none;
        color: var(--green-dark);
        padding: .75rem 1rem;
        margin-bottom: .3rem;
        border-radius: 10px;
        font-weight: 500;
        transition: all .25s ease;
      }
      nav a:hover, nav a.active {
        background: var(--green);
        color: white;
        transform: translateX(4px);
      }
      main {
        flex: 1;
        padding: 2rem;
        overflow-y: auto;
      }
      header {
        background: var(--green);
        color: var(--white);
        padding: 1.2rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
      }
      header h1 {
        font-family: "Playfair Display", serif;
      }
      .chat-container {
        background: var(--white);
        border-radius: var(--radius);
        box-shadow: 0 4px 14px rgba(0,0,0,0.04);
        padding: 1.5rem;
        max-width: 900px;
        margin: 2rem auto;
        display: flex;
        flex-direction: column;
        height: 70vh;
      }
      .messages {
        flex: 1;
        overflow-y: auto;
        padding-right: .5rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
      }
      .message {
        padding: 1rem;
        border-radius: 12px;
        max-width: 70%;
      }
      .message.redaktor {
        background: var(--green);
        color: white;
        align-self: flex-end;
      }
      .message.recenzent {
        background: #e9e6e1;
        align-self: flex-start;
      }
      .message small {
        display: block;
        margin-top: .3rem;
        font-size: .75rem;
        opacity: .8;
      }
      textarea {
        width: 100%;
        border-radius: 10px;
        border: 1px solid #ccc;
        resize: none;
        font-family: inherit;
        padding: 1rem;
        margin-top: 1rem;
      }
      button {
        background: var(--beige);
        color: white;
        border: none;
        padding: .8rem 1.4rem;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        margin-top: .8rem;
        transition: .25s;
      }
      button:hover { background: #b8824a; }
    </style>
  </head>
  <body>
    <aside>
      <h2>Redaktor</h2>
      <nav>
        <a href="redaktor.php">📊 Dashboard</a>
        <a href="#" class="active">💬 Komunikace</a>
        <a href="redaktor-nastaveni.php">⚙️ Nastavení</a>
      </nav>
    </aside>

    <main>
      <header>
        <h1>Komunikace – <?= htmlspecialchars($article['title']) ?></h1>
        <nav>
          <a href="redaktor.php" style="color:white;">← Zpět</a>
        </nav>
      </header>

      <div class="chat-container">
        <div class="messages" id="chat"></div>

        <textarea id="msg" placeholder="Napište zprávu recenzentovi..."></textarea>
        <button id="sendBtn">Odeslat</button>
      </div>
    </main>

<script>
const articleId = <?= json_encode($articleId) ?>;

async function loadMessages(){
  try {
    const res = await fetch('get_messages.php?article_id=' + articleId);
    const msgs = await res.json();
    const chat = document.getElementById('chat');
    chat.innerHTML = '';
    msgs.forEach(m => {
      const div = document.createElement('div');
      div.className = 'message ' + m.sender_role;
      div.innerHTML = `<div>${escapeHtml(m.text)}</div><small>${escapeHtml(m.sender_name)} • ${m.time}</small>`;
      chat.appendChild(div);
    });
    chat.scrollTop = chat.scrollHeight;
  } catch (e) { console.error(e); }
}

async function sendMessage(){
  const text = document.getElementById('msg').value.trim();
  if (!text) return;
  const form = new URLSearchParams({ article_id: articleId, text });
  const res = await fetch('save_message.php', { method: 'POST', body: form });
  const json = await res.json();
  if (json.ok) {
    document.getElementById('msg').value = '';
    loadMessages();
  } else {
    alert('Chyba při odesílání');
  }
}

function escapeHtml(s){
  return s.replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
}

document.getElementById('sendBtn').addEventListener('click', sendMessage);
setInterval(loadMessages, 2500);
loadMessages();
</script>
</body>
</html>