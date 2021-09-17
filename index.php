<?php
    session_start();

    $error = "";    

    if (array_key_exists("logout", $_GET)) {
        session_destroy();
        unset($_SESSION);
        setcookie("id", "", time() - 60*60);
        $_COOKIE["id"] = "";  
        
    } else if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])) {
        
        header("Location: loggedinpage.php");
        
    }

    if (array_key_exists("submit", $_POST)) {
        
       include_once 'connection.php';
        
        
        
        if (!$_POST['email']) {
            
            $error .= "Il campo email è obbligatorio<br>";
            
        } 
        
        if (!$_POST['password']) {
            
            $error .= "Il campo password è obbligatorio<br>";
            
        } 
        
        if ($error != "") {
            
            $error = "<p>Ci sono stati degli errori</p>".$error;
            
        } else {
            
            if ($_POST['signUp'] == '1') {
            
                $query = "SELECT * FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";

                $result = mysqli_query($link, $query);
               
                if ($result && mysqli_num_rows($result) > 0) {
                        
                    $error = "Email inserita è gia stata presa";

                } else {

                    $query = "INSERT INTO `users` (`email`, `password`) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."', '".mysqli_real_escape_string($link, $_POST['password'])."')";
                
                    if (!mysqli_query($link, $query)) {

                        $error = "<p>Ci sono stati degli errori del server.Riprovare più tardi.</p>";

                    } else {
                      $id = mysqli_insert_id($link);
                      $password =password_hash($id .$_POST['password'], PASSWORD_DEFAULT  );
                        $query = "UPDATE `users` SET password = '".$password."' WHERE id = ".$id." LIMIT 1";
                       
                        mysqli_query($link, $query);
               
                        $_SESSION['id'] =  $id;

                        if (isset($_POST['stayLoggedIn']) && $_POST['stayLoggedIn'] == '1') {

                            setcookie("id", $id, time() + 60*60*24*365);

                        } 

                        header("Location: loggedinpage.php");

                    }

                } 
                
            } else {
                    
                    $query = "SELECT * FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";
                
                    $result = mysqli_query($link, $query);
                
                    $row = mysqli_fetch_array($result);
                
                    if (isset($row)) {
                        
                        $password = $row['id'].$_POST['password'];
                        
                        if (password_verify( $password , $row['password'])) {
                            
                            $_SESSION['id'] = $row['id'];
                            
                            if (!empty($_POST['stayLoggedIn'])) {

                                setcookie("id", $row['id'], time() + 60*60*24*365);

                            } 

                            header("Location: loggedinpage.php");
                                
                        } else {
                            
                            $error = "That email/password combination could not be found.";
                            
                        }
                        
                    } else {
                        
                        $error = "La combinazione email/password non esiste";
                        
                    }
                    
                }
            
        }
        
        
    }

include 'header.php';
?>




<div class="container" id="homePageContainer">
    <div id="error">
        <?php 
         if($error!=''){
           echo '  <div class="alert alert-danger">'.$error.'</div>';
            
        }
        ?></div>
    <h1>Secret Diary</h1>

    <p><strong>Store your thoughts permanently and securely.</strong></p>

    <div id="error"></div>

    <form method="post" id = "signUpForm">

        <p>Interested? Sign up now.</p>

        <fieldset class="form-group">

            <input class="form-control" type="email" name="email" placeholder="Your Email">

        </fieldset>

        <fieldset class="form-group">

            <input class="form-control" type="password" name="password" placeholder="Password">

        </fieldset>

        <div class="checkbox">

            <label>

                <input type="checkbox" name="stayLoggedIn" value=1> Stay logged in

            </label>

        </div>

        <fieldset class="form-group">

            <input type="hidden" name="signUp" value="1">

            <input class="btn btn-success" type="submit" name="submit" value="Sign Up!">

        </fieldset>

        <p><a class="toggleForms" href="#">Log in</a></p>

    </form>

    <form method="post" id = "logInForm">

        <p>Log in using your username and password.</p>

        <fieldset class="form-group">

            <input class="form-control" type="email" name="email" placeholder="Your Email">

        </fieldset>

        <fieldset class="form-group">

            <input class="form-control"type="password" name="password" placeholder="Password">

        </fieldset>

        <div class="checkbox">

            <label>

                <input type="checkbox" name="stayLoggedIn" value=1> Stay logged in

            </label>

        </div>

        <input type="hidden" name="signUp" value="0">

        <fieldset class="form-group">

            <input class="btn btn-success" type="submit" name="submit" value="Log In!">

        </fieldset>

        <p><a  class="toggleForms">Sign up</a></p>

    </form>

</div>

<?php
include 'footer.php';