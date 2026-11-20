<?php
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $isSupervisor = isset($_POST["isSupervisor"]) ? 1 : 0;
    $address1 = $_POST["address1"];
    $address2 = $_POST["address2"];
    $suiteNum = $_POST["suiteNum"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $zipcode = $_POST["zipCode"];
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

    $request = "UPDATE employees SET firstName='" . $firstName . "', lastName='" . $lastName . "', isSupervisor=" . $isSupervisor . ", address1='" . $address1 . "', address2='" . $address2 . "', suiteNum='" . $suiteNum . "', city='" . $city . "', US_state='" . $state . "', zipcode='" . $zipcode . "' WHERE id=" . $id;
    
    $conn->query($request);

    $conn->close();
    header("Location: ListEntries.php");
    exit();
?>