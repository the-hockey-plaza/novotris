# Analyse zu db.php

## Kurzfazit

Die Datei hat mehrere kritische Sicherheitsprobleme (SQL Injection, harte Zugangsdaten, fehlende Autorisierung), dazu ein sehr eng gekoppeltes Design (Routing, Business-Logik und DB-Zugriff in einer Datei) und mehrere Datenkonsistenz- sowie Performance-Risiken.

## 1. Kritische Befunde

1. Harte DB-Zugangsdaten im Code
   - Stelle: `createPdo` in Zeile 17-21.
   - Problem: Benutzername und Passwort sind fest im Quelltext (`novotris_admin` / `NovForEver`).
   - Risiko: Leak im Repo bedeutet sofortigen DB-Zugriff.
   - Empfehlung: Zugangsdaten in Umgebungsvariablen/Secret-Store, nie im Repo.

2. Client kann DB-Name steuern
   - Stelle: Zeile 756, 762 (`$db_name` aus Request, dann `createPdo($db_name)`).
   - Problem: Der Request bestimmt, gegen welche Datenbank verbunden wird.
   - Risiko: Datenabfluss, Manipulation anderer DBs (je nach Rechten), schwer kontrollierbare Umgebung.
   - Empfehlung: DB-Name serverseitig festlegen; keine freie Auswahl aus Input.

3. Massive SQL-Injection-Flaeche durch String-Konkatenation
   - Beispiele:
     - `readHighscoreFromDb` ab Zeile 121 ff.
     - `readRankingPosition` ab Zeile 193 ff.
     - `createGuestUser` Zeile 228, 232.
     - `getUserFromDb` Zeile 243, 272, 313.
     - `createUserOnDb` Zeile 345, 360, 379-381.
     - `resetPassword` Zeile 401, 408.
     - `login` Zeile 430.
     - `saveLevelToDb`, `saveUserNameToDb`, `saveUserSettingsToDb`, `activate`, `getChangePasswordUser`, `getUserInfo`.
   - Problem: Ungepruefte Nutzereingaben werden direkt in SQL eingebaut.
   - Risiko: Datendiebstahl, Datenmanipulation, Account-Uebernahme.
   - Empfehlung: Konsequent vorbereitete Statements mit Bind-Parametern, inklusive numerischer Parameter.

4. Dynamischer Tabellenname ohne Whitelist
   - Stelle: `saveScoreToDb` Zeile 102.
   - Problem: Tabellenname wird direkt in SQL interpoliert (`INSERT INTO {$table}`).
   - Risiko: SQL-Injection auf Strukturebene.
   - Empfehlung: Harte Whitelist erlaubter Tabellen, niemals freie Tabellen-Identifiers aus Input.

5. Passwort- und Token-Hashing ist veraltet/unsicher
   - Stellen: Zeile 379-380, 408, 596, 625, 645, plus Salt in Zeile 760.
   - Problem: `crypt(..., '$1$novotris$')` verwendet statisches MD5-crypt-Schema.
   - Risiko: Schwacher Schutz gegen brute force/rainbow-Tabellen; gleiches Passwort ergibt vorhersehbare Muster.
   - Empfehlung: `password_hash(..., PASSWORD_ARGON2ID)` oder mindestens `PASSWORD_BCRYPT`; Reset-/Activation-Token als zufaellige, einmalige, zeitlich begrenzte Tokens speichern (idealerweise gehasht).

6. Keine echte Autorisierung auf API-Ebene
   - Stelle: Dispatcher ab Zeile 764.
   - Problem: Funktionen werden per `functionname` aufrufbar; es gibt keine Session-/Token-Pruefung pro Aktion.
   - Risiko: Unberechtigte Aufrufe fuer Konto- und Spielmanipulation (z. B. `saveLevelToDb`, `saveUserSettingsToDb`, `updatePassword`).
   - Empfehlung: Authentisierung + Autorisierung pro Endpoint; User-ID nie blind aus Client akzeptieren.

### Maßnahmen

1.1 [erledigt] DB-Zugangsdaten und Salt aus dem Code entfernen und nur noch ueber Environment/Secret-Store beziehen.
1.2 [erledigt] DB-Auswahl serverseitig fixieren und `db_name` aus Requests ignorieren.
1.3 [erledigt] Alle SQL-Konkatenationen auf vorbereitete Statements mit Bind-Parametern umstellen.
1.4 [erledigt] Dynamische Tabellenidentifiers nur ueber harte Whitelist erlauben.
1.5 [erledigt] Passwort- und Token-Handling auf `password_hash`/`password_verify` plus sichere Token-Lebenszyklen umstellen.
1.6 [erledigt] Verbindliche Authentisierung und Autorisierung pro Aktion erzwingen.

## 2. Hohe Design- und Robustheitsprobleme

