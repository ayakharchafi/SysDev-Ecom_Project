<?php
namespace controllers;

use views\utilities\settings;

class SettingsController {
    public function displaySettings() {
        echo $this->getSettingsHTML();
    }

    private function translate($text) {
        return _($text);
    }

    private function getSettingsHTML() {
        return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="/tern_app/SysDev-Ecom_Project/public/css/settings.css">
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
        <h2 class="settings-button" id="archivedClients">{$this->translate('Archived Clients')}</h2>
        <h2 class="settings-button" id="deactivatedUsers">{$this->translate('Deactivated Users')}</h2>
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
