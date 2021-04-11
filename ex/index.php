<?php
require_once "./db.php";


if (!empty($_POST)) {
  extract($_POST);
  try {
    $sql = "Insert into games (title, price, launch) values (?,?,?)";
    $rs = $db->prepare($sql);
    $rs->execute([$title, $price, $launch]);
  } catch (PDOException $ex) {
    $error = "insert olmadı abi";
  }
} else if (isset($_GET["delete"])) {
  $id = $_GET["delete"];

  try {
    $rs = $db->prepare("delete from games where id = :id");
    $rs->execute(["id" => $id]);
    if ($rs->rowCount() == 0)
      $error = "zaten hepsi silindi";
  } catch (PDOException $ex) {
    $error = "delete olmadı abi";
  }
}





try {
  $rs = $db->query("select * from games");
  $games = $rs->fetchAll(PDO::FETCH_ASSOC);

  // var_dump($games);
} catch (PDOException $ex) {
  echo "<p>", $ex->getMessage(), "</p>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Title of the document</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <style>
  </style>
</head>

<body>
  <div class="container">
    <div class="card-panel teal lighten-2 white-text">
      <h1 class="center"> List Of Games</h1>
    </div>
    <form action="" method="post">

      <table>
        <tr>
          <td colspan="2">
            <div class="input-field">
              <input name="title" id="title" type="text" class="validate">
              <label for="title">Title</label>
            </div>
          </td>
          <td>
            <div class="input-field">
              <input name="price" id="price" type="text" class="validate">
              <label for="price">Price</label>
            </div>
          </td>

          <td>
            <div class="input-field">
              <input name="launch" id="launch" type="text" class="datepicker">

            </div>
          </td>
          <td>
            <button class="btn waves-effect waves-light" type="submit" name="action">Submit
              <i class="material-icons right">send</i>
            </button>
          </td>
        </tr>

        <tr>
          <th width="%5">ID</th>
          <th width="%50">TITLE</th>
          <th width="%20">PRICE</th>
          <th width="%10">LAUNCH</th>
          <th width="%5">ops</th>
        </tr>
        <?php
        foreach ($games as $game) {
          echo "<tr>";
          echo "<td>$game[id]</td>";
          echo "<td>$game[title]</td>";
          echo "<td>$game[price]", " $", "</td>";
          echo "<td>$game[launch]</td>";
          echo "<td><a href='?delete=$game[id]' class='btn-small'>Delete</a></td>";
          echo "</tr>";
        }
        ?>


      </table>
    </form>

  </div>
<?php

if(isset($error))
echo $error;
?>


  <script>
    $(function() {
      $('.datepicker').datepicker({
        format: "yyyy-mm-dd"
      });
    })
  </script>
</body>

</html>