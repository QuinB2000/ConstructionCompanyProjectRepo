<?php
    $date = $_POST["date"];
    $job_id = $_POST["job_id"];
    $start_time = $_POST["start_time"];
    $end_time = $_POST["end_time"];

    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "construction";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    }

    $request = 'INSERT INTO assignments (date, job_id, start_time, end_time) VALUES ("' . $date . '", ' . $job_id . ', "' . $start_time . '", "' . $end_time . '")';
    
    $conn->query($request);

    $conn->close();
    header("Location: index.html");
    exit();
?>