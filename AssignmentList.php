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

    $sql = "SELECT * FROM assignments";
    $result = $conn->query($sql);

    if ($result->num_rows > 0)
    {
        while($row = $result->fetch_assoc()) 
        {
                echo "<h1>job " . $row["job_id"] . "</h1>";
                echo "Date: " . $row["date"] . "<br>";
                echo "start time: " . $row["start_time"] . "<br>";
                echo "end time: " . $row["end_time"] . "<br>";

                $temp = $row["resources"];
                $resources = explode(",", $temp);
                for ($i = 0; $i < count($resources); $i++) 
                {
                    $temp = explode(" ", $resources[$i]);
                    if ($temp[0] == "employee")
                    {
                        $sql = "SELECT firstName, lastName FROM employees WHERE id = " . $temp[1];
                        $employee_result = $conn->query($sql);
                        if ($employee_result->num_rows > 0) {
                            $employee_row = $employee_result->fetch_assoc();
                            echo $employee_row["firstName"] . " " . $employee_row["lastName"] . "<br>";
                        }
                    }
                    else if ($temp[0] == "material")
                    {
                        $sql = "SELECT material, units, quantity FROM materials WHERE id = " . $temp[1];
                        $material_result = $conn->query($sql);
                        if ($material_result->num_rows > 0) {
                            $material_row = $material_result->fetch_assoc();
                            echo $material_row["quantity"] . " " . $material_row["units"] . " of " . $material_row["material"] . "<br>";
                        }
                    }
                    else if ($temp[0] == "truck")
                    {
                        $sql = "SELECT truck_id FROM trucks WHERE id = " . $temp[1];
                        $truck_result = $conn->query($sql);
                        if ($truck_result->num_rows > 0) {
                            $truck_row = $truck_result->fetch_assoc();
                            echo "Truck ID: " . $truck_row["truck_id"] . "<br>";
                        }
                    }
                }
        }
    } 
    else 
    {
        echo "0 results";
    }
    $conn->close();
?>