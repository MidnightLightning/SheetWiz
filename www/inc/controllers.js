var sheetWizControllers = angular.module('sheetWizControllers', []);

sheetWizControllers.controller('CharacterListCtrl', ['$scope', '$http', 'SilexVars', function($scope, $http, SilexVars) {
  $http.defaults.headers.common.Authorization = SilexVars.authHeader;
  $http.get('https://midnight.cloudant.com/sheetwhiz/_design/characters/_view/name').success(function(rs) {
    $scope.characters = rs.rows;
  });
}]);