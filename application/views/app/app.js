var myApp = angular.module('myApp', ['ui.router']);

myApp.controller('MainCtrl', function($scope) {});

myApp.config(function($stateProvider, $urlRouterProvider) {

    // default route
    $urlRouterProvider.otherwise("/first");
  var header = {
       template: '<h1>Im Header</h1>',
       controller: function($scope) {}
  
  }
     var footer = {
       template: '<h1>Im Footer </h1>',
       controller: function($scope) {}
  
  }
    // ui router states
    $stateProvider
        .state('first', {
            url: "/first",
            views: {
                header: header,
                content: {
                    template: '<p>First content</>',
                    controller: function($scope) {}
                },
                footer: footer
            }
        })
        .state('second', {
            url: "/second",
            views: {
                header: header,
                content: {
                    template: '<p>Second content</>',
                    controller: function($scope) {}
                },
                footer: footer
            }
        });

});