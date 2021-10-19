<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['delete']) && isset($_POST['profile_id']) ) {
    $sql = "DELETE FROM profile WHERE profile_id = :zip";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':zip' => $_POST['profile_id']));
    $_SESSION['success'] = 'Record deleted';
    header( 'Location: index.php' ) ;
    return;
}

// Guardian: Make sure that user_id is present
if ( ! isset($_GET['profile_id']) ) {
  $_SESSION['error'] = "Missing autos_id";
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
$profile_id = $row['profile_id'];
?>
<html>
<head>
<title>Murtaza Radhanpurwala</title>
</head><body>
<div class="container">
<p>Confirm: Deleting <?= htmlentities($row['first_name']) ?></p>

<form method="post">
<input type="hidden" name="profile_id" value="<?= $profile_id ?>">
<input type="submit" value="Delete" name="delete">
<a href="index.php">Cancel</a>
</form>
</div>
</body>
