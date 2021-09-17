<?php

    $link = mysqli_connect("localhost", "root", "");
    mysqli_select_db($link, "secretdiary");
        
        if (mysqli_connect_error()) {
            
            die ("Database Connection Error");
            
        }

?>