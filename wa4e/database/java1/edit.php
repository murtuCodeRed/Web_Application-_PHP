<?php
require_once "pdo.php";
session_start();

if ( isset( $_POST[ 'first_name' ] ) && isset( $_POST[ 'last_name' ] ) && isset( $_POST[ 'email' ] ) && isset( $_POST[ 'headline' ] ) && isset( $_POST[ 'summary' ] ) ) 
{

    // Data validation
    if ( (strlen( $_POST[ 'first_name' ] ) < 1) ||  (strlen( $_POST[ 'last_name' ] ) < 1) ||  (strlen( $_POST[ 'email' ] ) < 1) ||  (strlen( $_POST[ 'headline' ] ) < 1) ||(strlen( $_POST[ 'summary' ] ) < 1) ) 
    {
        $_SESSION['error'] = 'Missing data';
        header("Location: edit.php?profile_id=".$_POST['profile_id']);
        return;
    }

    $sql = "UPDATE profile SET 
    first_name= :first_name,
    last_name= :last_name,
    email= :email,
    headline =:headline,
    summary=:summary
            WHERE profile_id = :profile_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
                    ':first_name' => $_POST['first_name'],
                    ':last_name' => $_POST['last_name'],
                    ':email' => $_POST['email'],
                    ':profile_id' => $_POST['profile_id'],
                    ':headline' =>$_POST['headline'],
                    ':summary' => $_POST['summary']));
    $_SESSION['success'] = 'Record edited';
    header( 'Location: index.php' ) ;
    return;
}

// Guardian: Make sure that user_id is present
if ( ! isset($_GET['profile_id']) ) {
  $_SESSION['error'] = "Missing profile_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT * FROM profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile_id';
    header( 'Location: index.php' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

$fn= htmlentities($row['first_name']);
$ln = htmlentities($row['last_name']);
$em = htmlentities($row['email']);
$hd = htmlentities($row['headline']);
$sum = htmlentities($row['summary']);
$profile_id = $row['profile_id'];
?>
<html>
<head>
<title>Murtaza Radhanpurwala</title>
</head><body>
<div class="container">
<p>Edit User</p>
<form method="post">
<label for="first">First name</label>
<input type="text" name="first_name" value="<?= $fn ?>" id="first" ><br/>

<label for="fourth">Last name</label>
<input type="text" name="last_name"  value="<?= $ln ?>" id="fourth" ><br/>

<label for="second">Email</label>
<input type="text" name="email" value="<?= $em ?>" id="second"><br/>

<label for="third">Headline</label>
<input type="text" name="headline" value="<?= $hd ?>" id="third"><br/>

<label for="four">Summary</label>
<input type="text" name="summary" value="<?= $sum ?>" id="four"><br/>

<input type="hidden" name="profile_id" value="<?= $profile_id ?>">
<p><input type="submit" value="Save"/>
<a href="index.php">Cancel</a></p>
</form>
</div>
