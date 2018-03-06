<!DOCTYPE html>
<html ng-app="app">
<head>
    <!-- Start jQuery v3 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- End jQuery v3 -->

    <!-- Start AngularJS -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-sanitize.js"></script>
    <!-- End AngularJS -->

    <!-- Start Bootstrap v4 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- End Bootstrap v4 -->

    <script src="/js/md5.min.js"></script>

    <script type="text/javascript">
    var app = angular.module("app",["ngSanitize"]);

    app.controller("PageCtrl",["$scope","$http",function($scope,$http){
        var baseUrl = "https://gateway.marvel.com/";
        $scope.searchFor = "";
        $scope.results = [];
        $scope.search = function(args) {
            $scope.sendProxyRequest("/v1/public/characters",{
                "name":$scope.searchFor
            });
        };
        $scope.sendProxyRequest = function(endpoint,data) {
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
                if(response.data.data) {
                    if(!$scope.$$phase) {
                        $scope.$apply(function() {
                            $scope.results = response.data.data.results;
                            console.log($scope.results);
                        });
                    } else {
                        $scope.results = response.data.data.results;
                        console.log($scope.results);
                    }
                }                
            });
        }
    }]);
    </script>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body ng-controller="PageCtrl">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Home</a>
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

    <div class="container-fluid">
        <div class="row">
            <form class="col-sm-12" action="javascript:void(0)">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search for Hero" ng-model="searchFor">
                </div>
                <button type="submit" class="btn btn-primary" ng-click="search(this)">Submit</button>
            </form>
        </div>
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12" ng-repeat="Character in results">
                <div class="row lead-image">
                    <div class="col-sm-12">
                        <img ng-src="{{Character.thumbnail.path}}.{{Character.thumbnail.extension}}" class="img-thumbnail" />
                    </div>
                </div>
                <div class="row character-name text-center">
                    <div class="col-sm-12">
                        <h2 ng-bind-html="Character.name"></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
