var app = angular.module("IrisAPP", ['ngRoute']);
app.run(['$rootScope',
  function($rootScope) {
    $rootScope.main = {
      user:''
    };
    $rootScope.cargaUser = function(u) {
      $rootScope.main.user = u;
    };
  }
]);

app.config(function($routeProvider) {
  $routeProvider
    .when('/asistentes', {
      templateUrl: 'html/asistentes.html',
      controller: 'asistentesController'
    })
    .when('/eventos', {
      templateUrl: 'html/eventos.html',
      controller: 'eventosController'
    })
    .when('/asistencia', {
      templateUrl: 'html/asistencia.html',
      controller: 'listaController'
    })
});
app.directive('headerPagina', [function() {
  return {
    restrict: 'E',
    templateUrl: 'html/headerDirectiva.html'
  };
}]);
app.directive('directivaCantidad', [function() {
  return {
    restrict: 'E',
    scope:{
      car : '='
    },
    templateUrl: 'html/cantidadDirectiva.html'
  };
}]);
