<?php
    $truckID = $_POST["truckID"];
    $truckCapacity = $_POST["truckCapacity"];
    $licenseNum = $_POST["LicenseNum"];

    $servername = "localhost";
    $username = "Quinn";
    $password = "Quinn123";
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