<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Formulář pro podání článku</title>
</head>
<body>
    <h2>Podání článku</h2>
    <form action="upload_handler.php" method="POST" enctype="multipart/form-data">
        <label>Název článku:</label><br>
        <input type="text" name="nazev" required><br><br>

        <label>Téma:</label><br>
        <input type="text" name="tema" required><br><br>

        <label>Autoři:</label><br>
        <input type="text" name="autori" required><br><br>

        <label>Soubor (.pdf nebo .docx, max 30 MB):</label><br>
        <input type="file" name="soubor" accept=".pdf,.docx" required><br><br>

        <input type="submit" value="Odeslat článek">
    </form>
</body>
</html>
