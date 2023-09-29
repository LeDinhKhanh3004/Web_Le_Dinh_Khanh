<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['title']) && isset($_POST['content']) && isset($_POST['post_id']) ) {

    // Data validation
    if ( strlen($_POST['title']) < 1 || strlen($_POST['content']) < 1) {
        $_SESSION['error'] = 'Missing data';
        header("Location: edit_post.php?post_id=".$_POST['post_id']);
        return;
    }

    $sql = "UPDATE posts SET title = :title, content = :content,
            post_id = :post_id, user_id = :user_id
            WHERE post_id = :post_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':title' => $_POST['title'],
        ':content' => $_POST['content'],
        ':post_id' => $_POST['post_id'],
        ':user_id' => $_POST['user_id']));
    $_SESSION['success'] = 'Record updated';
    header( 'Location: app.php' ) ;
    return;
}

// Guardian: Make sure that post_id is present
if ( ! isset($_GET['post_id']) ) {
  $_SESSION['error'] = "Missing post_id";
  header('Location: app.php');
  return;
}

$stmt = $pdo->prepare("SELECT * FROM posts where post_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['post_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for post_id';
    header( 'Location: app.php' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

$title = htmlentities($row['title']);
$content = htmlentities($row['content']);
$user_id = htmlentities($row['user_id']);
$post_id = $row['post_id'];

if ( ! isset($_SESSION["user_id"]) ) { ?>
       <p>Please <a href="login.php">Log In</a> to start.</p>
    <?php } else {?>
<p>Edit Post</p>
<form method="post">
<p>Title:
<input type="text" name="title" value="<?= $title ?>"></p>
<p>Content:
<input type="text" name="content" value="<?= $content ?>"></p>
<input type="hidden" name="post_id" value="<?= $post_id ?>">
<input type="hidden" name="user_id" value="<?= $user_id ?>">
<p><input type="submit" value="Update"/>
<a href="app.php">Cancel</a></p>
</form>
<?php } ?>