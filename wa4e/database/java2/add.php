<?php
session_start();
require_once "pdo.php";
////////////////////////////////////
#if ( ! isset($_SESSION['email']) || strlen($_SESSION['email']) < 1  ) {
#    die('ACCESS DENIED');
#}

// If the user requested logout go back to index.php
if ( isset($_POST['cancel']) ) {
    header('Location: index.php');
    return;
}

if ( isset( $_POST[ 'first_name' ] ) && isset( $_POST[ 'last_name' ] ) && isset( $_POST[ 'email' ] ) && isset( $_POST[ 'headline' ] ) && isset( $_POST[ 'summary' ] ) ) 
{
    unset($_SESSION['first_name']);
    unset($_SESSION['last_name']);
    unset($_SESSION['email']);
    unset($_SESSION['headline']);
    unset($_SESSION['summary']);
    
    if ( (strlen( $_POST[ 'first_name' ] ) < 1) ||  (strlen( $_POST[ 'last_name' ] ) < 1) ||  (strlen( $_POST[ 'email' ] ) < 1) ||  (strlen( $_POST[ 'headline' ] ) < 1) ||(strlen( $_POST[ 'summary' ] ) < 1) ) 
    {
       # $failure = 'Mileage and year must be numeric';
        $_SESSION["error"] = 'All values are required';
        header( 'Location: add.php' ) ;
        return;
    }        
    $x=$_POST['email'];
                $f=0;
                for($i=0;$i<strlen($x);$i=$i+1)
                {
                    if($x[$i]=='@')
                    $f=1; 
                }    
                    
            if($f == 0 )
             {
  #              $failure = "Email must have @ sign";
                $_SESSION["error"] = "Email must have @ sign";
                header( 'Location: login.php' ) ;
                return;
             } 
             else{
             #  $inserted ="Record inserted";
                $_SESSION["success"] = 'Record added';
                $stmt = $pdo->prepare('INSERT INTO Profile
                (user_id, first_name, last_name, email, headline, summary)
                VALUES ( :uid, :fn, :ln, :em, :he, :su)');
               $stmt->execute(array(
                ':uid' => $_SESSION['user_id'],
                ':fn' => $_POST['first_name'],
                ':ln' => $_POST['last_name'],
                ':em' => $_POST['email'],
                ':he' => $_POST['headline'],
                ':su' => $_POST['summary'])
                  );

                  $profile_id = $pdo->lastInsertId();

                  $rank=1;
                  for($i=0;$i<9;$i++)
                  {
                      if(!isset($_POST['year'.$i]))
                      continue;
                      if(!isset($_POST['desc'.$i]))
                      continue;

                      $year = $_POST['year'.$i];
                      $desc = $_POST['desc'.$i];

                      if ( !is_numeric($year) )
                      {
                         # $failure = 'Mileage and year must be numeric';
                          $_SESSION["error"] = 'Year must be numeric';
                          header( 'Location: add.php' ) ;
                          return;
                      } 
                     

            echo("Hello friend");
                  $stm = $pdo->prepare('INSERT INTO Position
                  (profile_id, rank, year, description)
                  VALUES ( :pid, :rank, :year, :desc)');
                    $stm->execute(array(
                        ':pid' => $profile_id,
                        ':rank' => $rank,
                        ':year' => $year,
                        ':desc' => $desc)
                          );

                      $rank++;    
                        }
                    header( 'Location: index.php' ) ;
                    return;
                  
                                
        
    }
}
////////////////////////////////////////

?>

<!DOCTYPE html>
<html>
<head>
<title>Murtaza Radhanpurwala</title>
<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Custom styles for this template -->
<link href="starter-template.css" rel="stylesheet">

</head>
<body>
<div class="container">
<h1>ADD</h1>

<br>
<?php
    if ( isset($_SESSION["error"]) ) {
        echo('<p style="color:red">'.$_SESSION["error"]."</p>\n");
        unset($_SESSION["error"]);
    }
?>
<br>
<form method="POST">
<label for="first">First name</label>
<input type="text" name="first_name"  id="first" ><br/>

<label for="fourth">Last name</label>
<input type="text" name="last_name"  id="fourth" ><br/>

<label for="second">Email</label>
<input type="text" name="email" id="second"><br/>

<label for="third">Headline</label>
<input type="text" name="headline" id="third"><br/>

<label for="five">Summary</label>
<input type="text" name="summary" id="five"><br/>

<label for="six">Position</label>
<input type="submit" name="pos" value="+" id="six"><br/>

<div id="position_fields">
</div>

<br>
<input type="submit" name="Add" value="Add">
<input type="submit" name="Cancel" value="Cancel">
</form>
<script type="text/javascript">
countPos = 0;

// http://stackoverflow.com/questions/17650776/add-remove-html-inside-div-using-javascript
$(document).ready(function(){
    window.console && console.log('Document ready called');
    $('#six').click(function(event){
        // http://api.jquery.com/event.preventdefault/
        event.preventDefault();
        if ( countPos >= 9 ) {
            alert("Maximum of nine position entries exceeded");
            return;
        }
        countPos++;
        window.console && console.log("Adding position "+countPos);
        $('#position_fields').append(
            '<div id="position'+countPos+'"> \
            <p>Year: <input type="text" name="year'+countPos+'" value="" /> \
            <input type="button" value="-" \
                onclick="$(\'#position'+countPos+'\').remove();return false;">\
            Description: <input type="text" name="desc'+countPos+'" value="" /></p>\
            </div>');
    });
});
</script>
</div>
</body>
