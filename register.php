<?php
session_start();
if(isset($_SESSION["user_id"])) {
  header("Location: ./index.php");
}
else {
  include("db_login.php");
  if(isset($_POST["login"]) && isset($_POST["pass"]) && isset($_POST["name"]) && isset($_POST["surname"]) && isset($_POST["email"])) {
    $login = mysqli_real_escape_string($conn, $_POST["login"]);
    $passwd = mysqli_real_escape_string($conn, $_POST["pass"]);

    $hashed = password_hash($passwd, PASSWORD_DEFAULT);

    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $surname = mysqli_real_escape_string($conn, $_POST["surname"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);

    $sql_login = "SELECT login, email FROM users WHERE login='$login' OR email='$email';";
    $result = mysqli_query($conn, $sql_login);
    if(mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)){
        if($row["login"] == $login) {
          header("Location: ./register.php?fail=login");
        }
        else if($row["email"] == $email) {
          header("Location: ./register.php?fail=email");
        }
      }
    }
    else {
      if(!empty($_POST["login"]) && !empty($_POST["pass"]) && !empty($_POST["name"]) && !empty($_POST["surname"]) && !empty($_POST["email"])) {
        $sql_register = "INSERT INTO users (id, login, password, email, avt_path, rank, name, surname) VALUES
        (NULL,'$login', '$hashed', '$email', NULL, 'User', '$name', '$surname');";
        if($result = mysqli_query($conn, $sql_register)) {
          header("Location: ./login.php?register");
        }
      }
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
  <link rel="stylesheet" href="css/register.css">
  <title>AskJS.com</title>
</head>

<body>
  <div class="register container">
    <h1 class="logo">
      <a href="./index.php" class="logo__header">AskJS.com</a>
    </h1>
    <div class="register__panel">
      <h1 class="register__header">Register</h1>
      <form action="./register.php" method="post" class="register__form">
        <input type="text" placeholder="Name" name="name" class="register__input">
        <input type="text" placeholder="Surname" name="surname" class="register__input">
        <?php if(isset($_GET["fail"])) {
          if($_GET["fail"] == "email"){
            echo (
              "<span class='alert alert-danger'>User with this email already exists</span>"
            );
          }
        } ?>
        <input type="text" placeholder="Email" name="email" class="register__input">
        <?php if(isset($_GET["fail"])) {
          if($_GET["fail"] == "login"){
            echo (
              "<span class='alert alert-danger'>User with this login already exists</span>"
            );
          }
        } ?>
        <input type="text" placeholder="Login" name="login" class="register__input">
        <input type="password" placeholder="Password" name="pass" class="register__input">
        <button type="submit" class="register__btn btn btn-success">Register</button>
      </form>
    </div>
  </div>




  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>

</html>
