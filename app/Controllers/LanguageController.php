<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lang'])) {
    $_SESSION['language'] = $_POST['lang'];
    syslog(LOG_INFO, json_encode(["success" => true, "message" => "Language updated successfullys"]));
} else {
    error_log(json_encode(["success" => false, "message" => "Language failed to update."]));
}

?>