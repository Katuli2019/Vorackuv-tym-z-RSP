function filterArticles() {
  const filter = document.getElementById("filter").value;
  const articles = document.querySelectorAll(".article");
  articles.forEach((article) => {
    const category = article.getAttribute("data-category");
    article.style.display =
      filter === "all" || category.includes(filter) ? "block" : "none";
  });
}