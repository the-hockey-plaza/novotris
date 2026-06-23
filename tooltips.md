# Tooltip-Vorschlaege fuer die wichtigsten Seiten

Diese Vorschlaege fokussieren auf Stellen, an denen Nutzer oft unsicher sind oder schnelle Orientierung brauchen. Prioritaet haben die Kernpfade: Spielen, Ranking, Login/Registrierung, Passwort-Flow und Startseite.

## Grundsaetze

- Tooltips nur bei Erklaerbedarf einsetzen, nicht auf jedem Label.
- Maximal 1 bis 2 kurze Saetze pro Tooltip.
- Auf Mobile eher Info-Icon oder kurzes Tap-Hint statt klassischem Hover.
- Tooltips sollen Handlung ausloesen ("was bringt mir das?") und nicht nur Begriffe wiederholen.

## 1) Spielen (de/play.php)

1. Element: Level-Auswahl (`#drp-play-level`)
- Warum sinnvoll: Spieler verstehen oft nicht, wann hoehere Level freigeschaltet werden.
- Tooltip-Text: "Waehle den Schwierigkeitsgrad. Neue Level schaltest du ueber deinen Highscore frei."

2. Element: Modus-Auswahl (`#drp-play-mode`)
- Warum sinnvoll: Unterschied classic/speed ist nicht sofort klar.
- Tooltip-Text: "Classic: stabile Punkte pro Stein. Speed: mehr Punkte bei schnellem Fallenlassen."

3. Element: Start-Button (`#do_start`)
- Warum sinnvoll: Ein klarer CTA mit Tastatur-Hinweis verbessert Einstieg.
- Tooltip-Text: "Spiel starten. Tipp: Mit P kannst du starten, pausieren und fortsetzen."

4. Element: Score-Anzeige (`#txt_score`)
- Warum sinnvoll: Nutzer fragen sich, wie Punkte entstehen.
- Tooltip-Text: "Dein aktueller Spielstand. Punkte erhaeltst du pro Stein und je nach Modus."

5. Element: Highscore-Anzeige (`#txt_highscore`)
- Warum sinnvoll: Trennung von aktuellem Score und Bestwert wird klar.
- Tooltip-Text: "Dein bester Wert fuer diesen Level und Modus."

6. Element: Spielflaeche (`#mainCanvas` oder `#div-play-frame`)
- Warum sinnvoll: Onboarding fuer Steuerung (Desktop + Mobile) direkt am Ort des Geschehens.
- Tooltip-Text: "Steuerung: Pfeiltasten bewegen/drehen, Leertaste droppt sofort. Mobil: wischen und tippen."

## 2) Ranking (de/ranking.php)

1. Element: User-Filter (`#drp-rnk-auswahl`)
- Warum sinnvoll: Unterschied "alle" vs. "nur ich" ist zentral fuer die Nutzung.
- Tooltip-Text: "Zeige entweder alle Spieler oder nur deine Ergebnisse."

2. Element: Level-Filter (`#drp-rnk-level`)
- Warum sinnvoll: Score-Vergleich ist nur innerhalb gleicher Schwierigkeit fair.
- Tooltip-Text: "Filtere nach Level, um vergleichbare Ergebnisse zu sehen."

3. Element: Modus-Filter (`#drp-rnk-mode`)
- Warum sinnvoll: Classic und Speed haben unterschiedliche Punkte-Logik.
- Tooltip-Text: "Classic und Speed werden getrennt gewertet. Waehle den passenden Modus."

4. Element: Zeitraum-Filter (`#drp-rnk-period`)
- Warum sinnvoll: Nutzer erkennen schneller den Unterschied zwischen aktuellen und historischen Ergebnissen.
- Tooltip-Text: "12 Monate zeigt aktuelle Form, gesamt zeigt Bestleistungen ueber alle Jahre."

5. Element: Score-Spaltenkopf (Tabellenkopf "Score")
- Warum sinnvoll: Hilft, die Sortier- und Vergleichslogik zu verstehen.
- Tooltip-Text: "Hoehere Werte sind besser. Bei gleichem Score entscheidet das Datum."

## 3) Login (de/login.html)

1. Element: Username-Feld (`#input_login_user_name`)
- Warum sinnvoll: Verhindert Verwechslung mit E-Mail-Login.
- Tooltip-Text: "Melde dich mit deinem Benutzernamen an, nicht mit der E-Mail-Adresse."

2. Element: Passwort-Feld (`#input_login_password`)
- Warum sinnvoll: Reduziert Fehlversuche bei Copy/Paste oder Sonderzeichen.
- Tooltip-Text: "Achte auf korrekte Schreibweise und Gross-/Kleinschreibung."

3. Element: OK-Button (`#btn_login_ok`)
- Warum sinnvoll: Button ist initial deaktiviert, das braucht Erklaerung.
- Tooltip-Text: "Wird aktiv, sobald gueltige Eingaben vorhanden sind. Enter bestaetigt ebenfalls."

4. Element: Link "Passwort vergessen"
- Warum sinnvoll: Wird oft gesucht, aber schnell uebersehen.
- Tooltip-Text: "Setze dein Passwort per Username + E-Mail zurueck."

## 4) Registrierung (de/registration.html)

