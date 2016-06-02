<?php

//$json = json_decode(file_get_contents('https://www.instagram.com/jpisty/'));
//echo "<pre>" . json_encode($json, JSON_PRETTY_PRINT);
//echo "The username is: <b>" . $json->items[0]->caption->from->username . "</b>";

//https://gist.github.com/cosmocatalano/4544576
//returns a big old hunk of JSON from a non-private IG account page.
function scrape_insta($username) {
	$insta_source = file_get_contents('http://instagram.com/'.$username);
	$shards = explode('window._sharedData = ', $insta_source);
	$insta_json = explode(';</script>', $shards[1]);
	$insta_array = json_decode($insta_json[0], TRUE);
	return $insta_array;
}
//Supply a username
$my_account = 'fitness';
//Do the deed
$results_array = scrape_insta($my_account);
//Grab the username
print_r("Your Username is: " . $results_array['entry_data']['ProfilePage'][0]['user']['username'] . "<br>");
//grab the # of followers
print_r("<span id='numOfFollowers'>Your # of Followers is : " . $results_array['entry_data']['ProfilePage'][0]['user']['followed_by']['count'] . "</span><br>");
//grab the user ID
print_r("Your User ID is: " . $results_array['entry_data']['ProfilePage'][0]['user']['id'] . "<br>");
//grab and display the profile picture
print_r("Your Profile Picture URL is: <img src='" . $results_array['entry_data']['ProfilePage'][0]['user']['profile_pic_url'] . "'/>" . "<br>");


//$comments_array = $results_array['entry_data']['ProfilePage'][0]['user']['media']['nodes']['comments'];
//$likes_array = $results_array['entry_data']['ProfilePage'][0]['user']['media']['nodes']['likes'];

//Programatically generate an html table
echo('<table border="1"><tr><th>comments</th><th>likes</th></tr></tr>');
$i = 0;
  //that first parameter in the foreach loop could probably be set as a variable, looks ugly as is
 foreach( $results_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'] as $item ){
    //basically if the counter reaches 9, shut the loop off.
    //This particular app can go all the way to 12 before you need pagination
    if($i == 9) break;
    $i++;
    echo '<td class="commentNum">'.$item['comments']['count'] .'</td>';
    echo '<td class="likeNum">'.$item['likes']['count'] .'</td>';
    //Sets 2 colums for the table
    if($i % 1==0)
    {
       echo '</tr><tr>';
    }

 }

echo'</tr></table>';







//Prints out a messy """"TABLE"""""
// foreach($results_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'] as $item){
//   print_r("Comment Count: " . $item['comments']['count'] . " Likes Count: " . $item['likes']['count'] . "<br>");
// }


//echo "<pre>" . json_encode($results_array, JSON_PRETTY_PRINT) . "</pre>";

//$comments_array = $results_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'][0]['comments']['count'];

// echo "The Array is " . $comments_array . "<br>";
// echo "The Array is " . $comments_array . "<br>";
// echo "The Array is " . $comments_array . "<br>";
// for($i=1; $i<=3; $i++){
//      echo "The number is " . $comments_array[$i] . "<br>";
//  }




//An example of where to go from there
 // $latest_array = $results_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'][0];
 // echo 'Latest Photo:<br/>';
 // echo '<a href="http://instagram.com/p/'.$latest_array['code'].'"><img src="'.$latest_array['display_src'].'"></a></br>';
 // echo 'Likes: '.$latest_array['likes']['count'].' - Comments: '.$latest_array['comments']['count'].'<br/>';
 ?>
 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>IG SCRAPE RAPE</title>
     <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>
   </head>
   <body>
     <!-- Adds up and averages the comments/likes and adds an Engagement Ratio -->
     <table id="sum_table" class="table table-bordered">
       <tr class="totalColumn success">
         <td class="totalComment"></td>
         <td class="totalLikes"></td>
         <td class="engagementRatio"></td>
       </tr>
     </table>
     <script type="text/javascript">
     var sumComments = 0;
     // Get comment count numbers
     $(".commentNum").each(function () {
       var value = $(this).text();
       // Add only if the value is number
       if (!isNaN(value) && value.length != 0) {
         sumComments += parseFloat(value);
       }
     });
     var totLikes = 0;
     // Get likes count numbers
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
     // Add in the math for the engagement Ratio
     // [Likes + Comments] / Followers = Engagement Ratio
     // I only sample the first 9 images on their account. No sense in getting numbers for pics that are 6 months old
     var likesAndComments = totLikes + sumComments;
     var numOfFollowers = $("#numOfFollowers").text().split(": ").pop();
     var engagementRatio = likesAndComments / numOfFollowers * 100;
     $(".engagementRatio").html("Engagement Ratio: " + "<b>" + engagementRatio.toFixed(2) + "</b>");
     </script>
   </body>
 </html>
