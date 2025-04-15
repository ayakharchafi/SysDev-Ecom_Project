<?php
//session_start();

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: /tern_application/login');
    exit;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="/tern_application/public/css/global.css" />
    <link rel="stylesheet" href="/tern_application/public/css/style_main.css" />
  </head>
  <body>
    <div class="dashboard-main">
      <div class="overlap-wrapper">
        <div class="overlap">
          <div class="overlap-group">
            <!-- Username Display -->
            <div class="username-display">
              Logged in as: <?= htmlspecialchars($_SESSION['user']) ?>
            </div>
            
            <!-- Existing Content -->
            <div class="rectangle"></div>
            <div class="div"></div>
            <div class="ellipse"></div>
            <div class="rectangle-2"></div>
            <div class="text-wrapper">Search</div>
            <div class="text-wrapper-2">File Manager</div>
            <div class="text-wrapper-3">Tables</div>
            <img class="search-icon" src="/tern_application/public/img/search.svg" />
            <div class="text"></div>
            <p class="settings"><span class="span">Settings</span> <span class="text-wrapper-4">&nbsp;</span></p>
            <a href="/tern_application/logout" class="log-out">
              <span class="text-wrapper-5">Log Out</span> 
              <span class="text-wrapper-4">&nbsp;</span>
            </a>
            <div class="create-button">
              <div class="div-wrapper"><div class="text-wrapper-6">Back-Up</div></div>
            </div>

            <!-- Functions Button (Updated Structure) -->
            <div class="function-button" id="functionsButton" style="cursor: pointer;">
              <div class="overlap-2">
                <div class="text-wrapper-7">Functions</div>
                <img class="arrow_down" 
                     src="/tern_application/public/img/arrow_down2.png" 
                     id="functionsArrow"
                     style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px;" />
              </div>
              <div class="dropdown-menu" id="functionsDropdown">
                <a href="#" class="dropdown-item">Data Tracking</a>
                <a href="#" class="dropdown-item">Modify User</a>
                <a href="#" class="dropdown-item">Create Report</a>
                <a href="#" class="dropdown-item">Batch Update</a>
                <a href="#" class="dropdown-item">Create Client</a>
              </div>
            </div>

            <!-- Clients Button (Updated Structure) -->
            <div class="text-wrapper-10" id="clientsButton" style="cursor: pointer; position: relative;">
              Clients
              <img class="arrow_down" 
                   src="/tern_application/public/img/arrow_down2.png" 
                   id="clientsArrow"
                   style="position: absolute; left: 130px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px;" />
              <div class="dropdown-menu" id="clientsDropdown">
                <div class="client-item">Client 1</div>
                <div class="client-item">Client 2</div>
                <div class="client-item">Client 3</div>
                <div class="client-item">Client 4</div>
                <div class="client-item">Client 5</div>
              </div>
            </div>

            <!-- Remaining Original Content -->
            <img class="line" src="/tern_application/public/img/line-1.svg" />
            <img class="settings-icon" src="/tern_application/public/img/settings.svg" />
            <img class="log-out-icon" src="/tern_application/public/img/logout.svg" />
            <div class="rectangle-3"></div>
            <div class="rectangle-4"></div>
            <div class="rectangle-5"></div>
            <div class="rectangle-6"></div>
            <div class="text-wrapper-8">Users</div>
            <div class="text-wrapper-9">Export</div>
            <img class="img" src="/tern_application/public/img/line-10.svg" />
            <div class="text-wrapper-11">Import</div>
            <div class="text-wrapper-12">Username</div>
            <img class="back_up" src="/tern_application/public/img/download.svg" />
          </div>
          <div class="overlap-3">
            <!-- Table Structure -->
            <div class="rectangle-7"></div>
            <img class="line-2" src="/tern_application/public/img/line-18.svg" />
            <img class="line-3" src="/tern_application/public/img/line-16.svg" />
            <img class="line-4" src="/tern_application/public/img/line-17.svg" />
            <img class="line-5" src="/tern_application/public/img/line-14.svg" />
            <img class="line-6" src="/tern_application/public/img/line-15.svg" />
            <img class="line-7" src="/tern_application/public/img/line-13.svg" />
            <img class="line-8" src="/tern_application/public/img/line-12.svg" />
            <img class="line-9" src="/tern_application/public/img/line-11.svg" />
          </div>
        </div>
      </div>
    </div>

    <!-- JavaScript -->
    <script src="/tern_application/public/js/main.js"></script>
  </body>
</html>