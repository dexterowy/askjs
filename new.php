<?php
  session_start();
  include("db_login.php");
  if(!(isset($_SESSION["user_id"])) || $_SESSION["user_rank"] != "Admin") {
    header("Location: ./login.php");
  }


?>
<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
  <link rel="stylesheet" href="css/new.css">
  <title>AskJS.com</title>
</head>

<body>
  <header class="header">
    <h1 class="logo">
      <a href="./index.php" class="logo__header">AskJS.com</a>
    </h1>
  </header>
  <div class="new">
    <h2 class="new__info">
      There are asks which are waiting for accept!
    </h2>
    <div class="new__list">

      <div class="new__item">
        <div class="new_info">
          <span class="new__date">2018-05-28 /</span>
          <span class="new__cat"> jQuery /</span>
          <span class="new__author"> dexterowy</span>
          <br>
          <span class="new_topic">Sample topic</span>
        </div>
        <div class="new__button">
          <a href="#" class="btn btn-info">Show</a>
        </div>
      </div>


    </div>
  </div>



  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
  <script src="./edit.js"></script>
</body>

</html>
