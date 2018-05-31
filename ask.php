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
  else if(isset($_GET["action"]) && isset($_POST["topic"]) && isset($_POST["text"]) && isset($_GET["cat"])) {
    $topic = mysqli_real_escape_string($conn, $_POST["topic"]);
    $text = mysqli_real_escape_string($conn, $_POST["text"]);
    $cat = mysqli_real_escape_string($conn, $_GET["cat"]);
    if(isset($_FILES["img"]) && !empty($_FILES["img"]["name"])) {
      $img = $_FILES["img"];
      print_r($img);
      $name = explode(".", $img["name"]);
      $type = strtolower(end($name));
      $allowed = array("jpg", "jpeg", "png");
      if(in_array($type, $allowed)) {
        if($img["error"] === 0) {
          if($img["size"] < 5000000) {
            $newName = uniqid('', true).".".$type;
            $path = "uploads/posts/".$newName;
            move_uploaded_file($img["tmp_name"], $path);
            $sqlPath = mysqli_real_escape_string($conn, $path);
            echo $path;
            $sqlPath = "'".$sqlPath."'";
          }
        }
      }
    }
    else {
      $sqlPath = "NULL";
    }
    //echo $topic;
    $sql = "INSERT INTO topics (id, accepted, owner_id, category_id, published, date, content) VALUES (NULL, 0, ".$_SESSION["user_id"].", ".$_GET["cat"].", 0, '".date("Y-m-d H:i:s ")."', '$topic');";
    if(mysqli_query($conn, $sql)) {
      $last_id = mysqli_insert_id($conn);
      $sql = "INSERT INTO posts (id, author, date, topic_id, type, content, image_path, main) VALUES (NULL, ".$_SESSION["user_id"].", '".date("Y-m-d H:i:s ")."', $last_id, 'ASK', '".$_POST["text"]."', $sqlPath , 1);";
      echo $sql;
      if(mysqli_query($conn, $sql)) {
        $sql = "SELECT email FROM users u INNER JOIN cat_mang m ON u.id = m.users_id WHERE m.categories_id = ".$_GET["cat"].";";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result)) {
          while($row = mysqli_fetch_assoc($result)) {
            $email = $row["email"];
          }
        }
        echo $email;
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            // $mail->SMTPDebug = 2;                                 // Enable verbose debug output
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
            $mail->Subject = 'NEW ask in your category!';
            $mail->Body    = "
            <h1>NEW ASK WAS POSTED</h1>
            date: ".date("Y-m-d H:i:s ")." <br />
            topic: $topic <br />
            content: ".$_POST["text"]." <br />

            HURRY UP USER IS WAITING FOR REPLY! DON'T FORGET TO ACCEPT ASK!
            ";
            $mail->AltBody = "
            <h1>NEW ASK WAS POSTED</h1>
            date: ".date("Y-m-d H:i:s ")." <br />
            topic: $topic <br />
            content: ".$_POST["text"]." <br />

            HURRY UP USER IS WAITING FOR REPLY! DON'T FORGET TO ACCEPT ASK!
            ";
            $mail->send();

        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
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
        <input type="file" name="img" value="Add image">
        <input type="submit" value="Ask!" class="send btn btn-success">
      </div>
    </form>
  </div>



  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>

</html>
