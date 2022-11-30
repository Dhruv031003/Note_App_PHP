<?php
$servername="localhost";
$username="root";
$password="";

$conn=mysqli_connect($servername,$username,$password);
if(!$conn){
    die("There was some error with connecting to the server".mysqli_connect_error());
}
else{
    $query="CREATE DATABASE CRUD_APP";
    $result=mysqli_query($conn,$query);
    if(!$result){
        echo "There was some error in creating the database";
    }  
    else{
        $query="create table `CRUD_APP`.`notes`(`s_no` INT(8) NOT NULL AUTO_INCREMENT , `title` VARCHAR(255) NOT NULL , `description` VARCHAR(1000) NOT NULL , PRIMARY KEY (`s_no`)) ENGINE = InnoDB;";
        $result=mysqli_query($conn,$query);
        if(!$result){
            echo "there was some error creating table";
        }
        else{
            echo "Everthing worked perfectly you can continue now";
        }
    }
}
?>