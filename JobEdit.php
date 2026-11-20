<?php
    $id = $_POST["id"];
    $address1 = $_POST["address1"];
    $address2 = $_POST["address2"];
    $suiteNum = $_POST["suiteNum"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $zipcode = $_POST["zipCode"];

    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "construction";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    }

    $request = "UPDATE jobs SET address1='" . $address1 . "', address2='" . $address2 . "', suiteNum='" . $suiteNum . "', city='" . $city . "', US_state='" . $state . "', zipcode='" . $zipcode . "' WHERE id=" . $id;
    
    $conn->query($request);

    $conn->close();
    header("Location: ListEntries.php");
    exit();
?>