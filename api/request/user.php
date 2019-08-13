<?php
    header("Access-Control-Allow-Origin: *");
    // header("Content-Type: application/json; charset=UTF-8");

    include '../config/connection.php';
    include_once '../class/users.php';

    $id=NULL;
    $fname=NULL;
    $lname=NULL;
    $sex=NULL;
    $type=NULL;
    $phone=NULL;
    $psdo=NULL;
    $pswd=NULL;
    
    if(isset($_POST['connect'])){
        $psdo=$_POST['username'];
        $pswd=$_POST['password'];
        $user = new users($connexion,$id,$fname,$lname,$sex,$type,$phone,$psdo,$pswd);
        $user->connexion();
    } 
    
    
    if(isset($_GET['departement'])){
        switch($_GET['departement']){
            case 'getdepartement':
            $user = new users($connexion,$id,$fname,$lname,$sex,$type,$phone,$psdo,$pswd);
            $user->getdepartement();
            break;
            case 'gettypeFees':
            $user = new users($connexion,$id,$fname,$lname,$sex,$type,$phone,$psdo,$pswd);
            $user->gettypeOfFees();
            break;
            case 'getTransactions':
            $user = new users($connexion,$id,$fname,$lname,$sex,$type,$phone,$psdo,$pswd);
            $user->gettypeOfFees();
            break;
        }        
    }   
    
?>