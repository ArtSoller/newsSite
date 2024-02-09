<?php
 try 
 {
   session_start();
   $pdo = new PDO('mysql:dbname=news; host=localhost', 'root', '');
 } 
 catch (PDOException $e) 
 {
  die($e->getMessage());
 }
?>