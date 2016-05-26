# IG 9recent [![License](https://img.shields.io/badge/license-GPL--2.0%2B-green.svg)](http://www.gnu.org/licenses/gpl-2.0.html)

A simple Instagram analytics tool for evaluating activity on specified accounts. This tool is useful for Internet marketers who are searching for influencer accounts with high engagement and activity. IG 9recent scans the most recent 9 photos of an Instagram account and spits out data for several fields:

1. Static User data
  * Profile Avatar
  * Username
  * Current Number of Followers
  * Instagram User ID
2. Current Number of Comments for Each Photo
3. Current Number of Likes for Each Photo
4. Total Number of Comments for All 9 Photos
5. Average Number of Comments for All 9 Photos
6. Total Likes of All 9 Photos
7. Average Number of Likes for All 9 Photos
8. Engagement Ratio
  * [Likes + Comments] / Followers = Engagement Ratio

Once the data has been collected via the Instagram API, you will have the ability to store the results in a MySQL DB. As of 25MAY2016 the index page will only display data for the placeholder user 'fitness'. In order to change the displayed results you will need to manually edit the '$q' variable in historydisplay.php to show other stored users.

## Installing
Copy the contents of 'config-sample.php' and create a new file named 'config.php'.

```
cp config-sample.php config.php
```

After that edit the variables in config.php to connect to the MySQL database.

Note for Beginners:
>This repository uses PHP and a CDN for Bootstrap.
>Therefore, you will need to utilize a local web server to run the files
>[XAMPP](https://www.apachefriends.org/) or [MAMP/MAMP Pro](https://www.mamp.info/en/) will be your easiest solution  

## Libraries and Plugins Used

+ [jQuery](http://jquery.com)
+ [jQuery Number Format](https://www.customd.com/articles/14/jquery-number-format-redux)
+ [Bootstrap](http://getbootstrap.com)


## TODO
- [x] Add commas for numbers in thousands
- [x] Combine the 2 results tables into 1
- [x] Hide results table on load, show it on click
- [ ] Figure out a non hacky way to load results instead of using setTimeout
- [ ] If any of the 9 pics returned is less than x hours old, discard it until you have 9 results that are > x hours old
- [x] Store results and save them so they can be compared to future results
- [x] Grey out submit button on results, otherwise hitting it again will double feed results
- [ ] Need to figure out a way to have the username box send a SQL query to the DB via historydisplay.php
- [ ] Clean up Update.php and historydisplay.php and remove the DB vars, include vars from config.php
- [ ] Hide Results Table until username is submitted
- [ ] Remove unnecessary console.log commands on production

---
## Creators

* [James Pistell](https://github.com/pistell)
* [Joseph Fusco](https://github.com/josephfusco)
