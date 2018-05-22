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
      <div class="menu__wrapper">
        <a href="" class="menu__main">Cat</a>
        <div class="menu__sub"><a href="" class="menu__myasks">MyAsks</a><a href="" class="menu__public">Public</a><a href="./ask.php" class="menu__ask">ask now!</a></div>
      </div>
      <div class="menu__wrapper">
        <a href="" class="menu__main">Cat</a>
        <div class="menu__sub"><a href="" class="menu__myasks">MyAsks</a><a href="" class="menu__public">Public</a><a href="./ask.php" class="menu__ask">ask now!</a></div>
      </div>
      <div class="menu__wrapper">
        <a href="" class="menu__main">Cat</a>
        <div class="menu__sub"><a href="" class="menu__myasks">MyAsks</a><a href="" class="menu__public">Public</a><a href="./ask.php" class="menu__ask">ask now!</a></div>
      </div>
      <div class="menu__wrapper">
        <a href="" class="menu__main">Cat</a>
        <div class="menu__sub"><a href="" class="menu__myasks">MyAsks</a><a href="" class="menu__public">Public</a><a href="./ask.php" class="menu__ask">ask now!</a></div>
      </div>
      <div class="menu__wrapper">
        <a href="" class="menu__main">Cat</a>
        <div class="menu__sub"><a href="" class="menu__myasks">MyAsks</a><a href="" class="menu__public">Public</a><a href="./ask.php" class="menu__ask">ask now!</a></div>
      </div>
      <div class="menu__wrapper">
        <a href="" class="menu__main">Cat</a>
        <div class="menu__sub"><a href="" class="menu__myasks">MyAsks</a><a href="" class="menu__public">Public</a><a href="./ask.php" class="menu__ask">ask now!</a></div>
      </div>
      <div class="menu__wrapper">
        <a href="" class="menu__main">Cat</a>
        <div class="menu__sub"><a href="" class="menu__myasks">MyAsks</a><a href="" class="menu__public">Public</a><a href="./ask.php" class="menu__ask">ask now!</a></div>
      </div>
  </nav>
  </header>
  <main>
    <section class="box">
      <a href="question.php" class="box__wrapper">
        <div class="box__textside">
          <div class="box__info">
            <span class="box__date">19-05-2018</span>
            <span class="box__author">Mateusz Szczotarz</span>
            <span class="box__cat">NodeJS</span>
          </div>
          <h2 class="box__header">Konfiguracja Express.JS</h2>

            <div class="box__content">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </div>
        </div>
        <div class="box__imgWrapper"><img src="https://via.placeholder.com/300x300" alt="placeholder" class="box__image"></div>
      </a>
    </section>
    <section class="box">
      <a href="question.php" class="box__wrapper">
        <div class="box__textside">
          <div class="box__info">
            <span class="box__date">19-05-2018</span>
            <span class="box__author">Mateusz Szczotarz</span>
            <span class="box__cat">NodeJS</span>
          </div>
          <h2 class="box__header">Konfiguracja Express.JS</h2>

            <div class="box__content">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </div>
        </div>
        <div class="box__imgWrapper"><img src="https://via.placeholder.com/300x300" alt="placeholder" class="box__image"></div>
      </a>
    </section>
    <section class="box">
      <a href="question.php" class="box__wrapper">
        <div class="box__textside">
          <div class="box__info">
            <span class="box__date">19-05-2018</span>
            <span class="box__author">Mateusz Szczotarz</span>
            <span class="box__cat">NodeJS</span>
          </div>
          <h2 class="box__header">Konfiguracja Express.JS</h2>

            <div class="box__content">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </div>
        </div>
        <div class="box__imgWrapper"><img src="https://via.placeholder.com/300x300" alt="placeholder" class="box__image"></div>
      </a>
    </section>
    <section class="box">
      <a href="question.php" class="box__wrapper">
        <div class="box__textside">
          <div class="box__info">
            <span class="box__date">19-05-2018</span>
            <span class="box__author">Mateusz Szczotarz</span>
            <span class="box__cat">NodeJS</span>
          </div>
          <h2 class="box__header">Konfiguracja Express.JS</h2>

            <div class="box__content">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </div>
        </div>
        <div class="box__imgWrapper"><img src="https://via.placeholder.com/300x300" alt="placeholder" class="box__image"></div>
      </a>
    </section>
    <section class="box">
      <a href="question.php" class="box__wrapper">
        <div class="box__textside">
          <div class="box__info">
            <span class="box__date">19-05-2018</span>
            <span class="box__author">Mateusz Szczotarz</span>
            <span class="box__cat">NodeJS</span>
          </div>
          <h2 class="box__header">Konfiguracja Express.JS</h2>

            <div class="box__content">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </div>
        </div>
        <div class="box__imgWrapper"><img src="https://via.placeholder.com/300x300" alt="placeholder" class="box__image"></div>
      </a>
    </section>
    <section class="box">
      <a href="question.php" class="box__wrapper">
        <div class="box__textside">
          <div class="box__info">
            <span class="box__date">19-05-2018</span>
            <span class="box__author">Mateusz Szczotarz</span>
            <span class="box__cat">NodeJS</span>
          </div>
          <h2 class="box__header">Konfiguracja Express.JS</h2>

            <div class="box__content">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </div>
        </div>
        <div class="box__imgWrapper"><img src="https://via.placeholder.com/300x300" alt="placeholder" class="box__image"></div>
      </a>
    </section>
  </main>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

</body>
</html>
