<?php
require_once('startup.php');
require_once('config.php');

try {
  $db = new PDO("mysql:host=host-10;
                       dbname=9recent;
                       port=3306", //specify DB port if need be
                       "root", //db username
                       DB_PASSWORD); //DB password

  $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  $fol = $_POST['num_followers'];

  $sql = "INSERT INTO IG_Users(num_followers) VALUES($fol)";
  $stmt = $db->prepare($sql);
  $stmt-> bindParam(':num_followers', $fol, PDO::PARAM_STR);
  //$stmt-> execute();
} catch (PDOException $e) {
  echo 'ERROR: ' . $e->getMessage();
  exit;
}



















?>
