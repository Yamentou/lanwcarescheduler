<?php
    //DB connection parameters
    $serverName = "localhost";
    $userName = "root";
    $password = "root";
    $dbName = "lawncarescheduler";

    //Create connection
    //Syntax: mysqli_connect(host, username, password, dbname, port, socket)
    $conn = mysqli_connect($serverName, $userName, $password, $dbName, 8889);

    //Check connection
    if(!$conn) {
        die('Connection failed: '.mysqli_connect_error());
    } 

    //we include the functions file
    include("functions.php");
?>