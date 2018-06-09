<?php
  session_start();
  include("db_login.php");
  if(!isset($_SESSION["user_id"])) {
    header("Location: ./login.php");
  }
  else {
      $sql = "select * from users where id=".$_SESSION['user_id'].";";
      $result = mysqli_query($conn, $sql);
      // $rank = '';
      // $name = '';
      // $surname = '';
      // $email = '';
      // $login = '';
      // $avt_path = '';
      // $date = '';

      if(mysqli_num_rows($result) > 0) {

        while($row = mysqli_fetch_assoc($result)) {
          $name = $row["name"];
          $surname = $row["surname"];
          $rank = $row["rank"];
          $email = $row["email"];
          $login = $row["login"];
          $date = $row["last"];
          if($date == "") {
            $date = "never";
          }
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
          <p class="profile__date">Last log in: <span class="datedb"><?php echo $date;?></span></p>
        </div>
      </div>  <!-- end panel -->
      <div class="profile__buttons">
        <?php
        if($rank == "Admin") {
          echo ("
          <a href='./upload.php' class='btn btn-primary'>Upload avatar</a>
          <a href='./subscribe.php' class='btn btn-primary'>Subscribe categories</a>
          <a href='./edit.php' class='btn btn-primary'>Edit categories</a>
          <a href='./new.php' class='btn btn-success'>New questions</a>
          <a href='./accepted.php' class='btn btn-info'>Accepted</a>
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
            $sql = "select c.name,
            count(if(t.accepted=1,1,null)) as accepted,
            count(if(t.accepted=0,1,null)) as new,
            count(if(t.published=1,1,null)) as published,
            m.users_id as admin,
            count(if(p.type='ANSWER',1,null)) as answers
            from categories c
            inner join topics t on c.id=t.category_id
            left join cat_mang m on c.id=m.categories_id
            left join posts p on t.id=p.topic_id
            where m.users_id = ".$_SESSION["user_id"]."
            group by c.name, m.users_id;";

            echo ("
            <thead>
              <tr>
                <th scope='col'>Category</th>
                <th scope='col'>New</th>
                <th scope='col'>Accepted</th>
                <th scope='col'>Published</th>
                <th scope='col'>Answers</th>
              </tr>
            </thead>
            <tbody>");

            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result)) {
              while($row = mysqli_fetch_assoc($result)) {
                echo("
                <tr>
                  <th scope='row'>".$row["name"]."</th>
                  <td>".$row["new"]."</td>
                  <td>".$row["accepted"]."</td>
                  <td>".$row["published"]."</td>
                  <td>".$row["answers"]."</td>
                </tr>
                ");
              }
            }

              echo("
            </tbody>
            ");
          }
          else if( $rank == "User") {
            $sql = "select c.name,
            count(if(t.accepted=1,1,null)) as accepted,
            count(if(t.published=1,1,null)) as published,
            count(t.id) as questions
            from categories c
            inner join topics t on c.id=t.category_id
            where t.owner_id = ".$_SESSION["user_id"]."
            group by c.name;";

            echo ("
            <thead>
              <tr>
                <th scope='col'>Category</th>
                <th scope='col'>Questions</th>
                <th scope='col'>Accepted</th>
                <th scope='col'>Published</th>
              </tr>
            </thead>
            <tbody>");

            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result)) {
              while($row = mysqli_fetch_assoc($result)) {
                echo("
                <tr>
                  <th scope='row'>".$row["name"]."</th>
                  <td>".$row["questions"]."</td>
                  <td>".$row["accepted"]."</td>
                  <td>".$row["published"]."</td>
                </tr>
                ");
              }
            }

              echo("
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
