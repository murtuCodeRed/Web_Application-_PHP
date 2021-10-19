<?php
require_once "pdo.php";
////////////////////////////////////
if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
    die('Name parameter missing');
}
$oldmake = isset($_POST['make'])?$_POST['make']:"";
$oldyear = isset($_POST['year'])?$_POST['year']:"";
$oldmileage = isset($_POST['mileage'])?$_POST['mileage']:"";

$failure = false;
$inserted = false;
// If the user requested logout go back to index.php
if ( isset($_POST['logout']) ) {
    header('Location: index.php');
    return;
}

if ( isset( $_POST[ 'make' ] ) && isset( $_POST[ 'year' ] ) && isset( $_POST[ 'mileage' ] ) ) 
{
    if ( !is_numeric( $_POST[ 'mileage' ] ) || !is_numeric( $_POST[ 'year' ] ) ) 
    {
        $failure = 'Mileage and year must be numeric';
    } 
    else 
    {
        if ( strlen( $_POST[ 'make' ] ) < 1 ) 
        {
            $failure = 'Make is required';
        } 
        else{         
                $inserted ="Record inserted";
                $sql = "INSERT INTO autos (make, year, mileage) 
                        VALUES (:make, :year, :mileage)";
               # echo("<pre>\n".$sql."\n</pre>\n");
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                    ':make' => $_POST['make'],
                    ':year' => $_POST['year'],
                    ':mileage' => $_POST['mileage']));
                                
        }
    }
}
////////////////////////////////////////
if ( !isset($_POST['make']) && !isset($_POST['year']) && !isset($_POST['mileage']))
        {
            $failure = false;
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
if ( isset($_REQUEST['name']) ) {
    echo "<h1>";
    echo htmlentities($_REQUEST['name']);
    echo "</h1>\n";
}
?>
<br>
<?php
// Note triple not equals and think how badly double
// not equals would work here...
if ( $failure !== false ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
}

else {
    // Look closely at the use of single and double quotes
    echo('<p style="color: green;">'.htmlentities($inserted)."</p>\n");
}
?>
<br>
<form method="POST">
<label for="first">Make</label>
<input type="text" name="make" value = "<?= $oldmake?>" id="first" ><br/>

<label for="second">Year</label>
<input type="text" name="year" value = "<?= $oldyear?>" id="second"><br/>

<label for="third">Mileage</label>
<input type="text" name="mileage" value = "<?= $oldmileage?>" id="third"><br/>

<br>
<input type="submit" name="Add" value="Add">
<input type="submit" name="logout" value="Logout">
</form>
<br><br>
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
</div>
</body>
