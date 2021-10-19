<?php
session_start();
require_once "pdo.php";
////////////////////////////////////
if ( ! isset($_SESSION['email']) || strlen($_SESSION['email']) < 1  ) {
    die('ACCESS DENIED');
}

// If the user requested logout go back to index.php
if ( isset($_POST['cancel']) ) {
    header('Location: logout.php');
    return;
}

if ( isset( $_POST[ 'make' ] ) && isset( $_POST[ 'model' ] ) && isset( $_POST[ 'year' ] ) && isset( $_POST[ 'mileage' ] ) ) 
{
    unset($_SESSION['make']);
    unset($_SESSION['model']);
    unset($_SESSION['year']);
    unset($_SESSION['mileage']);
    
    if ( (strlen( $_POST[ 'make' ] ) < 1) ||  (strlen( $_POST[ 'model' ] ) < 1) ||  (strlen( $_POST[ 'year' ] ) < 1) ||  (strlen( $_POST[ 'mileage' ] ) < 1) ) 
    {
       # $failure = 'Mileage and year must be numeric';
        $_SESSION["error"] = 'All values are required';
        header( 'Location: add.php' ) ;
        return;
    } 
    else 
    {
        if ( !is_numeric( $_POST[ 'mileage' ] ) || !is_numeric( $_POST[ 'year' ]  ) )
        {
          #  $failure = 'Make is required';
            $_SESSION["error"] = 'Mileage and year must be numeric';
            header( 'Location: add.php' ) ;
            return;
        } 
        else{         
              #  $inserted ="Record inserted";
                $_SESSION["success"] = 'Record added';
                $sql = "INSERT INTO autos (make,model, year, mileage) 
                        VALUES (:make,:model, :year, :mileage)";
               # echo("<pre>\n".$sql."\n</pre>\n");
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                    ':make' => $_POST['make'],
                    ':model' => $_POST['model'],
                    ':year' => $_POST['year'],
                    ':mileage' => $_POST['mileage']));
                    header( 'Location: index.php' ) ;
                    return;
                                
        }
    }
}
////////////////////////////////////////

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
    if ( isset($_SESSION["error"]) ) {
        echo('<p style="color:red">'.$_SESSION["error"]."</p>\n");
        unset($_SESSION["error"]);
    }
?>
<br>
<form method="POST">
<label for="first">Make</label>
<input type="text" name="make"  id="first" ><br/>

<label for="fourth">Make</label>
<input type="text" name="model"  id="fourth" ><br/>

<label for="second">Year</label>
<input type="text" name="year" id="second"><br/>

<label for="third">Mileage</label>
<input type="text" name="mileage" id="third"><br/>

<br>
<input type="submit" name="Add" value="Add">
<input type="submit" name="Cancel" value="Cancel">
</form>
</div>
</body>
