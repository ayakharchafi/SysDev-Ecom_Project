<?php
session_start();

if (isset($_POST['lang'])) {
    $lang = $_POST['lang'];
    $_SESSION['lang'] = $lang; // Store the selected language in the session
}
?>