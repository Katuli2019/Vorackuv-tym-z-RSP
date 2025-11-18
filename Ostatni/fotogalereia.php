<!DOCTYPE html>
<html lang="cs">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="64x64" href="favicon-64x64.png" />
    
    <title>Fotogalerie | Gastro Časopis Jihlava</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Poppins:wght@300;400;600&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="style.css" />
    <style>
      :root {
        --green: #1f4a3b;
        --green-dark: #0e2921;
        --beige: #c89a5a;
        --bg: #f9f7f3;
        --white: #ffffff;
        --radius: 16px;
      }

      * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
      }

      body {
        font-family: "Poppins", sans-serif;
        background: var(--bg);
        color: var(--green-dark);
        overflow-x: hidden;
      }

      /* ──────────────── NAVIGACE ──────────────── */
      nav {
        width: 100%;
        background: var(--white);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.8rem 2rem;
        position: fixed;
        top: 0;
        z-index: 1000;
      }

      .nav-left {
        font-family: "Playfair Display", serif;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--green-dark);
        letter-spacing: 1px;
      }

      .nav-right a {
        color: var(--green-dark);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.9rem;
        margin-left: 0.1rem;
        letter-spacing: 0.5px;
        transition: all 0.25s ease;
        padding: 6px 10px;
        border-radius: 8px;
      }

      .nav-right a:hover,
      .nav-right a.active { /* Добавил .active для единообразия */
        background: rgba(200, 154, 90, 0.1);
        color: var(--beige);
      }

      /* ──────────────── HERO SEKCIA ──────────────── */
      .hero {
        background: linear-gradient(
            rgba(31, 74, 59, 0.6),
            rgba(31, 74, 59, 0.6)
          ),
          url("hero.jpg") center/cover no-repeat;
        color: var(--white);
        text-align: center;
        padding: 5rem 2rem 6rem;
        margin-top: 70px;
        position: relative;
      }

      .hero img {
        width: 120px;
        border-radius: 50%;
        border: 4px solid var(--beige);
        margin-bottom: 1rem;
      }

      .hero h1 {
        font-family: "Playfair Display", serif;
        font-size: 3.4rem;
        letter-spacing: 2px;
        margin-bottom: 1rem;
      }

      .hero p {
        font-size: 1.2rem;
        letter-spacing: 1px;
        color: #ddebe3; /* Изменено с #334c40 для лучшей читаемости */
        max-width: 700px;
        margin: 0 auto 2.5rem;
        line-height: 1.6;
      }

      .hero-buttons {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 1rem;
      }

      .hero-buttons a {
        text-decoration: none;
        padding: 0.9rem 1.8rem;
        border-radius: var(--radius);
        font-weight: 600;
        transition: all 0.3s ease;
      }

      .hero-buttons .primary {
        background: var(--beige);
        color: var(--white);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      }

      .hero-buttons .primary:hover {
        background: #b58145;
      }

      .hero-buttons .secondary {
        border: 2px solid var(--white);
        color: var(--white);
      }

      .hero-buttons .secondary:hover {
        background: var(--white);
        color: var(--green-dark);
      }

      /* ──────────────── OBSAH ──────────────── */
      section.about {
        max-width: 850px;
        background: var(--white);
        border-radius: var(--radius);
        padding: 3rem 3rem 2.5rem;
        margin: -5rem auto 4rem;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        position: relative;
        z-index: 2;
      }

      section.about h2 {
        font-family: "Playfair Display", serif;
        color: var(--green);
        font-size: 1.8rem;
        margin-bottom: 1rem;
        position: relative;
      }

      section.about h2::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: -6px;
        width: 60px;
        height: 2px;
        background: var(--beige);
      }

      section.about p {
        line-height: 1.7;
        font-size: 1.05rem;
        color: #334c40;
        margin-bottom: 1rem;
      }

      footer {
        text-align: center;
        font-size: 0.9rem;
        color: #607b70;
        padding: 2.5rem 1rem;
      }
      /* ──────────────── AKTUÁLNÍ ČLÁNEK ──────────────── */
      section.article {
        max-width: 850px;
        margin: 2rem auto 4rem;
        text-align: left;
        background: var(--bg);
        border-left: 6px solid var(--beige);
        padding: 2rem;
      }

      section.article h2 {
        font-family: "Playfair Display", serif;
        font-size: 1.8rem;
        color: var(--green-dark);
        margin-bottom: 0.8rem;
      }

      section.article p {
        font-size: 1.05rem;
        color: #334c40;
        line-height: 1.7;
        margin-bottom: 1.2rem;
      }

      section.article a {
        text-decoration: none;
        color: var(--green);
        font-weight: 600;
        border-bottom: 2px solid var(--beige);
        transition: 0.3s;
      }

      section.article a:hover {
        color: var(--beige);
        border-color: var(--green);
      }

      @media (max-width: 768px) {
        .nav-right a {
          margin-left: 1rem;
          font-size: 0.95rem;
        }
        .hero h1 {
          font-size: 2.4rem;
        }
        .hero p {
          font-size: 1rem;
        }
        section.about {
          padding: 2rem;
          margin-top: -3rem;
        }
      }
      /* ──────────────── ЛОГОТИП НА ФОНЕ СТРАНИЦЫ ──────────────── */
