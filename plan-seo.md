# SEO-Verbesserungsplan – "tetris kostenlos online"

Ziel: Bessere Platzierungen bei Google für den Suchbegriff **"tetris kostenlos online"**
und verwandte Begriffe (z. B. "tetris spielen", "tetris browser", "tetris gratis").

---

## 0. Realistische Erwartungshaltung

**"Tetris kostenlos online" ist ein extrem umkämpftes Keyword.** Die Top-10-Ergebnisse
werden von großen Spieleportalen (1001spiele.de, spielespiele.de, tetris.com u. ä.)
dominiert – Seiten mit tausenden von Spielen, jahrelanger Domain-Authority und
zahlreichen Backlinks. Für eine Einzelseite ist es nahezu unmöglich, dort hineinzukommen,
unabhängig von der On-Page-SEO.

**Das eigentliche Ziel sollte daher sein:**
- Gute Platzierungen für **Long-Tail-Keywords** mit weniger Wettbewerb (siehe Punkt 10).
- Eine solide technische Basis, die überhaupt erst ermöglicht, sichtbar zu werden.
- Wer "novotris" direkt sucht, findet die Seite sowieso – der Hebel liegt bei
  Nutzern, die über Long-Tail-Begriffe auf die Seite stoßen.

> **Hinweis zur Domain:** "Tetris" ist eine eingetragene Marke der *The Tetris Company*.
> Eine Domain wie `tetris-kostenlos.de` wäre markenrechtlich problematisch und
> riskiert Abmahnungen oder Einzug der Domain. `novotris.de` ist die sichere Wahl.

---

## 1. Domain / Hosting-Autorität

**Problem:** Die Seite läuft unter `bplaced.net` (kostenloser Hoster). Google bewertet
eigene Domains deutlich höher als Subdomains eines Gratishosters. Viele Mitbewerber
haben eigene TLDs (.de, .com).

**Maßnahme:** Eigene `.de`-Domain registrieren (z. B. `novotris.de`) und den Hoster
auf einen Anbieter mit besserer Performance wechseln. Das ist vermutlich der
**größte Einzelhebel** für die Platzierung.

---

## 2. ✅ Seitentitel – einzigartig pro Seite

**Problem:** Fast alle Seiten tragen denselben Titel:
`"Novotris, the better Tetris kostenlos online spielen"`.
Google mag unique Titles; doppelte Titel werden abgewertet. Zudem beginnt der Titel
mit dem Markennamen statt mit dem Keyword.

**Maßnahme:** Titles keyword-first und seitenspezifisch formulieren, z. B.:

| Seite            | Vorschlag |
|------------------|-----------|
| `de/index.php`   | Tetris kostenlos online spielen – Novotris |
| `de/play.php`    | Jetzt Tetris spielen – kostenlos im Browser – Novotris |
| `de/help.php`    | Tetris-Anleitung & Spielregeln – Novotris |
| `de/ranking.php` | Tetris-Rangliste – Wer spielt am besten? – Novotris |
| `de/alternatives.php` | Tetris-Alternativen kostenlos online – Novotris |
| `de/news.php`    | Neuigkeiten rund um Novotris & Tetris – Novotris |

---

## 3. ✅ Meta-Description – einzigartig pro Seite

**Problem:** Identische Meta-Description auf allen Seiten. Google zeigt sie zwar
nicht im Ranking-Algorithmus, aber eine gute, seitenspezifische Beschreibung
erhöht die Click-Through-Rate (CTR) aus den Suchergebnissen.

**Maßnahme:** Für jede Seite eine individuelle Description (ca. 150 Zeichen), die
die Hauptaussage der Seite widerspiegelt und zur Interaktion einlädt, z. B.:

- `play.php`: *"Spiele Tetris jetzt kostenlos im Browser – ohne Download, ohne
  Anmeldung. Bis zu 6 Levels, Classic- und Speed-Modus."*
- `help.php`: *"Spielregeln, Level-System und Tipps für Novotris – deinem
  kostenlosen Tetris-Erlebnis im Browser."*

---

## 4. ✅ Semantische HTML-Struktur (H1–H3)

**Problem:** Seitenüberschriften sind als `<div>` realisiert, nicht als `<h1>`/`<h2>`.
Google gewichtet Überschriften-Tags für die Relevanz.

