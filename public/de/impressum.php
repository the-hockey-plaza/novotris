<!DOCTYPE html>
<html>

<head>
  <title>Impressum - Novotris</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width">
  <meta name="description" content="Impressum von Novotris.">
  <meta name="keywords" content="tetris, impressum">
  <meta name="Copyright" content="Armin Steidlinger Softwareentwicklung">
  <meta name="Author" content="Armin Steidlinger Softwareentwicklung">

  <link rel="icon" type="image/x-icon" href="../icons/novotris-icon.png">

  <link rel="canonical" href="https://novotris.bplaced.net/de/impressum.php" />

  <link rel="preconnect" href="https://www.googletagmanager.com">
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async
    src="https://www.googletagmanager.com/gtag/js?id=G-9GL47VN2C7"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-9GL47VN2C7');
  </script>

  <link rel="stylesheet" type="text/css" href="../css/novotris.css" />

  <?php include '../php/navi.php'; ?>

</head>

<!-- ---------------------------------------------------- -->

<body>

  <div class="pseudoBody">
    <div class="container" id="div-container">
      <div class="novHeader"
        style="border-top-left-radius: 4px; border-top-right-radius: 4px;">
        <h1 id="lblTitle" class="nov-title-area lbl-title-compact" style="flex: 80">Impressum</h1>
        <div style="flex: 20">
          <picture>
            <source srcset="../images/novotris-logo.webp" type="image/webp">
            <img src="../images/novotris-logo.jpg" width="135" height="auto"
              align="right" alt="Novotris - kostenloses Tetris-Spiel">
          </picture>
        </div>
      </div>

      <div class="novBody">
        <div class="help-text">
          <br> Armin Steidlinger <br> Softwareentwicklung <br> <br>
          <!-- Heinrich-Heine-Ring 159 <br> -->D-76199 Karlsruhe<br>
          Deutschland <br> <br> novotris (at) steidlinger.de
        </div>
      </div>

      <?php include '../php/page-footer.php'; ?>

    </div>

  </div>

  <!-- ---------------------------------------------------- -->

  <div class="standardmessage" id="div-message-dialog"
    style="position: absolute; z-index: 4; flex-direction: column; display: none; overflow: hidden;">
    <div
      style="flex: 15; font-size: 16pt; margin-top: 30px; margin-bottom: 1px; margin-left: 25px; margin-right: 25px">
      <span id="span-msg-header">msg-header</span>
    </div>

    <div
      style="flex: 70; overflow-y: auto; font-size: 12pt; margin-top: 1px; margin-left: 25px; margin-right: 25px">
      <span id="span-msg-text">msg-txt</span>
    </div>

    <div style="flex: 15; margin-top: 15px;">
      <button id="btn_msg_ok" class="dialog-button-modal"
        onclick="classDialog.msgDialogOk()">OK</button>
    </div>
  </div>

  <div id="div-cnv-message" style="position: absolute; z-index: 3;">
    <canvas id="cnv-message" style="z-index: 3;" hidden="true"></canvas>
  </div>

  <!-- ---------------------------------------------------- -->

  <script src="https://code.jquery.com/jquery-latest.js"></script>

  <script
    src="../js/global.js?v=<?php echo filemtime('../js/global.js'); ?>"></script>
  <script src="../js/user.js?v=<?php echo filemtime('../js/user.js'); ?>"></script>
  <script src="../js/main.js?v=<?php echo filemtime('../js/main.js'); ?>"></script>
  <script
    src="../js/novotris.js?v=<?php echo filemtime('../js/novotris.js'); ?>"></script>
  <script
    src="../js/dialog.js?v=<?php echo filemtime('../js/dialog.js'); ?>"></script>

  <script>
    document.addEventListener('DOMContentLoaded', onContentLoaded, false);
    var glUser = new User();
    mainInit();
    glUser.init(false);
    classDialog.initMessages();
    classDialog.init();

    mainUpdateFooter();
    $("body").fadeIn("slow");
  </script>
</body>

</html>