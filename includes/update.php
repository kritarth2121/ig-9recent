<?php

try {
  //connection shit
  $host = "host-10";
  $user = "killbot";
  $pass = "kill";
  $database = "9recent";
  //PDO shit
  $dbc = new PDO("mysql:host=" . $host . ";dbname=" . $database, $user, $pass);
  $dbc->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  //Form shit
  $num_followers = $_POST['num_followers'];
  $user_id = $_POST['user_id'];
  //$username is the name of the column in the DB, users_name is the name of the AJAX var
  $username = $_POST['users_name'];
  $total_comments = $_POST['total_comments'];
  $avg_comments = $_POST['avg_comments'];
  $total_likes = $_POST['total_likes'];
  $avg_likes = $_POST['avg_likes'];
  $engagement_ratio = $_POST['engagement_ratio'];

  //Query shit (var from Form Shit (the DB column) compared to Ajax var)
  $q = "INSERT INTO IG_Users(num_followers, user_id, username, total_comments, avg_comments, total_likes, avg_likes, engagement_ratio) VALUES(:num_followers, :user_id, :users_name, :total_comments, :avg_comments, :total_likes, :avg_likes, :engagement_ratio)";

    $query = $dbc->prepare($q);
    $query->bindParam(':num_followers', $num_followers);
    $query->bindParam(':user_id', $user_id);
    //Ajax var compared to var from Form Shit (the DB column)
    $query->bindParam(':users_name', $username);
    $query->bindParam(':total_comments', $total_comments);
    $query->bindParam(':avg_comments', $avg_comments);
    $query->bindParam(':total_likes', $total_likes);
    $query->bindParam(':avg_likes', $avg_likes);
    $query->bindParam(':engagement_ratio', $engagement_ratio);

    $results = $query->execute();
} catch (PDOException $e) {
  echo 'ERROR: ' . $e->getMessage();
  exit;
}





?>