**Maßnahme:**
- Jede Seite bekommt genau **ein `<h1>`** mit dem wichtigsten Keyword, z. B.
  `<h1>Tetris kostenlos online spielen</h1>`.
- Abschnitte auf der Hilfe-Seite (`help-header`) als `<h2>` umsetzen.
- In `play.php` ggf. einen unsichtbaren (visuell versteckten) `<h1>`-Text ergänzen,
  da das Spielfeld selbst ein Canvas ist und keinen crawlbaren Text bietet.

---

## 5. ✅ Textinhalt auf der Spielseite (play.php)

**Problem:** `play.php` besteht fast ausschließlich aus einem `<canvas>`-Element.
Google kann Canvas-Inhalte nicht lesen – die Seite hat dadurch kaum indexierbaren Text.

**Maßnahme:** Unterhalb oder neben dem Spielfeld einen kurzen, textreichen Abschnitt
einfügen (ca. 100–200 Wörter), der das Spiel beschreibt: Regeln, Besonderheiten
(Level-System, Speed-Modus), Registrierung, Rangliste. Das liefert Google
crawlbaren Inhalt zum Thema.

---

## 6. ✅ Strukturierte Daten (Schema.org)

**Problem:** Kein JSON-LD vorhanden. Für Spiele-Seiten bietet sich das Schema
`VideoGame` bzw. `Game` an.

**Maßnahme:** JSON-LD-Block in `play.php` einfügen, z. B.:
```json
{
  "@context": "https://schema.org",
  "@type": "VideoGame",
  "name": "Novotris",
  "description": "Tetris kostenlos online im Browser spielen – Classic- und Speed-Modus, bis zu 6 Levels.",
  "genre": "Puzzle",
  "playMode": "SinglePlayer",
  "applicationCategory": "Game",
  "operatingSystem": "Web Browser",
  "offers": {
    "@type": "Offer",
    "price": "0",
    "priceCurrency": "EUR"
  }
}
```

---

## 7. ✅ Sitemap-Duplikate bereinigen

**Problem:** `sitemap.xml` enthält sowohl `/de/` als auch `/de/index.php` – das sind
für Google zwei URLs mit identischem Inhalt.

**Maßnahme:** Entweder nur die `/de/`-URL in der Sitemap behalten (bevorzugt) oder
sicherstellen, dass `/de/index.php` per 301-Redirect auf `/de/` zeigt.

---

## 8. ✅ Bildoptimierung

**Problem:**
- Das Logo `logo bing v8.jpg` hat einen unangemessenen Dateinamen und einen generischen
  `alt`-Text.
- Bilder in `index.php` (Zeitung, Läufer) haben keinen `alt`-Text.

**Maßnahme:**
- Logo umbenennen, z. B. `novotris-logo.jpg`.
- Alt-Texte mit Keywords befüllen, z. B. `alt="Novotris – kostenloses Tetris-Spiel"`.
- Bilder als WebP bereitstellen (kleinere Dateigröße, bessere Ladezeiten).

---

## 9. Ladegeschwindigkeit (Core Web Vitals)

**Problem:** Ladegeschwindigkeit ist ein direkter Google-Rankingfaktor. Kostenlose
Hoster sind oft langsam.

**Maßnahmen:**
- Bilder komprimieren (TinyPNG, WebP).
- ~~CSS-Datei minifizieren (`novotris.css`).~~ → **Verzichtet.** Die Ersparnis (~7 KB)
  ist minimal; der Wartungsaufwand (manueller Schritt nach jeder Änderung) steht
  in keinem guten Verhältnis dazu.
- ~~JavaScript-Dateien bündeln und minifizieren~~ → **Verzichtet.** Die `<script>`-Tags
  stehen bereits am Ende von `<body>` (entspricht `defer`-Verhalten). Bündeln wäre
  fehlerträchtig ohne Build-Tool.
- ~~Im `<head>` unnötige Ressourcen entfernen oder auf `defer`/`async` umstellen.~~ → **Erledigt.** `preconnect`-Hint für `googletagmanager.com` ergänzt; widersprüchliche `<meta http-equiv="content-type" charset=iso-8859-1>`-Tags entfernt.

---

## 10. ✅ Content-Strategie: Keyword-Abdeckung ausweiten

**Problem:** Die Seite deckt nur das Hauptkeyword ab. Verwandte Suchanfragen
(Long-Tail) werden nicht gezielt angesprochen.

