<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['delete']) && isset($_POST['post_id']) ) {
    $sql = "DELETE FROM posts WHERE post_id = :zip";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':zip' => $_POST['post_id']));
    $_SESSION['success'] = 'Record deleted';
    header( 'Location: app.php' ) ;
    return;
}

// Guardian: Make sure that post_id is present
if ( ! isset($_GET['post_id']) ) {
  $_SESSION['error'] = "Missing post_id";
  header('Location: app.php');
  return;
}

$stmt = $pdo->prepare("SELECT title, post_id FROM posts where post_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['post_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for post_id';
    header( 'Location: app.php' ) ;
    return;
}

?>
<p>Confirm: Deleting <?= htmlentities($row['title']) ?></p>

<form method="post">
<input type="hidden" name="post_id" value="<?= $row['post_id'] ?>">
<input type="submit" value="Delete" name="delete">
<a href="app.php">Cancel</a>
</form>
