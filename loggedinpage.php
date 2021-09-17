<?php

    session_start();

    if (array_key_exists("id", $_COOKIE)) {
        
        $_SESSION['id'] = $_COOKIE['id'];
        
    }

    if (array_key_exists("id", $_SESSION)) {
        
      
        include 'connection.php';
        $diary='';
        //echo 'test';
        $sql ="select diary from users where id=".(int)$_SESSION['id'];
       
        $query= mysqli_query($link,$sql);
        $row = mysqli_fetch_array($query);
        $diary = $row['diary'];
    } else {
        
        header("Location: index.php");
        
    }

include 'header.php';

    ?>
<nav class="navbar navbar-light bg-faded navbar-fixed-top">
    <a class="navbar-brand" href="#">My Secret Diary</a>
    <div class="pull-xs-right">
        <a class="btn btn-success-outline" href="index.php?logout=1">Logout</a>
    </div>
</nav>
<div class="container-fluid" id="containerLoggedInPage">
    <form>  
        <textarea id="diary" class="form-control"><?=$diary?></textarea>
    </form>
 
</div>
<?php

    include 'footer.php';
?>