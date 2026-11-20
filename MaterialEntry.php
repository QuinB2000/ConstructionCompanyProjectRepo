<?php
    $units = $_POST["units"];
    $quantity = $_POST["quantity"];
    $material = $_POST["material"];
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


    $request = "SELECT * FROM materials WHERE units='" . $units . "' AND material='" . $material . "'";

    $result = $conn->query($request);

    if ($result->num_rows == 0) {
        $request = "INSERT INTO materials (units, quantity, material) VALUES ('" . $units . "', " . $quantity . ", '" . $material . "')";
        $conn->query($request);
    }
    else
    {
        $row = $result->fetch_assoc();
        $newQuantity = $row["quantity"] + $quantity;
        $request = "UPDATE materials SET quantity=" . $newQuantity . " WHERE units='" . $units . "' AND material='" . $material . "'";
        $conn->query($request);
    }

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