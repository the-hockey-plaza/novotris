<?php
  $nov_domain = "https://" . $_SERVER['HTTP_HOST'];
  $nov_path = dirname($_SERVER['PHP_SELF']);
  $nov_url = $nov_domain . $nov_path . '/';
  $nov_url_index = $nov_url . 'index.php';
  $nov_url_play = $nov_url . 'play.php';
  $nov_url_ranking = $nov_url . 'ranking.php';
  $nov_url_help = $nov_url . 'help.php';
  $nov_url_news = $nov_url . 'news.php';
  $nov_url_alternatives = $nov_url . 'alternatives.php';
  $nov_url_bonanza = $nov_url . 'bonanza.php';
?>