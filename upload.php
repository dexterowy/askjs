<?php
  session_start();
  include("db_login.php");
  if(!isset($_SESSION["user_id"])) {
    header("Location: ./login.php");
  }
  else if(isset($_POST["submit"])) {
    $sql = "SELECT avt_path FROM users WHERE id = ".$_SESSION["user_id"].";";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
        if($row["avt_path"] != "") {
          unlink($row["avt_path"]);
        }
      }
    }
    if(isset($_FILES["img"])) {
      $img = $_FILES["img"];
      //print_r($img);
      $name = explode(".", $img["name"]);
      $type = strtolower(end($name));
      $allowed = array("jpg", "jpeg", "png");
      if(in_array($type, $allowed)) {
        if($img["error"] === 0) {
          if($img["size"] < 5000000) {
            $newName = uniqid('', true).".".$type;
            $path = 'uploads/profiles/'.$newName;
            move_uploaded_file($img["tmp_name"], $path);
            $sqlPath = mysqli_real_escape_string($conn, $path);
            $sql = "UPDATE users SET avt_path = '$sqlPath' WHERE id = ".$_SESSION["user_id"].";";
            echo $sql;
            mysqli_query($conn, $sql);
             echo $path;
            header("Location: upload.php?success");
          }
        }
      }
    }
  }
  else {
    $sql = "SELECT avt_path FROM users WHERE id = ".$_SESSION["user_id"].";";
    $result = mysqli_query($conn, $sql);
    $avt = "test";
    if(mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
        $avt = $row["avt_path"];
      }
    }
    if($avt == "") {
      $avt = "https://via.placeholder.com/300x300";
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
  <link rel="stylesheet" href="css/upload.css">
  <title>AskJS.com</title>
</head>

<body>
  <header class="header">
    <h1 class="logo">
      <a href="./index.php" class="logo__header">AskJS.com</a>
    </h1>
  </header>
  <div class="upload">
    <?php if(isset($_GET["success"])) {
      echo ("
      <div class='alert alert-success'>New avatar uploaded!</div>
      ");
    } ?>
    <h2 class="upload__text">Change your profile photo!</h2>
    <img id="img" src="<?php echo $avt; ?>" alt="" class="upload__img">
    <form action="upload.php" class="upload__form" method="post" enctype="multipart/form-data">
      <input id="imgInput" type="file" name="img">
      <button class="btn btn-success" type="submit" name="submit" value="submit">Zapisz</button>
      <a href="./profile.php" class="btn btn-primary">Back</a>
    </form>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>

</html>
