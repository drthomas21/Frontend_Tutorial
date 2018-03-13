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
    var app = angular.module("app",["ngSanitize"]);

    app.controller("PageCtrl",["$scope",function($scope){
        $scope.userData = {
            firstName: "John",
            lastName: "Deere",
            phone: "888-888-8888",
            email: "john.deare@youtube.com",
            bio: "John Deere has great lawn tractor equipment"
        };
    }]);
    </script>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body ng-controller="PageCtrl">
    <div class="container-fluid">
        <div class="row">
            <form action="javascript:void(0)" method="GET" class="form col-sm-12">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>First Name</label>
                        <input type="text" class="form-control" ng-model="userData.firstName" placeholder="First Name"/>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Last Name</label>
                        <input type="text" class="form-control" ng-model="userData.lastName" placeholder="Last Name"/>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-12">
                        <label>Phone #</label>
                        <input type="tel" class="form-control" ng-model="userData.phone" placeholder="Phone #"/>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-12">
                        <label>E-mail Address</label>
                        <input type="email" class="form-control" ng-model="userData.email" placeholder="E-mail Address"/>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label>Bio</label>
                        <textarea ng-model="userData.bio" class="form-control" style="min-height:100px;"></textarea>
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>First Name</th>
                        <td ng-bind="userData.firstName"></td>
                    </tr>
                    <tr>
                        <th>Last Name</th>
                        <td ng-bind="userData.lastName"></td>
                    </tr>
                    <tr>
                        <th>Phone #</th>
                        <td ng-bind="userData.phone"></td>
                    </tr>
                    <tr>
                        <th>E-mail Address</th>
                        <td ng-bind="userData.email"></td>
                    </tr>
                    <tr>
                        <th>Bio</th>
                        <td ng-bind="userData.bio"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
