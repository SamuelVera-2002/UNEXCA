<?php
try{
$conn = new PDO('mysql:host=localhost; dbname=unexca', 'root', '');
} catch(PDOException $e){
   echo "Error: ". $e->getMessage();
   die();
}
?>