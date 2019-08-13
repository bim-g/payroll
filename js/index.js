var app = angular.module("myApp", ["ngRoute"]);

app.config(function($routeProvider) {
    $routeProvider
    .when("/", {
        templateUrl : "template/home.html",
        controller:"homeCtrl"
    })
    .when("/finance", {
        templateUrl : "template/finance.html",
        controller:"financeCtrl"
    })    
    .when("/listStudent", {
        templateUrl : "template/listStudent.html",
        controller:"studentListCtrl"
    })
    .when("/config", {
        templateUrl : "template/config.html"
    })
    .when("/login", {
        templateUrl : "template/login.html"
    });
});

function myFunction() {
    var x = document.getElementById("Demo");
    if (x.className.indexOf("w3-show") == -1) {  
        x.className += " w3-show";
    } else { 
        x.className = x.className.replace(" w3-show", "");
    }
}