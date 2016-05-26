<?php
include '../config.php';
//This file displays the results from the database that match the users name you typed

$con = mysqli_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}
$username = $_POST['username'];
$sql = "SELECT * FROM IG_Users WHERE username = '$username' ORDER BY `time_stamp` DESC";
$results = mysqli_query($con,$sql);

echo "<table class='table table-striped clear-top table-hover' id='dbTable'>
        <tr>
          <th>User ID</th>
          <th>Username</th>
          <th>Total Comments</th>
          <th>Average Comments</th>
          <th>Total Likes</th>
          <th>Average Likes</th>
          <th>Time Stamp</th>
          <th># of Followers</th>
          <th>Engagement Ratio</th>
        </tr>";
while($row = mysqli_fetch_array($results)){
  echo "<tr><td>";
    echo $row['user_id'];
    echo "</td><td>";
    echo $row['username'];
    echo "</td><td><span class='number'>";
    echo $row['total_comments'];
    echo "</span></td><td><span class='number'>";
    echo $row['avg_comments'];
    echo "</span></td><td><span class='number'>";
    echo $row['total_likes'];
    echo "</span></td><td><span class='number'>";
    echo $row['avg_likes'];
    echo "</span></td><td>";
    echo $row['time_stamp'];
    echo "</td><td><span class='number'>";
    echo $row['num_followers'];
    echo "</span></td><td>";
    echo $row['engagement_ratio'];
    echo "</td>";
  echo "</tr>";
}
echo "</table>";
mysqli_close($con);
