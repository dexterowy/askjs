<?php
  session_start();
  include("db_login.php");
  if(!isset($_SESSION["user_id"])) {
    header("Location: ./login.php");
  }
  else {
      $sql = "select * from users where id=".$_SESSION['user_id'].";";
      $result = mysqli_query($conn, $sql);
      $rank = '';
      $name = '';
      $surname = '';
      $email = '';
      $login = '';
      $avt_path = '';

      if(mysqli_num_rows($result) > 0) {

        while($row = mysqli_fetch_assoc($result)) {
          $name = $row["name"];
          $surname = $row["surname"];
          $rank = $row["rank"];
          $email = $row["email"];
          $login = $row["login"];
          echo $row["avt_path"];
          if(!$row["avt_path"]) {
            $avt_path = "https://via.placeholder.com/300x300";
          }
          else {
            $avt_path = $row["avt_path"];
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
  <link rel="stylesheet" href="css/profile.css">
  <title>AskJS.com</title>
</head>
<body>
  <header class="profile">
    <h1 class="logo">
      <a href="./index.php" class="logo__header">AskJS.com</a>
    </h1>
  </header>
  <main>
    <div class="profile container">
      <div class="profile__panel">
          <img class="profile__img" src="<?php echo $avt_path; ?>" alt="">
        <div class="profile__info">
          <h2 class="profile_login"><?php echo $login; ?></h2>
          <p class="profile__type">Rank: <span class="rankdb"><?php echo $rank; ?></span></p>
          <p class="profile__name">Name: <span class="namedb"><?php echo $name; ?></span></p>
          <p class="profile__surname">Surname: <span class="surnamedb"><?php echo $surname; ?></span></p>
          <p class="profile__email">Email: <span class="emaildb"><?php echo $email; ?></span></p>
        </div>
      </div>  <!-- end panel -->
      <div class="profile__buttons">
        <?php
        if($rank == "Admin") {
          echo ("
          <a href='./upload.php' class='btn btn-primary'>Upload avatar</a>
          <a href='./subscribe.php' class='btn btn-primary'>Subscribe categories</a>
          <a href='./edit.php' class='btn btn-primary'>Edit categories</a>
          <a href='./index.php?new' class='btn btn-success'>New questions</a>
          <a href='./index.php?accepted' class='btn btn-info'>Accepted</a>
          ");
        }
        else if( $rank == "User") {
          echo ("
          <a href='./upload.php' class='btn btn-primary'>Upload avatar</a>
          <a href='./subscribe.php' class='btn btn-primary'>Subscribe categories</a>
          ");
        }
         ?>
        </div>  <!-- end buttons -->
      <div class="stats">
        <h2 class="stats__header">Stats</h2>
        <table class="table">
          <?php
          if($rank == "Admin") {
            echo ("
            <thead>
              <tr>
                <th scope='col'>Category</th>
                <th scope='col'>New</th>
                <th scope='col'>Accepted</th>
                <th scope='col'>Published</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope='row'>NodeJS</th>
                <td>154</td>
                <td>54</td>
                <td>54</td>

              </tr>
              <tr>
                <th scope='row'>React</th>
                <td>12</td>
                <td>11</td>
                <td>11</td>

              </tr>
              <tr>
                <th scope='row'>jQuery</th>
                <td>12468</td>
                <td>10468</td>
                <td>10468</td>
              </tr>
            </tbody>
            ");
          }
          else if( $rank == "User") {
            echo ("
            <thead>
              <tr>
                <th scope='col'>Category</th>
                <th scope='col'>Questions</th>
                <th scope='col'>Accepted</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope='row'>NodeJS</th>
                <td>154</td>
                <td>54</td>

              </tr>
              <tr>
                <th scope='row'>React</th>
                <td>12</td>
                <td>11</td>

              </tr>
              <tr>
                <th scope='row'>jQuery</th>
                <td>12468</td>
                <td>10468</td>
              </tr>
            </tbody>
            ");
          }
           ?>

</table>
      </div>
    </div>
  </main>


  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>

</html>
