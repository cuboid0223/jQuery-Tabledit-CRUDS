<?php
    $dsn = "mysql:host=localhost; dbname=tabledit";
    // $dsn (str) 包含 mysql:host=     ;   dbname= 
    //https://www.php.net/manual/en/ref.pdo-mysql.connection.php
    $username = "";
    $password = "";
    $options = [];// ?????
    
    try{
        $connection = new PDO($dsn, $username, $password, $options);
        // echo "connect success";
    }catch(PDOException $e){
        echo $e;// show the error 
    }
?>