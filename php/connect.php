<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $database = "iris2018";
    //$con = mysql_connect($host, $user, $pass);

    $con = mysqli_connect($host, $user, $pass, $database);

    if(!$con){
    die ('Error de conexi��n: '.mysql_error() );
    }
?>
