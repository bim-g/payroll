app.service("initApp",function($http,$window,$location){
    var link="http://localhost/payroll_ulk/api/request/";

    this.initilize=function(){
        var url="/login";
        if($window.sessionStorage.userPseudo && $window.sessionStorage.userEmail){
			url="";
		}
		$location.path(url);		
    };
    this.connection=function(user){        
        var param="connect=getConnection&username="+user.userName+"&password="+user.passWord;
        $http({
            method:"POST",
            url:link+"user.php",
            data:param,
            headers:{'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function(response){
            var res=response.data[0];          
            $window.sessionStorage.setItem("userId",res.id_user);
            $window.sessionStorage.setItem("userFName",res.Fname);
            $window.sessionStorage.setItem("userLName",res.Lname);
            $window.sessionStorage.setItem("userType",res.idtypeuser);
            $window.sessionStorage.setItem("userPseudo",res.pseudo);
            $window.sessionStorage.setItem("userEmail",res.email);
            $window.sessionStorage.setItem("userPhone",res.phoneNumber);
            $window.sessionStorage.setItem("userSexe",res.sexe);
            location.reload();
        },errorServer)
    };
    this.getdepartement=function(cb){
        $http({
            method:"GET",
            url:link+"user.php",
            params:{
                departement:"getdepartement"
            }            
        }).then(function(response){
            cb(response.data); 
        },errorServer)
    };
    this.getTypefees=function(cb){
        $http({
            method:"GET",
            url:link+"user.php",
            params:{
                departement:"gettypeFees"
            }            
        }).then(function(response){
            cb(response.data); 
        },errorServer)
    };
    this.getTransactions=function(id,cb){
        $http({
            method:"GET",
            url:link+"student.php",
            params:{
                student:"getTransactions",
                userid:id
            }            
        }).then(function(response){
            cb(response.data); 
        },errorServer)
    };
    this.addstudent=function(student,cb){ 
        var param="student=addstudent&fname="+student.fname+"&lname="+student.lname+"&email="+student.email+"&phone="+student.phone+"&sexe="+student.sexe+"&departement="+student.departerment;
        $http({
            method:"POST",
            url:link+"student.php",
            data:param,
            headers:{'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function(response){
            cb(response.data); 
        },errorServer)
    };
    this.getStudents=function(cb){
        $http({
            method:"GET",
            url:link+"student.php",
            params:{
                student:"getStudents"
            }            
        }).then(function(response){
            cb(response.data); 
        },errorServer)
    };
    this.studentinfos=function(std,cb){
        $http({
            method:"GET",
            url:link+"student.php",
            params:{
                student:"getStudentInfos",
                rollnumber:std.idstudent
            }            
        }).then(function(response){
            cb(response.data[0]); 
        },errorServer)
    };
    this.studentPay=function(std,cb){        
        var param="student=studentPay&bkproof="+std.bankproof+"&stdAmount="+std.amount+"&idTypefess="+std.idtypeFess+"&idstudent="+std.idstudent+"&iduser="+std.iduser;
        $http({
            method:"POST",
            url:link+"student.php",
            data:param,
            headers:{'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function(response){
            cb(response.data); 
        },errorServer)
    };
})

var errorServer=function(response){
    console.log("Problem connection on server::"+response);
};