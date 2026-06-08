Initial commit corresponds to novotris version 4.1.1b.

## Umgebungsvariablen Setup (bplaced/Linux Shared Hosting)

Die Datei public/php/db.php erwartet diese Variablen zur Laufzeit:

- NOVOTRIS_DB_USER
- NOVOTRIS_DB_PASSWORD
- NOVOTRIS_PW_SALT

Optional:

- NOVOTRIS_DB_NAME (Default: novotris_work)

### 1) Vorlage nutzen

1. Datei .env.example als Ausgangspunkt nehmen.
2. Datei als .env ablegen und Werte fuer die drei Variablen mit echten Secrets befuellen.
3. Datei .env nicht ins Repository committen.

Hinweis: db.php nutzt zuerst Prozess-Umgebungsvariablen (getenv()) und faellt auf eine lokale .env-Datei zurueck.
Der Parameter db_name aus Requests wird aus Sicherheitsgruenden ignoriert.

### 2) Ablageort fuer .env

Empfohlener Ort im Projekt:

- novotris/.env

Alternative (falls Deployment-Struktur anders ist):

- novotris/public/.env

Wichtig:

- .env muss serverseitig liegen und darf nicht oeffentlich auslieferbar sein.
- Falls dein Hoster .env im Webroot ausliefern wuerde, nutze den Projekt-Root ausserhalb des oeffentlichen Document-Roots.

### 3) Optional: Hoster-Umgebungsvariablen statt .env

Wenn bplaced fuer deinen Tarif Umgebungsvariablen im Panel erlaubt, kannst du die drei Variablen dort setzen. Dann ist keine .env-Datei noetig.

### 4) Schnelltest

Wenn Variablen fehlen, liefert db.php eine HTTP-500-JSON-Antwort mit "Server configuration error".
Wenn alles korrekt gesetzt ist, verschwindet dieser Fehler.

### 5) Beispiel .env

Inhalt:

NOVOTRIS_DB_USER=your_db_user
NOVOTRIS_DB_PASSWORD=your_db_password
NOVOTRIS_DB_NAME=novotris_work
NOVOTRIS_PW_SALT=$1$novotris$
