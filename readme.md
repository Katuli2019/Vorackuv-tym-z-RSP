# Feature: Formulář pro podání článku (upload + metadata)

## Popis
Tento modul umožňuje:
- Autorům nahrát článek (PDF nebo DOCX)
- Vyplnit metadata (název, téma, autoři)
- Kontrolu formátu a velikosti souboru (max 30 MB)
- Ukládání verzí článků
- Přehled verzí pro redaktora

## Struktura souborů
- `upload_form.php` – HTML formulář pro autora
- `upload_handler.php` – PHP skript pro validaci, upload a ukládání verzí
- `seznam_verzi.php` – stránka pro redaktora s přehledem všech verzí
- `uploads/` – složka pro uložené soubory a metadata

## Jak používat
1. Otevřete `upload_form.php` a nahrajte článek.
2. Po odeslání se uloží soubor a metadata s verzí.
3. Redaktor může zobrazit všechny verze přes `seznam_verzi.php`.
