<?php
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "construction";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    }   

    $request = "SELECT * FROM jobs";
    $result = $conn->query($request);
    while ($row = $result->fetch_assoc())
    {
        
    }

?>