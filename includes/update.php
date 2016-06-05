<?php
include '../config.php';
//This file stores the results from the Instagram API into the database
try {
  //PDO DB connection
  $dbc = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
  $dbc->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  //Form Vars
  $num_followers = $_POST['numFollowers'];
  $user_id = $_POST['userId'];
  //$username is the name of the column in the DB, users_name is the name of the AJAX var
  $username = $_POST['users_name'];
  $total_comments = $_POST['totalComments'];
  $avg_comments = $_POST['averageComments'];
  $total_likes = $_POST['totalLikes'];
  $avg_likes = $_POST['averageLikes'];
  $engagement_ratio = $_POST['engagementRatio'];
  $picture = $_POST['profilePic'];
  //Query DB (variables from the above mentioned 'Form Vars' (the DB column) compared to Ajax var)
  $q = "INSERT INTO IG_Users(num_followers, user_id, username, total_comments, avg_comments, total_likes, avg_likes, engagement_ratio, picture) VALUES(:numFollowers, :userId, :users_name, :totalComments, :averageComments, :totalLikes, :averageLikes, :engagementRatio, :profilePic)";
    $query = $dbc->prepare($q);
    $query->bindParam(':numFollowers', $num_followers);
    $query->bindParam(':userId', $user_id);
    //Ajax var compared to var from the 'Form Vars' (the DB column)
    $query->bindParam(':users_name', $username);
    $query->bindParam(':totalComments', $total_comments);
    $query->bindParam(':averageComments', $avg_comments);
    $query->bindParam(':totalLikes', $total_likes);
    $query->bindParam(':averageLikes', $avg_likes);
    $query->bindParam(':engagementRatio', $engagement_ratio);
    $query->bindParam(':profilePic', $picture);
    $results = $query->execute();
    /*** close the database connection ***/
    $dbc = null;
} catch (PDOException $e) {
  echo 'ERROR: ' . $e->getMessage();
  exit;
}





?>
