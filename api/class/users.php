<?php
    class users{
        private $idUser;
        private $Fname;
        private $Lname;
        private $Sexe;
        private $Type;
        private $Phone;
        private $Pseudo;
        private $Passwd;
        private $bdd;

        function __construct($base,$id,$fname,$lname,$sex,$type,$phone,$psdo,$pswd)
        {
            $this->bdd=$base;
            $this->idUser=$id;
            $this->Fname=htmlspecialchars($fname);
            $this->Lname=htmlspecialchars($lname);
            $this->Sexe=$sex;
            $this->Type=$type;
            $this->Phone=$phone;
            $this->Pseudo=$psdo;
            $this->Passwd=md5($pswd);
        }

        function connexion(){
            $req="SELECT * FROM userstaff WHERE (email=:pseudo OR pseudo=:pseudo) AND passwd=:pwd";
            try{
                $q=$this->bdd->prepare($req);
                $q->bindParam(":pseudo",$this->Pseudo);
                $q->bindParam(":pwd",$this->Passwd);
                $q->execute();
                $res=$q->fetchAll();
                echo json_encode($res);
            }catch(Exception $ex){
                echo "error_student pay=>".$ex->getMessage();
            }            
        }
        function displayusers($uniq=false){
            $req="SELECT * FROM userstaff ";
            if($uniq==true){
                $req.=" WHERE id_user=:id";
            }
            $req.="ORDER BY id_user DESC";
            try{
                $q=$this->bdd->prepare($req);
                if($uniq==true){
                    $q->bindParam(":id",$this->idUser);
                }              
                $q->execute();
                $res=$q->fetchAll();
                echo json_encode($res);
            }catch(Exception $ex){
                echo "error_student pay=>".$ex->getMessage();
            }            
        }
        function getdepartement($uniq=false){
            $req="SELECT id_dep,dep_name FROM departement ";            
            try{
                $q=$this->bdd->prepare($req);                            
                $q->execute();
                $res=$q->fetchAll();
                echo json_encode($res);
            }catch(Exception $ex){
                echo "error_get departement=>".$ex->getMessage();
            }            
        }
        function gettypeOfFees($uniq=false){
            $req="SELECT * FROM type_fees";            
            try{
                $q=$this->bdd->prepare($req);                            
                $q->execute();
                $res=$q->fetchAll();
                echo json_encode($res);
            }catch(Exception $ex){
                echo "error_get typeofFees=>".$ex->getMessage();
            }            
        }
    }
?>