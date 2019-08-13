<?php
header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");

include '../config/connection.php';
include_once '../class/student.php';

$id=NULL;
$fname=NULL;
$lname=NULL;
$sex=NULL;
$phone=NULL;
$email=NULL;
$depart=NULL;


if(isset($_POST['student'])){
    switch($_POST['student']){
        case 'addstudent': 
            $fname=$_POST['fname'];
            $lname=$_POST['lname'];;
            $sex=$_POST['sexe'];;
            $phone=$_POST['phone'];;
            $email=$_POST['email'];;
            $depart=$_POST['departement'];
            $user = new student($connexion,$id,$fname,$lname,$sex,$email,$phone);
            $user->insertStudent();
        break;
        case 'studentPay': 
            $iduser=$_POST['idstudent'];
            $user = new student($connexion,$iduser,$fname,$lname,$sex,$email,$phone);
            $user->studentPay($_POST['bkproof'],$_POST['stdAmount'],$_POST['idTypefess'],$_POST['iduser']);
        break;
        
    }
    
}
if(isset($_GET['student'])){
    switch($_GET['student']){
        case 'getStudents':
        $user = new student($connexion,$id,$fname,$lname,$sex,$email,$phone);
        $user->displayStudents();
        break;        
        case 'getStudentInfos':
        $id=$_GET['rollnumber'];
        $user = new student($connexion,$id,$fname,$lname,$sex,$email,$phone);
        $user->detailStudent();
        break;        
        case 'getTransactions':
        $id=$_GET['userid'];
        $user = new student($connexion,$id,$fname,$lname,$sex,$email,$phone);
        $user->studentTransaction();
        break;        
    }   
}


