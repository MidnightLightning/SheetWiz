var sheetWizApp = angular.module('sheetWizApp', ['sheetWizControllers']);

sheetWizApp.config(function($interpolateProvider) {
  $interpolateProvider.startSymbol('[[').endSymbol(']]');
})