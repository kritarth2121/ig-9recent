# IG 9recent [![License](https://img.shields.io/badge/license-GPL--2.0%2B-green.svg)](http://www.gnu.org/licenses/gpl-2.0.html)

![IG 9recent Screenshot](http://i.imgur.com/JJO4y29.png?1 "IG 9recent Screenshot")

A simple Instagram analytics tool for evaluating activity on specified accounts. This tool is useful for Internet marketers who are searching for influencer accounts with high engagement and activity. Previously this app interfaced with the Instagram API to pull the data, however in early June 2016 Instagram decided to require all API requests be authenticated per user, even the data they share publically. Therefore IG 9recent scrapes data without the need of an API. IG 9recent scans the most recent 9 photos of an Instagram account and spits out data for several fields:

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

Once the data has been collected via the Instagram API, you will have the ability to store the results in a MySQL DB.

## Installing
Copy the contents of 'config-sample.php' and create a new file named 'config.php'.

```
cp config-sample.php config.php
```

Open up your MySQL database in phpMyAdmin (or whatever DB management tool you prefer). Copy the contents of build_db.sql and paste them into a SQL query box. Run the statement to build the database.

After that edit the variables in config.php to connect to the MySQL database.

Note for Beginners:
>This repository uses PHP and a CDN for Bootstrap.
>Therefore, you will need to utilize a web server to run the files. The quickest way is to use a local web server.
>[XAMPP](https://www.apachefriends.org/) or [MAMP/MAMP Pro](https://www.mamp.info/en/) will be your easiest solutions.  

## Libraries and Plugins Used

+ [jQuery](http://jquery.com)
+ [jQuery Number Format](https://www.customd.com/articles/14/jquery-number-format-redux)
+ [Bootstrap](http://getbootstrap.com)


## TODO
- [x] Add commas for numbers in thousands
- [x] Combine the 2 results tables into 1
- [x] Hide results table on load, show it on click
- [x] Figure out a non hacky way to load results instead of using setTimeout
- [ ] If any of the 9 pics returned is less than x hours old, discard it until you have 9 results that are > x hours old
- [x] Store results and save them so they can be compared to future results
- [x] Grey out submit button on results, otherwise hitting it again will double feed results
- [x] Need to figure out a way to have the username box send a SQL query to the DB via historydisplay.php
- [x] Clean up Update.php and historydisplay.php and remove the DB vars, include vars from config.php
- [x] Hide Results Table until username is submitted
- [x] Remove unnecessary console.log commands on production
- [x] Fix sticky footer clipping the results table
- [x] The "#result" div has responsive CSS issues
- [x] Should be a cleaner way to remove the results on the page without reloading
- [x] Update Database button should automatically populate the DB records table below
- [ ] Truncate queried records and paginate

## Built With
* [Atom](https://atom.io/)
* [MAMP Pro](https://www.mamp.info/en/)
* [PHP](http://php.net)
* [phpMyAdmin](https://www.phpmyadmin.net/)
* [Tears](http://i.imgur.com/pM1bLLX.jpg)

---
## Creators

+ ##### James Pistell
  * ![James Pistell's GitHub Account](http://i.imgur.com/Myo5q9q.png "James Pistells GitHub Account") [GitHub](https://github.com/pistell)  
  * ![James Pistell's LinkedIn Account](http://i.imgur.com/Oq9lKwx.png "James Pistells LinkedIn Account") [LinkedIn](https://www.linkedin.com/in/jamespistell)

+ ##### Joseph Fusco
  * ![Joseph Fusco's GitHub Account](http://i.imgur.com/Myo5q9q.png "Joseph Fucsos GitHub Account") [GitHub](https://github.com/josephfusco)
  * ![Joseph Fusco's Website](http://i.imgur.com/HBak7o7.png "Joseph Fucsos Website") [Website](http://josephfus.co/)
