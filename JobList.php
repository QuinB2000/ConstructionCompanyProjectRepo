<?php
    $servername = "localhost";
    $username = "Quinn";
    $password = "Quinn123";
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