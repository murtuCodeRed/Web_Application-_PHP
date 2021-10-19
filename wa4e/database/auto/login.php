<?php // Do not put any HTML above this line

if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to game.php
    header("Location: index.php");
    return;
}

$oldname = isset($_POST['who'])?$_POST['who']:"";
$oldpass = isset($_POST['pass'])?$_POST['pass']:"";
$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is php123

$failure = false;  // If we have no POST data

// Check to see if we have some POST data, if we do process it
if ( isset($_POST['who']) && isset($_POST['pass']) ) 
{


    if ( strlen($_POST['who']) < 1 || strlen($_POST['pass']) < 1 ) 
    {
        $failure = "Email ID and password are required";
    } 

    else 
    {
               
                    $x=$_POST['who'];
                    $f=0;
                    for($i=0;$i<strlen($x);$i=$i+1)
                    {
                        if($x[$i]=='@')
                        $f=1;
                    }    
                    
                    if($f == 0 )
                    {
                        $failure = "Email must have @ sign";
                    }    
            
        
        else{
        $check = hash('md5', $salt.$_POST['pass']);
            
            if ( $check == $stored_hash ) 
            {
                // Redirect the browser to game.php
                $failure = "Success";
                error_log("Login success ".$_POST['who']." $check");
                header("Location: autos.php?name=".urlencode($_POST['who']));
                return;
            } 
            else 
            {
                $failure = "Incorrect password";
                error_log("Login fail ".$_POST['who']." $check");
            }
    }
    }

}

// Fall through into the View
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
<h1>Please Log In</h1>
<?php
// Note triple not equals and think how badly double
// not equals would work here...
if ( $failure !== false ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
}
?>
<form method="POST">
<label for="nam">Email ID</label>
<input type="text" name="who" value = "<?= $oldname?>" id="nam"><br/>
<label for="id_1723">Password</label>
<input type="text" name="pass"  value = "<?= $oldpass?>" id="id_1723"><br/>
<input type="submit" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>
For a password hint, view source and find a password hint
in the HTML comments.
<!-- Hint: The password is the four character sound a cat
makes (all lower case) followed by 123. -->
</p>
</div>
</body>
