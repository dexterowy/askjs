<?php
  session_start();
  include("db_login.php");
  if(!isset($_SESSION["user_id"])) {
    header("Location: ./login.php");
  }
  else if(isset($_GET["logout"])) {
    session_unset();
    session_destroy();
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
  <link rel="stylesheet" href="css/index.css">
  <title>AskJS.com</title>
</head>
<body>
  <header>
    <h1 class="logo">
      <a href="./index.php" class="logo__header">AskJS.com</a>
    </h1>
      <div class="panel">
        <a href="./index.php?logout=logout" class="logout">
          <button class="btn btn-danger">Logout</button>
        </a>
        <a href="./profile.php" class="profile">
          <button class="btn btn-primary">Profile</button>
        </a>
      </div>
    <nav class="menu">
      <?php
      if(isset($_SESSION["user_id"])) {
        $sql = "SELECT categories.id, categories.name FROM categories INNER JOIN subscribes ON categories.id = subscribes.category_id WHERE subscribes.users_id = ".$_SESSION["user_id"].";";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
            echo ("
            <div class='menu__wrapper'>
              <a href='./index.php?cat=".$row["id"]."&filter=all' class='menu__main'>".$row["name"]."</a>
              <div class='menu__sub'>
              <a href='./index.php?cat=".$row["id"]."&filter=myasks' class='menu__myasks'>MyAsks</a>
              <a href='./index.php?cat=".$row["id"]."&filter=public' class='menu__public'>Public</a>
              <a href='./ask.php?cat=".$row["id"]."' class='menu__ask'>ask now!</a>
              </div>
            </div>
            ");
          }
        }
        else {
          echo ("
          <div class='menu__wrapper'>
            <a href='./subscribe.php' class='menu__main'>You have not subscribed any categories. You can do it in your profile panel (or click here)!</a>
          </div>
          ");
        }
      }
       ?>
      <!-- <div class="menu__wrapper">
        <a href="" class="menu__main">Cat</a>
        <div class="menu__sub"><a href="" class="menu__myasks">MyAsks</a><a href="" class="menu__public">Public</a><a href="./ask.php" class="menu__ask">ask now!</a></div>
      </div> -->
  </nav>
  </header>
  <main>
    <?php
    if(isset($_GET["cat"]) && isset($_GET["filter"])) {
      if($_GET["filter"] == "all") {
        $sql = "SELECT t.date, u.login, c.name, t.content as topic, p.content as post, p.image_path FROM topics t
        INNER JOIN users u ON u.id=t.owner_id
        LEFT JOIN categories c ON t.category_id=c.id
        LEFT JOIN posts p ON p.topic_id=t.id
        WHERE c.id = ".$_GET["cat"]." AND (t.published = 1 OR t.owner_id = ".$_SESSION["user_id"].") AND p.main = 1 ORDER BY t.date DESC;";
      }
      else if($_GET["filter"] == "myasks") {
        $sql = "SELECT t.date, u.login, c.name, t.content as topic, p.content as post, p.image_path FROM topics t
        INNER JOIN users u ON u.id=t.owner_id
        LEFT JOIN categories c ON t.category_id=c.id
        LEFT JOIN posts p ON p.topic_id=t.id
        WHERE c.id = ".$_GET["cat"]." AND (t.owner_id = ".$_SESSION["user_id"].") AND p.main = 1 ORDER BY t.date DESC;";
      }
      else if($_GET["filter"] == "public") {
        $sql = "SELECT t.date, u.login, c.name, t.content as topic, p.content as post, p.image_path FROM topics t
        INNER JOIN users u ON u.id=t.owner_id
        LEFT JOIN categories c ON t.category_id=c.id
        LEFT JOIN posts p ON p.topic_id=t.id
        WHERE c.id = ".$_GET["cat"]." AND t.published = 1 AND p.main = 1 ORDER BY t.date DESC;";
      }

      $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result)) {
          while($row = mysqli_fetch_assoc($result)) {
            echo ("
            <!-- <section class='box'> -->
              <a href='question.php' class='box box__wrapper'>
                <div class='box__textside'>
                  <div class='box__info'>
                    <span class='box__date'>".$row["date"]."</span>
                    <span class='box__author'>".$row["login"]."</span>
                    <span class='box__cat'>".$row["name"]."</span>
                  </div>
                  <h2 class='box__header'>".$row["topic"]."</h2>
                    <div class='box__content'>
                      <span>
                        ".$row["post"]."
                      </span>
                    </div>
                </div>
                <img class='box_img' src='".$row["image_path"]."'>
              </a>
            <!-- </section> -->
            ");
          }
        }
    }
    else {
      $sql = "SELECT t.date, u.login, c.name, t.content as topic, p.content as post, p.image_path FROM topics t
      INNER JOIN users u ON u.id=t.owner_id
      LEFT JOIN categories c ON t.category_id=c.id
      LEFT JOIN posts p ON p.topic_id=t.id
      WHERE t.published = 1 AND p.main = 1 ORDER BY t.date DESC;";
      $result = mysqli_query($conn, $sql);
      if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
          echo ("
          <section class='box'>
            <a href='question.php' class='box__wrapper'>
              <div class='box__textside'>
                <div class='box__info'>
                  <span class='box__date'>".$row["date"]."</span>
                  <span class='box__author'>".$row["login"]."</span>
                  <span class='box__cat'>".$row["name"]."</span>
                </div>
                <h2 class='box__header'>".$row["topic"]."</h2>
                  <div class='box__content'>
                    <span>
                      ".$row["post"]."
                    </span>
                  </div>
              </div>
              <img class='box_img' src='".$row["image_path"]."'>
            </a>
          </section>
          ");
        }
      }
    }

     ?>



  </main>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

</body>
</html>
