<?php
// Sichere Domain-Ermittlung
$nov_domain = "https://" . ($_SERVER['SERVER_NAME'] ?? 'localhost');
$nov_path = dirname($_SERVER['PHP_SELF'] ?? '');
$nov_url = $nov_domain . $nov_path . '/';

// Array mit allen Seiten für DRY-Prinzip
$nav_pages = [
  'index' => 'index.php',
  'play' => 'play.php',
  'ranking' => 'ranking.php',
  'help' => 'help.php',
  'news' => 'news.php',
  'alternatives' => 'alternatives.php',
  'bonanza' => 'bonanza.php',
];

// Dynamisch alle URLs erstellen
foreach ($nav_pages as $key => $page) {
  $var_name = 'nov_url_' . $key;
  $$var_name = $nov_url . $page;
}
