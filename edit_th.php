<?php
  session_start();
  include("db_login.php");
  if(!(isset($_SESSION["user_id"]))) {
    header("Location: ./login.php");
  }
  else if(isset($_GET["id"])) {
    if(isset($_GET["action"]) && $_GET["action"] == "delete" && isset($_GET["p"]) && isset($_GET["id"])) {
      $t = mysqli_real_escape_string($conn, $_GET["id"]);
      $p = mysqli_real_escape_string($conn, $_GET["p"]);
      $sql = "DELETE FROM posts WHERE topic_id = $t AND id = $p;";
      mysqli_query($conn, $sql);
   }
   if(isset($_GET["action"]) && $_GET["action"] == "done" && isset($_GET["id"])) {
     $id = mysqli_real_escape_string($conn, $_GET["id"]);
     $new = mysqli_real_escape_string($conn, $_POST["new"]);
     $sql = "UPDATE topics SET content = '$new' WHERE id = $id";
     if(mysqli_query($conn, $sql)) {
       header("Location: question.php?id=$id");
     }
   }

    $sql = "SELECT t.content, t.accepted, m.users_id, t.published FROM topics AS t INNER JOIN cat_mang AS m ON m.categories_id = t.category_id WHERE m.users_id = ".$_SESSION["user_id"]." AND t.id = ".$_GET["id"].";";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
        $topic = $row["content"];
        $state = $row["accepted"];
        $admin_id = $row["users_id"];
        $pub = $row["published"];
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
  <link rel="stylesheet" href="css/edit_th.css">
  <title>AskJS.com</title>
</head>
<body>
  <div class="edit container">
    <header>
      <h1 class="logo">
        <a href="./index.php" class="logo__header">AskJS.com</a>
      </h1>
    </header>
    <form action="edit_th.php?id=<?php echo $_GET["id"]; ?>&action=done" method="post" class="edit__header">
      <h2 class="edit__topic">
      <input type="text" name="new" value="<?php echo $topic; ?>">
      </h2>
      <div class="edit__buttons">
        <?php if($_SESSION["user_rank"] == "Admin")  {
          echo ("
          <button class='btn btn-info'>Done</button>
          ");
        }?>
      </div>
    </form>
    <div class="msg">

      <?php
        $sql = "select p.id, p.date, p.type, p.content, u.login, c.name, p.image_path from posts p inner join users u on p.author = u.id  left join topics t on t.id = p.topic_id left join categories c on t.category_id = c.id WHERE t.id = ".$_GET["id"]." order by p.date asc;";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0) {

          while($row = mysqli_fetch_assoc($result)) {
            $autor = $row["login"];
            $date = $row["date"];
            $content = $row["content"];
            $cat = $row["name"];
            $id = $row["id"];
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
                <a href='edit_th.php?id=".$_GET["id"]."&action=delete&p=".$row["id"]."' class='delete btn btn-danger'>Delete</a>
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
                <a href='edit_th.php?id=".$_GET["id"]."&action=delete&p=".$row["id"]."' class='delete btn btn-danger'>Delete</a>
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
