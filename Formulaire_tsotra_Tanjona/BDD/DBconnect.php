<?php 
function DBconnect()
{
  $servername = "localhost";
  $username = "root";
  $password = "";
  
  try 
  {
    $conn = new PDO( "mysql:host=$servername;dbname=formtreatment", $username, $password);
    
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
    return $conn;
  } 
  catch(PDOException $e) 
  {
    echo "Connection echoué " . $e->getMessage();
    return null;
  }

}

?>

