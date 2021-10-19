<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>Murtaza Radhanpurwala</title>
</head><body>
<div class="container">
<h1>VIEW</h1>
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
?>


<table border="1">
<?php
require_once "pdo.php";
$stmt = $pdo->query("SELECT * FROM profile");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


echo "<tr><td>";
echo('<b>profile_id');
echo("</td><td>");
echo('<b>user_id');
echo("</td><td>");
echo('<b>first_name');
echo("</td><td>");
echo('<b>last_name');
echo("</td><td>");
echo('<b>email');
echo("</td><td>");
echo('<b>headline');
echo("</td><td>");
echo('<b>summary');
echo("</td></tr>\n");
foreach( $rows as $row) {
    echo "<tr><td>";
    echo(htmlentities($row['profile_id']));
    echo("</td><td>");
    echo(htmlentities($row['user_id']));
    echo("</td><td>");
    echo(htmlentities($row['first_name']));
    echo("</td><td>");
    echo(htmlentities($row['last_name']));
    echo("</td><td>");
    echo(htmlentities($row['email']));
    echo("</td><td>");
    echo(htmlentities($row['headline']));
    echo("</td><td>");
    echo(htmlentities($row['summary']));
    echo("</td></tr>\n");
}

?>
</table>
<a href="index.php">Back</a>
</div>
</body>
