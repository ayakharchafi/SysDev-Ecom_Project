<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/tern_app/SysDev-Ecom_Project/public/css/export.css">
 
    <title>Document</title>
</head>
<body>
<div class="export-form">
<!-- <h2>Choose client to export:</h2>
<select id="clientSelect">
    <option value="">Select Client</option>
    <option value="os">OS</option>
    <option value="mk">MK</option>
    <option value="bg">BG</option>
</select> -->

<!-- <h2>Select the CSV file:</h2>
<input type="file" id="csvFile" accept=".csv">
<br><br>
<button id="exportbutton">export</button> -->
<h2>Export MK table as a  CSV file:</h2>
<form method="post" action="export.php">
    <input type="submit" name="export" value="CSV Export"/>
</form>
</div>

</body>
<!-- <script src="/tern_app/SysDev-Ecom_Project/public/js/import.js"></script> -->

</html>
<?php
require_once __DIR__ . '/../../Core/Database/databaseconnectionmanager.php';

use database\DatabaseConnectionManager;


$connect = mysqli_connect("localhost","root","", "terndatabase");
$query= "SELECT * FROM mk_occupancy_reports ORDER BY id asc";
$result = mysqli_query($connect, $query);
while($row = mysqli_fetch_array($result)){

}


