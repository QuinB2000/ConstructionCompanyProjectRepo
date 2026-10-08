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

    echo "<h1>Jobs</h1>";
    $sql = "SELECT * FROM jobs";

    $result = $conn->query($sql);
    echo "<table border='1px solid black'>";
    echo "<thead><tr><th>Address 1</th><th>Address 2</th><th>Suite Number</th><th>City</th><th>State</th><th>Zip Code</th></tr></thead>";
    echo "<tbody>";
    if ($result->num_rows > 0) 
    {
        while($row = $result->fetch_assoc()) 
        {
            echo "<tr><td>" . $row["address1"]. "</td><td>" . $row["address2"]. "</td><td>" . $row["suiteNum"]. "</td><td>" . $row["city"]. "</td><td>" . $row["US_state"]. "</td><td>" . $row["zipcode"]. "</td></tr>";
        }
    }
    echo "</tbody>";
    echo "</table>";

    echo "<br><br>";
    echo "<h1>Employees</h1>";


    $sql = "SELECT * FROM employees";
    $result = $conn->query($sql);
    echo "<table border='1px solid black'>";
    echo "<thead><tr><th>First Name</th><th>Last Name</th><th>Supervisor</th><th>Address 1</th><th>Address 2</th><th>Suite Number</th><th>City</th><th>State</th><th>Zip Code</th></tr></thead>";
    echo "<tbody>";
    if ($result->num_rows > 0) 
    {
        while($row = $result->fetch_assoc()) 
        {
            if ($row["isSupervisor"] == 1) 
            {
                $row["isSupervisor"] = "Yes";
            } else 
            {
                $row["isSupervisor"] = "No";
            }
            echo "<tr><td>" . $row["firstName"]. "</td><td>" . $row["lastName"]. "</td><td>" . $row["isSupervisor"]. "</td><td>" . $row["address1"]. "</td><td>" . $row["address2"]. "</td><td>" . $row["suiteNum"]. "</td><td>" . $row["city"]. "</td><td>" . $row["US_state"]. "</td><td>" . $row["zipcode"]. "</td></tr>";
        }
    }
    echo "</tbody>";
    echo "</table>";

    echo "<br><br>";
    echo "<h1>Materials</h1>";

    $sql = "SELECT * FROM materials";
    $result = $conn->query($sql);
    echo "<table border='1px solid black'>";
    echo "<thead><tr><th>Units</th><th>Quantity</th><th>Material</th></tr></thead>";
    echo "<tbody>";
    if ($result->num_rows > 0) 
    {
        while($row = $result->fetch_assoc()) 
        {
            echo "<tr><td>" . $row["units"]. "</td><td>" . $row["quantity"]. "</td><td>" . $row["material"]. "</td></tr>";
        }
    }
    echo "</tbody>";
    echo "</table>";

    echo "<br><br>";
    echo "<h1>Trucks</h1>";

    $sql = "SELECT * FROM trucks";
    $result = $conn->query($sql);
    echo "<table border='1px solid black'>";
    echo "<thead><tr><th>truck_id</th><th>capacity</th><th>License Number</th></tr></thead>";
    echo "<tbody>";
    if ($result->num_rows > 0) 
    {
        while($row = $result->fetch_assoc()) 
        {
            echo "<tr><td>" . $row["truck_id"]. "</td><td>" . $row["capacity"]. "</td><td>" . $row["licenseNumber"]. "</td></tr>";
        }
    }
    echo "</tbody>";
    echo "</table>";

    echo "<br><br>";


?>