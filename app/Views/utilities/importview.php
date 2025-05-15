<?php
require_once __DIR__ . '/../../Core/Database/databaseconnectionmanager.php';

use database\DatabaseConnectionManager;


$conn = mysqli_connect("localhost","root","");
mysqli_select_db($conn, "terndatabase");
if(isset($_POST['uploadfile'])){

    $csvTemp = $_FILES["csvfile"]["tmp_name"];
    $getContent = file($csvTemp);
    $handle = fopen($csvTemp, 'r');
    
    $i = 0;
    while (($row = fgetcsv($handle)) !== false) {
        // Skip the header row
        if ($i++ === 0) continue;

        // Ensure exactly 13 values
        if (count($row) < 12) {
            echo " Skipping row $i: not enough columns<br>";
            continue;
        }

        // Clean values
        $cleaned = array_map(function ($value) {
            return trim(str_replace('$', '', $value));
        }, $row);

        list(
            $LocationID,
            $FirstDateofCoverage,
            $LastDateofCoverage,
            $LocationAddress,
            $LocationPostalCode,
            $LocationCity,
            $LocationProvince,
            $Numberofbedrooms,
            $Numberofdaysoccupied,
            $Currency,
            $PremiumCollected,
            $Extra 
        ) = $cleaned;

        $query = "INSERT INTO mk_occupancy_reports (
            location_id,
            first_date_of_coverage,
            last_date_of_coverage,
            location_address,
            location_postal_code,
            location_city,
            location_province,
            number_of_bedrooms,
            number_of_days_occupied,
            currency,
            premium_collected,
            is_archived
        ) VALUES (
            '$LocationID', '$FirstDateofCoverage', '$LastDateofCoverage', 
            '$LocationAddress', '$LocationPostalCode', '$LocationCity', 
            '$LocationProvince', '$Numberofbedrooms', '$Numberofdaysoccupied',
            '$Currency', '$PremiumCollected', 0
        )";
         if (!mysqli_query($conn, $query)) {
            echo " Error on row $i: " . mysqli_error($conn) . "<br>";
        }
    }

    fclose($handle);
    echo "<br> CSV Import completed.";

}
?>
<style>
    .import-wrapper {
        max-width: 500px;
        margin: 80px auto;
        background-color: #f5f5f5;
        padding: 30px 40px;
        border-radius: 12px;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }

    .import-wrapper h2 {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 20px;
        color: #2c3e50;
    }

    .import-wrapper input[type="file"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        background-color: white;
        font-size: 15px;
        margin-bottom: 25px;
    }

    .import-wrapper button {
        width: 120px;
        padding: 10px 15px;
        background-color: #3498db;
        color: white;
        font-weight: bold;
        font-size: 16px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .import-wrapper button:hover {
        background-color: #2980b9;
    }
</style>

<div class="import-wrapper">
    <h2>Select the CSV file:</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" enctype="multipart/form-data">
        <input type="file" name="csvfile" accept=".csv" required>
        <button type="submit" name="uploadfile">import</button>
    </form>
</div>
