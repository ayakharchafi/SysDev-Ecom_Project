<?php
if(isset($_POST["export"])){
    $connect = mysqli_connect("localhost","root","", "terndatabase");
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=data.csv');
$output= fopen("php://output","w");
fputcsv($output, array( 'Location id',
            'First date of coverage',
            'Last date of coverage',
            'Location address',
            'Location postal code',
            'Location city',
            'Location province',
            'Number of bedrooms',
            'Number of days occupied',
            'Currency',
            'Premium collected',
            'Is archived'));
$query= "SELECT * FROM mk_occupancy_reports ORDER BY id asc";
$result = mysqli_query($connect, $query);
while($row = mysqli_fetch_assoc($result)){
    fputcsv($output, $row);
}
fclose($output);
}