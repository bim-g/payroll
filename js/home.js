
app.controller("homeCtrl",function($scope,$location,initApp){
    $scope.newstudent=false;
    $scope.newStudent=function(){
        initApp.addstudent($scope.student,function(r){
            if(r=="add student"){
                $scope.newstudent=false;
                $scope.student.fname=null;
                $scope.student.lname=null;
                $scope.student.sexe=null;
                $scope.student.phone=null;
                $scope.student.email=null;
                alert("Student Add successfully");
            }else{
                alert(r);
            }
        }); 
    };
    initApp.getdepartement(function(r){
        if(angular.isObject(r) && !angular.isUndefined(r)){
            $scope.departement=r;
        }else{
            alert(r);
        }
    });
    $scope.searchStudent=function(){
        console.log($scope.rearch);
        //$scope.fetchLink("search");
    };
    // fetch link
    $scope.fetchLink=function(url){
        if(url){
            $location.path(url);
        }
    };
    $scope.mylogin=true;
});
app.controller("studentListCtrl",function($scope,initApp){
    initApp.getStudents(function(r){
        if(angular.isObject(r) && !angular.isUndefined(r)){
            $scope.students=r;
        }else{
            alert(r);
        }
    });

    $scope.getinfosStudent=function(){
        initApp.studentinfos(function(){
            if(angular.isObject(r) && !angular.isUndefined(r)){
                $scope.students=r;
            }else{
                alert(r);
            }
        });
    };
})
app.controller("financeCtrl",function($scope,$window,initApp){
    $scope.rollnumber;
    initApp.getTypefees(function(r){
        if(angular.isObject(r) && !angular.isUndefined(r)){
            $scope.typeFees=r;
        }else{
            alert(r);
        }
    });
    $scope.getTransaction=function(iduser){
        initApp.getTransactions(iduser,function(r){
            if(angular.isObject(r) && !angular.isUndefined(r)){
                $scope.transactions=r;
                $scope.transact=r.length;
            }else{
                console.log(r);
            }
        });
    };
    $scope.searchStudent=function(){
        if(!angular.isUndefined($scope.rearch)){
            initApp.studentinfos($scope.rearch,function(r){
                if(angular.isObject(r) && !angular.isUndefined(r)){
                    $scope.rollnumber=$scope.rearch.idstudent;
                    $scope.stdname=angular.uppercase(r.Fname+" "+r.Lname);
                    $scope.stdsexe=r.sexe;
                    $scope.stdphone=r.phone;
                    $scope.stdemail=r.email;
                    $scope.finatotalPayed=r.totalPay;
                    $scope.getTransaction($scope.rearch.idstudent);}
                else{
                    alert(r);
                }
            });
        }else{
            alert("enter a rollNumber");
        }
    };

    $scope.studentpayed=function(){
        $scope.payment={
            bankproof:$scope.finBank,
            amount:$scope.finamount,
            idtypeFess:$scope.finTypes,
            idstudent:$scope.rearch.idstudent,
            iduser:$window.sessionStorage.userId
        }
        initApp.studentPay($scope.payment,function(r){
            if(r=="success pay"){
                $scope.finBank=null;
                $scope.finamount=null;
                $scope.finTypes=null;
                $scope.searchStudent();
            }
            else{
                alert(r);
            };
        });
    };
});