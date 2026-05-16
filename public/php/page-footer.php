<?php
$pageLang = $pageLang ?? 'de';
$footerActive = $footerActive ?? 'play';

$footerLabelWorld = $footerLabelWorld ?? ($pageLang === 'en' ? 'Tetris World' : 'Tetriswelt');
$footerLabelPlay = $footerLabelPlay ?? ($pageLang === 'en' ? 'Play' : 'Spielen');
$footerLabelRanking = $footerLabelRanking ?? ($pageLang === 'en' ? 'Rankings' : 'Ranglisten');
$footerLabelHelp = $footerLabelHelp ?? ($pageLang === 'en' ? 'Help' : 'Anleitung');
$footerLabelVersion = $footerLabelVersion ?? 'Version';

$nov_url_index = $nov_url_index ?? '#';
$nov_url_play = $nov_url_play ?? '#';
$nov_url_ranking = $nov_url_ranking ?? '#';
$nov_url_help = $nov_url_help ?? '#';

$footerPlayStyle = $footerActive === 'play' ? 'color: var(--play-color); cursor: pointer;' : 'cursor: pointer;';
$footerRankingStyle = $footerActive === 'ranking' ? 'color: var(--play-color); cursor: pointer;' : 'cursor: pointer;';
$footerHelpStyle = $footerActive === 'help' ? 'color: var(--play-color); cursor: pointer;' : 'cursor: pointer;';
?>

<div class="novFooter">
  <div class="row-footer-box">
    <a class="footer-label" href="<?= $nov_url_index ?>"><?= htmlspecialchars($footerLabelWorld, ENT_QUOTES, 'UTF-8') ?></a>
  </div>
  <div class="row-footer-box">
    <a class="footer-label" href="<?= $nov_url_play ?>"
      style="<?= htmlspecialchars($footerPlayStyle, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($footerLabelPlay, ENT_QUOTES, 'UTF-8') ?></a>
  </div>
  <div class="row-footer-box">
    <a class="footer-label" style="<?= htmlspecialchars($footerRankingStyle, ENT_QUOTES, 'UTF-8') ?>"
      href="<?= $nov_url_ranking ?>"><?= htmlspecialchars($footerLabelRanking, ENT_QUOTES, 'UTF-8') ?></a>
  </div>
  <div class="row-footer-box">
    <a class="footer-label" style="<?= htmlspecialchars($footerHelpStyle, ENT_QUOTES, 'UTF-8') ?>"
      href="<?= $nov_url_help ?>"><?= htmlspecialchars($footerLabelHelp, ENT_QUOTES, 'UTF-8') ?></a>
  </div>
</div>

<div class="novFooter"
  style="border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
  <div class="row-footer-box">
    <a id="footer-user" class="footer-label"
      style="cursor: pointer;" onclick="showUserInfoDialog();"></a>
  </div>
  <div class="row-footer-box">
    <a id="footer-login" class="footer-label"
      onclick="glUser.loginLogout('index.php')"
      style="cursor: pointer;"></a>
  </div>
  <div class="row-footer-box">
    <a id="footer-version" class="footer-label"
      style="cursor: pointer;" onclick="showNovotrisInfoDialog();"><?= htmlspecialchars($footerLabelVersion, ENT_QUOTES, 'UTF-8') ?></a>
  </div>
  <div class="row-footer-box" style="margin-left: 0px;">
    <select id="drp-language" class="footer-label"
      style="padding-left: 1.0em;">
      <option>deutsch</option>
      <option>english</option>
    </select>
  </div>
</div>