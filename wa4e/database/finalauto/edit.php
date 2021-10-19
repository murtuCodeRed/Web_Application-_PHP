<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['make']) && isset($_POST['model']) && isset($_POST['mileage'])
     && isset($_POST['year']) && isset($_POST['autos_id']) ) {

    // Data validation
    if ( strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1) {
        $_SESSION['error'] = 'Missing data';
        header("Location: edit.php?user_id=".$_POST['autos_id']);
        return;
    }

    if ( !is_numeric( $_POST[ 'mileage' ] ) || !is_numeric( $_POST[ 'year' ] ) ) 
    {
       # $failure = 'Mileage and year must be numeric';
        $_SESSION["error"] = 'Mileage and year must be numeric';
        header( 'Location: add.php' ) ;
        return;
    }

    $sql = "UPDATE autos SET make= :make,model= :model,year =:year,mileage=:mileage
            WHERE autos_id = :autos_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
                    ':make' => $_POST['make'],
                    ':model' => $_POST['model'],
                    ':year' => $_POST['year'],
                    ':autos_id' =>$_POST['autos_id'],
                    ':mileage' => $_POST['mileage']));
    $_SESSION['success'] = 'Record edited';
    header( 'Location: index.php' ) ;
    return;
}

// Guardian: Make sure that user_id is present
if ( ! isset($_GET['autos_id']) ) {
  $_SESSION['error'] = "Missing autos_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT autos_id,make, model,year, mileage FROM autos where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for autos_id';
    header( 'Location: index.php' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

$ma = htmlentities($row['make']);
$mo = htmlentities($row['model']);
$y = htmlentities($row['year']);
$mi = htmlentities($row['mileage']);
$autos_id = $row['autos_id'];
?>
<html>
<head>
<title>Murtaza Radhanpurwala</title>
</head><body>
<div class="container">
<p>Edit User</p>
<form method="post">
<label for="first">Make</label>
<input type="text" name="make"  value="<?= $ma ?>" id="first" ><br/>

<label for="fourth">Model</label>
<input type="text" name="model" value="<?= $mo ?>" id="fourth" ><br/>

<label for="second">Year</label>
<input type="text" name="year" value="<?= $y ?>" id="second"><br/>

<label for="third">Mileage</label>
<input type="text" name="mileage" value="<?= $mi ?>" id="third"><br/>

<input type="hidden" name="autos_id" value="<?= $autos_id ?>">
<p><input type="submit" value="Save"/>
<a href="index.php">Cancel</a></p>
</form>
</div>