Group project for CPSC 304 on databases.

### Objective

Demonstrate database operations such as inserts, deletes, updates, joins, ect.
Project was created with a focus on using PHP.
Database is a MySQL database.

### Setup

PHP 7.0+ is required for some code to work.
  
To get the git repo on your machine, you can either git clone or run the following commands in an existing folder:  

- git init  
- git remote add origin git@bitbucket.org:gvanesch/cpsc-304.git  (Not sure if currently private.)
- git pull origin master

Then import the database by running either of the following from the database folder (not both; they give the same result):

- inventory.sql followed by dummy.sql
- singleimport.sql

Update the config.php file to your specific set-up if necessary.

### Demo prep

The report.pdf file has some hyperlinks in it which link to specific SQL queries which fulfill each rubric item. This should streamline things quite a bit.
The entire demo can be done from the restaurant perspective as all of the required query types have been implemented for restaurants but not necessarily others. Thus it makes the most sense to log in as a restaurant for demo purposes.
It should also be noted that although most things work and are tied together, this software is not 100% completed or in a sellable state. Yet, according to [outdated course forum link) all expected/required elements are there.

### Bonus Details

- The fancy GUI was created with Bootstrap 4.4.1, FontAwesome 5.12.1, and custom CSS.
- Animations created from CSS and Javascript appear in many areas such as the homepage login banner,
buttons, and forms.
- Maps for the restaurant and wholesaler pages were added with the Google Maps API and Geocoder to
convert addresses into latitude and longitude. (API key has been removed by me (William Luo)
- Session variables are used to personalize pages to specific user types.
