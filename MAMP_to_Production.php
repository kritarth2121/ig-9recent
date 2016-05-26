<?php
/*
This is a How-To file for transfering the repo from localhost to the WWW:
This file exists due to the frustraiting nature of transporting this repo from localhost to a VPS. I spent several hours fiddling around with Ajax and PHP and couldn't find a suitable solution.
I settled on having 2 separate configs for MAMP servers and a VPS. The big difference is the MAMP server POSTS and the VPS GETS. I honestly don't know why I can't use one config for development
and production. This method is hacky but it works, and I am honestly so burned out that I cannot fathom troubleshooting this for one more minute.
-JP
*/

//MAMP File Config (Use this if you're going to host locally):

//1. index.php
            //4th, getJSON()-- displays user history table Below
            //The following $.ajax() works on MAMP but not on a server. No idea why
            //https://webdesignerhut.com/pass-data-with-ajax-to-a-php-file/
            var un = $("#username").val();
            $.ajax({
              type: "POST",
              url: "includes/historydisplay.php",
              data: {
                username: un
              },
              dataType: 'html',
              cache: false,
              success: function (response) {
                console.log("THE USERNAME I HAVE IS:::::: " + un);
                $("#dbTable").html(response);
              }
            });

//2. historydisplay.php
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


//=========================================================================//

//Production File Config (edit these 2 files if you're going to host on a VPS)

//1. index.php
            //4th, getJSON()-- displays user history table Below
            var un = $("#username").val();
            $.ajax({
              type: "GET",
              url: "includes/historydisplay.php",
              data: 'username='+ un,
              dataType: 'html',
              cache: false,
              success: function (data) {
                console.log("THE USERNAME I HAVE IS:::::: " + un);
                $("#dbTable").html(data);
              }
            });

//2. historydisplay.php
            $con = mysqli_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
            if (!$con) {
                die('Could not connect: ' . mysqli_error($con));
            }
            $username = $_GET['username'];
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
