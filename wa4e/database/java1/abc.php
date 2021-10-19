
<?php
    session_start();
    require_once "pdo.php";
    if ( isset($_POST['cancel'] ) ) {
        // Redirect the browser to game.php
        header("Location: index.php");
        return;
    }

    $salt = 'XyZzy12*_';
   # $stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is php123
    

    if ( isset($_POST["email"]) && isset($_POST["pass"]) ) 
    {
        unset($_SESSION["email"]);  // Logout current user
        unset($_SESSION["pass"]);

        if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) 
        {
#        $failure = "Email ID and password are required";

        $_SESSION["error"] = "Email ID and password are required";
        header( 'Location: login.php' ) ;
        return;
        }
        else
        {
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
                $check = hash('md5', $salt.$_POST['pass']);
                $stmt = $pdo->prepare('SELECT user_id, name FROM users
                WHERE email = :em AND password = :pw');
                $stmt->execute(array( ':em' => $_POST['email'], ':pw' => $check));
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($row !== false) 
                    {
                        // Redirect the browser to game.php
                     #   $failure = "Success";
                        error_log("Login success ".$_POST['email']." $check");
                        $_SESSION['name'] = $row['name'];
                        $_SESSION['user_id'] = $row['user_id'];
                        $_SESSION["success"] = "Logged in.";
                        header( 'Location: index.php' ) ;
                        return;
                    } 
                    else 
                    {
 #                       $failure = "Incorrect password";
                        error_log("Login fail ".$_POST['email']." $check");
                        $_SESSION["error"] = "Incorrect password or Email ID.";
                        header( 'Location: login.php' ) ;
                        return;
                    }
            }
        }
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
<h1>Please Log In</h1>
<?php
    if ( isset($_SESSION["error"]) ) {
        echo('<p style="color:red">'.$_SESSION["error"]."</p>\n");
        unset($_SESSION["error"]);
    }
?>
<form method="POST">
<label for="nam">Email ID</label>
<input type="text" name="email" id="nam"><br/>
<label for="p">Password</label>
<input type="text" name="pass"   id="p"><br/>
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
