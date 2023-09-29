<?php
require_once "pdo.php";
session_start();
// p' OR '1' = '1

if ( isset($_POST['email']) && isset($_POST['password'])  ) {
    unset($_SESSION["user_id"]);  // Logout current user
    unset($_SESSION["admin"]);
    $sql = "SELECT user_id, admin FROM users 
        WHERE email = :em AND password = :pw";

    echo "<p>$sql</p>\n";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':em' => $_POST['email'], 
        ':pw' => $_POST['password']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    var_dump($row);
   if ( $row === FALSE ) {
    //   echo "<h1>Login incorrect.</h1>\n";
      $_SESSION["error"] = "Incorrect.";
      header( 'Location: login.php' ) ;
      return;
   } else { 
    //   $_SESSION["email"] = $_POST["email"];
      $_SESSION["user_id"] = $row['user_id'];
      $_SESSION["success"] = "Logged in.";
    if($row['admin'] == 1){
      $_SESSION["admin"] = $row['user_id'];
       }
      header( 'Location: app.php' ) ;
      return;
   }
}

?>
<html>
<head>
</head>
<body style="font-family: sans-serif;">
<h1>Please Log In</h1>
<?php
    if ( isset($_SESSION["error"]) ) {
        echo('<p style="color:red">'.$_SESSION["error"]."</p>\n");
        unset($_SESSION["error"]);
    }
    if ( isset($_SESSION['success']) ) {
        echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
        unset($_SESSION['success']);
    }
?>

<p>Please Login</p>
<form method="post">
<p>Email    : <input type="text" name="email" value=""></p>
<p>Password : <input type="text" name="password" value=""></p>
<!-- password is umsi -->
<p><input type="submit" value="Log In">
<!-- <a href="app.php">Cancel</a></p> -->
<a href="register.php">Register</a>
</form>

</body>


