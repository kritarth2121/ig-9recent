<?php
include '../config.php';
//This file stores the results from the Instagram API into the database
try {
  //PDO DB connection
  $dbc = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
  $dbc->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  //Form Vars
  $num_followers = $_POST['num_followers'];
  $user_id = $_POST['user_id'];
  //$username is the name of the column in the DB, users_name is the name of the AJAX var
  $username = $_POST['users_name'];
  $total_comments = $_POST['total_comments'];
  $avg_comments = $_POST['avg_comments'];
  $total_likes = $_POST['total_likes'];
  $avg_likes = $_POST['avg_likes'];
  $engagement_ratio = $_POST['engagement_ratio'];
  $picture = $_POST['picture'];
  //Query DB (variables from the above mentioned 'Form Vars' (the DB column) compared to Ajax var)
  $q = "INSERT INTO IG_Users(num_followers, user_id, username, total_comments, avg_comments, total_likes, avg_likes, engagement_ratio, picture) VALUES(:num_followers, :user_id, :users_name, :total_comments, :avg_comments, :total_likes, :avg_likes, :engagement_ratio, :picture)";
    $query = $dbc->prepare($q);
    $query->bindParam(':num_followers', $num_followers);
    $query->bindParam(':user_id', $user_id);
    //Ajax var compared to var from the 'Form Vars' (the DB column)
    $query->bindParam(':users_name', $username);
    $query->bindParam(':total_comments', $total_comments);
    $query->bindParam(':avg_comments', $avg_comments);
    $query->bindParam(':total_likes', $total_likes);
    $query->bindParam(':avg_likes', $avg_likes);
    $query->bindParam(':engagement_ratio', $engagement_ratio);
    $query->bindParam(':picture', $picture);
    $results = $query->execute();
} catch (PDOException $e) {
  echo 'ERROR: ' . $e->getMessage();
  exit;
}





?>
