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

<form method="post" action=" <?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" enctype="multipart/form-data">
    <input type="file" name="csvfile">
    <button class= "btn" name="uploadfile">import</button>
</form>