body::before {
  content: "";
  position: fixed;
  top: 50%;
  left: 50%;
  width: 900px; /* размер логотипа */
  height: 900px;
  background: url("bek1.png") center/contain no-repeat;
  opacity: 0.1; /* прозрачность — можно увеличить до 0.07 */
  transform: translate(-50%, -50%) rotate(-8deg);
  z-index: -1; /* логотип за контентом */
  pointer-events: none;
  filter: blur(0.3px);
}
/* ──────────────── ЖИВАЯ / ANIMATED GRID ──────────────── */
.gallery {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 1.8rem;
  margin-top: 2.5rem;
  position: relative;
  z-index: 1;
}

/* Фото — как живые элементы */
.gallery img {
  width: 100%;
  aspect-ratio: 4/3;
  object-fit: cover;
  border-radius: 16px;
  box-shadow: 0 12px 28px rgba(0,0,0,0.15);
  transition: transform 0.9s cubic-bezier(.25, .8, .25, 1),
              box-shadow 0.6s ease,
              filter 0.6s ease;
  
  /* лёгкое микро-движение */
  animation: float 6s ease-in-out infinite;
}

/* При наведении — усиленная динамика */
.gallery img:hover {
  transform: scale(1.07) translateY(-10px);
  box-shadow: 0 18px 45px rgba(0,0,0,0.25);
  filter: brightness(1.05);
  animation-play-state: paused;
}

/* микро-анимация “дыхание” */
@keyframes float {
  0%   { transform: translateY(0px); }
  50%  { transform: translateY(-8px); }
  100% { transform: translateY(0px); }
}

/* Для разных фото — разные смещения */
.gallery img:nth-child(3n) {
  animation-delay: 0.7s;
}
.gallery img:nth-child(4n) {
  animation-delay: 1.2s;
}
.gallery img:nth-child(5n) {
  animation-delay: 2s;
}

/* ──────────────── LIGHTBOX (увеличение фото) ──────────────── */
#lightbox {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.75);
  backdrop-filter: blur(4px);
  display: flex;
  justify-content: center;
  align-items: center;
  opacity: 0;
  visibility: hidden;
  transition: opacity 0.4s ease;
  z-index: 2000;
}

#lightbox.active {
  opacity: 1;
  visibility: visible;
}

#lightbox img {
  max-width: 90%;
  max-height: 90%;
  border-radius: 16px;
  box-shadow: 0 20px 45px rgba(0,0,0,0.4);
  transform: scale(0.85);
  transition: transform 0.4s ease;
}

#lightbox.active img {
  transform: scale(1);
}
    </style>
  </head>

  <body class="page-fotogalerie">
    <nav>
      <div class="nav-left">Gačas Jihlava</div>
      <div class="nav-right">
        <a href="hlavnist.php">O magazínu</a>
        <a href="clanek.php">Články</a>
        <a href="fotogalereia.php" class="active">Fotogalerie</a>
        <a href="reklama.html">Reklama/Partneři</a>
        <a href="kontakty.html">Kontakty</a>
        <a href="archiv.html">Archiv</a>
        <a href="login.html">Přihlášení</a>
      </div>
    </nav>

    <section class="hero" style="background: linear-gradient(rgba(31,74,59,0.6), rgba(31,74,59,0.6)), url('gallery-bg.jpg') center/cover;">
      <h1>Fotogalerie</h1>
      <p>Momentky z akcí, kuchyní a jihlavských podniků.</p>
    </section>

    <section class="about">
      <h2>Naše fotografie</h2>
      <p>Podívejte se na atmosféru z našich gastronomických akcí a reportáží. Každá fotografie vypráví svůj příběh.</p>

      <div class="gallery">
        <img src="foto.jpg" alt="">
        <img src="hero-img-middle.png" alt="">
        <img src="about-food-1.jpg" alt="">
        <img src="images.jpg" alt="">
        <img src="foto1.jpg" alt="">
        <img src="stud.jpg" alt="">
      </div>

    </section>

    <footer>
      © 2025 Gastro Časopis Jihlava · Projekt VŠPJ
    </footer>
    <div id="lightbox">
      <img id="lightbox-img" src="" alt="">
    </div>
<script>
  const galleryImages = document.querySelectorAll(".gallery img");
  const lightbox = document.getElementById("lightbox");
  const lightboxImg = document.getElementById("lightbox-img");

  galleryImages.forEach(img => {
    img.addEventListener("click", () => {
      lightboxImg.src = img.src;
      lightbox.classList.add("active");
    });
  });

  // Закрытие при клике на фон
  lightbox.addEventListener("click", () => {
    lightbox.classList.remove("active");
  });
</script>

  </body>
</html>