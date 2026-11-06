<?php
    $units = $_POST["units"];
    $quantity = $_POST["quantity"];
    $material = $_POST["material"];

    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "construction";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    }

    $request = "INSERT INTO materials (units, quantity, material) VALUES ('" . $units . "', " . $quantity . ", '" . $material . "')";
    
    $conn->query($request);

    $conn->close();
    header("Location: index.html");
    exit();
?>