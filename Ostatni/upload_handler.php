<?php
$uploadDir = "uploads/";
if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nazev = trim($_POST["nazev"]);
    $tema = trim($_POST["tema"]);
    $autori = trim($_POST["autori"]);
    $soubor = $_FILES["soubor"];

    // --- Kontrola metadat ---
    if (empty($nazev) || empty($tema) || empty($autori)) {
        exit("❌ Chyba: Vyplňte všechna metadata.");
    }

    // --- Kontrola formátu ---
    $allowedTypes = [
        "application/pdf",
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
    ];
    if (!in_array($soubor["type"], $allowedTypes)) {
        exit("❌ Nepodporovaný formát souboru.");
    }

    // --- Kontrola velikosti ---
    if ($soubor["size"] > 30 * 1024 * 1024) {
        exit("❌ Soubor je příliš velký (max 30 MB).");
    }

    // --- Generování unikátního ID článku ---
    $id = uniqid("clanek_");

    // --- Složka pro článek a verze ---
    $articleDir = $uploadDir . $id . "/";
    if (!is_dir($articleDir)) mkdir($articleDir, 0777, true);

    // --- Uložení nové verze ---
    $version = 1;
    while (file_exists($articleDir . "verze_{$version}_" . basename($soubor["name"]))) {
        $version++;
    }
    $targetFile = $articleDir . "verze_{$version}_" . basename($soubor["name"]);
    move_uploaded_file($soubor["tmp_name"], $targetFile);

    // --- Metadata pro verzi ---
    $metadata = [
        "id" => $id,
        "verze" => $version,
        "nazev" => $nazev,
        "tema" => $tema,
        "autori" => $autori,
        "soubor" => basename($targetFile),
        "datum" => date("Y-m-d H:i:s"),
        "status" => "Podáno"
    ];
    file_put_contents($articleDir . "metadata_verze_{$version}.json", json_encode($metadata, JSON_PRETTY_PRINT));

    echo "<h3>✅ Článek úspěšně nahrán!</h3>";
    echo "<p>ID článku: <strong>{$id}</strong></p>";
    echo "<p>Verze: <strong>{$version}</strong></p>";
    echo "<p>Status: <strong>Podáno</strong></p>";
    echo "<p><a href='upload_form.php'>← Zpět na formulář</a></p>";
}
?>
