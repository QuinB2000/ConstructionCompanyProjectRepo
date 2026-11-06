<?php

// Retrieve POST data
$truckText = isset($_POST["TrucksCSV"]) ? $_POST["TrucksCSV"] : "";
$peopleText = isset($_POST["PeopleCSV"]) ? $_POST["PeopleCSV"] : "";
$materialText = isset($_POST["MaterialCSV"]) ? $_POST["MaterialCSV"] : "";

$assignmentID = $_POST["assignmentID"];

$TrucksCSV = str_getcsv($truckText, separator: ' ');
$PeopleCSV = str_getcsv($peopleText, separator: ' ');
$MaterialCSV = str_getcsv($materialText, separator: ',');

echo "Trucks: " . $truckText . "<br>";
echo "People: " . $peopleText . "<br>";
echo "Materials: " . $materialText . "<br>";


$servername = "127.0.0.1";
$username = "root";
$password = "";
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

        $request = "SELECT * FROM materials WHERE id = '" . $material . "'";
        $result = $conn->query($request);
        $row = $result->fetch_assoc();
        $type = $row["material"];
        $availableQuantity = $row["quantity"];
        $units = $row["units"];
        $newQuantity = $availableQuantity - $quantity;
        if ($newQuantity > 0) {
            $request = "UPDATE materials SET quantity = " . $newQuantity . " WHERE id = '" . $material . "'";
            $conn->query($request);
            $text .= "material " . $material . ",";
            //Text in assignment should reflect the materials allocated here. Come up with scheme to track how many materials are allocated to a given assignment
            $request = "SELECT * FROM materials_assignment_specific where id = " . $assignmentID . " AND material = " . $type . " AND units = '" . $units . "'";
            $result = $conn->query($request);
            $row = $result->fetch_assoc();
            if ($row) {
                $existingQuantity = $row["quantity"];
                $request = "UPDATE materials_assignment_specific SET quantity = " . ($existingQuantity + $quantity) . " WHERE id = " . $assignmentID . " AND material = " . $type . " AND units = '" . $units . "'";
                $conn->query($request);
            } else {
                $request = "INSERT INTO materials_assignment_specific (id, material, quantity, units) VALUES (" . $assignmentID . ", " . $type . ", " . $quantity . ", '" . $units . "')";
                $conn->query($request);
            }
        }
        else {
            // Handle the case where there is not enough quantity available
        }
    }

    $text = rtrim($text, ",");
    $request = "UPDATE assignments SET resources = '" . $text . "' WHERE id = " . $assignmentID;
    $conn->query($request);
    $conn->close();

    //header("Location: AssignmentList.php");

?>