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
        $text = $text . "truck " . $truck . ",";
    }

    for ($i = 0; $i < count($PeopleCSV); $i++)
    {
        $people = null;
        if (sscanf($PeopleCSV[$i], "%s", $people) !== 1 || empty($people)) 
        {
            continue;
        }
        $text .= "employee " . $people . ",";
    }
    
    //For materials, updating a job with materials will check the quantity of materials available, subtract the used quantity, and then update the assignment

    for($i = 0; $i < count($MaterialCSV); $i++)
    {
        $material = null;
        $quantity = null;
        if (sscanf($MaterialCSV[$i], "%s %s", $material, $quantity) !== 2 || empty($material) || empty($quantity)) 
        {
            continue;
        }

        $request = "SELECT quantity FROM materials WHERE id = '" . $material . "'";
        $result = $conn->query($request);
        $availableQuantity = $result->fetch_assoc()["quantity"];
        $newQuantity = $availableQuantity - $quantity;
        if ($newQuantity > 0) {
            $request = "UPDATE materials SET quantity = " . $newQuantity . " WHERE id = '" . $material . "'";
            $conn->query($request);
            $text .= "material " . $material . ",";
            //Text in assignment should reflect the materials allocated here. Come up with scheme to track how many materials are allocated to a given assignment
        }
        else {
            // Handle the case where there is not enough quantity available
        }
    }

    $text = rtrim($text, ",");
    $request = "UPDATE assignments SET resources = '" . $text . "' WHERE id = " . $assignmentID;
    $conn->query($request);
    $conn->close();

?>