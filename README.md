# Postr
PHP job posting board site. Create, edit, save postings.
https://postr.awettech.com

# How to run the app
1. Fork/clone repo
2. Install XAMPP to run local Apache and MySql servers on your machine, or upload to remote server with these services
3. Create a folder 'config' in /src with a file 'db_connect.php'. In it connect to your database server, remote or local, with `mysqli_connect()` and store the connection in a variable `$conn`

#### /config/db_connect.php
```
<?php
  // define connection to mysql db
  $conn = mysqli_connect("host", 'username', 'password', 'db name', 'port' //optional);
  // catch error in connection
  if (!$conn) {
      echo "Connection error:" . mysqli_connect_error();
      exit();
  }

```
4. Create database

5. With in your database create three tables: posts, users, favorite_posts
 #### Run the following queries from cmd line once connected to db or in phpmyadmin sql console
 ```
 CREATE TABLE posts (id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT, title VARCHAR(225) NOT NULL, description LONGTEXT, type VARCHAR(20) NOT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL, company VARCHAR(100) NOT NULL, city VARCHAR(100) NOT NULL, state VARCHAR(100) NOT NULL, zipcode VARCHAR(100), phone VARCHAR(10), salary_min INT(11), salary_max  INT(11), hourly_max INT(11), hourly_min INT(11), requirements  VARCHAR(225) , preferred  VARCHAR(225), email VARCHAR(100) NOT NULL , created_by INT(11) NOT NULL);

 CREATE TABLE users (id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT, email VARCHAR(100) NOT NULL, password VARCHAR(225) NOT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL, private TINYINT(1) NOT NULL);

 CREATE TABLE favorite_posts (user_id INT(11) PRIMARY KEY NOT NULL, post_id INT(11) NOT NULL);
  ```
6. Have fun!

## About
 * This project primarily consists of php scripts that pull from, create, delete or insert data into the mysql db.
 * Posts are created by running SQL queries against the database with validated data from a POST request sent when an authenticated user submits a post through the /add page.
 * These posts are added to a collection of posts that all users can see on the home page. Posts can also be filtered by users through the 'options' panel on the home page.
 * Posts are pulled from the database by limiters given as query params from the query string. The options panel is a form that, on submit, sends a GET request to the home page, which then pulls the appropriate data.
 * Users can sign in and create new posts, edit created posts, delete posts, save other users posts, and are given the option to private their profiles.

## Languages and libraries
* PHP
* MySQL
* Materialize.css
* Sass


## What the app looks like
![alt text](https://imgur.com/tPgpEG7.gif)