1. Element: Username-Feld (`#input_registration_user_name`)
- Warum sinnvoll: Name-Regeln und spaetere Sichtbarkeit sind relevant.
- Tooltip-Text: "Dieser Name erscheint in der Rangliste. Waehle einen gut merkbaren Namen."

2. Element: E-Mail-Feld (`#input_registration_email`)
- Warum sinnvoll: Kritisch fuer Passwort-Reset und Account-Wiederherstellung.
- Tooltip-Text: "Diese E-Mail wird fuer Passwort-Reset und wichtige Kontoaktionen genutzt."

3. Element: Passwort-Feld (`#input_registration_password`)
- Warum sinnvoll: Bessere Passwoerter ohne langes Regelwerk.
- Tooltip-Text: "Nutze ein sicheres Passwort, das du nicht auf anderen Seiten verwendest."

4. Element: Checkbox "Bisherige Spiele uebernehmen" (`#chk-inherit`)
- Warum sinnvoll: Feature ist wertvoll, aber selbsterklaerend nur teilweise.
- Tooltip-Text: "Uebernimmt vorhandene Gast-Ergebnisse in deinen neuen Account."

5. Element: Checkbox Datenschutz/Nutzungsbedingungen (`#chk-privacy`)
- Warum sinnvoll: Erklaert, warum der OK-Button sonst deaktiviert bleibt.
- Tooltip-Text: "Ohne Zustimmung kann die Registrierung nicht abgeschlossen werden."

6. Element: OK-Button (`#btn_registration_ok`)
- Warum sinnvoll: Aktivierungslogik transparent machen.
- Tooltip-Text: "Der Button wird aktiv, wenn alle Pflichtfelder korrekt sind."

## 5) Passwort-Flow (de/reset-password.html und de/change-password.html)

1. Element: Reset-Formular (Username + E-Mail)
- Warum sinnvoll: Nutzer muessen wissen, welche Kombination erwartet wird.
- Tooltip-Text: "Gib Username und E-Mail wie bei der Registrierung ein."

2. Element: Zuruecksetzen-Button (`#btn_reset_password` im Reset)
- Warum sinnvoll: Erwartung an naechsten Schritt klaeren.
- Tooltip-Text: "Du erhaeltst einen Link zum Setzen eines neuen Passworts."

3. Element: Neues Passwort-Feld (`#input_registration_password` im Change)
- Warum sinnvoll: Hilft gegen zu schwache oder wiederverwendete Passwoerter.
- Tooltip-Text: "Waehle ein neues Passwort, das sich vom alten unterscheidet."

4. Element: Passwort-Wiederholung (`#input_registration_password_repeat` im Change)
- Warum sinnvoll: Typische Fehlerquelle direkt adressieren.
- Tooltip-Text: "Zur Sicherheit erneut eingeben. Beide Felder muessen identisch sein."

## 6) Startseite (de/index.php)

1. Element: Teaser-Links zu News / Alternatives / Bonanza
- Warum sinnvoll: Nutzer verstehen den Mehrwert der Bereiche schneller.
- Tooltip-Text News: "Aktuelle Updates, Changelog und interessante Tetris-Fakten."
- Tooltip-Text Alternatives: "Vergleiche weitere kostenlose Tetris-Varianten im Browser."
- Tooltip-Text Bonanza: "Kuratiere Links, Stories und Wissenswertes rund um Tetris."

## 7) Footer und globale Navigation (seitenuebergreifend)

1. Element: Sprach-Dropdown (`#drp-language`)
- Warum sinnvoll: Besonders auf Mobile oft uebersehen.
- Tooltip-Text: "Sprache fuer die gesamte Seite umstellen (deutsch/english)."

2. Element: Footer-Login-Bereich (`#footer-login`)
- Warum sinnvoll: Erklaert den Zustandswechsel Login/Logout.
- Tooltip-Text: "Hier meldest du dich an oder ab. Dein Status wird sofort aktualisiert."

3. Element: Footer-User (`#footer-user`)
- Warum sinnvoll: Macht Gast- vs. Account-Status sichtbar.
- Tooltip-Text: "Zeigt den aktiven Spieler an (Gast oder registrierter User)."

## Priorisierung fuer die Umsetzung

1. ✅ Phase A (hoechster Nutzen): play.php, ranking.php, login.html, registration.html — **ERLEDIGT**
2. ✅ Phase B: reset-password.html, change-password.html — **ERLEDIGT**
3. ✅ Phase C: index.php und globale Footer-/Sprach-Tooltips — **ERLEDIGT**

## Implementierungs-Status

**Abgeschlossen:**
- ✅ Phase A: 21 Tooltips (de + en) auf 4 Seiten
- ✅ Phase B: reset-password.html und change-password.html (de + en)
- ✅ Phase C: 6 Tooltips (de + en Teaser) + 3 sprachabhängige Footer-Tooltips

**Ausstehend:**
- Keine offenen Tooltip-Phasen mehr in diesem Dokument.

## Technische Hinweise (kurz)

- Desktop: Tooltip bei Hover + Focus (Accessibility).
- Mobile: Info-Icon neben Feldlabel oder kurzer Hint bei erstem Tap.
- Der Ansatz "nur einmal anzeigen" wird vorerst bewusst nicht umgesetzt und erst spaeter verfeinert (z.B. kontextabhaengig nach Spielfortschritt).
