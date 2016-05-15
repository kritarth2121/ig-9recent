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

   $q = "SELECT * FROM `IG_Users` WHERE `username` = 'fitness' ORDER BY `time_stamp` DESC";
   $query = $dbc->prepare($q);
   $query->execute();
   $results = $query->fetchAll( PDO::FETCH_ASSOC );

 } catch (PDOException $e) {
   echo 'ERROR: ' . $e->getMessage();
   exit;
 }
?>
 <table class="table table-striped">
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
   </tr>
   <?php foreach( $results as $row ){
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
 ?>
 </table>
