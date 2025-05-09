<?php
namespace controllers;

use views\utilities\settings;

class ModifyController {
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
    <link rel="stylesheet" href="/tern_app/SysDev-Ecom_Project/public/css/settings.css">
</head>
<body  onload = "getTheme()">
<div class="top-bar">
<div class="search-container">
                    <i class="fa-solid fa-search"></i>
                    <input type="text" id="searchInput" placeholder="{$this->translate('Search')}">
                    <div id="searchResults" class="search-results"></div>
                </div>
                <h2> Modify User</h2>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" id="mfunctionsBtn">
                            <span>{$this->translate('Modify Functions')}</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-content" id="mfunctionsDropdown">
                            <div class="dropdown-item" id = "createUserBtn">{$this->translate('Create User')}</div>
                            <div class="dropdown-item">{$this->translate('Deactivate')}</div>
                        </div>
                    </div>
                </div>
                <div class="content">
                <!-- Content will be loaded here -->
            </div>
    <script src="/tern_app/SysDev-Ecom_Project/public/js/modify.js"></script>
</body>
</html>
HTML;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $settings = new ModifyController();
    $settings->displaySettings();
}
?>