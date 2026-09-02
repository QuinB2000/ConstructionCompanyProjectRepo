<?php

// Retrieve POST data
$truckText = isset($_POST["truckText"]) ? $_POST["truckText"] : "";
$peopleText = isset($_POST["peopleText"]) ? $_POST["peopleText"] : "";
$materialText = isset($_POST["materialText"]) ? $_POST["materialText"] : "";

$assignmentID = $_POST["assignmentID"];

$TrucksCSV = str_getcsv($truckText, separator: ' ');
$PeopleCSV = str_getcsv($peopleText, separator: ' ');
$MaterialCSV = str_getcsv($materialText, separator: ',');

$servername = "localhost";
$username = "Quinn";
$password = "Quinn123";
$dbname = "construction";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
}

    $request = "SELECT resources FROM assignments WHERE id = " . $assignmentID;
    $result = $conn->query($request);

    $text = $result->fetch_assoc()["resources"];

    for ($i = 0; $i < count($TrucksCSV); $i++)
    {
        sscanf($TrucksCSV[$i], "%s", $truck);
        if (empty($truck)) {
            continue;
        }
        $text = $text . ", truck" . $truck;
    }

    for ($i = 0; $i < count($PeopleCSV); $i++)
    {
        sscanf($PeopleCSV[$i], "%s", $people);
        if (empty($people)) {
            continue;
        }
        $text = $text . ", employee " . $people;
    }

    $request = "UPDATE assignments SET resources = '" . $text . "' WHERE id = " . $assignmentID;
    $conn->query($request);
    $conn->close();

?>