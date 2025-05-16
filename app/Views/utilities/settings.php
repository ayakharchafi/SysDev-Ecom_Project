<?php
//namespace controllers;
use views\utilities\settings;
class SettingsController {
    public function displaySettings() {
        echo $this->getSettingsHTML();
    }
    private function translate($text) {
        return _($text);
    }
    private function getSettingsHTML() {
          $archivedHref  = '/tern_app/SysDev-Ecom_Project/app/Views/utilities/archived_clients.php';
    $deactivatedHref = '/tern_app/SysDev-Ecom_Project/app/Views/utilities/desactivate_users.php';
        return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="/tern_app/SysDev-Ecom_Project/public/css/settings.css">
    <style>
        #archivedClients, #deactivatedUsers {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 4px;
            text-decoration: none;
            color: inherit;
            transition: background-color 0.2s ease;
        }
        #archivedClients:hover, #deactivatedUsers:hover {
            background-color: gray;
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="settings-content">
        <h1 id="settingsTitle">{$this->translate('Settings')}</h1>
        <br>
        <div>
            <h2 id="themeTitle">{$this->translate('Theme')}</h2>
            <p id="themeDescription">{$this->translate('Select your display preferences')}</p>
            <div class="theme-options">
                <button class="light-theme" onclick="changeTheme('light')">{$this->translate('Light')}</button>
                <button class="dark-theme" onclick="changeTheme('dark')">{$this->translate('Dark')}</button>
            </div>
        </div>
        <br>
        <div>
            <h2 id="languageTitle">{$this->translate('Language')}</h2>
            <p id="languageDescription">{$this->translate('Select your preferred language')}</p>
            <div class="language-options">
                <form id="languageForm">
                    <button type="submit" name="lang" value="fr" class="french-btn">{$this->translate('French')}</button>
                    <button type="submit" name="lang" value="en" class="english-btn">{$this->translate('English')}</button>
                </form>
            </div>
        </div>
        <br><br>
        <h2><a id="archivedClients" href="{$archivedHref}">{$this->translate('Archived Clients')}</a></h2>
         <h2><a id="deactivatedUsers" href="{$deactivatedHref}">{$this->translate('Deactivated Users')}</a></h2>
    </div>
    <script src="/tern_app/SysDev-Ecom_Project/public/js/settings.js"></script>
</body>
</html>
HTML;
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $settings = new SettingsController();
    $settings->displaySettings();
}
?>