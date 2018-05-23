<?php
  session_start();
  include("db_login.php");
  if(!isset($_SESSION["user_id"])) {
    header("Location: ./login.php");
  }
  else {
      $sql = "select name from categories;";
      $result = mysqli_query($conn, $sql);
      $cats = [];

      if(mysqli_num_rows($result) > 0) {

        while($row = mysqli_fetch_assoc($result)) {
          array_push($cats, $row["name"]);
        }
      }
      $sql = "select categories.name from subscribes INNER JOIN categories on subscribes.category_id = categories.id where subscribes.users_id=".$_SESSION["user_id"].";";
      $result = mysqli_query($conn, $sql);
      $checked = [];

      if(mysqli_num_rows($result) > 0) {

        while($row = mysqli_fetch_assoc($result)) {
          array_push($checked, $row["name"]);
        }
      }

    }
  if(isset($_POST["save"])) {

    $sql = "DELETE FROM subscribes WHERE users_id=".$_SESSION["user_id"].";";
    if($deleted=mysqli_query($conn, $sql)) {
      $completed = true;
        foreach ($_POST as $item) {
          $sql = "INSERT INTO subscribes (users_id, category_id) VALUES (".$_SESSION["user_id"].", (SELECT id FROM categories where name= '".$item."'));";
          if($updated = mysqli_query($conn, $sql)) {

          }
          else {
            $completed = false;
          }
        }
          header("Location: ./subscribe.php?saved=true");
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
  <link rel="stylesheet" href="css/subscribe.css">
  <title>AskJS.com</title>
</head>

<body>
  <header class="header">
    <h1 class="logo">
      <a href="./index.php" class="logo__header">AskJS.com</a>
    </h1>
  </header>
  <div class="subscribe">
    <h2 class="subscribe__info">
      Choose which categories you want to follow.
    </h2>
    <?php if(isset($_GET["saved"])) {
      echo ("<div class='alert alert-success'>Your subscribes has beed saved!</div>");
    } ?>
    <form action="subscribe.php" method="post" class="subscribe__list form-group">
        <?php
          foreach ($cats as $cat) {
            $check = false;
            foreach ($checked as $item) {
              if($cat == $item) {
                $check = true;
                break;
              }
            }
            if($check) {
              echo ('
              <div>
                <label for="'.$cat.'">'.$cat.'</label><input checked type="checkbox" id="'.$cat.'" name="'.$cat.'" value="'.$cat.'">
              </div>');
            }
            else {
              echo ('
              <div>
                <label for="'.$cat.'">'.$cat.'</label><input type="checkbox" id="'.$cat.'" name="'.$cat.'" value="'.$cat.'">
              </div>');
            }
          }
         ?>
      <button type="submit" name="save" class="btn btn-success">Save</button>
      <a href="profile.php" class="btn btn-primary">Back</a>
    </form>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>

</html>
