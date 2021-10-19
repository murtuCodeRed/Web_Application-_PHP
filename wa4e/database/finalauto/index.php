<?php
require_once "pdo.php";
session_start();
?>
<html>
<head>
<title>Murtaza Radhanpurwala</title>
</head><body>
<div class="container">
<h1>Tracking orders for</h1>
<break>
<?php
if ( isset($_SESSION['email']) ) {
    echo "<h1>";
    echo htmlentities($_SESSION['email']);
    echo "</h1>\n";
}
?>
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
$stmt = $pdo->query("SELECT autos_id,make, model,year, mileage FROM autos");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'No rows found';
}
else{
echo "<tr><td>";
echo('<b>autos_id');
echo("</td><td>");
echo('<b>make');
echo("</td><td>");
echo('<b>model');
echo("</td><td>");
echo('<b>year');
echo("</td><td>");
echo('<b>mileage');
echo("</td><td>");
echo('<b>fuctions');
echo("</td></tr>\n");
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    echo "<tr><td>";
    echo(htmlentities($row['autos_id']));
    echo("</td><td>");
    echo(htmlentities($row['make']));
    echo("</td><td>");
    echo(htmlentities($row['model']));
    echo("</td><td>");
    echo(htmlentities($row['year']));
    echo("</td><td>");
    echo(htmlentities($row['mileage']));
    echo("</td><td>");
    echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
    echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
    echo("</td></tr>\n");
}
}
?>
</table>
<br>
<a href="add.php">Add New Entry</a>
<br><br>
<a href="logout.php">Logout</a>
</div>
</body>
