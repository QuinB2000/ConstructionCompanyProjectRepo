<?php

$unit = $_POST["UnitType"];
$quantity = $_POST["Amount"];
$material = $_POST["material"];

$servername = "localhost";
$username = "Quinn";
$password = "Quinn123";
$dbname = "construction";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO materials (units, quantity, material)
VALUES ('$unit', '$quantity', '$material')";

if (!($conn->query($sql) === TRUE))
{
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

header("Location: https://localhost/ConstructionCompanyProjectRepo/EntryList.php?type=material");
exit;
?>