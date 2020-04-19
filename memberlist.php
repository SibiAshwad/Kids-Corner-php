<?php
// First we execute our common code to connection to the database and start the session
require("connection.php");
 
// At the top of the page we check to see whether the user is logged in or not
if(empty($_SESSION['user'])) {
    // If they are not, we redirect them to the login page.
    header("Location: login.php");

    // Remember that this die statement is absolutely critical.  Without it,
    // people can view your members-only content without logging in.
    die("Redirecting to login.php");
}

// Everything below this point in the file is secured by the login system
 
// We can retrieve a list of members from the database using a SELECT query.
// In this case we do not have a WHERE clause because we want to select all
// of the rows from the database table.
$query = "
    SELECT
        id,
        username,
        email
    FROM users
";

try {
    // These two statements run the query against your database table.
    $stmt = $db->prepare($query);
    $stmt->execute();
}
catch(PDOException $ex) {
    // Note: On a production website, you should not output $ex->getMessage().
    // It may provide an attacker with helpful information about your code.
    die("Failed to run query: " . $ex->getMessage());
}
    
// Finally, we can retrieve all of the found rows into an array using fetchAll
$rows = $stmt->fetchAll();
?>
<?php include("menu_admin.php"); ?>



<!doctype html>
<html lang="en">
    <head>
        <title>Memberlist</title>
        <meta charset="UTF-8">
    </head>
<img align="right" width="450" height="250" src="https://s3.amazonaws.com/kids-corner/assets/images/hero/KidsCorner-cover-art.jpg"  >

<body style="background: url(https://cdn2.vectorstock.com/i/1000x1000/32/11/abstract-3d-grey-background-made-from-triangles-vector-2853211.jpg); background-size: 100%">
<h1>Memberlist</h1>
<table>
    <tr>
	<font size="4">
        <th>ID</th>
        <th>Username</th>
        <th>E-Mail Address</th>
    </font>
	</tr>
	<h2 Style="text-align:right;"><font size="6" color="white">Know the members of this site :</font></h2>
	
    <?php foreach($rows as $row): ?>
        <tr>
            <td><?php echo $row['id']; ?></td> <!-- htmlentities is not needed here because $row['id'] is always an integer -->
            <td><?php echo htmlentities($row['username'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlentities($row['email'], ENT_QUOTES, 'UTF-8'); ?></td>
        </tr> 
    <?php endforeach; ?>
</table>
</body>
</html>