1. God-File mit vermischten Verantwortlichkeiten
   - Stelle: gesamte Datei.
   - Problem: Transport (HTTP), Routing, Domainlogik, SQL und Response-Rendering sind zusammengelegt.
   - Auswirkung: schwer testbar, schwer wartbar, hohe Fehlerkopplung.
   - Empfehlung: Trennen in Controller/Service/Repository, klare Schichten.

2. Globale mutable Abhaengigkeiten (`global $pdo`, `global $pw_salt`)
   - Stellen: viele Funktionen.
   - Problem: versteckte Abhaengigkeiten, schwer testbar, Seiteneffekte.
   - Empfehlung: Dependency Injection (PDO und Konfiguration als Parameter/Konstruktor).

3. Fehlendes Error-Handling und fehlende PDO-Konfiguration
   - Stelle: `createPdo` Zeile 17-21.
   - Problem: Kein `try/catch`, kein explizites `ERRMODE_EXCEPTION`, kein Zeichensatz in DSN.
   - Risiko: stille Fehler, inkonsistente Responses, moegliche Encoding-Probleme.
   - Empfehlung: PDO mit Optionen initialisieren und Fehler zentral behandeln.

4. Inkonsistente Input-Verarbeitung (`$input` vs `$_POST`)
   - Stellen: Dispatcher ab Zeile 764.
   - Problem: Manche Cases lesen JSON, andere POST, teilweise gemischt.
   - Risiko: fragile API, schwer reproduzierbares Verhalten.
   - Empfehlung: einheitliches Request-Parsing und Validierung.

5. Kein Default-Fall im Switch
   - Stelle: Switch ab Zeile 764.
   - Problem: Unbekannte Funktionsnamen liefern keine definierte Fehlerantwort.
   - Empfehlung: Standardfall mit HTTP-Statuscode und JSON-Fehlerstruktur.

6. Datenbankzugriff und Output sind eng gekoppelt
   - Stellen: fast alle Funktionen (`echo json_encode(...)`, `echo "Y"`, `echo "ok"`).
   - Problem: Funktionen sind nicht als reine Datenzugriffsschicht nutzbar.
   - Empfehlung: Funktionen sollen Daten zurueckgeben; Response im Controller erzeugen.

### Maßnahmen

2.1 [erledigt] Datei in klar getrennte Schichten aufteilen (Controller, Service, Repository).
2.2 [erledigt] Globale Abhaengigkeiten reduzieren und PDO/Konfiguration ueber Dependency Injection bereitstellen.
2.3 [erledigt] Einheitliches Error-Handling mit Exceptions, konsistenten HTTP-Statuscodes und JSON-Fehlerobjekten einfuehren.
2.4 [erledigt] Request-Parsing auf ein einziges Eingabeformat vereinheitlichen und zentral validieren.
2.5 [erledigt] Einen Default-Fall fuer unbekannte Aktionen mit sauberer Fehlerantwort einbauen.
2.6 [erledigt] DB-Funktionen von Response-Erzeugung entkoppeln.

## 3. Datenkonsistenz- und Logikrisiken

1. Mehrschritt-Operationen ohne Transaktion
   - Beispiele:
     - `createGuestUser` (Insert + Update) Zeile 228-233.
     - `createUserOnDb` (Insert + Update) Zeile 373-382.
     - `activate` (User aktivieren + Spiele umhaengen) Zeile 604-611.
   - Risiko: Teilupdates bei Fehlern, inkonsistente Daten.
   - Empfehlung: Transaktionen (`beginTransaction`, `commit`, `rollBack`).

2. Race Condition bei Spielstart
   - Stelle: `startGameOnDb` Zeile 550-562.
   - Problem: Nach Insert wird per `SELECT ... WHERE level IS NULL ORDER BY id DESC` gesucht.
   - Risiko: Bei Parallelitaet kann falscher Datensatz erwischt werden.
   - Empfehlung: Direkt `lastInsertId()` nach Insert verwenden.

3. Mobile-Flag-Logik widerspruechlich
   - Stelle: `resolveMobileFlag` Zeile 74-86.
   - Problem: Client-Wert wird geparst, aber immer Server-Detection bevorzugt; Parameter wirkt praktisch ignoriert.
   - Empfehlung: Entscheidung dokumentieren und API vereinfachen (unnuetze Parameter entfernen) oder klar priorisieren.

4. Aktivierungs-/Reset-Workflow ohne Ablaufzeit und ohne Einmaligkeit
   - Stellen: `resetPassword`, `activate`, `getChangePasswordUser`, `updatePassword`.
   - Risiko: Token-Replay und laenger gueltige Angriffsfenster.
   - Empfehlung: `token_expires_at`, `token_used_at`, Token-Rotation.

### Maßnahmen

