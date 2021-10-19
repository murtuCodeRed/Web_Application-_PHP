<?php
    session_start();
    if ( ! isset($_SESSION['email']) || strlen($_SESSION['email']) < 1  ) {
        die('Name parameter missing');
    }
?>
<!DOCTYPE html>
<html>
<head>
<title>Murtaza Radhanpurwala</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Custom styles for this template -->
<link href="starter-template.css" rel="stylesheet">

</head>
<body>
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
    if ( isset($_SESSION["inserted"]) ) {
        echo('<p style="color:green">'.$_SESSION["inserted"]."</p>\n");
        unset($_SESSION["inserted"]);
    }
    if ( isset($_SESSION["success"]) ) {
        echo('<p style="color:green">'.$_SESSION["success"]."</p>\n");
        unset($_SESSION["success"]);
    }

?>
<br>
<h2>Automobiles</h2>
<table border="1">
<?php
require_once "pdo.php";
$stmt = $pdo->query("SELECT * FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<tr><td>";
echo('<b>make');
echo("</td><td>");
echo('<b>year');
echo("</td><td>");
echo('<b>mileage');
echo("</td></tr>\n");
foreach ( $rows as $row ) {
    echo "<tr><td>";
    echo(htmlentities($row['make']));
    echo("</td><td>");
    echo(htmlentities($row['year']));
    echo("</td><td>");
    echo(htmlentities($row['mileage']));
    echo("</td></tr>\n");
}

?>
</table>
<p>
<a href="add.php">Add New</a>
|
<a href="logout.php">Logout</a>
</p>
</div>
</body>

