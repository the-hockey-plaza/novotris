# Repair Plan: Saubere mobile Version

## Zielbild
Eine robuste mobile Version, in der das Spiel auf Smartphones stabil laeuft, Touch-Eingaben zuverlaessig sind, kein ungewolltes Scrollen/Bounce auftritt und alle Seiten (Play, Ranking, Help, Login, Registration) konsistent responsiv sind.

## Ausgangslage (bereits sichtbar im Code)
- Globale Groessen sind hart kodiert (z. B. Container 600x750), dadurch bricht das Layout auf kleinen Displays.
- Body hat `overflow-y: hidden`, gleichzeitig existieren scrollbare Inhaltsbereiche; das fuehrt zu inkonsistentem Scroll-Verhalten.
- Touch-Events werden global auf `document` gebunden, ohne klare Trennung zwischen Spielgesten und normalem Seiten-Scroll.
- Viewport-Hoehe basiert auf `100vh`, was auf Mobile (Adressleiste/Toolbar) oft zu Hoehen-Spruengen fuehrt.
- Es gibt viele Inline-Styles in einzelnen Seiten, dadurch ist mobile Verhalten schwer zentral steuerbar.

## Leitprinzipien
- Mobile-First fuer alle Layouts.
- Scroll-Lock nur dort, wo wirklich Spiel-Interaktion stattfindet (Play-Canvas), nicht global.
- Eine gemeinsame Basis fuer responsive Layouts, statt seitenweiser Sonderlogik.
- Touch/Pointer sauber kapseln: Spiel-Gesten im Canvas, UI-Interaktion ausserhalb normal.

## Status (laufend gepflegt)

### Erledigt
- [x] Phase 1.1 Scroll-Modell: globaler harter Scroll-Block entfernt, Scroll-Lock nur noch zustandsbasiert im Spiel.
- [x] Phase 1.2 Viewport modernisiert: `100dvh` mit Fallback auf `100vh` eingebaut.
- [x] Phase 1.3 Overscroll gesteuert: `overscroll-behavior` gezielt fuer Lock und Spielbereich gesetzt.
- [x] Phase 1.4 Touch-Aktionen am Spielbereich: `touch-action` am Play-Container/Canvas gesetzt.
- [x] Phase 2.1 Harte Pixelgroessen entfernt: Container/Play-Bereiche auf fluide Breiten/Hoehen umgestellt, JS-Hardcoding (600x750) entfernt.
- [x] Phase 2.2 Einheitliche Breakpoints eingefuehrt: responsive Regeln fuer <=768 und <=480 in zentraler CSS-Datei.
- [x] Phase 2.3 Play-UI fuer Mobile neu angeordnet: Canvas oben, Daten/Controls darunter im Grid, Touch-Targets vergroessert.
- [x] Phase 2.4 Inline-Styles reduziert: wiederkehrende Layout-Styles in Play/Ranking/Help (de/en) in zentrale Klassen ueberfuehrt.
- [x] Phase 2 Nacharbeit Desktop: Container-Breite und Mindesthoehe des Play-Bereichs fuer Desktop korrigiert, damit die Spielflaeche wieder voll sichtbar ist.
- [x] Phase 2 Nacharbeit Desktop 2: Play-Stage auf stabile Desktop-Breite eingestellt und Intro-/Hinweisdialog wieder am Container statt am gesamten Viewport ausgerichtet.
- [x] Phase 2 Nacharbeit Desktop 3: Play-Stage/Sidebar fuer Desktop feinjustiert (flexibler Bereich 380-410px), damit das Spielfeld nicht schmal wirkt und das Gesamtbild ausgewogen bleibt.
- [x] Phase 2 Nacharbeit Desktop 4: Presets fuer Desktop-Breite eingefuehrt (`layout=compact` oder `layout=wide`), um die Spielfeldbreite schnell umschalten zu koennen.
- [x] Phase 2 Nacharbeit Desktop 5: Eingangsmeldung vertikal wieder naeher an der frueheren Position ausgerichtet (nicht mehr zu weit oben).
- [x] Phase 2 Nacharbeit Layout-Konsistenz: `div-container` auf allen Seiten auf einheitliche feste Hoehe/Breite gesetzt; Scrollen erfolgt in den inneren Content-Bereichen (z. B. Ranking-Liste) statt durch wachsenden Container.
- [x] Phase 2 Nacharbeit Desktop 6: Groessen von Play-Anzeigen (Rows/Speed/Score/Level/Mode) fuer Desktop auf das fruehere Niveau zurueckgestellt; vergroesserte Touch-Groessen bleiben nur auf Mobile aktiv.
- [x] Phase 2 Nacharbeit Desktop 7: Kachelgroesse (`cBrickWidth`) fuer das 10x20-Spielfeld zusaetzlich an die tatsaechliche Canvas-Geometrie begrenzt, damit unten nichts abgeschnitten wird.
- [x] Phase 2 Nacharbeit Desktop 8 (Recheck): Starre Mindesthoehe im Play-Stage-Layout entfernt (`min-height: 610px`), damit das Spielfeld nicht mehr durch Container-Clipping unten abgeschnitten wird.
- [x] Phase 2 Nacharbeit Mobile 1: `div-container` auf Mobile ueber zentrale Variablen mit einheitlicher fixer Breite/Hoehe je Breakpoint vereinheitlicht.
- [x] Phase 2 Nacharbeit Mobile 2: Beide Fusszeilen auf Mobile auf einzeilige Darstellung umgestellt (kompaktere Schrift/Abstaende statt Zeilenumbruch).
- [x] Phase 2 Nacharbeit Mobile 3: Play-Layout auf Mobile wieder links/rechts angeordnet (Spielfeld links, Anzeigen/Bedienung rechts) und Bedienelemente kompakt skaliert, damit alles erreichbar bleibt.
- [x] Phase 2 Nacharbeit Mobile 4: Breite der Play-Dropdowns (Level/Modus) auf Mobile weiter reduziert, damit die rechte Spalte nicht ueberdehnt.
- [x] Phase 3.1 (vorgezogen) Swipe-Handling gekapselt: Touch-Listener vom globalen `document` auf Spielziel begrenzt.
- [x] Phase 3.2 (teilweise vorgezogen) Passive/aktive Listener: Touch-Listener mit passender Konfiguration und `preventDefault` nur bei aktiver Spielgeste.
- [x] Phase 3 Nacharbeit Mobile Tap: Tap-Rotation wieder robuster gemacht (kleine Finger-Drift/Tap-Dauer tolerant), damit ein kurzer Tap wieder zuverlaessig rotiert.

