<html><body>
<center>
<?php

    $vehiclechoice = $_POST['vehiclechoice'];
    $customerid = $_POST['customerid'];

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
        while ($row = $result -> fetch_assoc())
        {
            if ($vehiclechoice == $i)
            {
                $chosenvehicleid = $row['VehicleID'];
                $todaysdate = date("Y-m-d");
                $chosenrentaltype = $row['RentalType'];
                $chosenqty = $row['Qty'];
                $i++;
            }
        }
    }

    echo $customerid;
    $sql = "INSERT INTO project2.rental (CUSTID) VALUES ('$customerid')";
    $sql = "UPDATE project2.rental SET VehicleID = ('$chosenvehicleid') WHERE CUSTID = ('$customerid')";
    $sql = "UPDATE project2.rental SET StartDate = ('$startdate') WHERE CUSTID = ('$customerid')";
    $sql = "UPDATE project2.rental SET RentalType = ('$chosenrentaltype') WHERE CUSTID = ('$customerid')";
    $sql = "UPDATE project2.rental SET Qty = ('$chosenqty') WHERE CUSTID = ('$customerid')";
    $sql = "UPDATE project2.rental SET ReturnDate = ('$returndate') WHERE CUSTID = ('$customerid') ";
    $sql = "UPDATE project2.rental SET TotalAmount = NULL WHERE CUSTID = ('$customerid')";
    $sql = "UPDATE project2.rental SET PaymentDate = NULL WHERE CUSTID = ('$customerid')";


    if ($result = $mysqli -> query($sql))
    {
        echo "Rental succesfully added.";
    }

    $mysqli->close();

?>