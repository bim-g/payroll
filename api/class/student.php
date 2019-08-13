<?php
    class student{
        private $rollNumber;
        private $Fname;
        private $Lname;
        private $Sexe;
        private $Email;
        private $Phone;
        private $bdd;

        function __construct($base,$id,$fname,$lname,$sex,$email,$phone)
        {
            $this->rollNumber=$id;
            $this->Fname=$fname;
            $this->Lname=$lname;
            $this->Sexe=$sex;
            $this->Phone=$phone;
            $this->Email=$email;
            $this->bdd=$base;
        }

        private function generateRollnumber(){
            $mydate=getdate(date("U"));
            $year=$mydate['year']."20";
            try{
                $req="SELECT * FROM `student` WHERE `rollNumber` LIKE '".$year."%'";
                $q=$this->bdd->prepare($req);
                $q->execute();
                $res=count($q->fetchAll());
                $rollNumber=0;
                if($res<10){
                    $rollNumber="00".$year.$res+1;
                }else{
                    if($res<100){
                        $rollNumber="0".$year.$res+1;
                    }else{
                        $rollNumber=$year.$res+1;
                    }
                }
                return $rollNumber;
            }catch(Exception $ex){
                echo "error_genarate RollNumber=>".$ex->getMessage();
            }
        }

        function insertStudent(){
            $this->rollNumber=$this->generateRollnumber();
            try{
                $req="INSERT INTO student VALUES (:id,:fname,:lname,:sexe,:email,:phone,CURRENT_TIMESTAMP())";
                $q=$this->bdd->prepare($req);
                $q->bindParam(":id",$this->rollNumber);
                $q->bindParam(":fname",$this->Fname);
                $q->bindParam(":lname",$this->Lname);
                $q->bindParam(":sexe",$this->Sexe);
                $q->bindParam(":email",$this->Email);
                $q->bindParam(":phone",$this->Phone);
                $q->execute();
                echo "add student";
            }catch(Exception $ex){
                echo "error_create student=>".$ex->getMessage();
            }
        }

        function displayStudents(){
            $students=array();
            $req="SELECT * FROM student ORDER BY rollNumber DESC";
            try{
                $q=$this->bdd->prepare($req);
                $q->execute();
                while($res=$q->fetch()){
                    array_push($students,array(
                        "rollNumber"=>$res['rollNumber'],
                        "Fname"=>$res['Fname'],
                        "Lname"=>$res['Lname'],
                        "Sexe"=>$res['sexe'],
                        "email"=>$res['email'],
                        "phone"=>$res['phoneNumber']
                    ));
                }
                echo json_encode($students);
            }catch(Exception $ex){
                echo "Error_select students=>".$ex->getMessage();
            }
        }   

        function editStudent(){
            $req="UPDATE student SET Fname=:fname,Lname=:lname,sexe=:sexe,email=:mail,phoneNumber=:phone WHERE rollNumber=:id";
            try{
                $q=$this->bdd->prepare($req);
                $q->bindParam(":id",$this->rollNumber);
                $q->bindParam(":fname",$this->Fname);
                $q->bindParam(":lname",$this->Lname);
                $q->bindParam(":sexe",$this->Sexe);
                $q->bindParam(":mail",$this->Email);
                $q->bindParam(":phone",$this->Phone);
                $q->execute();
                
                echo "succees update student";
            }catch(Exception $ex){
                echo "Error_update student=>".$ex->getMessage();
            }
        }
        function deleteStudent(){
            $req="DELETE FROM student WHERE rollNumber=:id";
            try{
                $q=$this->bdd->prepare($req);
                $q->bindParam(":id",$this->rollNumber);
                $q->execute();
                
                echo "succees delete student";
            }catch(Exception $ex){
                echo "Error_update student=>".$ex->getMessage();
            }
        }

        function detailStudent(){
            $student=array();
            $req="SELECT * FROM student std LEFT JOIN std_pay stp ON std.rollNumber=stp.rollNumber WHERE std.rollNumber=:id";
            try{
                $q=$this->bdd->prepare($req);
                $q->bindParam(":id",$this->rollNumber);
                $q->execute();
                while($res=$q->fetch()){
                    array_push($student,array(
                        "rollNumber"=>$res['rollNumber'],
                        "Fname"=>$res['Fname'],
                        "Lname"=>$res['Lname'],
                        "sexe"=>$res['sexe'],
                        "email"=>$res['email'],
                        "phone"=>$res['phoneNumber'],
                        "totalPay"=>$this->totalPay(),
                    ));
                }
                echo json_encode($student);
            }catch(Exception $ex){
                echo "error_infos_student =>".$ex->getMessage();
            }
        }
        private function totalPay(){
            $amount=0;
            $req="SELECT amount FROM std_pay WHERE rollNumber=:id";
            try{
                $q=$this->bdd->prepare($req);
                $q->bindParam(":id",$this->rollNumber);
                $q->execute();
                while($res=$q->fetch()){
                    $amount+=(int)$res['amount'];
                }
                return $amount;
            }catch(Exception $ex){
                echo "error_getTotal amount =>".$ex->getMessage();
            }
        }
        private function totalTransaction(){
            $amount=array();
            $req="SELECT * FROM std_pay WHERE rollNumber=:id";
            try{
                $q=$this->bdd->prepare($req);
                $q->bindParam(":id",$this->rollNumber);
                $q->execute();
                while($res=$q->fetch()){
                    $amount+=(int)$res['amount'];
                }
                return $amount;
            }catch(Exception $ex){
                echo "error_getTotal amount =>".$ex->getMessage();
            }
        }
        private function getOperator($idoperator){
            $operator=null;
            $req="SELECT Fname,Lname FROM userstaff WHERE id_user=:id";
            try{
                $q=$this->bdd->prepare($req);
                $q->bindParam(":id",$idoperator);
                $q->execute();
                while($res=$q->fetch()){
                    $operator=$res['Fname']." ".$res['Lname'];
                }
                return $operator;
            }catch(Exception $ex){
                echo "error_getTotal amount =>".$ex->getMessage();
            }
        }
        
        function studentPay($proof,$amount,$typeFess,$iduser){
            $req="INSERT INTO std_pay (rollNumber,bank_proof,amount,id_typeFees,id_user,date_pay
            ) VALUES (:id,:bproof,:amount,:typeFees,:user,CURRENT_TIMESTAMP())";
            try{
                $q=$this->bdd->prepare($req);
                $q->bindParam(":id",$this->rollNumber);
                $q->bindParam(":bproof",$proof);
                $q->bindParam(":amount",$amount);
                $q->bindParam(":typeFees",$typeFess);
                $q->bindParam(":user",$iduser);
                $q->execute();
                echo "success pay";
            }catch(Exception $ex){
                echo "error_student pay=>".$ex->getMessage();
            }
        }
        function studentTransaction(){
            $req="SELECT std.bank_proof,std.amount,(SELECT fees_name FROM type_fees WHERE id=std.id_typeFees) as feesName,(SELECT CONCAT(Fname,Lname) FROM userstaff WHERE id_user=std.id_user) as userSuport,date_pay,std.date_pay FROM std_pay as std WHERE std.rollNumber=:iduser";
            $transaction=array();
            try{
                $q=$this->bdd->prepare($req);
                $q->bindParam(":iduser",$this->rollNumber);
                $q->execute();

                while($res=$q->fetch()){
                    array_push($transaction,array(
                        "bankproof"=>$res['bank_proof'],
                        "amount"=>$res['amount'],
                        "feesName"=>$res['feesName'],
                        "userSuport"=>$res['userSuport'],
                        "dateTransact"=>$res['date_pay']
                    ));
                }
                echo json_encode($transaction);
            }catch(Exception $ex){
                echo "error_student pay=>".$ex->getMessage();
            }
            
        }
    }
?>