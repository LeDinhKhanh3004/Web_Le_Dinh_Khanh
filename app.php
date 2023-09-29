<?php
    session_start();
    require_once "pdo.php";
?>
<html>
<head>
</head>
<body style="font-family: sans-serif;">
<h1>User Application</h1>
<?php 
    if ( isset($_SESSION["success"]) ) {
        echo('<p style="color:green">'.$_SESSION["success"]."</p>\n");
        unset($_SESSION["success"]);
    }  
 
    // Check if we are logged in!
    if ( ! isset($_SESSION["user_id"]) ) { ?>
       <p>Please <a href="login.php">Log In</a> to start.</p>
    <?php } else {
       echo('<table border="1">'."\n");
       $stmt = $pdo->prepare("SELECT post_id, title, content, user_id FROM posts where user_id = :xyz");
       $stmt->execute(array(":xyz" => $_SESSION["user_id"]));
    // $stmt = $pdo->query("SELECT name, email, password, user_id FROM users");
       while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
            echo "<tr><td>";
            echo(htmlentities($row['post_id']));
            echo("</td><td>");
            echo(htmlentities($row['title']));
            echo("</td><td>");
            echo(htmlentities($row['content']));
            echo("</td><td>");
            echo('<a href="edit_post.php?post_id='.$row['post_id'].'">Edit</a> / ');
            echo('<a href="delete_post.php?post_id='.$row['post_id'].'">Delete</a>');
            echo("</td></tr>\n");
        }      
     } ?>
</table>
<p><a href="add_post.php">Add New</a></p>
<p><a href="post_search.php">Post Search</a></p>
<?php
if ( isset($_SESSION["admin"]) ){?>
<p><a href="user_management.php">User Management</a></p>
<?php } ?>
<p>Please <a href="logout.php">Log Out</a> when you are done.</p>
</body>
</html>
