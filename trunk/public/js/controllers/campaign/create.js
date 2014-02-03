/**
 * Created with JetBrains PhpStorm.
 * User: Hitanshu
 * Date: 2/2/14
 * Time: 8:14 PM
 * To change this template use File | Settings | File Templates.
 */
'use strict';
var app = angular.module("xcdapp", []);
app.controller('Campaign_Create', ['$scope', '$http', '$window', '$location', function ($scope, $http, $window, $location) {
    $scope.message = '';
    $scope.getSingleMessageCredit = function () {
        if ($scope.message == null)
            return 0;
        return Math.ceil($scope.message.length / 160);
    };
}]);