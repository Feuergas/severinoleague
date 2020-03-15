<?php
// Initialize the session
session_start();
require_once "config.php";

$err = [];
$valid_session = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;
$valid_contest = true;
/*// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: login.php");
  exit;
}*/

if(isset($_GET["id"])){
  $id = $_GET["id"];
  $sql = "SELECT * FROM contests WHERE id = $id";
  if($result = mysqli_query($link, $sql)){
    $row = mysqli_fetch_assoc($result);
    $contest_name = $row['name'];
    $n_problems = $row['n_problems'];
  }else{
    $err[] = "Something went wrong. Please try again later.";
  }
  $ranking = [];
  $sql = "SELECT * FROM scoreboard$id WHERE 1 ORDER BY score DESC";
  if ($result = mysqli_query($link, $sql)) {

    /* fetch associative array */

    while ($row = mysqli_fetch_assoc($result)) {
      $ranking[] = $row;
    }

    /* free result set */
    mysqli_free_result($result);
  }else{
    $err[] = "Something went wrong. Please try again later.";
  }

  $sql = "SELECT * FROM contests WHERE id = $id";

}else{
  $err[] = "Something went wrong. Please try again later.";
}
if(!empty($err)){
  foreach($err as $error){
    echo $error . "<br>";
  }
  $valid_contest = false;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Severino League - Scoreboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="https://severinoleague.altervista.org/style.css">
    <style type="text/css">
      body{ font: 14px sans-serif; text-align: center; }
    </style>
  </head>
  <body>
    <div class="page-header">
      <h1>Hi<b><?php if($valid_session){ echo ", " . htmlspecialchars($_SESSION["username"]); } ?></b>. 
        <?php if($valid_contest){ ?>This is the scoreboard of <b><?php echo htmlspecialchars($contest_name); ?></b>.<?php } ?></h1>
      <p>
        <a href="index.php" class="btn btn-warning">Home</a>
        <?php if($valid_session){ ?>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
        <?php } ?>
      </p>
    </div>
    <a href="https://severinoleague.altervista.org/style.css">STILE</a>

    <div>
      <table>
        <?php
        foreach($ranking as $row){
        ?>
        <tr>
          <th> <?php echo $row["score"]; ?> </th>
          <th> <?php echo $row["username"]; ?> </th>

          <?php for($i = 1; $i <= $n_problems; ++$i){ ?>
          <th> <?php echo $row["score_$i"] ?> </th>
          <?php } ?>
        </tr>
        <?php
        }
        ?>
      </table>
    </div>

  </body>
</html>






