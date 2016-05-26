<?php

require_once('startup.php');
require_once('config.php');

try {
  $db = new PDO("mysql:host=" . DB_HOST . ";
                       dbname=" . DB_NAME,
                       DB_USERNAME, //db username
                       DB_PASSWORD); //DB password
  //var_dump($db); //Dump the database info
  $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); //Shows errors if the PDO object returns errors such as cannot execute query
                                                               //in PHP the 2 colons "::" represent a relationship between the class name on the left and the property or method on the right
  //$db->exec("SET NAMES 'utf8'"); //set standard character set

} catch (Exception $e) {
  echo "Could not connect to DB"; //Display message if you cant connect
  exit; //end connection
}

try{
  $results = $db->query("SELECT * FROM IG_Users");
} catch (PDOException $e){
  echo 'ERROR: ' . $e->getMessage();
  exit;
}
 ?>