### Offen
- [ ] Phase 1 Akzeptanzkriterien per Device-Matrix gegen iPhone Safari und Android Chrome abnehmen.
- [ ] Phase 2 Akzeptanzkriterien auf echten 320-428px Devices gegenpruefen (kein Horizontal-Scroll, gute Bedienbarkeit ohne Zoom).
- [ ] Phase 3 restlich umsetzen (zentraler State inkl. Dialogzustand, optional Pointer-Events).
- [ ] Phase 5 Testprotokoll in dieser Datei ergaenzen.

## Phase 0: Inventar und Repro (1 Tag)
1. Eine kurze Issue-Liste mit reproduzierbaren Schritten erstellen:
- Seite
- Geraet/Browser
- Erwartetes Verhalten
- Ist-Verhalten
- Screenshot/Screenrecord
2. Referenzgeraete fuer Entwicklung festlegen:
- iPhone Safari (aktuelle iOS-Version)
- Android Chrome (aktuelle Version)
- Optional: Samsung Internet
3. Einfache Repro-URL-Checkliste anlegen (de/en):
- play.php
- ranking.php
- help.php
- index.php
- login/registration/reset pages

Ergebnis Phase 0:
- Verbindlicher Bug-Backlog mit Prioritaet P1/P2/P3.

## Phase 1: Scroll und Viewport stabilisieren (P1, 1-2 Tage)
1. Scroll-Modell definieren:
- Global: `html, body` nicht mehr hart blockieren.
- Play-Seite: Scroll-Lock nur waehrend aktiver Spiel-Session oder nur im Spielbereich.
2. Viewport modernisieren:
- `100dvh` als primaere Hoehe fuer mobile Browser verwenden.
- Fallback fuer Browser ohne `dvh` vorsehen.
3. Overscroll steuern:
- `overscroll-behavior` gezielt einsetzen, damit kein Pull-to-refresh/Bounce die Session stoert.
4. Touch-Aktionen am Spielbereich:
- Fuer den Canvas/Play-Container `touch-action: none` oder passende Teilmenge.
- Ausserhalb des Spielbereichs Scroll und Formulare normal nutzbar lassen.

Akzeptanzkriterien Phase 1:
- Kein ungewolltes Page-Scroll waehrend aktiver Spielgeste.
- Dialoge/Listen bleiben scrollbar, ohne dass das Spielfeld unkontrolliert reagiert.
- Keine Layout-Spruenge beim Ein-/Ausblenden der Browser-UI.

