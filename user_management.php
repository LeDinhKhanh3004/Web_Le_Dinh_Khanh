<?php
    session_start();
    require_once "pdo.php";
?>
<html>
<head>
</head>
<body style="font-family: sans-serif;">
<h1>User Management</h1>
<?php 

 
    // Check if we are logged in!
    if ( ! isset($_SESSION["admin"]) ) { ?>
       <p>Please <a href="login.php">Log In</a> to start.</p>
    <?php } else {
       echo('<table border="1">'."\n");
       $stmt = $pdo->query("SELECT * FROM users WHERE 1 ");
    // $stmt->execute(array(":xyz" => $_SESSION["admin"]));
    // $stmt = $pdo->query("SELECT name, email, password, user_id FROM users");
       while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
            echo "<tr><td>";
            echo(htmlentities($row['user_id']));
            echo("</td><td>");
            echo(htmlentities($row['name']));
            echo("</td><td>");
            echo(htmlentities($row['email']));
            echo("</td><td>");
            echo(htmlentities($row['password']));
            echo("</td><td>");
            echo(htmlentities($row['admin']));
            echo("</td><td>");
            echo('<a href="edit_user.php?user_id='.$row['user_id'].'">Edit</a> / ');
            echo('<a href="delete_user.php?user_id='.$row['user_id'].'">Delete</a>');
            echo("</td></tr>\n");
        }      
     } ?>
</table>
<p><a href="register.php">Add New User</a></p>
<p>Please <a href="logout.php">Log Out</a> when you are done.</p>
</body>
</html>
