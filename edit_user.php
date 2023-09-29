<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['admin']) && isset($_POST['user_id']) ) {

    // Data validation
    if ( strlen($_POST['name']) < 1 || strlen($_POST['email']) < 1 || strlen($_POST['password']) < 1 || strlen($_POST['admin']) < 1) {
        $_SESSION['error'] = 'Missing data';
        header("Location: edit_user.php?user_id=".$_POST['user_id']);
        return;
    }

    $sql = "UPDATE users SET name = :name, email = :email, password = :password,
            admin = :admin, user_id = :user_id
            WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':name' => $_POST['name'],
        ':email' => $_POST['email'],
        ':password' => $_POST['password'],
        ':admin' => $_POST['admin'],
        ':user_id' => $_POST['user_id']));
    $_SESSION['success'] = 'Record updated';
    header( 'Location: user_management.php' ) ;
    return;
}

// Guardian: Make sure that user_id is present
if ( ! isset($_GET['user_id']) ) {
  $_SESSION['error'] = "Missing user_id";
  header('Location: user_management.php');
  return;
}

$stmt = $pdo->prepare("SELECT * FROM users where user_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['user_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for user_id';
    header( 'Location: user_management.php' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

$user_id = htmlentities($row['user_id']);
$name = htmlentities($row['name']);
$email = htmlentities($row['email']);
$password = htmlentities($row['password']);
$admin = $row['admin'];

if ( ! isset($_SESSION["user_id"]) ) { ?>
       <p>Please <a href="login.php">Log In</a> to start.</p>
    <?php } else {?>
<p>Edit User</p>
<form method="post">
<p>Name:
<input type="text" name="name" value="<?= $name ?>"></p>
<p>Email:
<input type="text" name="email" value="<?= $email ?>"></p>
<p>Password:
<input type="text" name="password" value="<?= $password ?>"></p>
<p>Admin:
<input type="text" name="admin" value="<?= $admin ?>"></p>
<input type="hidden" name="user_id" value="<?= $user_id ?>">
<p><input type="submit" value="Update"/>
<a href="user_management.php">Cancel</a></p>
</form>
<?php } ?>