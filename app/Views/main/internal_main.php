<?php
use models\User;
use controllers\UserController;
use controllers\ClientController;
use controllers\MkClientController;

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: /tern_app/SysDev-Ecom_Project/login');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/tern_app/SysDev-Ecom_Project/public/css/style_main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body  onload = "getTheme()">
 
    <style>

:root {
    --hoverText: #333 ;
    --bg: #ffffff;
    --text: #333;
    --bg2: #f5f5f5;
    --sidebar-bg: #2c3e50;
    --button-bg: #3498db;
    --button-hover: #2980b9;
    --exit-bg: black;
    --exit-hover: #333;
}
.dropdown-item:hover{
    color: var(--sidebar-bg);
}
.create-client-container{
    background-color: var(--sidebar-bg);
}
.create-client-form{
    background-color: var(--sidebar-bg);
    color: var(--sidebar-bg);
}
#searchInput {
  background-color: var(--bg);

}
input{
    background-color: var(--bg);
}

select{
    background-color: var(--bg);
    color: var(--text);
}

.sidebar-item:hover {
  background-color: var(--bg);
}

tr:hover {
color: var(--hoverText);
}
.container{
    color: var(--text);
}
.main-content {

  background-color: var(--sidebar-bg);

}
.TextInput {
    background-color: var(--bg);
}

th {

  background-color:var(--bg);
  color:var(--text);
}
.content {
    background-color: var(--bg);
}
body {
    background-color: var(--bg);
    color: var(--text);
}
.sidebar-button {
    background-color:var(--bg);
    color: var(--text);
}
.sidebar {
    background-color:var(--bg);

    color: var(--text);

}
.dropdown-content{
    background-color:var(--bg);
}
input{
    color: var(--text);
}
.modal-content{
    background-color:var(--bg);
}
    </style>
    <div class="container" >
        <!-- Left Sidebar -->
        <div class="sidebar">
            <div class="user-profile">
                <div class="avatar">
                    <i class="fa-solid fa-user"></i>
                </div>
                <span class="username"><?php 
                    echo htmlspecialchars($_SESSION['user']) ?>
                </span>
            </div>

            <div class="sidebar-section">
                <h3><?= _('Tables')?></h3>
                <div class="sidebar-item collapsible" id="clientsBtn">
                    <span><?= _('Clients')?></span>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>
                <div class="collapsible-content" id="clientsContent">
                    <div class="sub-item" data-client-type="mk">MK</div>
                    <div class="sub-item" data-client-type="os">OS</div>
                    <div class="sub-item" data-client-type="bg">BG</div>
                    <div class="sub-item" data-client-type="th">TH</div>
                    <div class="sub-item create-client-btn" data-client-type="mk">Create Client</div>
                </div>
                <div class="sidebar-item">
                    <span><?= _('Users')?></span>
                </div>
            </div>

            <div class="sidebar-section">
                <h3><?= _('File Manager')?></h3>
                <div class="sidebar-item">
                    <span><?= _('Export')?></span>
                </div>
                <div class="sidebar-item">
                    <span><?= _('Import')?></span>
                </div>
            </div>

            <div class="sidebar-footer">
                <div class="sidebar-item" id="settingsBtn">
                    <i class="fa-solid fa-gear"></i>
                    <span><?= _('Settings')?></span>
                </div>
                <div class="sidebar-item" id="logoutBtn">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span><?= _('Sign out')?></span>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="top-bar">
                <div class="search-container">
                    <i class="fa-solid fa-search"></i>
                    <input type="text" id="searchInput" placeholder="<?= _('Search')?>">
                    <div id="searchResults" class="search-results"></div>
                </div>
                <div class="action-buttons">
                    <!--No need for backup button if it only backs up automatically-->
                    <!--<button class="btn btn-primary">
                        <span><?= _('Back-up')?></span>
                        <i class="fa-solid fa-download"></i>
                    </button>-->
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" id="functionsBtn">
                            <span><?= _('Functions')?></span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-content" id="functionsDropdown">
                            <div class="dropdown-item"><?= _('Data Tracking')?></div>
                            <div class="dropdown-item"><?= _('Create Report')?></div>
                            <div class="dropdown-item create-client-btn" data-client-type="mk"><?= _('Create Client')?></div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="content">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Settings Modal -->
    <div id="settingsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><?= _('Settings')?></h2>
                <span class="close-modal">&times;</span>
            </div>
            <div class="modal-body">
                <p>This is a placeholder for the settings page. The actual settings functionality will be implemented in the future.</p>
                <div class="settings-section">
                    <h3>General Settings</h3>
                    <div class="form-group">
                        <label>Theme</label>
                        <select>
                            <option>Light</option>
                            <option>Dark</option>
                            <option>System Default</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Language</label>
                        <select>
                            <option>English</option>
                            <option>Spanish</option>
                            <option>French</option>
                        </select>
                    </div>
                </div>
                <div class="settings-section">
                    <h3>Notification Settings</h3>
                    <div class="form-group">
                        <label>Email Notifications</label>
                        <input type="checkbox" checked>
                    </div>
                    <div class="form-group">
                        <label>Push Notifications</label>
                        <input type="checkbox">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="closeSettingsBtn">Cancel</button>
                <button class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div id="logoutModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><?= _('Confirm Sign Out')?></h2>
                <span class="close-modal">&times;</span>
            </div>
            <div class="modal-body">
                <p><?= _('Are you sure you want to log out?')?></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="cancelLogoutBtn"><?= _('Cancel')?></button>
                <button class="btn btn-danger" id="confirmLogoutBtn"><?= _('Sign out')?></button>
            </div>
        </div>
    </div>

    <script src="/tern_app/SysDev-Ecom_Project/public/js/internal_main.js"></script>
</body>
</html>