3.1 [erledigt] Mehrschritt-Operationen in Transaktionen kapseln.
3.2 [erledigt] Spielstart atomar machen und `lastInsertId()` statt Nachsuche verwenden.
3.3 [erledigt] Mobile-Flag-Regel vereinfachen und eindeutig dokumentieren.
3.4 [erledigt] Token-Ablauf, Einmalverwendung und Rotation fuer Aktivierung/Reset implementieren.

## 4. Performance- und Skalierungsprobleme

1. Teure Schleifen mit vielen Einzelqueries (N+1)
   - Stellen: `getUserFromDb` und `login` (je 2 * 8 Abfragen) ab Zeile 302 und 462.
   - Problem: Fuer jeden Level/Mode wird separat abgefragt.
   - Empfehlung: Eine aggregierte Query mit `GROUP BY level, nov_mode`.

2. Limitierung erst in PHP statt in SQL
   - Stellen:
     - `readHighscoreFromDb`: Break bei 50 (Zeile 177).
     - `readRankingPosition`: Break bei 100 (Zeile 215).
   - Problem: DB liefert potenziell mehr Daten als benoetigt.
   - Empfehlung: `LIMIT` direkt in SQL.

3. Potenziell ineffiziente Unterabfragen
   - Stellen: Highscore-/Ranking-Queries mit korrelierten Subqueries.
   - Empfehlung: Query-Plan pruefen, passende Indizes sicherstellen (z. B. auf `game(user_id, level, nov_mode, beginn, score)`).

### Maßnahmen

4.1 [erledigt] N+1-Abfragen in `getUserFromDb` und `login` durch aggregierte Sammelqueries ersetzen.
4.2 [erledigt] Ergebnislimits direkt in SQL mit `LIMIT` setzen.
4.3 [erledigt] Query-Plaene analysieren und fehlende Indizes gezielt nachziehen.

Nachweis 4.3:
- `database/queries-3-indexes.sql` enthaelt die vorgeschlagenen Zielindizes fuer `game`, `nov_user` und `nov_level` sowie EXPLAIN-Beispiele zur Verifikation.

## 5. Wartbarkeit und Codequalitaet

1. Viele Magic Numbers und harte Annahmen
   - Stellen: Level 1..8, Modes 1..2 in Schleifen.
   - Problem: Domainenummern sind fest eingebrannt.
   - Empfehlung: Konfiguration oder Tabellengetriebene Werte.

2. Doppelte Logik
   - Stellen: Score-Ermittlung in `getUserFromDb` und `login` nahezu identisch.
   - Empfehlung: Gemeinsame Hilfsfunktion/Service-Methode.

3. Uneinheitlicher SQL-Stil und Namensgebung
   - Problem: `SELECT`/`select`, deutsch/englisch gemischt, unterschiedliche Antwortformate (`Y/N`, `ok`, JSON).
   - Empfehlung: Konventionen festlegen (Code Style + API-Vertrag).

4. Logging kann sensible Informationen enthalten
   - Stellen: `dbLog('functionname = ... , db_name = ...')` Zeile 758, SQL-Logging in Zeile 202.
   - Risiko: interne Struktur oder Query-Details im Log.
   - Empfehlung: strukturierte, minimierte Logs ohne sensitive Details.

### Maßnahmen

5.1 Magic Numbers durch Konfiguration oder datengetriebene Werte ersetzen.
5.2 Doppelte Logik in gemeinsame Funktionen/Services extrahieren.
5.3 Verbindliche Namens- und SQL-Stilkonventionen festlegen.
5.4 Logging-Policy einfuehren und sensitive Inhalte aus Logs entfernen.

## 6. Positiv aufgefallen

1. Teilweise bereits vorbereitete Statements in neueren Funktionen (`startGameOnDb`, `stopGameOnDb`, `updateGameOnDb`, `saveLanguageToDb`).
2. JSON-Response-Header wird gesetzt.
3. Einige Modernisierungsspuren sind erkennbar (Nutzung von `password_verify`, Fallback fuer JSON-Input).

## 7. Priorisierte naechste Schritte

1. Sofort: [erledigt] Alle SQL-Konkatenationen auf Prepared Statements umstellen und dynamische Tabellen per Whitelist absichern.
2. Sofort: [erledigt] DB-Credentials und Salt aus Code entfernen; Secrets in Environment.
3. Sofort: [erledigt] Authentisierung/Autorisierung pro Aktion einbauen.
4. Kurzfristig: [erledigt] Passwort- und Token-Handling auf moderne, zeitgemaesse Verfahren umstellen.
5. Kurzfristig: Transaktionen fuer Mehrschritt-Operationen.
6. Mittelfristig: Datei in Schichten aufteilen (Controller/Service/Repository) und API-Input vereinheitlichen.
7. Offen: Expliziten Logout-Endpoint mit serverseitiger Session-Beendigung und Session-Timeout einfuehren (nicht nur beim Verlassen der Seite).