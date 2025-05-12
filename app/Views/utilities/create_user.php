<?php
namespace controllers;


require __DIR__.'/../../../vendor/autoload.php'; 
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__."/../../../");
$dotenv->load();
use models\User;
use views\utilities\settings;
use database\DatabaseConnectionManager;
use models\Client;
require_once __DIR__ . "/../../Models/Client.php";
require_once __DIR__ . "/../../Models/User.php";
require_once __DIR__ . "/../../Core\Database\databaseconnectionmanager.php";
class CreateUserController
{
    private $createdUser;
    private $dbConnection;
    //  private $admin;

    public function __construct()
    {
        // Initialize the database connection
        $this->createUser = new User();
        $this->dbConnection = (new DatabaseConnectionManager())->getConnection();
        //   $this->admin = (new User())->readByUsername('Ian');
    }

    public function displaySettings()
    {
        echo $this->getSettingsHTML();
    }
    private function translate($text)
    {
        return _($text);
    }

    public function read()
    {
        $query = "SELECT * FROM users";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    private function getSettingsHTML()
    {
        $clients = new Client();
        $data = $clients->read();
        $options = $clients->displayOptions($data);
        return <<<HTML
      <!DOCTYPE html>
      <html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
  
</head>
<body  onload = "getTheme()">
    <style>

#create_content {
    background-color: var(--sidebar-bg);
}
.row {
  display: flex;
}

.column {
  flex: 50%;
}
    </style>
<div class="top-bar">
<div class="search-container">
                    <i class="fa-solid fa-search"></i>
                    <input type="text" id="searchInput" placeholder="{$this->translate('Search')}">
                    <div id="searchResults" class="search-results"></div>
                </div>
                <h2>Modify User - Create User </h2>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" id="cfunctionsBtn">
                            <span>{$this->translate("Modify Functions")}</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-content" id="cfunctionsDropdown">
                        <div class="dropdown-item" id = "createUserBtn">{$this->translate(
            "Create User"
        )}</div>
                            <div class="dropdown-item" id = "deleteUserBtn">{$this->translate(
            "Delete User"
        )}</div>
                        </div>
                    </div>
                </div>
            <div class = "content" id = "create_content">

            

                    <form   action = "/tern_app/SysDev-Ecom_Project/dashboard" method = "POST" >
<div class = "row">

<div class = "column" >
                <div class="search-container">
              
                    <label style = "color: white;" for="">Username:</label>
                    <br>
                    <br>
                    <input type="text" required class = "TextInput" placeholder="Enter Username"  name ="NewUsername"  >
</div>
                <div class="search-container">
                <br>
                <br>
                    <label  style = "color: white;"for="">Email:</label>
                    <br>
                    <br>
                    <input type="text" required  pattern="[^ @]*@[^ @]*" class = "TextInput" placeholder="Enter Email"    name = "NewEmail" >
                </div>
                <div class="search-container">
                <br>
                <br>
                    <label style = "color: white;" for="">Password:</label>
                    <br>
                    <br>
                    <input type="password" required class = "TextInput" placeholder="Enter Password"  name = "NewPassword" >

                </div>

                </div>

                <div class = "column" >
                <br>
                <h2 style = "color: white;">
                  Enable 2FA
                </h2>     
  <Select class = "confirm-button"  name = "2FA" >

<option value="enabled">Enable 2FA</option>
<option value=" ">Disable 2FA</option>
    </Select>
    <br>
    <br>
                    <h2 style = "color: white;">
                    Enter User Type
                </h2>
<Select class = "confirm-button" onchange ="showExternalInput()" id="roleBox" name = "newRole" >
<option value="Internal">Internal</option>
<option value="External">External</option>
    </Select>
    <br>
    <br> 
    <div style = "display: none;" id="externalInput">
                 
    <Select class = "confirm-button" name  = "newClient">
    {$this->translate($options)}
          </Select>

    </div>
</div>
                </div>


                  <!-- Logout Confirmation Modal -->
  <div id="CreateModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>{$this->translate("Confirm User Creation")}</h2>
                <span class="close-modal">&times;    
      </span>


      </div>
      <div class="modal-body">
                <p>{$this->translate(
            "Confirm User Creation by entering Admin Password"
        )}</p>

                <div class="search-container">
                <br>
                <input type="password" required class = "TextInput" placeholder="Enter Admin Password"  name = "adminPassword" >
                <div id="searchResults" class="search-results"></div>
            </div>
            </div>
            <div class="modal-footer">
               <input class = "confirm-button" type="submit" value = "{$this->translate('Confirm'   )}">
            </div>
        </div>
    </div>
                </form>
                </div>
                </div>

                </div>
                <div class = "create-button" id="CreateBtn">
                    <span>{$this->translate("Create")}</span>
                </div>

    <script src="/tern_app/SysDev-Ecom_Project/public/js/create.js"></script>
</body>
</html>
HTML;
    }
}
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $settings = new CreateUserController();
    $settings->displaySettings();
}

$admin = new User();
$admin->readByUsername("Ian");

?>
