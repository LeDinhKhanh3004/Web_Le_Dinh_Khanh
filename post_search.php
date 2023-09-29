<?php
    session_start();
    require_once "pdo.php";

    if ( isset($_POST['title'])  ) {
        echo('<table border="1">'."\n");
       $stmt = $pdo->prepare("SELECT * FROM posts where title = :xyz");
       $stmt->execute(array(":xyz" => $_POST['title']));
    // $stmt->execute(array(":xyz" => $_SESSION["user_id"]));
    // $stmt = $pdo->query("SELECT name, email, password, user_id FROM users");
       while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
            echo "<tr><td>";
            echo(htmlentities($row['post_id']));
            echo("</td><td>");
            echo(htmlentities($row['title']));
            echo("</td><td>");
            echo(htmlentities($row['content']));
            echo("</td><td>");
            echo("</td></tr>\n");
        }     
        echo('</table>');
    }
?>
<html>
<head>
</head>
<body style="font-family: sans-serif;">
<h1>Search Title</h1>
<?php 
    if ( isset($_SESSION["success"]) ) {
        echo('<p style="color:green">'.$_SESSION["success"]."</p>\n");
        unset($_SESSION["success"]);
    }  
 
    // Check if we are logged in!
    if ( ! isset($_SESSION["user_id"]) ) { ?>
       <p>Please <a href="login.php">Log In</a> to start.</p>
    <?php } else { ?>
    <form method="post">
       <p>Search title : <input type="text" name="title" value=""></p> 
       <p><input type="submit" value="Search"> 
    </form> <?php
     } ?>

<p><a href="app.php">Back</a></p>
<p>Please <a href="logout.php">Log Out</a> when you are done.</p>
</body>
</html>
