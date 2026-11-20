<?php
    $units = $_POST["units"];
    $quantity = $_POST["quantity"];
    $material = $_POST["material"];
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

    $request = "UPDATE materials SET units='" . $units . "', quantity=" . $quantity . ", material='" . $material . "' WHERE id=" . $id;
    
    $conn->query($request);

    $conn->close();
    header("Location: ListEntries.php");
    exit();
?>