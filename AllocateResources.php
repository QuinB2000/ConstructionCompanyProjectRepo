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

    $sql = "SELECT * FROM assignments WHERE id = " . $_POST['id'];
    $result = $conn->query($sql);

    $row = $result->fetch_assoc();

    $startTime = $row["start_time"];
    $endTime = $row["end_time"];    

    $sql = "SELECT resources FROM assignments WHERE (start_time BETWEEN '" . $startTime . "' AND '" . $endTime . "') OR (end_time BETWEEN '" . $startTime . "' AND '" . $endTime . "') or (start_time <= '" . $startTime . "' AND end_time >= '" . $endTime . "')";
    $result = $conn->query($sql);


    $unavailableTrucks = array();
    $unavailableEmployees = array();
    $unavailableMaterials = array();

    $maxTruckIDs = 0;
    $maxEmployeeIDs = 0;
    $maxMaterialIDs = 0;

    while ($row = $result->fetch_assoc()) 
    {
        $resources = $row["resources"];
        $csv = explode(",", $resources);

        foreach ($csv as $resource)
        {
            $temp = explode(" ", $resource);
            if ($temp[0] == "truck")
            {
                array_push($unavailableTrucks, $temp[1]);
            }
            else if ($temp[0] == "employee")
            {
                array_push($unavailableEmployees, $temp[1]);
            }
            else if ($temp[0] == "material")
            {
                array_push($unavailableMaterials, $temp[1]);
            }
        }
    }

    $availableTrucks = array();
    $availableEmployees = array();
    $availableMaterials = array();

    $AvailableTruckIDs = array();
    $AvailableEmployeeNames = array();
    $AvailableMaterialNames = array();


    $sql = "SELECT * FROM trucks";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) 
    {
        if (!in_array($row["id"], $unavailableTrucks))
        {
            array_push($availableTrucks, $row["id"]);
            array_push($AvailableTruckIDs, $row["truck_id"]);
            $maxTruckIDs += 1;

        }
    }

    $sql = "SELECT * FROM employees";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) 
    {
        if (!in_array($row["id"], $unavailableEmployees))
        {
            array_push($availableEmployees, $row["id"]);

            $tempName = $row["firstName"] . " " . $row["lastName"];

            array_push($AvailableEmployeeNames, $tempName);
            $maxEmployeeIDs += 1;
        }
    }

    $sql = "SELECT * FROM materials";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) 
    {
        if (!in_array($row["id"], $unavailableMaterials))
        {
            array_push($availableMaterials, $row["id"]);
            array_push($AvailableMaterialNames, $row["material"]);
            $maxMaterialIDs += 1;
        }
    }

    echo "<div id='maxIDs' hidden>" . $maxTruckIDs . " " . $maxEmployeeIDs . " " . $maxMaterialIDs . "</div>";

?>

<div id="AvailableTruckIDs" hidden><?= htmlspecialchars(implode(' ', $AvailableTruckIDs), ENT_QUOTES, 'UTF-8') ?></div>
<div id="AvailableEmployeeNames" hidden><?= htmlspecialchars(implode(',', $AvailableEmployeeNames), ENT_QUOTES, 'UTF-8') ?></div>
<div id="AvailableMaterialNames" hidden><?= htmlspecialchars(implode(' ', $AvailableMaterialNames), ENT_QUOTES, 'UTF-8') ?></div>


<div id="Availablematerials" hidden><?= htmlspecialchars(implode(' ', $availableMaterials), ENT_QUOTES, 'UTF-8') ?></div>
<div id="Availableemployees" hidden><?= htmlspecialchars(implode(' ', $availableEmployees), ENT_QUOTES, 'UTF-8') ?></div>
<div id="Availabletrucks" hidden><?= htmlspecialchars(implode(' ', $availableTrucks), ENT_QUOTES, 'UTF-8') ?></div>

<label for="truckNum">Number of trucks</label>
<input id="truckNum" type="number" min="0" value="0" oninput="truckQuantityChange()">

