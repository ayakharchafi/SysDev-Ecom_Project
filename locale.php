<?php
if ((isset($_GET['lang']))) {
    $lang  = $_GET['lang'];
    $_SESSION['lang'] = $lang;
}

if ((isset($_SESSION['lang']))) {
    
    $lang = $_SESSION['lang'];
    $localeName = explode('_', $_SESSION['lang'])[0];

    setlocale(LC_ALL,  $localeName);
    //echo setlocale(LC_ALL, 0);

    bindtextdomain($lang, __DIR__ . "/app/locale");
    textdomain($lang);
}
?>