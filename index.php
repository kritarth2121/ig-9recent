<?php
require_once('startup.php');
require_once('database.php');
get_header();
//https://gist.github.com/cosmocatalano/4544576
//Big thanks to @cosmocatalano for the Gist
?>
<div class="container-fluid">
   <div class="row">
      <div class="col-md-6">
         <!-- Include the Results Table-->
         <?php
            //returns a big old hunk of JSON from a non-private IG account page.
            function scrape_insta($username) {
            	$insta_source = file_get_contents('http://instagram.com/'.$username);
            	$shards = explode('window._sharedData = ', $insta_source);
            	$insta_json = explode(';</script>', $shards[1]);
            	$insta_array = json_decode($insta_json[0], TRUE);
            	return $insta_array;
            }
            //Retreives the username from the input box (also works hardcoded too)
            $my_account = $_GET['name'];
            //Do the deed
            $results_array = scrape_insta($my_account);
            //Programatically generate an html table
            echo('<div class="resultsCol">
                        <table class="table table-striped table-hover">
                          <tr>
                            <th>Comments</th>
                            <th>Likes</th>
                          </tr>');
            $i = 0;
              //that first parameter in the foreach loop could probably be set as a variable, looks ugly as is
             foreach( $results_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'] as $item ){
                //basically if the counter reaches 9, shut the loop off.
                //This particular app can go all the way to 12 before you need pagination
                if($i == 9) break;
                $i++;
                echo '<td class="commentNum"><span class="number">'.$item['comments']['count'] .'</span></td>';
                echo '<td class="likeNum"><span class="number">'.$item['likes']['count'] .'</span></td>';
                //Sets 2 colums for the table
                if($i % 1==0)
                {
                   echo '</tr><tr>';
                }
             }
            echo'</tr></table></div>';
            ?>
         <!--Include the Green Totals Table-->
         <table id="sum_table" class="table table-bordered">
            <tr class="totalColumn success">
               <td class="totalComment"></td>
               <td class="totalLikes"></td>
               <td class="engagementRatio"></td>
            </tr>
         </table>
      </div>
      <div class="col-md-6">
         <!--User Search Bar and Update DB Button-->
         <h4>
            <p class="text-info">Search for a user:</p>
         </h4>
         <div class="input-group">
            <span class="input-group-btn">
            <button type="button" value="submit" class="btn btn-primary" onclick="ajax()" id="get_id" name="submit">Submit</button>
            </span>
            <input type="text" id="username" name="username" value="" class="form-control">
            <button type="button" id="sendToDb" class="btn btn-primary" onclick="updateDatabase()">Update Database</button>
         </div>
         <!--Username,Num Followers, User ID & Profile Pic-->
         <?php
            //https://gist.github.com/cosmocatalano/4544576
            $scrapedUsername = $results_array['entry_data']['ProfilePage'][0]['user']['username'];
            $scrapedFollowersCount = $results_array['entry_data']['ProfilePage'][0]['user']['followed_by']['count'];
            $scrapedUserId = $results_array['entry_data']['ProfilePage'][0]['user']['id'];
            $scrapedProfilePic = $results_array['entry_data']['ProfilePage'][0]['user']['profile_pic_url'];
            echo "<div class='avatarData'>";
            //Grab the username
            print_r("Username: <span class='usersName'>" . $scrapedUsername . "</span><br>");
            //grab the # of followers
            print_r("# of Followers: <span class='number numOfFollowers'>" . $scrapedFollowersCount . "</span><br>");
            //grab the user ID
            print_r("User ID: <span class='userId'><b>" . $scrapedUserId . "</b></span><br>");
            //grab and display the profile picture
            print_r("<a href='https://instagram.com/" . $scrapedUsername . "' target='_blank'><img id='profilePic' src='" . $scrapedProfilePic . "'/></a>" . "<br>");
            echo "</div>";
            ?>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <?php require 'includes/historydisplay.php'; ?>
      </div>
   </div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		//Hide these divs on page load
		$(".resultsCol").hide();
		$(".avatarData").hide();
		$("#dbTable").hide();
		$("#sum_table").hide();
		//disable submit button on load
		$("#get_id").prop("disabled", true);
		$("#username").keyup(function () {
			//If the username textbox has at least 1 character, enable it
			if ($("#username").val().length >= 1) {
				$("#get_id").prop("disabled", false);
			}
		});
		//Enable form submission when the Return key is pressed
		$('#username').keypress(function (e) {
			var key = e.which;
			//13 is the enter key code
			if (key == 13) {
				$('button[id="get_id"]').click();
				return false;
			}
		});
	});
	//The submit button 
	function ajax() {
		var username = document.getElementById("username").value;
		window.location.href = "index.php?name=" + username;
	};
	//Get comment count numbers
	var sumComments = 0;
	$(".commentNum").each(function () {
		var value = $(this).text();
		//Add only if the value is number
		if (!isNaN(value) && value.length != 0) {
			sumComments += parseFloat(value);
		}
	});
	//Get likes count numbers
	var totLikes = 0;
	$(".likeNum").each(function () {
		var value_likes = $(this).text();
		if (!isNaN(value_likes) && value_likes.length != 0) {
			totLikes += parseFloat(value_likes);
		}
	});
	//Add <span class='number'> to results for number formatting
	$('.totalComment').html("Total Comments: <b><span class='number total_comments'>" + sumComments + "</span></b>" + "<p>Average Comments: <b><span class='number avg_comments'>" + parseInt(sumComments / 9) + "</span></b></p>");
	//Below takes the total number of likes and displays that number, then on the next line it divides the number by 9 and displays the average likes
	$('.totalLikes').html("Total Likes: <b><span class='number total_likes'>" + totLikes + "</span></b>" + "<p>Average Likes: <b><span class='number avg_likes'>" + parseInt(totLikes / 9) + "</span></b></p>");
	//Add in the math for the engagement Ratio
	//[Likes + Comments] / Followers = Engagement Ratio
	//I only sample the first 9 images on their account. No sense in getting numbers for pics that are 6 months old
	var likesAndComments = totLikes + sumComments;
	var numOfFollowers = $(".numOfFollowers").text();
	var engagementRatio = likesAndComments / numOfFollowers * 100;
	$(".engagementRatio").html("Engagement Ratio: " + "<b>" + engagementRatio.toFixed(2) + "</b>");
	//Activate the jQuery Number plugin to add commas on thousands
	$('.number').number(true);
	//Update the database with the returned results
	function updateDatabase() {
		event.preventDefault();
		//Define data var
		var db = {};
		//Finds the DOM element, splits, pops and replaces any commas
		db.numFollowers = $(".numOfFollowers").text().replace(/,/g, "");
		db.userId = $(".userId").text();
		db.users_name = $(".usersName").text();
		db.totalComments = $(".total_comments").text().replace(/,/g, "");
		db.averageComments = $(".avg_comments").text().replace(/,/g, "");
		db.totalLikes = $(".total_likes").text().replace(/,/g, "");
		db.averageLikes = $(".avg_likes").text().replace(/,/g, "");
		db.engagementRatio = $(".engagementRatio b").text();
		db.profilePic = $("#profilePic").attr("src");
		//Send the data to the DB with AJAX
		$.ajax({
			type: "POST",
			cache: false,
			data: db,
			url: "includes/update.php",
			success: function (response) {
				//Auto refresh the div with new data
				$(".col-md-12").load(location.href + " .col-md-12");
				//Disable button on click
				$('#sendToDb').prop('disabled', true);
				setTimeout(function () {
					//Activate the jQuery Number AGAIN after refresh
					$('.number').number(true);
				}, 1500);
				console.log("# of Followers: " + db.numFollowers);
				console.log("User ID: " + db.userId);
				console.log("User Name: " + db.users_name);
				console.log("Total Comments: " + db.totalComments);
				console.log("Average Comments: " + db.averageComments);
				console.log("Total Likes: " + db.totalLikes);
				console.log("Average Likes: " + db.averageLikes);
				console.log("Engagement Ratio: " + db.engagementRatio);
				console.log("Picture: " + db.profilePic);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	};
	//Fires last- waits for the page to load after the ajax() function triggers
	$(document).ready(function () {
		var pattern = /name(.*)/gm;
		var url = window.location.href.split("?")[1];
		var result = pattern.test(url);
		if (result == true) {
			console.log("Url Matched: " + url + " " + result);
			$(".resultsCol").show();
			$(".avatarData").show();
			$("#dbTable").show();
			$("#sum_table").show();
		} else {
			console.log("NO MATCHING URL");
		}
	});
</script>
<?php get_footer(); ?>