**Maßnahme:** Long-Tail-Keywords haben deutlich weniger Wettbewerb und sind für
eine Einzelseite realistisch erreichbar. Bestehende Seiten als Ziel nutzen:

| Seite | Long-Tail-Keyword | Wettbewerb |
|-------|-------------------|------------|
| `help.php` | "tetris spielregeln", "tetris anleitung" | gering |
| `alternatives.php` | "tetris alternativen kostenlos online" | gering |
| `ranking.php` | "tetris highscore online", "tetris rangliste" | mittel |
| `play.php` | "tetris ohne anmeldung spielen", "tetris speed modus" | mittel |
| (neu) FAQ | "was ist novotris", "tetris browser varianten" | sehr gering |

Jede dieser Seiten **gezielt auf ein Keyword** optimieren (Title, H1, Beschreibungstext).
Ein Nutzer, der über einen Long-Tail-Begriff landet und das Spiel gut findet,
wird zum wiederkehrenden Besucher – das verbessert die User-Signals, die Google
indirekt bewertet.

---

## 11. Backlinks aufbauen

**Problem:** Ohne externe Links, die auf `novotris.bplaced.net` verweisen, fehlt
Domain Authority.

**Maßnahmen:**
- Eintrag in Spiele-Verzeichnisse (z. B. browsergames.de, onlinespiele.de).
- Kommentar oder Post in Tetris-/Retrogaming-Foren mit Link.
- Die `alternatives.php`-Seite ist gut für potenzielle gegenseitige Verlinkung –
  andere gelistete Seiten kontaktieren.

---

## 12. ✅ `user-scalable=no` im Viewport entfernen (Mobile UX)

**Problem:** `<meta name="viewport" content="width=device-width, user-scalable=no">`
verhindert das Zoomen auf Mobilgeräten. Google berücksichtigt Mobile Usability
als Rankingfaktor.

**Maßnahme:** Nur entfernen, soweit das Spielerlebnis es zulässt. Zumindest auf
Nicht-Spielseiten (index, help, news, ranking, alternatives) `user-scalable=no`
weglassen.

---

## Prioritäten (Aufwand vs. Wirkung)

| Priorität | Maßnahme | Aufwand | Erwartete Wirkung |
|-----------|----------|---------|-------------------|
| 🔴 Hoch | Eigene Domain (.de) | mittel | sehr hoch |
| 🔴 Hoch | Einzigartige Titles/Descriptions | gering | hoch |
| 🔴 Hoch | H1-Tags + Textinhalt auf play.php | gering | hoch |
| 🟠 Mittel | Schema.org JSON-LD | gering | mittel |
| 🟠 Mittel | Sitemap-Duplikate bereinigen | gering | mittel |
| 🟠 Mittel | Bildoptimierung (Alt-Texte, WebP) | mittel | mittel |
| 🟡 Niedrig | JS/CSS minifizieren | mittel | mittel |
| 🟡 Niedrig | Backlinks aufbauen | hoch | hoch (langfristig) |

---

## Anhang: Gesamtbewertung

Das wichtigste Keyword "tetris" (und seine naheliegenden Kombinationen wie
"tetris kostenlos online") liegt praktisch unangefochten bei großen Spieleportalen
mit jahrelanger Domain-Authority und massenhaften Backlinks. Für eine Einzelseite
ist es nicht möglich und auch nicht sinnvoll, dagegen anzukämpfen – das
Aufwand-Nutzen-Verhältnis für ein ernsthaftes SEO-Investment ist schlecht.

**Was sich trotzdem lohnt:** Die Maßnahmen mit sehr geringem Aufwand –
einzigartige Titles, H1-Tags, Alt-Texte – sind keine Optimierungen im engeren
Sinne, sondern **handwerkliche Mindestqualität** einer Webseite. Sie kosten
wenig Zeit und zahlen sich nebenbei auch für Barrierefreiheit und Wartbarkeit aus.

**Was sich nicht lohnt:** Eigene Domain, Hoster-Wechsel, Schema.org-Markup,
aktiver Backlink-Aufbau – das wäre echter Aufwand für einen Markt, den man
ohnehin nicht gewinnen kann.

**Fazit:** Kein großes SEO-Investment. Die kleinen, schnellen Korrekturen
mitnehmen – den Rest sein lassen.
