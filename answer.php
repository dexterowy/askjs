<?php
  session_start();
  include("db_login.php");
  require ('PHPMailer/src/PHPMailer.php');
  require ('PHPMailer/src/SMTP.php');
  require ('PHPMailer/src/Exception.php');
  use PHPMailer\PHPMailer\PHPMailer;
  if(!(isset($_SESSION["user_id"]))) {
    header("Location: ./login.php");
  }
  else if(isset($_GET["cat"])) {
    $sql = "SELECT t.content, t.owner_id, m.users_id FROM topics AS t
    INNER JOIN cat_mang AS m ON m.categories_id = t.category_id
    WHERE (t.published = 1 OR t.owner_id = ".$_SESSION["user_id"]." OR m.users_id = ".$_SESSION["user_id"].") AND t.id = ".$_GET["cat"].";";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
        $topic = $row["content"];
        if($row["owner_id"] == $_SESSION["user_id"]) {
          $type = "ASK";
        }
        else if ($row["users_id"] == $_SESSION["user_id"]) {
          $type = "ANSWER";
        }
      }
      if(isset($_GET["answer"]) && isset($_POST["message"])) {
        $cat = mysqli_real_escape_string($conn, $_GET["answer"]);
        $msg = mysqli_real_escape_string($conn, $_POST["message"]);
        if(isset($_FILES["img"]) && !empty($_FILES["img"]["name"])) {
          $img = $_FILES["img"];
          $name = explode(".", $img["name"]);
          $imgType = strtolower(end($name));
          $allowed = array("jpg", "jpeg", "png");
          if(in_array($imgType, $allowed)) {
            if($img["error"] === 0) {
              if($img["size"] < 5000000) {
                $newName = uniqid('', true).".".$imgType;
                $path = "uploads/posts/".$newName;
                move_uploaded_file($img["tmp_name"], $path);
                $sqlPath = mysqli_real_escape_string($conn, $path);
                $sqlPath = "'".$sqlPath."'";
              }
            }
          }
        }
        else {
          $sqlPath = "NULL";
        }
        $sql = "INSERT INTO posts (id, author, date, topic_id, type, content, image_path, main)
        VALUES (NULL, ".$_SESSION["user_id"].", '".date("Y-m-d H:i:s ")."', $cat, '$type', '$msg', $sqlPath, 0);";
        if(mysqli_query($conn, $sql)) {
          if($type == "ANSWER") {
            $sql = "SELECT email FROM users u INNER JOIN topics t ON u.id = t.owner_id WHERE t.id =".$_GET["cat"].";";
          }
          else if ($type == "ASK") {
            $sql = "SELECT m.users_id, u.email, t.content
            FROM cat_mang m
            INNER JOIN users u ON u.id = m.users_id
            LEFT JOIN topics t ON t.category_id = m.categories_id
            WHERE t.id = ".$_GET["cat"].";";
          }
          $result2 = mysqli_query($conn, $sql);
          if(mysqli_num_rows($result2)) {
            while($row = mysqli_fetch_assoc($result2)) {
              $email = $row["email"];
            }
          }
          $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
          try {
              //Server settings
              //$mail->SMTPDebug = 2;                                 // Enable verbose debug output
              $mail->isSMTP();                                      // Set mailer to use SMTP
              $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
              $mail->SMTPAuth = true;                               // Enable SMTP authentication
              $mail->Username = 'askjs.com@gmail.com';                 // SMTP username
              $mail->Password = 'zaq1@WSX';                           // SMTP password
              $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
              $mail->Port = 465;                                    // TCP port to connect to
              //Recipients
              $mail->setFrom('no-reply@askjs.com', 'AskJS.com');
              $mail->addAddress($email);     // Add a recipient

              //Content
              $mail->isHTML(true);                                  // Set email format to HTML
              $mail->Subject = "NEW REPLY IN $topic!";
              $mail->Body    = "
              <h1>NEW REPLY in $topic</h1>
              date: ".date("Y-m-d H:i:s ")." <br /><br />
              topic: $topic <br /><br />
              content: ".$_POST["message"]." <br />
              ";
              $mail->AltBody = "
              <h1>YOUR POST HAS BEEN ACCEPTED</h1>
              date: ".date("Y-m-d H:i:s ")." <br />
              <h1>NEW REPLY in $topic</h1>
              date: ".date("Y-m-d H:i:s ")." <br /><br />
              topic: $topic <br /><br />
              content: ".$_POST["message"]." <br />
              ";
              $mail->send();
              echo 'Message has been sent';
          } catch (Exception $e) {
              echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
          }
          header("Location: question.php?id=$cat");
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
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
  <link rel="stylesheet" href="css/answer.css">
  <title>AskJS.com</title>
</head>

<body>
  <header class="header">
    <h1 class="logo">
      <a href="./index.php" class="logo__header">AskJS.com</a>
    </h1>
  </header>
  <div class="answer container">
    <div class="answer__header">
      <h2 class="answer__topic">
        <?php echo $topic; ?>
      </h2>
    </div>
    <form action='answer.php?answer=<?php echo $_GET["cat"]; ?>&cat=<?php echo $_GET["cat"]; ?>' method="post" enctype="multipart/form-data" class="answering">
      <textarea placeholder="Type your answer here..." class="message" name="message" rows="8" cols="80"></textarea>
      <div class="buttons">
        <input type="file" name="img" value="Add image">
        <input type="submit" value="Answer" class="send btn btn-success">
      </div>
    </form>
  </div>



  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>

</html>
