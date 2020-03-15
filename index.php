<?php
// Initialize the session
session_start();
require_once "config.php";

$valid_session = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;
/*// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: login.php");
  exit;
}*/
// Select sorted ranking from database
$ranking = [];
$sql = "SELECT username, score FROM users WHERE 1 ORDER BY score DESC";
// Attempt to execute the prepared statement
if($result = mysqli_query($link, $sql)){
  while($row = mysqli_fetch_assoc($result)){
    $ranking[] = array($row['username'], $row['score']);
  }
}else{
  echo "Something went wrong with loading the ranking. Please try again later.";
}

$contests = [];
$sql = "SELECT name, password_str, id, owner_id FROM contests WHERE 1 ORDER BY created_at DESC";
// Attempt to execute the prepared statement
if($result = mysqli_query($link, $sql)){
  while($row = mysqli_fetch_assoc($result)){
    // Store the contests in $contests array as (name, password, id, owner_id)
    $contests[] = $row; // array($row['name'], $row['password'], $row['id'], $row['owner_id']);
  }
}else{
  echo "Something went wrong with loading the contests. Please try again later.";
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Severino League - Homepage</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="https://severinoleague.altervista.org/style.css">
    <style type="text/css">
      body{ font: 14px sans-serif; text-align: center; }
    </style>
  </head>
  <body>
    <div class="page-header">
      <h1>Hi<b><?php if($valid_session){ echo ", " . htmlspecialchars($_SESSION["username"]); } ?></b>. Welcome to our site.</h1>
      <p>
        <?php if($valid_session){ ?>
        <a href="new-contest.php" class="btn btn-warning">Make a new contest</a>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
        <?php }else{ ?>
        <a href="login.php" class="btn btn-warning">Log In</a>
        <a href="register.php" class="btn btn-danger">Sign Up</a>
        <?php } ?>
      </p>
    </div>
    <div style="witdh: 90%;">
      <a href="https://severinoleague.altervista.org/style.css">STILE</a>
      <div>
        <table>
          <?php
          // Print all the contests
          foreach($contests as $contest){
          ?>
          <tr>
            <th>
              <?php echo $contest['name']; ?>
            </th>
            <th>
              <?php if($contest['owner_id'] == $_SESSION['id']){ ?>
              <a href="https://severinoleague.altervista.org/manage-contest.php?id=<?php echo $contest['id']; ?>">Gestisc the contest</a>
              <?php } ?>
            </th>
            <th>
              <a href="https://severinoleague.altervista.org/scoreboard.php?id=<?php echo $contest['id']; ?>">Scoreboard</a>
            </th>
            <th>
            	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="hidden" id="contest_id" name="contest_id" value="<?php echo $contest['id']; ?>">
                <input type="submit" value="Iscrivt">
                </form>
            </th>
          </tr>
          <?php } ?>
        </table>
      </div>
      <div class='ranklist' style='float: right;'>
        <table>
          <tr class='rankline'>
            <th>
              RANKLIST
            </th>
          </tr>
          <?php
          // Print the ranking for each user
          foreach($ranking as $user_rank){
          ?>
          <tr class='rankline'>
            <th> <?php echo $user_rank[1] ?> </th>
            <th> <?php echo $user_rank[0] ?> </th>
          </tr>
          <?php } ?>
        </table>
      </div>
    </div>
  </body>
</html>