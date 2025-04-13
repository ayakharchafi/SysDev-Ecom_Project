<?php

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
            <!-- Add username display -->
            <div class="username-display">
              Logged in as: <?= htmlspecialchars($_SESSION['user']) ?>
            </div>
            
            <!-- Rest of your original content -->
            <div class="rectangle"></div>
            <div class="div"></div>
            <div class="ellipse"></div>
            <div class="rectangle-2"></div>
            <div class="text-wrapper">Search</div>
            <div class="text-wrapper-2">File Manager</div>
            <div class="text-wrapper-3">Tables</div>
            <!-- Fix image paths -->
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
            <div class="function-button">
              <div class="overlap-2"><div class="text-wrapper-7">Functions</div></div>
            </div>
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
            <div class="text-wrapper-10">Clients</div>
            <div class="text-wrapper-11">Import</div>
            <div class="text-wrapper-12">Username</div>
            <img class="back_up" src="/tern_application/public/img/download.svg" />
            <img class="arrow_down" src="/tern_application/public/img/arrow_down2.png" />
          </div>
          <div class="overlap-3">
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
  </body>
</html>