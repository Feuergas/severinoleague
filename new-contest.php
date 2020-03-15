<?php
// Initialize the session
session_start();
require_once "config.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: login.php");
  exit;
}
$err = [];
if(isset($_POST['submitting'])){
  if(empty($_POST['name'])){
    $err[] = "Error. Contest name was not set";
  }
  if(empty($_POST['n_problems'])){
    $err[] = "Error. Number of problems was not set";
  }
  if(empty($_POST['start_date'])){
    $err[] = "Error. Contest starting date was not set";
  }
  if(empty($_POST['start_time'])){
    $err[] = "Error. Contest starting time was not set";
  }
  if(empty($_POST['length'])){
    $err[] = "Error. Contest duration was not set";
  }
  if(empty($err)){
    $name = $_POST['name'];
    $n_problems = $_POST['n_problems'];
    $start_time = $_POST['start_date'] . " " . $_POST['start_time'] . ":00";
    $length = $_POST['length'];
    if(empty($_POST['jolly_time'])){
      $jolly_time = "0";
    }else{
      $jolly_time = $_POST['jolly_time'];
    }
    if(empty($_POST['derive'])){
      $derive = "2";
    }else{
      $derive = $_POST['derive'];
    }
    if(empty($_POST['stop_inc'])){
      $stop_inc = "20";
    }else{
      $stop_inc = $_POST['stop_inc'];
    }
    $owner_id = $_POST['owner_id'];
    if(!empty($_POST['password'])){
      $password_column = ", password_str";
      $password = ", '" . $_POST['password'] . "'";
    }
    $sql = "INSERT INTO contests (name$password_column, n_problems, start_time, length, jolly_time, derive, stop_inc, owner_id) VALUES ('$name'$password, $n_problems, '$start_time', $length, $jolly_time, $derive, $stop_inc, $owner_id)";
    echo $sql;
    if(mysqli_query($link, $sql)){
      $sql = "SELECT id FROM contests ORDER BY id DESC";
      $result = mysqli_query($link, $sql);
      if($row = mysqli_fetch_assoc($result)){
        $contest_id = $row['id'];
      }else{
        echo "Error. Database connection timed out.";
      }
      if(isset($contest_id)){
        $sql = "CREATE TABLE scoreboard$contest_id (username varchar(50), score int";
        for($i = 1; $i <= $n_problems; ++$i){
          $sql .= ", score_$i int";
        }
        $sql .= ")";
        if(mysqli_query($link, $sql)){
          header("location: manage-contest.php");
        }else{
          echo "Error. Could not connect with database.";
        }
      }
    }else{
      echo "Error. Could not connect with database.";
    }


    /*if ($result = mysqli_query($link, $sql)) {
      // Fetch associative array
      while ($row = mysqli_fetch_assoc($result)) {
        printf ("%s (%s)\n", $row["name"], $row["n_problems"]);
      }
      // Free result set
      mysqli_free_result($result);
      //header("location: manage-contest.php");
    }*/
  }else{
    foreach($err as $error){
      echo $error . "<br>";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Severino League - New Contest</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="https://severinoleague.altervista.org/style.css">
    <style type="text/css">
      body{ font: 14px sans-serif; text-align: center; }
    </style>
  </head>
  <body>
    <div class="page-header">
      <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Make a new contest!</h1>
      <p>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
      </p>
    </div>
    <a href="https://severinoleague.altervista.org/style.css">STILE</a>
    <form method="post" action="/new-contest.php">
      <table>
        <tr>
          <th><label>Name your contest</label></th>
          <th><input type="text" id="name" name="name"></th>
        </tr>
        <tr>
          <th><label>Number of problems</label></th>
          <th><input type="number" min="1" max="2520" id="n_problems" name="n_problems"></th>
        </tr>
        <tr>
          <th><label>Start time</label></th>
          <th><input type="date" id="start_date" name="start_date"><input type="time" id="start_time" name="start_time">'NTO QUI METTIMECE UN CALENDARITTU</th>
        </tr>
        <tr>
          <th><label>Length</label></th>
          <th><input type="number" min="1" max="30240" id="length" name="length">(minutes)</th>
        </tr>
        <tr>
          <th><label>Jolly (minutes until you can't choose your jolly anymore)</label></th>
          <th><input type="number" min="1" max="30240" id="jolly_time" name="jolly_time">(minutes)</th>
        </tr>
        <tr>
          <th><label>DERIVE (number of problems that need to be solved to stop the score increment)</label></th>
          <th><input type="number" min="1" max="30240" id="derive" name="derive">(minutes)</th>
        </tr>
        <tr>
          <th><label>Stop increment (number of minutes that must be left to stop the score increment)</label></th>
          <th><input type="number" min="1" max="30240" id="stop_inc" name="stop_inc">(minutes)</th>
        </tr>
        <tr>
          <th><label>Password (optional)</label></th>
          <th><input type="text" id="password" name="password"></th>
        </tr>
        <tr>
          <th>
            <input type="hidden" id="owner_id" name="owner_id" value="<?php echo $_SESSION["id"]; ?>">
            <input type="hidden" id="submitting" name="submitting" value=True>
            <input type="submit" value="Submit">
          </th>
        </tr>
      </table>
    </form>
  </body>
</html>