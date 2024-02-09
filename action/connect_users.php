<?php
 try 
 {
    $pdo = new PDO('mysql:dbname=users; host=localhost', 'root', '');
 } 
 catch (PDOException $e) 
 {
  die($e->getMessage());
 }
?>