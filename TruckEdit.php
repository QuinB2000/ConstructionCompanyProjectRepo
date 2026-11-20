<?php
    $truckID = $_POST["truckID"];
    $truckCapacity = $_POST["truckCapacity"];
    $licenseNum = $_POST["LicenseNum"];
    $id = $_POST["id"];

    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "construction";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    }

    $request = "UPDATE trucks SET truck_id=" . $truckID . ", capacity=" . $truckCapacity . ", licenseNumber='" . $licenseNum . "' WHERE id=" . $id;
    $conn->query($request);

    $conn->close();
    header("Location: ListEntries.php");
    exit();
?>