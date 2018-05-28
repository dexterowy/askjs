<?php
  session_start();
  include("db_login.php");
  if(!(isset($_SESSION["user_id"]))) {
    header("Location: ./login.php");
  }
  else if(isset($_GET["id"])) {
    $sql = "SELECT t.content, t.accepted, m.users_id, t.published FROM topics AS t INNER JOIN cat_mang AS m ON m.categories_id = t.category_id WHERE (t.published = 1 OR t.owner_id = ".$_SESSION["user_id"]." OR m.users_id = ".$_SESSION["user_id"].") AND t.id = ".$_GET["id"].";";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {


      while($row = mysqli_fetch_assoc($result)) {
        $topic = $row["content"];
        $state = $row["accepted"];
        $admin_id = $row["users_id"];
        $pub = $row["published"];
      }
      if(isset($_GET["action"]) && $_SESSION["user_rank"] == "Admin") {
        if($admin_id == $_SESSION["user_id"] && $_GET["action"] == "accept") {
          $sql = "UPDATE topics SET accepted = 1 WHERE id = ".$_GET["id"].";";
          if(mysqli_query($conn, $sql)) {
            header("Location: question.php?id=".$_GET["id"]);
          }
        }
        else if($admin_id == $_SESSION["user_id"] && $_GET["action"] == "delete") {
          $sql = "DELETE FROM topics WHERE id = ".$_GET["id"].";";
          if(mysqli_query($conn, $sql)) {
            header("Location: index.php?deleted=".$_GET["id"]);
          }
        }
        else if($admin_id == $_SESSION["user_id"] && $_GET["action"] == "publish") {
          $sql = "UPDATE topics SET published = 1 WHERE id = ".$_GET["id"].";";
          if(mysqli_query($conn, $sql)) {
            header("Location: question.php?id=".$_GET["id"]);
          }
        }
      }
    }
    else {
      header("Location: ./index.php");
    }
  }
  else {
    header("Location: ./index.php");
  }
?>
<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
  <link rel="stylesheet" href="css/question.css">
  <title>AskJS.com</title>
</head>

<body>
  <div class="question container">
    <header>
      <h1 class="logo">
        <a href="./index.php" class="logo__header">AskJS.com</a>
      </h1>
    </header>
    <div class="question__header">
      <h2 class="question__topic">
      <?php echo $topic; ?>
      </h2>
      <div class="question__buttons">

        <?php if($_SESSION["user_rank"] == "Admin")  {
          if($state == "0") {
            echo ("
            <a href='question.php?id=".$_GET["id"]."&action=accept' class='btn btn-success'>Accept</a>
            ");
          }
          else {
            echo ("
            <a href='answer.php?cat=".$_GET["id"]."' class='btn btn-success'>Answer</a>
            ");
          }
          if($pub == "0") {
            echo ("
            <a href='question.php?id=".$_GET["id"]."&action=publish' class='btn btn-primary'>Publish</a>
            ");
          }
          echo ("
          <a href='question.php?id=".$_GET["id"]."&action=edit' class='btn btn-info'>Edit</a>

          <a href='question.php?id=".$_GET["id"]."&action=delete' class='btn btn-danger'>Delete</a>
          ");
        }
        else {
          echo ("
          <a href='answer.php?cat=".$_GET["id"]."' class='btn btn-success'>Answer</a>
          ");
        }?>
      </div>
    </div>
    <div class="msg">

      <?php
        $sql = "select p.date, p.type, p.content, u.login, c.name, p.image_path from posts p inner join users u on p.author = u.id  left join topics t on t.id = p.topic_id left join categories c on t.category_id = c.id WHERE t.id = ".$_GET["id"]." order by p.date asc;";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0) {

          while($row = mysqli_fetch_assoc($result)) {
            $autor = $row["login"];
            $date = $row["date"];
            $content = $row["content"];
            $cat = $row["name"];
            $img = $row["image_path"];
            if($row["type"] == "ASK") {
              echo ("
              <div class='ask'>
                <div class='ask__info'>
                  <span class='ask__autor'>$autor</span> / <span class='ask__date'>$date</span> / <span class='ask__cat'>$cat</span>
                </div>
                <div class='ask__content'>
                  $content
                  <img src='$img' alt='' class='ask__img'>
                </div>
              </div>
              ");
            }
            else {
              echo ("
              <div class='answer'>
                <div class='answer__info'>
                  <span class='answer__autor'>$autor</span> / <span class='answer__date'>$date</span> / <span class='answer__cat'>$cat</span>
                </div>
                <div class='answer__content'>
                  $content
                  <img src='$img' alt='' class='answer__img'>
                </div>
              </div>
              ");
            }
          }
        }
       ?>
    </div>
  </div>





  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>

</html>
