<?php

ini_set('display_errors', '1');

$MYSQL_HOST='163.172.130.142';
$MYSQL_PORT='3310';

$MYSQL_DATABASE='sakila';
$MYSQL_ROOT_PASSWORD='CrERP29qwMNvcbnAMgLzW9CwuTC5eJHn';

$MYSQL_USER='etudiant';
$MYSQL_PASSWORD='CrERP29qwMNvcbnAMgLzW9CwuTC5eJHn';

$sakilaDB = new \PDO('mysql:host=' . $MYSQL_HOST . ';port=' . $MYSQL_PORT . ';dbname=' . $MYSQL_DATABASE, $MYSQL_USER, $MYSQL_ROOT_PASSWORD);

$limit = 10;
if(isset($_GET['limit'])) {
  $limit = $_GET['limit'];
} else {
  $limit = 10;
}

$pageOffset = 0;
if(isset($_GET['pageOffset'])) {
  $pageOffset = $_GET['pageOffset'];
} else {
  $pageOffset = 0;
}

$offset = $limit * $pageOffset;

$groupBy = 'title';
if(isset($_GET['groupBy'])) {
  $groupBy = $_GET['groupBy'];
} else {
  $groupBy = 'title';
}

$desc = 'ASC';
if(isset($_GET['desc'])) {
  $desc = $_GET['desc'];
} else {
  $desc = 'ASC';
}

$sakilaDBstmt = $sakilaDB->prepare(
  'SELECT title, category.name as category, rental_rate, rating, count(*) as rentals
  FROM film, film_category, category, rental, inventory
  WHERE 
  film.film_id = film_category.film_id AND film_category.category_id = category.category_id
  AND film.film_id = inventory.film_id AND inventory.inventory_id = rental.inventory_id
  GROUP BY title
  ORDER BY '.$groupBy.' '.$desc.'
  limit '.$limit.'
  offset '.$offset.'');
  
$sakilaDBstmt->execute();
$sakilaDBFetch = $sakilaDBstmt->fetchAll(PDO::FETCH_ASSOC);

$resultCount = $sakilaDB->prepare('SELECT count(title) as result FROM film');
$resultCount->execute();
$resultCountFetch = $resultCount->fetchAll(PDO::FETCH_ASSOC);
$totalPage = $resultCountFetch[0]['result'] / $limit;

// BASIC CALL

// select title, rental_rate, rating, category.name as category, count(*) as rentals
// from film, film_category, category, rental, inventory
// where 
// film.film_id = film_category.film_id and film_category.category_id = category.category_id
// and film.film_id = inventory.film_id and inventory.inventory_id = rental.inventory_id
// group by title
// limit 10
// offset 10;