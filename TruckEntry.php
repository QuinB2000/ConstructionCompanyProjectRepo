<?php
    $truckID = $_POST["truckID"];
    $truckCapacity = $_POST["truckCapacity"];
    $licenseNum = $_POST["LicenseNum"];
    $source = $_POST["source"];

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
    if ($source === "index.html") {
        header("Location: index.html");
    } else if ($source === "ListEntries.php") {
        header("Location: ListEntries.php");
    } else {
        // Default redirection if source is not recognized
        header("Location: index.html");
    }
    exit();
?>