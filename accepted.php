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
  <link rel="stylesheet" href="css/accepted.css">
  <title>AskJS.com</title>
</head>

<body>
  <header class="header">
    <h1 class="logo">
      <a href="./index.php" class="logo__header">AskJS.com</a>
    </h1>
  </header>
  <div class="accepted">
    <h2 class="accepted__info">
      There are asks which you have accepted!
    </h2>
    <div class="accepted__list">
      <?php
        $sql ="SELECT t.date, t.id, u.login, c.name, t.content FROM topics t
        INNER JOIN users u ON t.owner_id = u.id
        LEFT JOIN categories c ON t.category_id = c.id
        LEFT JOIN cat_mang m ON m.categories_id = t.category_id
        WHERE t.accepted = 1 AND m.users_id = ".$_SESSION["user_id"].";";

        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result)) {
          while($row = mysqli_fetch_assoc($result)) {
            echo ("
            <div class='accepted__item'>
              <div class='accepted_info'>
                <span class='accepted__date'>".$row["date"]." /</span>
                <span class='accepted__cat'> ".$row["name"]." /</span>
                <span class='accepted__author'> ".$row["login"]."</span>
                <br>
                <span class='accepted_topic'>".$row["content"]."</span>
              </div>
              <div class='accepted__button'>
                <a href='question.php?id=".$row["id"]."' class='btn btn-info'>Show</a>
              </div>
            </div>
            ");
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