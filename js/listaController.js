app.controller('listaController', ['$scope', '$http', '$filter', function($scope, $http, $filter) {
    $scope.$on('$viewContentLoaded', function() {
        console.log('iniciando listaController....');
        $scope.eventos = [];
        $scope.eventosDia = [];
        $scope.lista = [];
        $scope.diaSeleccionado = '';
        $scope.eventoSeleccionado = [];
    });
    $scope.obtieneEventos = function() {
        $http.get("php/dbIris.php?action=getEventos").success(function(data) {
            $scope.eventos = data;
        });
    };
    $scope.actualizaEventos = function(diaS) {
        $scope.eventosDia = _.filter($scope.eventos, ['dia', diaS]);
    };
    $scope.obtieneLista = function(evento) {
        if (evento) {
            console.log(evento);
            $http.post("php/dbIris.php?action=getAsistencia", { id_evento: evento.id_evento }).success(function(data) {
                $scope.lista = data;
            });
        } else {
            $scope.lista = [];
        }
    };
}]);