<label for="peopleNum">Number of employees</label>
<input id="peopleNum" type="number" min="0" value="0" oninput="peopleQuantityChange()">

<label for="materialNum">Number of materials</label>
<input id="materialNum" type="number" min="0" value="0" oninput="materialQuantityChange()">

<div id="truckSection">
</div>
<div id="peopleSection">
</div>
<div id="materialSection">
</div>


<button id="submitButton" type="button">Submit</button>



<script>
    const isEmptyString = (str) => typeof str === 'string' && str.trim().length === 0;
    const submitButton = document.getElementById("submitButton");
    submitButton.addEventListener("click", function()
    {
        var peoplenum = document.getElementById("peopleNum").value;
        var materialnum = document.getElementById("materialNum").value;
        var trucknum = document.getElementById("truckNum").value;
        
        var truckText = "";
        var peopleText = "";
        var materialText = "";

        for (var i = 0; i < trucknum; i++)
        {
            var temp = "truck" + i;
            if (!isEmptyString(document.getElementById(temp).value))
            {
                truckText += document.getElementById(temp).value + " ";
            }
        }
        for (var i = 0; i < peoplenum; i++)
        {
            var temp = "people" + i;
            if (!isEmptyString(document.getElementById(temp).value))
            {
                peopleText += document.getElementById(temp).value + " ";
            }
        }
        for (var i = 0; i < materialnum; i++)
        {
            var tempMaterial = "material" + i;
            var tempQuantity = "quantity" + i;
            if (!isEmptyString(document.getElementById(tempMaterial).value) && !isEmptyString(document.getElementById(tempQuantity).value))
            {
                materialText += document.getElementById(tempMaterial).value + "," + document.getElementById(tempQuantity).value + " ";
            }
        }

        console.log("Trucks: " + truckText);
        console.log("People: " + peopleText);
        console.log("Materials: " + materialText);
    });



    const selectedTrucks = [];

    const myDiv = document.getElementById("Availabletrucks");
        
    var truckText = document.getElementById("Availabletrucks").innerHTML;
    //console.log(truckText);
    const unselectedTrucks = truckText.trim().split(" ");

    const selectedEmployees = [];
    const selectedMaterials = [];

    var employeeText = document.getElementById("Availableemployees").innerHTML;
    const unselectedEmployees = employeeText.trim().split(" ");

    var materialText = document.getElementById("Availablematerials").innerHTML;
    const unselectedMaterials = materialText.trim().split(" ");
    
    //Max Ids contains the highest ID number of trucks, employees, and materials at positions 0, 1, and 2 respectively
    var maxIDInfo = document.getElementById("maxIDs").innerHTML;
    const maxIDs = maxIDInfo.trim().split(" ");

    var truckIDText = document.getElementById("AvailableTruckIDs").innerHTML;
    const truckIDs = truckIDText.trim().split(" ");

    var employeeNameText = document.getElementById("AvailableEmployeeNames").innerHTML;
    const employeeNames = employeeNameText.trim().split(",");

    var materialNameText = document.getElementById("AvailableMaterialNames").innerHTML;
    const materialNames = materialNameText.trim().split(" ");

    var displayTrucksArray = new Array(parseInt(maxIDs[0]));
    var displayEmployeesArray = new Array(parseInt(maxIDs[1]));
    var displayMaterialsArray = new Array(parseInt(maxIDs[2]));

    //Display arrays set the truckID to the index of the ID in the array
    for(var i = 0; i < unselectedTrucks.length; i++)
    {
        var temp = unselectedTrucks[i];
        displayTrucksArray[temp] = truckIDs[i];
    }

    for(var i = 0; i < unselectedEmployees.length; i++)
    {
        var temp = unselectedEmployees[i];
        displayEmployeesArray[temp] = employeeNames[i];
    }
    
    for(var i = 0; i < unselectedMaterials.length; i++)
    {
        var temp = unselectedMaterials[i];
        displayMaterialsArray[temp] = materialNames[i];
    }
    
    function populateTruckOptions(index)//NOTE update this to directly edit the html of the index rather than return html
    {
        

        var id="truck"+index;

        var selectionSize = unselectedTrucks.length;
        

        var selectBox = document.getElementById(id);
        

        while (selectBox.options.length > 1) 
        {
            selectBox.remove(1);
        }


        if (selectedTrucks.at(index) > 0)
        {
            console.log("truck has default value");
            selectBox.value = selectedTrucks.at(index)
            var option = document.createElement("option");
            var  displayValue = displayTrucksArray[selectedTrucks.at(index)];
            option.text = displayValue;
            option.value = selectedTrucks.at(index);
            option.selected = true;
            selectBox.add(option);
        }
        
        
        

        for (var i = 0; i < selectionSize; i++)
        {
            if (unselectedTrucks.at(i) > 0)
            {
                var option = document.createElement("option");
                var displayValue = displayTrucksArray[unselectedTrucks.at(i)];
                option.text = displayValue;
                option.value = unselectedTrucks.at(i);
                selectBox.add(option);
            }
        }

        
        
    }

    function populateAllTruckOptions()
    {
        var truckNum = document.getElementById("truckNum").value;

        for(var i = 0; i < truckNum; i++)
        {
            populateTruckOptions(i);
        }
    }
    

    function truckChange(index)
    {
        var i = "truck" + index;
        var selectedTruck = document.getElementById(i).value;
        if(selectedTrucks.at(index) > 0)
        {
            unselectedTrucks.push(selectedTrucks.at(index));
        }

        selectedTrucks.splice(index, 1, selectedTruck);
        
        var index2 = unselectedTrucks.findIndex(isSelectedTruck);

        function isSelectedTruck(truck)
        {
            return truck == selectedTruck;
        }

        unselectedTrucks.splice(index2, 1);

        populateAllTruckOptions();
        
    }


    



