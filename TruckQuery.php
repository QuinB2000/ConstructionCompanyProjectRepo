<?php

$id = $_POST["truckID"];
$capacity = $_POST["truckCapacity"];
$license = $_POST["LicenseNum"];

$servername = "localhost";
$username = "Quinn";
$password = "Quinn123";
$dbname = "construction";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO trucks (truck_id, capacity, licenseNumber)
VALUES ('$id', '$capacity', '$license')";

if (!($conn->query($sql) === TRUE))
{
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
header("Location: https://localhost/ConstructionCompanyProjectRepo/EntryList.php?type=truck");
exit;
?>