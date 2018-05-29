<?php
  session_start();
  include("db_login.php");
  if(!(isset($_SESSION["user_id"]))) {
    header("Location: ./login.php");
  }
  else if(isset($_GET["action"]) && isset($_POST["topic"]) && isset($_POST["text"]) && isset($_GET["cat"])) {
    $topic = mysqli_real_escape_string($conn, $_POST["topic"]);
    $text = mysqli_real_escape_string($conn, $_POST["text"]);
    $cat = mysqli_real_escape_string($conn, $_POST["cat"]);

    echo $topic;
    $sql = "INSERT INTO topics (id, accepted, owner_id, category_id, published, date, content) VALUES (NULL, 0, ".$_SESSION["user_id"].", ".$_GET["cat"].", 0, '".date("Y-m-d H:i:s ")."', '$topic');";
    if(mysqli_query($conn, $sql)) {
      $last_id = mysqli_insert_id($conn);
      $sql = "INSERT INTO posts (id, author, date, topic_id, type, content, image_path, main) VALUES (NULL, ".$_SESSION["user_id"].", '".date("Y-m-d H:i:s ")."', $last_id, 'ASK', '".$_POST["text"]."', NULL, 1);";
      if(mysqli_query($conn, $sql)) {
        header("Location: question.php?id=$last_id");
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
  <link rel="stylesheet" href="css/ask.css">
  <title>AskJS.com</title>
</head>

<body>
  <header class="header">
    <h1 class="logo">
      <a href="./index.php" class="logo__header">AskJS.com</a>
    </h1>
  </header>
  <div class="ask container">
    <form action="<?php echo ("ask.php?action=send&cat=".$_GET["cat"]." "); ?>" method="POST" enctype=multipart/form-data class="asking">
      <input type="text" name="topic" placeholder="Topic" required class="topic">
      <textarea placeholder="Type question here..." required class="message" name="text" rows="8" cols="80"></textarea>
      <div class="buttons">
        <input type="file" name="file" value="Add image">
        <input type="submit" value="Ask!" class="send btn btn-success">
      </div>
    </form>
  </div>



  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>

</html>
