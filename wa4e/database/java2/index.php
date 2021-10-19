<?php
require_once "pdo.php";
session_start();
?>
<html>
<head>
<title>Murtaza Radhanpurwala</title>
</head><body>
<div class="container">
<h1>INDEX PAGE</h1>
<break>
<a href="login.php">Please log in</a>
<br>
<?php
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}
echo('<table border="1">'."\n");
$stmt = $pdo->query("SELECT profile_id,first_name,last_name FROM profile");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ( $rows === false ) {
    $_SESSION['error'] = 'No rows found';
    unset($_SESSION['error']);
}
else{
echo "<tr><td>";
echo('<b>profile_id');
echo("</td><td>");
echo('<b>first_name');
echo("</td><td>");
echo('<b>last_name');
if ( isset($_SESSION["name"]) && isset($_SESSION["user_id"]) ) 
{
echo("</td><td>");
echo('<b>Actions');
echo("</td></tr>\n");
}
else{
    echo("</td></tr>\n");  
}
foreach( $rows as $row) {
    echo "<tr><td>";
    echo(htmlentities($row['profile_id']));
    echo("</td><td>");
    echo(htmlentities($row['first_name']));
    echo("</td><td>");
    echo(htmlentities($row['last_name']));

    #script
    if ( isset($_SESSION["name"]) && isset($_SESSION["user_id"]) ) 
    {
    echo("</td><td>");
    echo('<a href="view.php?profile_id='.$row['profile_id'].'">View</a> / ');
    echo('<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> / ');
    echo('<a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
    echo("</td></tr>\n");
    }
    else{
        echo("</td></tr>\n");
    }
}
}
?>
</table>
<br>
<?php
 if ( isset($_SESSION["name"]) && isset($_SESSION["user_id"]) ) 
{
echo('<a href="add.php">Add New Entry</a>');
echo('<br><br>');
echo('<a href="logout.php">Logout</a>');
}
?>
</div>
</body>
