<?php
    $address1 = $_POST["address1"];
    $address2 = $_POST["address2"];
    $suiteNum = $_POST["suiteNum"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $zipcode = $_POST["zipCode"];

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

    $request = "INSERT INTO jobs (address1, address2, suiteNum, city, US_state, zipcode) VALUES ('" . $address1 . "', '" . $address2 . "', '" . $suiteNum . "', '" . $city . "', '" . $state . "', '" . $zipcode . "')";
    
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