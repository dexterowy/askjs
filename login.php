<?php
  session_start();
  include("db_login.php");
  if(isset($_SESSION["user_id"])) {
    header("Location: ./index.php");
  }
  else {
    include("db_login.php");
    if(!empty($_POST["login"]) && !empty($_POST["pass"])) {
      $login = mysqli_real_escape_string($conn, $_POST["login"]);
      $passwd = mysqli_real_escape_string($conn, $_POST["pass"]);

      $sql = "SELECT id, rank, password, date FROM users where login='$login';";
      $result = mysqli_query($conn, $sql);
      if (mysqli_num_rows($result) > 0) {
          // output data of each row
          while($row = mysqli_fetch_assoc($result)) {
            if(password_verify($passwd, $row["password"]) == 1) {
              $_SESSION["user_id"] = $row["id"];
              $_SESSION["user_rank"] = $row["rank"];
              $last = $row["date"];
              mysqli_query($conn, "UPDATE users SET date='".date("Y-m-d")."', last='$last' WHERE id=".$_SESSION["user_id"].";");
              header("Location: ./index.php");
            }
            else {
              header("Location: ./login.php?login=fail");
            }
          }

      }
      else {
        header("Location: ./login.php?login=fail");
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
  <link rel="stylesheet" href="css/login.css">
  <title>AskJS.com</title>
</head>

<body>
  <header class="login container">
    <h1 class="logo">
      <a href="./index.php" class="logo__header">AskJS.com</a>
    </h1>
    <?php if(isset($_GET["login"])) {
      echo ("<div class='alert alert-danger'>Wrong login or password!</div>");
    } ?>
    <?php if(isset($_GET["register"])) {
      echo ("<div class='alert alert-success'>Your account has been crated! Please log in!</div>");
    } ?>

    <div class="login__panel">
      <h1 class="login__header">Login</h1>
      <form action="login.php" method="post" class="login__form">
        <input type="text" placeholder="Login" name="login" class="login__input">
        <input type="password" placeholder="Password" name="pass" class="login__input">
        <button type="submit" class="login__btn btn btn-success">Login</button>
        <a href="./register.php" class="register__btn btn btn-danger">Register</a>
      </form>
    </div>
  </header>




  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>

</html>
