<!DOCTYPE html>
<html lang="cs">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="64x64" href="favicon-64x64.png" />

    <title>Články – GaČas Jihlava</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Poppins:wght@300;400;600&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="style.css" />
  </head>

  <body class="page-clanek">
    <nav>
      <div class="nav-left">GaČas Jihlava</div>
      <div class="nav-right">
        <a href="hlavnist.php">O magazínu</a>
        <a href="clanek.php" class="active">Články</a>
        <a href="fotogalereia.php">Fotogalerie</a>
        <a href="reklama.html">Reklama/Partneři</a>
        <a href="kontakty.html">Kontakty</a>
        <a href="archiv.html">Archiv</a>
        <a href="login.html">Přihlášení</a>
      </div>
    </nav>

    <section class="header">
      <h1>Články</h1>
      <p class="subtitle">
        Objevte nové pohledy na gastronomii, kulturu a kreativitu Jihlavy.
      </p>
    </section>

    <div class="filter">
      <label for="filter">Zobrazit:</label>
      <select id="filter" onchange="filterArticles()">
        <option value="all">Všechny články</option>
        <option value="new">Nové</option>
        <option value="2025">Rok 2025</option>
        <option value="2026">Rok 2026</option>
        <option value="cz">Čeští autoři</option>
        <option value="foreign">Zahraniční autoři</option>
      </select>
    </div>

    <main id="articles">
      <div class="article" data-category="new 2025 cz">
        <img src="kava-jihlava.jpg" alt="Káva a dobroty v Jihlavě" />
        <div class="article-info">
          <h3>Kam v Jihlavě za kávou a něčím dobrým</h3>
          <p>
            Sedm kaváren, které stojí za to navštívit. Od lokálních pražíren po
            designové bistry.
          </p>
          <p class="article-author">Autor: Andrianna Nhuien (🇨🇿)</p>
        </div>
      </div>

      <div class="article" data-category="2025 foreign">
        <img src="zlaty-lev.jpg" alt="Restaurace U Zlatého Lva" />
        <div class="article-info">
          <h3>Restaurace U Zlatého Lva</h3>
          <p>
            Tradiční chuť v moderním pojetí – klasická česká kuchyně s důrazem
            na kvalitu a lokální produkty.
          </p>
          <p class="article-author">Autor: Kira Dovbnia (🍀)</p>
        </div>
      </div>
    </main>

    <section class="alt-section">
      <main>
        <div class="article" data-category="new 2026 cz">
          <img src="novy-trend.jpg" alt="Nové trendy v gastronomii" />
          <div class="article-info">
            <h3>Nové trendy v gastronomii 2026</h3>
            <p>
              Od lokálních superpotravin po udržitelné stolování. Co nás čeká v
              příštím roce?
            </p>
            <p class="article-author">Autor: Jan Kovář (🇨🇿)</p>
          </div>
        </div>

        <div class="article" data-category="2026 foreign">
          <img src="world-food.jpg" alt="Global Taste" />
          <div class="article-info">
            <h3>Global Taste: Jihlava a světová kuchyně</h3>
            <p>
              Jak se do jihlavských restaurací dostává inspirace z Itálie, Asie
              a Latinské Ameriky.
            </p>
            <p class="article-author">Autor: Mei-Ling Zhou (🌱)</p>
          </div>
        </div>
      </main>
    </section>

    <footer>© 2025 GaČas Jihlava · Studentský gastronomický magazín</footer>

    <script src="script.js"></script>
  </body>
</html>