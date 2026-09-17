<?php
    $address1 = $_POST["address1"];
    $address2 = $_POST["address2"];
    $suiteNum = $_POST["suiteNum"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $zipcode = $_POST["zipCode"];

    $servername = "localhost";
    $username = "Quinn";
    $password = "Quinn123";
    $dbname = "construction";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    }

    $request = "INSERT INTO jobs (address1, address2, suiteNum, city, US_state, zipcode) VALUES ('" . $address1 . "', '" . $address2 . "', '" . $suiteNum . "', '" . $city . "', '" . $state . "', '" . $zipcode . "')";
    
    $conn->query($request);

    $conn->close();
    header("Location: index.html");
    exit();
?>