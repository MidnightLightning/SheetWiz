var sheetWizControllers = angular.module('sheetWizControllers', []);

sheetWizControllers.controller('CharacterListCtrl', ['$scope', '$http', function($scope, $http) {
  $http.defaults.headers.common.Authorization = 'Basic '+btoa("pendiskinglincringrebehe:e2horxfjutDbvFCIo7WPdMhO");
  $http.get('https://midnight.cloudant.com/sheetwhiz/_design/characters/_view/name').success(function(rs) {
    $scope.characters = rs.rows;
  });
}]);