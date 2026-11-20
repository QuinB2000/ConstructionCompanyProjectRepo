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

    echo '<button command="show-modal" commandfor="JobDialog">Add Job</button>

    <dialog id="JobDialog">
    <form action="JobEntry.php" method="post">
        <label for="address1">Address 1:</label>
        <input type="text" id="address1" name="address1" required><br><br>
        <label for="address2">Address 2:</label>
        <input type="text" id="address2" name="address2"><br><br>
        <label for="suiteNum">Suite Number:</label>
        <input type="text" id="suiteNum" name="suiteNum"><br><br>
        <label for="city">City:</label>
        <input type="text" id="city" name="city" required><br><br>
        <label for="state">State:</label>
        <input type="text" id="state" name="state" required><br><br>
        <label for="zipCode">Zip Code:</label>
        <input type="number" id="zipCode" name="zipCode" required><br><br>
        <input type="hidden" name="source" value="ListEntries.php">
        <input type="submit" value="Submit">
    </form>
    <button commandfor="JobDialog" command="close">Close</button>
    </dialog>';

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

    echo ' <button command="show-modal" commandfor="EmployeeDialog">Add Employee</button>
        <dialog id="EmployeeDialog">
        <form action="EmployeeEntry.php" method="post">
            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" name="firstName" required><br><br>
            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="lastName" required><br><br>
            <label for="isSupervisor">Supervisor:</label>
            <input type="checkbox" id="isSupervisor" name="isSupervisor"><br><br>
            <label for="address1">Address 1:</label>
            <input type="text" id="address1" name="address1" required><br><br>
            <label for="address2">Address 2:</label>
            <input type="text" id="address2" name="address2"><br><br>
            <label for="suiteNum">Suite Number:</label>
            <input type="text" id="suiteNum" name="suiteNum"><br><br>
            <label for="city">City:</label>
            <input type="text" id="city" name="city" required><br><br>
            <label for="state">State:</label>
            <input type="text" id="state" name="state" required><br><br>
            <label for="zipCode">Zip Code:</label>
            <input type="number" id="zipCode" name="zipCode" required><br><br>
            <input type="hidden" name="source" value="ListEntries.php">
            <input type="submit" value="Submit">
        </form>
        <button commandfor="EmployeeDialog" command="close">Close</button>
        </dialog>';


    echo "<br><br>";
    echo "<h1>Materials</h1>";

    $sql = "SELECT * FROM materials";
    $result = $conn->query($sql);

    $count = 0;

    echo "<table border='1px solid black'>";
    echo "<thead><tr><th>Units</th><th>Quantity</th><th>Material</th><th></th></tr></thead>";
    echo "<tbody>";
    if ($result->num_rows > 0) 
    {
        while($row = $result->fetch_assoc()) 
        {
            echo "<tr><td>" . $row["units"]. "</td><td>" . $row["quantity"]. "</td><td>" . $row["material"]. "</td><td><button command='show-modal' commandfor='MaterialDialog". $count ."'>Edit</button></td></tr>";
            echo '<dialog id="MaterialDialog'. $count .'">';
            echo "<form action='MaterialEdit.php' method='post'>";
            echo '<label for="units">Unit of measurement:</label>
                <input type="text" id="units" name="units" value="'. $row["units"] .'"><br><br>
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" value="'. $row["quantity"] .'"><br><br>
                <label for="material">Material:</label>
                <input type="text" id="material" name="material" value="'. $row["material"] .'"><br><br>
                <input type="hidden" name="id" value="'. $row["id"] .'">
                <input type="submit" value="Submit">
                </form>
                <button commandfor="MaterialDialog'. $count .'" command="close">Close</button>
                </dialog>';
            $count++;
        }
    }
    echo "</tbody>";
    echo "</table>";

    echo '<button command="show-modal" commandfor="MaterialDialog">Add Material</button>
        <dialog id="MaterialDialog">
        <form action="MaterialEntry.php" method="post">
            <label for="units">Unit of measurement:</label>
            <input type="text" id="units" name="units" required><br><br>
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" required><br><br>
            <label for="material">Material:</label>
            <input type="text" id="material" name="material" required><br><br>
            <input type="hidden" name="source" value="ListEntries.php">
            <input type="submit" value="Submit">
        </form>
        <button commandfor="MaterialDialog" command="close">Close</button>
        </dialog>';

    echo "<br><br>";
    echo "<h1>Trucks</h1>";

    $sql = "SELECT * FROM trucks";
    $result = $conn->query($sql);
    echo "<table border='1px solid black'>";
    echo "<thead><tr><th>truck_id</th><th>capacity</th><th>License Number</th><th></th></tr></thead>";
    echo "<tbody>";

    $count = 0;

    if ($result->num_rows > 0) 
    {
        while($row = $result->fetch_assoc()) 
        {
            echo "<tr><td>" . $row["truck_id"]. "</td><td>" . $row["capacity"]. "</td><td>" . $row["licenseNumber"]. "</td><td><button command='show-modal' commandfor='TruckDialog". $count ."'>Edit</button></td></tr>";
            echo '<dialog id="TruckDialog'. $count .'">
                <form action="TruckEdit.php" method="post">
                    <label for="truckID">Truck ID:</label>
                    <input type="number" id="truckID" name="truckID" value="'. $row["truck_id"] .'"><br><br>
                    <label for="truckCapacity">Truck Capacity:</label>
                    <input type="number" id="truckCapacity" name="truckCapacity" value="'. $row["capacity"] .'"><br><br>
                    <label for="LicenseNum">License Number:</label>
                    <input type="text" id="LicenseNum" name="LicenseNum" value="'. $row["licenseNumber"] .'"><br><br>
                    <input type="hidden" name="id" value="'. $row["id"] .'">
                    <input type="submit" value="Submit">
                </form>
                <button commandfor="TruckDialog"'. $count .'" command="close">Close</button>
                </dialog>';
            
                $count++;
        }
    }
    echo "</tbody>";
    echo "</table>";
    echo '<button command="show-modal" commandfor="TruckDialog">Add Truck</button>
        <dialog id="TruckDialog">
        <form action="TruckEntry.php" method="post">
            <label for="truckID">Truck ID:</label>
            <input type="number" id="truckID" name="truckID"><br><br>
            <label for="truckCapacity">Truck Capacity:</label>
            <input type="number" id="truckCapacity" name="truckCapacity"><br><br>
            <label for="LicenseNum">License Number:</label>
            <input type="text" id="LicenseNum" name="LicenseNum"><br><br>
            <input type="hidden" name="source" value="ListEntries.php">
            <input type="submit" value="Submit">
        </form>
        <button commandfor="TruckDialog" command="close">Close</button>
        </dialog>';

    echo "<br><br>";


?>