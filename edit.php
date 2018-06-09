<?php
  session_start();
  include("db_login.php");
  if(!(isset($_SESSION["user_id"])) || $_SESSION["user_rank"] != "Admin") {
    header("Location: ./login.php");
  }
  else {
    if(isset($_GET["save"])) {
      $cat = mysqli_real_escape_string($conn, $_GET["save"]);
      $sql = "SELECT id FROM categories WHERE name = '$cat';";
      $result = mysqli_query($conn, $sql);
      if(mysqli_num_rows($result) > 0) {
        header("Location: ./edit.php?fail=name");
      }
      else {
        if(isset($_GET["edit"])) {
          $old = mysqli_real_escape_string($conn, $_GET["edit"]);
          $new = mysqli_real_escape_string($conn, $_GET["save"]);
          $sql = "SELECT categories.name from categories INNER JOIN cat_mang ON categories.id = cat_mang.categories_id WHERE cat_mang.users_id = ".$_SESSION["user_id"]." AND categories.name = '$old';";
          $result = mysqli_query($conn, $sql);
          if (mysqli_num_rows($result) > 0) {
            $sql = "UPDATE categories SET name='$new' WHERE name='$old';";
            mysqli_query($conn, $sql);
          }
          else {
            header("Location: ./edit.php?fail=hack");
          }
        }
        else {
          $sql = "INSERT INTO categories (id ,name) values(NULL, '$cat')";
          if(mysqli_query($conn, $sql)) {
            $id = mysqli_insert_id($conn);
            $sql = "INSERT INTO cat_mang (categories_id , users_id) values($id, ".$_SESSION["user_id"].")";
            mysqli_query($conn, $sql);
          }
        }
      }
    }
    if(isset($_GET["delete"])) {
      $sql = "SELECT categories.name from categories INNER JOIN cat_mang ON categories.id = cat_mang.categories_id WHERE cat_mang.users_id = ".$_SESSION["user_id"]." AND categories.name = '".$_GET["delete"]."';";
      $result = mysqli_query($conn, $sql);
      if (mysqli_num_rows($result) > 0) {
        $cat = mysqli_real_escape_string($conn, $_GET["delete"]);
        $uid = mysqli_real_escape_string($conn, $_SESSION["user_id"]);
        $sql = "DELETE FROM categories WHERE name = '$cat';";
        mysqli_query($conn, $sql);
      }
      else {
        header("Location: ./edit.php?fail=hack");
      }

    }
    $sql = "SELECT categories.name from categories INNER JOIN cat_mang ON categories.id = cat_mang.categories_id WHERE cat_mang.users_id = '".$_SESSION["user_id"]."';";
    $result = mysqli_query($conn, $sql);
    $cats = [];
    if(mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
        array_push($cats, $row["name"]);
      }
    }
  }
  ?>
<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
  <link rel="stylesheet" href="css/edit.css">
  <title>AskJS.com</title>
</head>

<body>
  <header class="header">
    <h1 class="logo">
      <a href="./index.php" class="logo__header">AskJS.com</a>
    </h1>
  </header>
  <div class="edit">
    <?php
      if(isset($_GET["fail"])){
        if($_GET["fail"] == "hack") {
          echo (
            "<span class='alert alert-danger'>Stop it!</span>"
          );
        }
        elseif ($_GET["fail"] ==  "name") {
          echo (
            "<span class='alert alert-danger'>Category with chosen name already exists</span>"
          );
        }

      }
      if(isset($_GET["save"]) && !isset($_GET["edit"])) {
        echo (
          "<span class='alert alert-success'>New category '".$_GET["save"]."' has been created!</span>"
        );
      }
      if(isset($_GET["save"]) && isset($_GET["edit"])) {
        echo (
          "<span class='alert alert-success'>Category name has been changed!</span>"
        );
      }
      if(isset($_GET["delete"])){
        echo (
          "<span class='alert alert-info'>Category '".$_GET["delete"]."' has been deleted!</span>"
        );
      }
       ?>
    <ul class="edit__list">
      <?php
        foreach ($cats as $item) {
          echo ("
          <li class='edit__item'><span class='edit__cat'>$item</span><div class='edit__itemBtn'><button class=' edit btn btn-primary'>Edit</button><button class='del btn btn-danger'>Delete with all posts</button></div></li>
          ");
        }
        ?>
    </ul>
    <a href="./profile.php" class="btn btn-primary">Back</a>
    <button id="add" class="btn btn-success">Add</button>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
  <script src="./edit.js"></script>
</body>

</html>
