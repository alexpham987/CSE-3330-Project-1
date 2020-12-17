<html><body>
<?php

$customername = $_POST['customername'];

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
	
  if ($mysqli->connect_error) {
    echo 'Errno: '.$mysqli->connect_errno;
    echo '<br>';
    echo 'Error: '.$mysqli->connect_error;
    exit();
  }

  echo 'Success: A proper connection to MySQL was made.';
  echo '<br>';
  echo 'Host information: '.$mysqli->host_info;
  echo '<br>';
  echo 'Protocol version: '.$mysqli->protocol_version;

  echo 'Customer Name: ' .$customername;

  //Insert new customery
$sql = "INSERT INTO project2.customer (NAME) VALUES ('$customername')";
if ($result = $mysqli -> query($sql))
{
    echo 'Succesfully added customer, <br>';
}

$mysqli->close();


?>
</body></html>