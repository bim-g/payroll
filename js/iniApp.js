app.controller("initApp",function($scope,$location,$window,initApp){
	$scope.about=false;
	initApp.initilize();
	$scope.connect=false;
	$scope.logout=function(){
		
		$window.sessionStorage.clear();
		location.reload();
	};
});

app.controller("login",function($scope,initApp){
	$scope.connection=function(){
		if(!angular.isUndefined($scope.loginUser)){
			initApp.connection($scope.loginUser);
			$scope.$broadcast('logout');
		}
	};
});

app.directive("registration",function(){
	return {
		templateUrl:'template/registration.html'
	}
});