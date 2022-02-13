<?php

// Call bdd with the first basic call sql
include './PDOCall.php';

$keysTitles = array_keys($sakilaDBFetch[0]);

$pageOffset = 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <title>Homepage</title>
</head>
<body>
  <div class="container-xxl d-flex justify-content-center align-items-center flex-column">
    <h1 class="mt-4 mb-5">Rien que pour vos yeux</h1>

    
    <!-- SORT FORM -->


    <div class="container-xxl d-flex px-0">
      <form method="get" class="d-flex align-items-center">
        <div>
          <select name="limit" id="form-show" class="form-select">
            <option <?php if($limit == '10') { echo "selected"; }; ?> value="10">Voir 10 films</option>
            <option <?php if($limit == '30') { echo "selected"; }; ?> value="30">Voir 30 films</option>
            <option <?php if($limit == '50') { echo "selected"; }; ?> value="50">Voir 50 films</option>
            <option <?php if($limit == '100') { echo "selected"; }; ?> value="100">Voir 100 films</option>
          </select>
        </div>
        <div class="mx-3">
          <select name="groupBy" id="form-groupBy" class="form-select">
            <option <?php if($groupBy == 'title') { echo "selected"; }; ?> value="title">Title</option>
            <option <?php if($groupBy == 'category') { echo "selected"; }; ?> value="category">Category</option>
            <option <?php if($groupBy == 'rentals') { echo "selected"; }; ?> value="rentals">Rental</option>
          </select>
        </div>
        <div>
          <select name="desc" id="form-desc" class="form-select">
            <option <?php if($desc == 'ASC') { echo "selected"; }; ?> value="ASC">Crescent</option>
            <option <?php if($desc == 'DESC') { echo "selected"; }; ?> value="DESC">Decreasing</option>
          </select>
        </div>
        <input type="submit" value="Sort" class="btn btn-primary mx-3">
      </form>
    </div>


    <!-- PAGINATION -->


    <div class="pagination mt-3">
      Page <?= $pageOffset + 1 ?> / <?= $totalPage + 1 ?>
    </div>
    <div class="navigation-pagination">
      <?php if($pageOffset > 0){ echo '<a class="link-primary" href="?offset=' . $limit * ($pageOffset - 1) . '&limit='.$limit.'&groupBy='.$groupBy.'&desc='.$desc.'">Previous</a>'; } ?>
      <?php if($pageOffset < $totalPage){ echo '<a class="link-primary" href="?offset=' . $limit * ($pageOffset + 1) . '&limit='.$limit.'&groupBy='.$groupBy.'&desc='.$desc.'">Next</a>'; } ?>
    </div>


    <!-- TABLE -->


    <table class="table mt-5">
      <thead>
        <tr class="text-uppercase text-gray-600">
          <?php
            for ($properties = 0; $properties < count($sakilaDBFetch[0]); $properties++) {
              echo '<th scope="col">' . $keysTitles[$properties] . '</th>';
            }
          ?>
        </tr>
      </thead>
      <tbody>
          <?php
            for ($indexMovie = 0; $indexMovie < count($sakilaDBFetch); $indexMovie++) {
              echo '<tr>';
              for ($properties = 0; $properties < count($sakilaDBFetch[0]); $properties++) {
                echo '<td>' . $sakilaDBFetch[$indexMovie][$keysTitles[$properties]] . '</td>';
              }
              echo '</tr>';
            }
          ?>
      </tbody>
    </table>
  </div>
</body>
</html>