function truckQuantityChange() {
    let element = document.getElementById("truckSection");

    var truckNum = document.getElementById("truckNum").value;
    var html = "<form>";
    
    
    
    while (selectedTrucks.length > truckNum)
    {
        unselectedTrucks.push(selectedTrucks.at(selectedTrucks.length - 1));
        selectedTrucks.pop();
    }

    for(var i = selectedTrucks.length; i < truckNum; i++)
    {
        selectedTrucks.push(0);
    }

    for(var i = 0; i < truckNum; i++)
    {
        html = html + "<label for ='truck" + i +"'>Choose a truck</label>";
        html = html + "<select id ='truck" + i +"' name = 'truck" + i + "' onchange=truckChange(" + i + ")>";
        html = html + "<option value='' disabled selected hidden></option>";
        html = html + "</select><br>";
        
    }

    html = html + "</form>";

    
    

    element.innerHTML = html;

    populateAllTruckOptions()
}



    


    function populateEmployeeOptions(index)
    {
        var id = "people" + index;
        var selectBox = document.getElementById(id);

        while (selectBox.options.length > 1)
        {
            selectBox.remove(1);
        }

        if (selectedEmployees.at(index) > 0)
        {
            var option = document.createElement("option");

            var displayValue = displayEmployeesArray[selectedEmployees.at(index)];
            option.text = displayValue;
            option.value = selectedEmployees.at(index);
            option.selected = true;
            selectBox.add(option);
        }

        for (var i = 0; i < unselectedEmployees.length; i++)
        {
            if (unselectedEmployees.at(i) > 0)
            {
                var option = document.createElement("option");
                var displayValue = displayEmployeesArray[unselectedEmployees.at(i)];
                option.text = displayValue;
                option.value = unselectedEmployees.at(i);
                selectBox.add(option);
            }
        }
    }


    function populateAllEmployeeOptions()
    {
        var peopleNum = document.getElementById("peopleNum").value;

        for (var i = 0; i < peopleNum; i++)
        {
            populateEmployeeOptions(i);
        }
    }


    function employeeChange(index)
    {
        var id = "people" + index;
        var selectedEmployee = document.getElementById(id).value;

        if (selectedEmployees.at(index) > 0)
        {
            unselectedEmployees.push(selectedEmployees.at(index));
        }

        selectedEmployees.splice(index, 1, selectedEmployee);

        var index2 = unselectedEmployees.findIndex(isSelectedEmployee);

        function isSelectedEmployee(employee)
        {
            return employee == selectedEmployee;
        }

        unselectedEmployees.splice(index2, 1);

        populateAllEmployeeOptions();
    }


    function peopleQuantityChange()
    {
        var peopleNum = document.getElementById("peopleNum").value;
        var html = "<form>";

        while (selectedEmployees.length > peopleNum)
        {
            unselectedEmployees.push(
                selectedEmployees.at(selectedEmployees.length - 1)
            );

            selectedEmployees.pop();
        }

        for (var i = selectedEmployees.length; i < peopleNum; i++)
        {
            selectedEmployees.push(0);
        }

        for (var i = 0; i < peopleNum; i++)
        {
            html = html + "<label for='people" + i + "'>";
            html = html + "Choose an employee</label>";

            html = html + "<select id='people" + i;
            html = html + "' name='people" + i;
            html = html + "' onchange=employeeChange(" + i + ")>";

            html = html + "<option value='' disabled selected hidden>";
            html = html + "</option></select><br>";

           
        }

        html = html + "</form>";

        document.getElementById("peopleSection").innerHTML = html;

        populateAllEmployeeOptions();
    }


    function populateMaterialOptions(index)
    {
        var id = "material" + index;
        var selectBox = document.getElementById(id);

        while (selectBox.options.length > 1)
        {
            selectBox.remove(1);
        }

        if (selectedMaterials.at(index) > 0)
        {
            var option = document.createElement("option");
            var displayValue = displayMaterialsArray[selectedMaterials.at(index)];
            option.text = displayValue;
            option.value = selectedMaterials.at(index);
            option.selected = true;
            selectBox.add(option);
        }

        for (var i = 0; i < unselectedMaterials.length; i++)
        {
            if (unselectedMaterials.at(i) > 0)
            {
                var option = document.createElement("option");
                var displayValue = displayMaterialsArray[unselectedMaterials.at(i)];
                option.text = displayValue;
                option.value = unselectedMaterials.at(i);
                selectBox.add(option);
            }
        }
    }


    function populateAllMaterialOptions()
    {
        var materialNum = document.getElementById("materialNum").value;

        for (var i = 0; i < materialNum; i++)
        {
            populateMaterialOptions(i);
        }
    }


    function materialChange(index)
    {
        var id = "material" + index;
        var selectedMaterial = document.getElementById(id).value;

        if (selectedMaterials.at(index) > 0)
        {
            unselectedMaterials.push(selectedMaterials.at(index));
        }

        selectedMaterials.splice(index, 1, selectedMaterial);

        var index2 = unselectedMaterials.findIndex(isSelectedMaterial);

        function isSelectedMaterial(material)
        {
            return material == selectedMaterial;
        }

        unselectedMaterials.splice(index2, 1);

        populateAllMaterialOptions();
    }


    function materialQuantityChange()
    {
        var materialNum = document.getElementById("materialNum").value;
        var html = "<form>";

        while (selectedMaterials.length > materialNum)
        {
            unselectedMaterials.push(
                selectedMaterials.at(selectedMaterials.length - 1)
            );

            selectedMaterials.pop();
        }

        for (var i = selectedMaterials.length; i < materialNum; i++)
        {
            selectedMaterials.push(0);
        }

        for (var i = 0; i < materialNum; i++)
        {
            html = html + "<label for='material" + i + "'>";
            html = html + "Choose a material quantity and type</label><br>";

            html = html + "<select id='material" + i;
            html = html + "' name='material" + i;
            html = html + "' onchange=materialChange(" + i + ")>";

            html = html + "<option value='' disabled selected hidden>";
            html = html + "</option></select><br>";

             html = html + "<input type='number' id='quantity" + i + "' name='quantity" + i + "' min='0'><br>";
        }

        html = html + "</form>";

        document.getElementById("materialSection").innerHTML = html;

        populateAllMaterialOptions();
    }



</script>