<html><body>
    <center>
<?php

  $customername = $_POST['customername'];
  $vehicleid = $_POST['vehicleid'];
  $returndate = $_POST['returndate'];
  
  echo 'customername:'.$customername;
  echo 'vehicleid'.$vehicleid;
  echo 'returndate'.$returndate;

  $db_host = '127.0.0.1';
  $db_user = 'root';
  $db_password = 'root';
  $db_db = 'Project2';
  $db_port = 3306;
  $db_socket = 'MySql';

  $mysqli = @new mysqli(
    $db_host,
    $db_user,
    $db_password,
    $db_db,
    $db_port,
    $db_socket
  );

  if ($mysqli->connect_error) {
    echo 'Errno: '.$mysqli->connect_errno;
    echo '<br>';
    echo 'Error: '.$mysqli->connect_error;
    exit();
  }

$sql = "SELECT c.CustID FROM project.customer as c WHERE c.Name = ('$customername')";
$customerid = $mysqli -> query($sql);

$sql = "SELECT r.TotalAmount
        FROM project2.rental AS r
        INNER JOIN project2.customer AS c
        ON r.CustID = c.CustID
        WHERE c.CustID = ('$customerid')
        AND r.VehicleID = ('$vehicleid')";

$totalamount = $mysqli -> query($sql);
echo "<br>Total payment due is: ". $totalamount "</br>";

$sql = "UPDATE project2.rental SET r.ReturnDate = ('$returndate')
        WHERE CustID = ('$customerid')
        AND VehicleID = ('$vehicleid')";
        
if ($result = $mysqli -> query($sql))
{
    echo 'Succesfully returned car, <br>';
}

$mysqli->close();


?>

<center>
</body>
</html>