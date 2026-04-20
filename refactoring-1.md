# Issues ab "Refactoring-Vorschlag fuer gemeinsame Header/Footer"

## Inhaltliche Refactoring-Issues

1. Doppelte Head-Struktur in mehreren Seiten
- `de/alternatives.php`, `de/bonanza.php`, `en/alternatives.php`, `en/bonanza.php` enthalten sehr aehnlichen `<head>`-Code.
- Aenderungen an Meta-Tags, Tracking oder Styles muessen mehrfach gepflegt werden.

2. Doppelte Footer-/Script-Struktur
- Externe und lokale Script-Einbindungen sind seitenweise wiederholt.
- Erhoeht das Risiko von Inkonsistenzen bei Versionierung und Reihenfolge.

3. Fehlende zentrale Konfiguration fuer Seiten-Metadaten
- Titel, Description, Keywords, Sprache und Canonical/Hreflang sind nicht ueber ein gemeinsames Muster abstrahiert.
- Dadurch hoher Wartungsaufwand bei SEO-Aenderungen.

4. Kein gemeinsamer Include-Ansatz vorhanden
- Es fehlt ein zentrales `head.php`/`footer.php`-Pattern fuer wiederverwendbare Layoutteile.
- Refactoring-Ziel war deshalb: gemeinsame Includes + seitenbezogene Variablen.

## Umsetzungs-/Prozess-Issues in der anschliessenden Umsetzung

5. Fehlgeschlagener Patch-Lauf
- Beim Versuch, Dateien per Patch anzulegen/zu aendern, trat ein Formatfehler auf:
  `Invalid Add File Line: <!-- Lokale Scripts mit Cache-Busting -->`
- Ursache: ungueltiges Patch-Format beim Add-File-Block.

6. Unterbrochener Umsetzungsfluss
- Nach dem Patch-Fehler wurde die Ausfuehrung nicht sauber fortgesetzt.
- Statt geordneter Korrektur folgte eine unvollstaendige, repetitive Ausgabe ohne abgeschlossene Aenderung.

## Ergebnis

- Der Refactoring-Vorschlag ist fachlich weiterhin sinnvoll.
- Die eigentliche technische Umsetzung (gemeinsame Includes fuer Head/Footer) wurde in diesem Abschnitt noch nicht sauber abgeschlossen.
