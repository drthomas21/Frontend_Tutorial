<!DOCTYPE html>
<html ng-app="app">
<head>
    <base href="http://frontend.superwordpressguide.com/">

    <!-- Start jQuery v3 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- End jQuery v3 -->

    <!-- Start AngularJS -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-sanitize.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-route.js"></script>
    <!-- End AngularJS -->

    <!-- Start Bootstrap v4 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- End Bootstrap v4 -->

    <script src="/js/md5.min.js"></script>

    <script type="text/javascript">
    var app = angular.module("app",["ngSanitize","ngRoute"]);
    app.config(["$routeProvider","$locationProvider",function($routeProvider,$locationProvider){
        $routeProvider
        .when("/:id",{
            templateUrl: "templates/character.html",
            controller: "CharacterPageCtrl"
        })
        .otherwise({
            templateUrl: "templates/home.html",
            controller: "HomePageCtrl"
        });

        $locationProvider.html5Mode(true);
    }]);

    app.controller("PageCtrl",["$scope","$http","$location",function($scope,$http,$location){
        var baseUrl = "https://gateway.marvel.com/";
        $scope.sendProxyRequest = function(endpoint,data,callback) {
            //Trim '/'
            while(endpoint.startsWith("/")) {
                endpoint = endpoint.slice(1);
            }

            var url = baseUrl + endpoint;

            $http.post("/proxy.php",{
                "url":url,
                "args":data
            })
            .then(function(response) {
                if(callback) {
                    console.log(response.data);
                    callback(response.data);
                }
            });
        };

        $scope.loadChracterProfile = function(characterId) {
            $location.path("/"+characterId);
        }
    }]);
    app.controller("HomePageCtrl",["$rootScope","$scope",function($rootScope,$scope) {
        $scope.searchFor = "";
        $scope.results = [];
        $scope.search = function(args) {
            $scope.$parent.sendProxyRequest("/v1/public/characters",{
                "nameStartsWith":$scope.searchFor
            },function(response) {
                if(response.data) {
                    if(!$scope.$$phase) {
                        $scope.$apply(function() {
                            $scope.results = response.data.results;
                            console.log($scope.results);
                        });
                    } else {
                        $scope.results = response.data.results;
                        console.log($scope.results);
                    }
                }
            });
        };

        $scope.viewCharacter = function(characterId) {
            $scope.$parent.loadChracterProfile(characterId);
        }
    }]);
    app.controller("CharacterPageCtrl",["$rootScope","$scope","$routeParams",function($rootScope,$scope,$routeParams) {
        console.log($routeParams);
        $scope.Character = {};

        var init = function(){
            $scope.$parent.sendProxyRequest("/v1/public/characters/"+$routeParams.id,{},function(response) {
                console.log(response.data);
                if(response.data && response.data.count > 0) {
                    if(!$scope.$$phase) {
                        $scope.$apply(function() {
                            $scope.Character = response.data.results[0];
                            console.log($scope.results);
                        });
                    } else {
                        $scope.Character = response.data.results[0];
                        console.log($scope.results);
                    }
                }
            });
        }

        init();
    }]);
    </script>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body ng-controller="PageCtrl">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/">Home</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">GitHub Page</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">YouTube Page</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid" ng-view>

    </div>
</body>
</html>
