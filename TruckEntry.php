<?php
    $truckID = $_POST["truckID"];
    $truckCapacity = $_POST["truckCapacity"];
    $licenseNum = $_POST["LicenseNum"];

    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "construction";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    }

    $request = "INSERT INTO trucks (truck_id, capacity, licenseNumber) VALUES (" . $truckID . ", " . $truckCapacity . ", '" . $licenseNum . "')";
    
    $conn->query($request);

    $conn->close();
    header("Location: index.html");
    exit();
?>