<?php
$uploadDir = "uploads/";

echo "<h2>Přehled verzí článků</h2>";

$dirs = glob($uploadDir . "*", GLOB_ONLYDIR);
if (!$dirs) { echo "<p>Žádné články</p>"; exit; }

foreach ($dirs as $dir) {
    $jsonFiles = glob($dir . "*.json");
    foreach ($jsonFiles as $file) {
        $data = json_decode(file_get_contents($file), true);
        echo "<hr>";
        echo "<p>ID článku: {$data['id']}</p>";
        echo "<p>Název: {$data['nazev']}</p>";
        echo "<p>Téma: {$data['tema']}</p>";
        echo "<p>Autoři: {$data['autori']}</p>";
        echo "<p>Verze: {$data['verze']}</p>";
        echo "<p>Datum nahrání: {$data['datum']}</p>";
        echo "<p>Status: {$data['status']}</p>";
        echo "<p>Soubor: <a href='{$dir}{$data['soubor']}' target='_blank'>Stáhnout</a></p>";
    }
}
?>
