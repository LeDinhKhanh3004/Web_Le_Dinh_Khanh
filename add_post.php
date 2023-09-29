<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['title']) && isset($_POST['content'])) {

    // Data validation
    if ( strlen($_POST['title']) < 1 || strlen($_POST['content']) < 1) {
        $_SESSION['error'] = 'Missing data';
        header("Location: add_post.php");
        return;
    }

    $sql = "INSERT INTO posts (user_id, title, content)
              VALUES (:user_id, :title, :content)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':user_id' => $_SESSION["user_id"],
        ':title' => $_POST['title'],
        ':content' => $_POST['content']));
    $_SESSION['success'] = 'Record Added';
    header( 'Location: app.php' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

if ( ! isset($_SESSION["user_id"]) ) { ?>
       <p>Please <a href="login.php">Log In</a> to start.</p>
    <?php } else {?>
<p>Add A New Post</p>
<form method="post">
<p>Title: <input type="text" name="title" value=""></p>
<p>Content: <input type="text" name="content" value=""></p>
<p><input type="submit" value="Add New"/>
<a href="app.php">Cancel</a></p>
<p>Please <a href="logout.php">Log Out</a> when you are done.</p>
</form>
<?php } ?>