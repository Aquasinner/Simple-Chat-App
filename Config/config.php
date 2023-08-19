<?php 

 session_start();
 $host = '';
 $username = '';
 $password = '';
 $dbname = '';

 try {
    $conn = new PDO("mysql:host=$host; dbname=$dbname", $username,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
 } catch (\Throwable $th) {
    //throw $th;
    echo $th->getMessage();
    
 }
