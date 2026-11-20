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

    echo "<h1>Jobs</h1>";
    $sql = "SELECT * FROM jobs";

    $result = $conn->query($sql);
    echo "<table border='1px solid black'>";
    echo "<thead><tr><th>Address 1</th><th>Address 2</th><th>Suite Number</th><th>City</th><th>State</th><th>Zip Code</th><th></th></tr></thead>";
    echo "<tbody>";
    $count = 0;
    if ($result->num_rows > 0) 
    {
        while($row = $result->fetch_assoc()) 
        {
            echo "<tr><td>" . $row["address1"]. "</td><td>" . $row["address2"]. "</td><td>" . $row["suiteNum"]. "</td><td>" . $row["city"]. "</td><td>" . $row["US_state"]. "</td><td>" . $row["zipcode"]. '</td><td><button command="show-modal" commandfor="JobDialog'. $count .'">Edit</button></td></tr>';
            echo '<dialog id="JobDialog'. $count .'">
                <form action="JobEdit.php" method="post">
                <label for="address1" value="'. $row["address1"] .'">Address 1:</label>
                <input type="text" id="address1" name="address1" value="'. $row["address1"] .'" required><br><br>
                <label for="address2">Address 2:</label>
                <input type="text" id="address2" name="address2" value="'. $row["address2"] .'"><br><br>
                <label for="suiteNum">Suite Number:</label>
                <input type="text" id="suiteNum" name="suiteNum" value="'. $row["suiteNum"] .'"><br><br>
                <label for="city">City:</label>
                <input type="text" id="city" name="city" value="'. $row["city"] .'" required><br><br>
                <label for="state">State:</label>
                <input type="text" id="state" name="state" value="'. $row["US_state"] .'" required><br><br>
                <label for="zipCode">Zip Code:</label>
                <input type="number" id="zipCode" name="zipCode" value="'. $row["zipcode"] .'" required><br><br>
                <input type="hidden" name="id" value="'. $row["id"] .'">
                <input type="submit" value="Submit">
                </form>
            <button commandfor="JobDialog'. $count .'" command="close">Close</button>
            </dialog>';
        
            $count++;
        }
    }
    echo "</tbody>";
    echo "</table>";

    echo "<br><br>";
    echo "<h1>Employees</h1>";

    $count = 0;
    $sql = "SELECT * FROM employees";
    $result = $conn->query($sql);
    echo "<table border='1px solid black'>";
    echo "<thead><tr><th>First Name</th><th>Last Name</th><th>Supervisor</th><th>Address 1</th><th>Address 2</th><th>Suite Number</th><th>City</th><th>State</th><th>Zip Code</th><th></th></tr></thead>";
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
            echo "<tr><td>" . $row["firstName"]. "</td><td>" . $row["lastName"]. "</td><td>" . $row["isSupervisor"]. "</td><td>" . $row["address1"]. "</td><td>" . $row["address2"]. "</td><td>" . $row["suiteNum"]. "</td><td>" . $row["city"]. "</td><td>" . $row["US_state"]. "</td><td>" . $row["zipcode"]. "</td><td><button command='show-modal' commandfor='EmployeeDialog". $count ."'>Edit</button></td></tr>";
            echo '<dialog id="EmployeeDialog'. $count .'">
            <form action="EmployeeEdit.php" method="post">
                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="firstName" value="'. $row["firstName"] .'"><br><br>
                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="lastName" value="'. $row["lastName"] .'"><br><br>
                <label for="isSupervisor">Supervisor:</label>
                <input type="checkbox" id="isSupervisor" name="isSupervisor" '. ($row["isSupervisor"] == "Yes" ? "checked" : "") .'><br><br>
                <label for="address1">Address 1:</label>
                <input type="text" id="address1" name="address1"  value="'. $row["address1"] .'"><br><br>
                <label for="address2">Address 2:</label>
                <input type="text" id="address2" name="address2" value="'. $row["address2"] .'"><br><br>
                <label for="suiteNum">Suite Number:</label>
                <input type="text" id="suiteNum" name="suiteNum" value="'. $row["suiteNum"] .'"><br><br>
                <label for="city">City:</label>
                <input type="text" id="city" name="city"  value="'. $row["city"] .'"><br><br>
                <label for="state">State:</label>
                <input type="text" id="state" name="state"  value="'. $row["US_state"] .'"><br><br>
                <label for="zipCode">Zip Code:</label>
                <input type="number" id="zipCode" name="zipCode"  value="'. $row["zipcode"] .'"><br><br>
                <input type="hidden" id="id" name="id" value="'. $row["id"] .'">
                <input type="submit" value="Submit">
            </form>
            <button commandfor="EmployeeDialog'. $count .'" command="close">Close</button>
            </dialog>';
            
            
            $count++;
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