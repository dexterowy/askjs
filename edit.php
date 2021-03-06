<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
  <link rel="stylesheet" href="css/edit.css">
  <title>AskJS.com</title>
</head>

<body>
  <header class="header">
    <h1 class="logo">
      <a href="./index.php" class="logo__header">AskJS.com</a>
    </h1>
  </header>
  <div class="edit">
    <ul class="edit__list">
      <li class="edit__item">
        <span class="edit__cat">cat1</span><button class=" edit btn btn-primary">Edit</button><button class="del btn btn-danger">Delete with all posts</button>
      </li>
      <li class="edit__item">
        <span class="edit__cat">cat2</span><button class=" edit btn btn-primary">Edit</button><button class="del btn btn-danger">Delete with all posts</button>
      </li>
      <li class="edit__item">
        <span class="edit__cat">cat3</span><button class=" edit btn btn-primary">Edit</button><button class="del btn btn-danger">Delete with all posts</button>
      </li>
      <li class="edit__item">
        <span class="edit__cat">cat4</span><button class=" edit btn btn-primary">Edit</button><button class="del btn btn-danger">Delete with all posts</button>
      </li>
      <li class="edit__item">
        <span class="edit__cat">cat5</span><button class=" edit btn btn-primary">Edit</button><button class="del btn btn-danger">Delete with all posts</button>
      </li>
    </ul>
    <a href="./profile_admin.php" class="btn btn-primary">Back</a>
    <button id="add" class="btn btn-success">Add</button>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
  <script src="./edit.js"></script>
</body>

</html>
