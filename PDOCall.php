<?php

ini_set('display_errors', '0');

$sakilaDB = new \PDO('mysql:host=' . $_ENV['MYSQL_HOST'] . ';port=' . $_ENV['MYSQL_PORT'] . ';dbname=' . $_ENV['MYSQL_DATABASE'], $_ENV['MYSQL_USER'], $_ENV['MYSQL_ROOT_PASSWORD']);

$limit = 10;
if(isset($_GET['limit'])) {
  $limit = $_GET['limit'];
} else {
  $limit = 10;
}

$offset = 0;
if(isset($_GET['offset'])) {
  $offset = $_GET['offset'];
} else {
  $offset = 0;
}

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
$totalPage = ceil($resultCountFetch[0]['result'] / $limit);

// BASIC CALL

// select title, rental_rate, rating, category.name as category, count(*) as rentals
// from film, film_category, category, rental, inventory
// where 
// film.film_id = film_category.film_id and film_category.category_id = category.category_id
// and film.film_id = inventory.film_id and inventory.inventory_id = rental.inventory_id
// group by title
// limit 10
// offset 10;