<html><body>
<center>
<?php

    $vehicletype = explode(".",$_POST['vehicletype']);
    $vehicletypenumber = $vehicletype[0];
    $vehiclecategory = explode(".",$_POST['vehiclecategory']);
    $vehiclecategorynumber = $vehiclecategory[0];
    $startdate = $_POST['startdate'];
    $returndate = $_POST['returndate'];

    $db_host = '127.0.0.1';
    $db_user = 'root';
    $db_password = 'root';
    $db_db = 'Project2';
    $db_port = 3306;
    $db_socket = 'tmp/mysql.sock';

    $mysqli = @new mysqli(
      $db_host,
      $db_user,
      $db_password,
      $db_db,
      $db_port,
      $db_socket
    );
	
    if ($mysqli->connect_error) 
    {
      echo 'Errno: '.$mysqli->connect_errno;
      echo '<br>';
      echo 'Error: '.$mysqli->connect_error;
      exit();
    }

    $sql = "SELECT VehicleID, Description, Year, Type, Category FROM
        (SELECT v.VehicleID AS VehicleID, v.Description AS Description, v.Year AS Year, v.Type AS Type, v.Category AS Category,
        r.StartDate AS StartDate, r.OrderDate AS OrderDate, r.RentalType AS RentalType, r.Qty AS Qty, r.ReturnDate AS ReturnDate, 
        r.TotalAmount AS TotalAmount, r.PaymentDate AS PaymentDate
        FROM project2.vehicle AS v 
        INNER JOIN project2.rental AS r 
        ON v.VehicleID = r.VehicleID
        WHERE v.Type = '1' AND v.Category = '1' AND r.PaymentDate IS NOT NULL) AS SV
    GROUP BY VehicleID";
    
    if ($result = $mysqli -> query($sql))
    {
        $i=1;
        echo "<br> Vehicles of Type: " .$vehicletype[1]. " and Category: ". $vehiclecategory[1]. "<br>with a Start Date of: ". $startdate. "<br>and Return Date of: " . $returndate. "<br>are the following: <br><br><br>";
        while ($row = $result -> fetch_assoc())
        {
            echo $i.". VehicleID: " .$row['VehicleID'] . " Description: " . $row['Description'] . " Year: " . $row['Year'] . " Type: "  . $row['Type'] .  " Category: "  . $row['Category'] . "<br/>";
            $i++;
        }
    }
    
    $mysqli->close();

?>

<p>Please enter the vehicle number you would like to add the reservation for and the Customer ID for whom the reservation is being made:<p>
<form action="Task3b.php" method="post">
<p>Vehicle Number Choice: <input name = "vehiclechoice" type="text" /></p>
<p>Customer ID: <input name = "customerid" type="text" /></p>
<p><input type= "submit" value = "Submit"/></p>
</form>

<form action="Task3.html" method="post"> 
      <p><button type = "submit">Enter another rental</button><p>
</form>

<form action="Home_Screen" method="post"> 
      <p><button type = "submit">Return to the home screen</button><p>
</form>
</center>

</body></html>