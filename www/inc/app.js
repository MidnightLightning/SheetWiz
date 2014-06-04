var sheetWizApp = angular.module('sheetWizApp', ['sheetWizControllers']);

sheetWizApp.config(function($interpolateProvider) {
  $interpolateProvider.startSymbol('[[').endSymbol(']]');
});

sheetWizApp.factory('SilexVars', function() {
  return window.sw;
});