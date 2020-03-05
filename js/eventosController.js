app.controller('eventosController', ['$scope', '$http', '$filter', function($scope, $http, $filter) {
    $scope.$on('$viewContentLoaded', function() {
        console.log('EventosController iniciado....');
    });
    // $scope.filtraHorarios('2018-11-26');
    $scope.eventos = [];
    $scope.sedes = [];
    $scope.carreras = [];
    $scope.horasInicio = [];
    $scope.horasTermino = [];
    $scope.editando = false;
    $scope.horaInicioSeleccionada = {};
    $scope.horaTerminoSeleccionada = {};
    $scope.odes = [
        'ACCIONES 2030', 'INNOVACION Y SOSTENIBILIDAD', 'VISIBILIDAD 2030',
        'TECNOLOGIA 2030', 'CONTRIBUCIONES INTELIGENTES', 'ALIMENTACION PARA TODOS',
        'OBJET-ARTE', 'ENERGIAS PARA EL FUTURO', 'GOBIERNOS SOSTENIBLES', 'AGENDA 2030 KIDS'
    ];
    $scope.tipos = [
        'DIALOGO', 'CONFERENCIA', 'PROYECCION DE CORTOMETRAJE', 'CONCURSO', 'OBRA DE TEATRO', 'EXPOSICION PERMANENTE',
        'EXPOSICION', 'CONSTRUCCION', 'CURSO', 'ACTIVIDAD', 'PANEL', 'CURSO-TALLER', 'ESPECIAL'
    ];
    $scope.eventoAnterior = {};
    $scope.horasTerminoDia = [];
    $scope.horasInicioDia = [];
    $scope.pestana = 'generales';
    ////////////////////////////////////////////////////////////////////////////
    $scope.declaraEvento = function() {
        $scope.evento = {
            edadMin: 1,
            edadMax: 20,
            cantidad: 0,
        };
        $scope.eventoAnterior = {};
        $scope.horaInicioSeleccionada = {};
        $scope.horaTerminoSeleccionada = {};
    };
    /*********************** OBTIENE TABLAS *****************************************/
    $scope.obtieneSedes = function() {
        $http.get("php/dbIris.php?action=getSedes").success(function(data) {
            $scope.sedes = data;
        });
    };
    $scope.obtieneCarreras = function() {
        $http.get("php/dbIris.php?action=getCarreras").success(function(data) {
            $scope.carreras = data;
        });
    };
    $scope.obtieneHorasInicio = function() {
        $http.get("php/dbIris.php?action=getHorasInicio").success(function(data) {
            $scope.horasInicio = data;
            $scope.horasInicioDia = _.filter($scope.horasInicio, ['dia', '2018-11-26']);
        });
    };
    $scope.obtieneHorasTermino = function() {
        $http.get("php/dbIris.php?action=getHorasTermino").success(function(data) {
            $scope.horasTermino = data;
            $scope.horasTerminoDia = _.filter($scope.horasTermino, ['dia', '2018-11-26']);
        });
    };
    $scope.obtieneEventos = function() {
        $http.get("php/dbIris.php?action=getEventos").success(function(data) {
            $scope.eventos = data;
        });
    };

    //////////////////////////////////////////////////////////////////////////////////
    /*********************** E V E N T O S *****************************************/
    $scope.guardaCupos = function() {
        $scope.carrerasFiltradas = [];
        $scope.carrerasFiltradas = _.omit($scope.carreras, function(o) { return o.nombre; });
        $http.post('php/dbIris.php?action=guardaCupos', { 'carreras': $scope.carrerasFiltradas }).success(function(data, status, headers, config) {
            alertify.success('Evento Guardado!');
            $scope.declaraEvento();
        });
    };
    $scope.editaCupos = function(idE) {
        $scope.carrerasFiltradas = [];
        $scope.carrerasFiltradas = _.omit($scope.carreras, function(o) { return o.nombre; });
        $http.post('php/dbIris.php?action=editaCupos', {
            'carreras': $scope.carrerasFiltradas,
            'id_evento': idE
        }).success(function(data, status, headers, config) {
            alertify.success('Evento Guardado!');
            $scope.declaraEvento();
        });
    };


    $scope.guardarEvento = function() {
        if ($scope.editando) {

            $http.post('php/dbIris.php?action=editaEvento', {
                'evento': $scope.evento
            }).success(function(data, status, headers, config) {
                var idx = _.findIndex($scope.sedes, {
                    id_sede: $scope.evento.sede
                });
                if (idx > -1) {
                    $scope.evento.sede = $scope.sedes[idx].nombre;
                }
                var idx = _.findIndex($scope.horasInicio, { id_hora: $scope.evento.horaInicio });
                if (idx > -1) {
                    $scope.evento.horaInicio = $scope.horasInicio[idx].hora;

                }
                var idx = _.findIndex($scope.horasTermino, { id_hora: $scope.evento.horaTermino });
                if (idx > -1) {
                    $scope.evento.horaTermino = $scope.horasTermino[idx].hora;

                }

                var idx = _.findIndex($scope.eventos, $scope.eventoAnterior);
                if (idx > -1) {
                    $scope.eventos[idx] = $scope.evento;
                }
                $scope.editaCupos($scope.evento.id_evento);
            }).error(function(data, status, headers, config) {});
            $scope.editando = false;
        } else {

            $http.post('php/dbIris.php?action=guardaEvento', {
                'evento': $scope.evento
            }).success(function(data, status, headers, config) {

                var idx = _.findIndex($scope.sedes, { id_sede: $scope.evento.sede });
                if (idx > -1) {
                    $scope.evento.sede = $scope.sedes[idx].nombre;
                }
                var idx = _.findIndex($scope.horasInicio, { id_hora: $scope.evento.horaInicio });
                if (idx > -1) {
                    $scope.evento.horaInicio = $scope.horasInicio[idx].hora;
                }
                var idx = _.findIndex($scope.horasTermino, { id_hora: $scope.evento.horaTermino });
                if (idx > -1) {
                    $scope.evento.horaTermino = $scope.horasTermino[idx].hora;
                }
                $scope.eventos.push($scope.evento);
                $scope.guardaCupos();
            }).error(function(data, status, headers, config) {
                alertify.error('El evento no se pudo editar');
            });
        }
    };


    $scope.editarEvento = function(p) {
        $scope.editando = true;
        $scope.evento = angular.copy(p);
        $scope.eventoAnterior = angular.copy($scope.evento);
        $scope.filtraHorarios($scope.evento.dia);
    };


    $scope.eliminarEvento = function(p) {
        $http.post("php/dbIris.php?action=borraEvento", {
            'id_evento': p.id_evento
        }).success(function(data, status, headers, config) {
            var idx = _.findIndex($scope.eventos, p);
            if (idx > -1) {
                $scope.eventos.splice(idx, 1);
            }
            alertify.success('Evento eliminado');
        });
    };


    /////////////////////////////////////OPERACIONES///////////////////////////////
    $scope.filtraHorarios = function(diaS) {
        console.log('')
        $scope.horasInicioDia = _.filter($scope.horasInicio, ['dia', diaS]);
        $scope.horasTerminoDia = _.filter($scope.horasTermino, ['dia', diaS]);
    };
    $scope.actualizaHoraFin = function(hraI) {
        $scope.evento.horaInicio = hraI.id_hora;
        $scope.horasTerminoDia = _.filter($scope.horasTermino, function(o) { return o.hora > hraI.hora; });
    };
    $scope.actualizaCapacidadCantidad = function(sd) {
        var idx = _.findIndex($scope.sedes, { id_sede: sd });
        if (idx > -1) { $scope.evento.capacidad = parseInt($scope.sedes[idx].capacidad); }
    };
}]);