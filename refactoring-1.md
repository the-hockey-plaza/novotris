# Statusplan Refactoring gemeinsame Header/Footer

Stand: 2026-05-07

## Punkte mit Status

1. Doppelte Head-Struktur in mehreren Seiten
- Status: Erledigt
- Nachweis: `public/de/alternatives.php`, `public/de/bonanza.php`, `public/en/alternatives.php`, `public/en/bonanza.php` binden jeweils `../php/page-head.php` ein.
- Hinweis: Der Head ist fuer diese vier Zielseiten zentralisiert.

2. Doppelte Footer-/Script-Struktur
- Status: Erledigt
- Nachweis: Script-Einbindungen sind in `public/php/page-scripts.php` zentralisiert. Der visuelle Footer ist in `public/php/page-footer.php` zentralisiert und in den vier Zielseiten per Include eingebunden.

3. Fehlende zentrale Konfiguration fuer Seiten-Metadaten
- Status: Erledigt
- Nachweis: `public/php/page-head.php` nutzt zentrale Variablen (`$pageTitle`, `$pageDescription`, `$pageKeywords`, `$canonicalUrl`, Hreflang-URLs), die je Seite gesetzt werden.

4. Kein gemeinsamer Include-Ansatz vorhanden
- Status: Erledigt
- Nachweis: Gemeinsame Includes bestehen mit `public/php/page-head.php` und `public/php/page-scripts.php`.

5. Fehlgeschlagener Patch-Lauf
- Status: Erledigt (historischer Prozessfehler, fachlich behoben)
- Klarstellung: Der damalige Patch-Formatfehler ist kein offener Codezustand mehr. Die benoetigten Dateien und Includes sind inzwischen vorhanden.

6. Unterbrochener Umsetzungsfluss
- Status: Erledigt (historischer Prozesspunkt)
- Klarstellung: Der Umsetzungsfluss war damals unterbrochen. Der aktuelle Code-Stand zeigt eine abgeschlossene Umsetzung der Kernziele.

## Sauberer Plan Erledigt/Unerledigt

### Erledigt
- Punkt 1: Head zentralisiert fuer die vier Zielseiten.
- Punkt 2: Footer-/Script-Struktur zentralisiert.
- Punkt 3: Metadaten-Konfiguration zentralisiert.
- Punkt 4: Gemeinsamer Include-Ansatz eingefuehrt.
- Punkt 5: Patch-Fehler als historischer Prozessfehler abgeschlossen.
- Punkt 6: Unterbrechung als historischer Prozesspunkt abgeschlossen.

### Unerledigt
- Keine offenen Punkte in diesem Refactoring-Block.

## Naechster konkreter Schritt

1. Optional: Weitere Seiten auf denselben Footer-Partial umstellen, falls dort noch Duplikate bestehen.
2. Optional: Aktiven Footer-Menuepunkt je Seite ueber `$footerActive` setzen (z. B. `play`, `ranking`, `help`).
