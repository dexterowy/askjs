<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
  <link rel="stylesheet" href="css/subscribe.css">
  <title>AskJS.com</title>
</head>

<body>
  <header class="header">
    <h1 class="logo">
      <a href="./index.php" class="logo__header">AskJS.com</a>
    </h1>
  </header>
  <div class="subscribe">
    <h2 class="subscribe__info">
      Choose which categories you want to follow.
    </h2>
    <form action="subscribe.php" class="subscribe__list form-group">
        <div>
          <label for="cat1">cat1</label><input type="checkbox" id="cat1" name="category" value="cat1">
        </div>
        <div>
          <label for="cat2">cat2</label><input type="checkbox" id="cat2" name="category" value="cat2">
        </div>
        <div>
          <label for="cat3">cat3</label><input type="checkbox" id="cat3" name="category" value="cat3">
        </div>
        <div>
          <label for="cat4">cat4</label><input type="checkbox" id="cat4" name="category" value="cat4">
        </div>
        <div>
          <label for="cat5">cat5</label><input type="checkbox" id="cat5" name="category" value="cat5">
        </div>
      <button type="submit" class="btn btn-success" name="save" value="submit">Save</button>
      <a href="profile.php" class="btn btn-primary">Back</a>
    </form>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>

</html>