## Phase 2: Responsive Layout (P1, 2-3 Tage)
1. Harte Pixelgroessen entfernen:
- Container, Canvas und Seitenbereiche auf fluides Layout umstellen.
- Breite/Hoehe ueber CSS mit `min()`, `max()`, `clamp()` und Flex/Grid steuern.
2. Einheitliche Breakpoints definieren:
- z. B. <=480, <=768, >768.
3. Play-UI neu anordnen (mobile):
- Canvas prominent oben.
- Score/Level/Buttons darunter in 2-Spalten- oder Kartenlayout.
- Ausreichende Touch-Target-Groessen (mind. 44x44 CSS px).
4. Inline-Styles abbauen:
- Wiederkehrende Inline-Layoutregeln in zentrale CSS-Klassen ueberfuehren.

Akzeptanzkriterien Phase 2:
- Keine horizontale Scrollbar auf 320-428 px Breite.
- Start/Mode/Level und Footer-Interaktionen ohne Zoom nutzbar.
- Spielbereich bleibt sichtbar und korrekt skaliert in Portrait.

## Phase 3: Eingabe- und Event-Architektur (P1/P2, 2 Tage)
1. Swipe-Handling kapseln:
- Touch-Listener nur am Spielbereich registrieren, nicht global auf dem gesamten Dokument.
2. Passive/aktive Listener korrekt setzen:
- Wo `preventDefault` noetig ist, Listener explizit passend konfigurieren.
3. Pointer-Events vorbereiten:
- Optionaler Umstieg auf Pointer-Events fuer einheitliches Verhalten.
4. Scroll-Lock-State einfuehren:
- Zentraler UI-State: `isGameActive`, `isDialogOpen`.
- Lock/Unlock deterministisch bei Start, Pause, Ende, Dialog.

Akzeptanzkriterien Phase 3:
- Keine Ghost-Inputs, kein Double-Trigger von Gesten.
- Tap fuer Rotation und Swipe fuer Bewegung sind reproduzierbar.
- Dialog-Interaktion beeintraechtigt Spielsteuerung nicht.

## Phase 4: UX und Accessibility fuer Mobile (P2, 1-2 Tage)
1. Typografie und Abstaende fuer kleine Displays justieren.
2. Fokus-/Tastaturverhalten fuer Formseiten verbessern (Login/Registration/Reset).
3. Kontraste und Lesbarkeit in Footer/Dialogen pruefen.
4. Optional: haptisches Feedback (nur wenn sinnvoll und technisch verfuegbar).

Akzeptanzkriterien Phase 4:
- Formulare bleiben bei geoeffneter Onscreen-Tastatur bedienbar.
- Wichtige Actions sind auf erster Sicht erreichbar.

## Phase 5: Qualitaetssicherung und Rollout (P1, 1 Tag)
1. Testmatrix pro Seite/Geraet/Orientierung ausfuehren.
2. Regressionstest fuer Desktop (keine Verschlechterung).
3. Performance-Check:
- FPS subjektiv stabil.
- Keine auffaelligen Main-Thread-Blocker in Kernaktionen.
4. Stufenweiser Rollout:
- Erst intern/staging, dann Produktion.

## Konkrete Arbeitspakete (Backlog-ready)
1. CSS-Basis fuer mobile Viewport/Scroll-Lock in zentrale Datei aufnehmen.
2. Play-Container und Canvas auf responsive Dimensionierung umbauen.
3. Touch-Listener von `document` auf Spielbereich verschieben.
4. Einheitliche Utility-Klassen fuer Dialog- und Footer-Layouts erstellen.
5. Inline-Styles in Play/Ranking/Help Seiten reduzieren.
6. Mobile Smoke-Tests fuer de/en Seiten dokumentieren.

## Definition of Done
- Mobile P1-Bugs geschlossen.
- Keine kritischen Regressions auf Desktop.
- Testprotokoll mit Ergebnis je Geraet/Seite vorhanden.
- Code folgt einheitlichem Muster (keine neuen Inline-Layout-Sonderfaelle).

## Empfohlene Reihenfolge
1. Phase 1 zuerst (Scroll/Viewport), da dies die meisten Folgefehler verursacht.
2. Dann Phase 2 (Layout), um die UI stabil zu bekommen.
3. Danach Phase 3 (Input), damit Gesten sauber und wartbar sind.
4. Abschliessend Phase 4/5 fuer Feinschliff und sicheren Rollout.
