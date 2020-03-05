app.controller('asistentesController', ['$scope', '$http', '$filter', function($scope, $http, $filter) {
    $scope.$on('$viewContentLoaded', function() {
        console.log('AsistentesController iniciado....');

    });
    $scope.grupos = [{ grupo: 'A-401', id_carrera: 9 },
        { grupo: 'A-402', id_carrera: 9 },
        { grupo: 'D-401', id_carrera: 4 },
        { grupo: 'D-402', id_carrera: 4 },
        { grupo: 'D-403', id_carrera: 4 },
        { grupo: 'D-601', id_carrera: 4 },
        { grupo: 'E-401', id_carrera: 1 },
        { grupo: 'G-401', id_carrera: 3 },
        { grupo: 'G-402', id_carrera: 3 },
        { grupo: 'G-403', id_carrera: 3 },
        { grupo: 'G-601', id_carrera: 3 },
        { grupo: 'M-401', id_carrera: 13 },
        { grupo: 'M-402', id_carrera: 13 },
        { grupo: 'P-401', id_carrera: 2 },
        { grupo: 'T-401', id_carrera: 10 },
        { grupo: 'AS-1001', id_carrera: 15 },
        { grupo: 'DE-901', id_carrera: 8 },
        { grupo: 'DE-1001', id_carrera: 8 },
        { grupo: 'DE-1002', id_carrera: 8 },
        { grupo: 'DE-1003', id_carrera: 8 },
        { grupo: 'ER-1001', id_carrera: 6 },
        { grupo: 'ME-1001', id_carrera: 17 },
        { grupo: 'TB-1001', id_carrera: 7 },
        { grupo: 'TI-1001', id_carrera: 14 },
        { grupo: 'G-901', id_carrera: 5 },
        { grupo: 'G-1001', id_carrera: 5 },
        { grupo: 'G-1002', id_carrera: 5 },
        { grupo: 'G-1003', id_carrera: 5 },
        { grupo: 'TI-701', id_carrera: 14 },
        { grupo: 'AS-701', id_carrera: 15 },
        { grupo: 'ER-701', id_carrera: 6 },
        { grupo: 'TB-701', id_carrera: 7 },
        { grupo: 'DE-701', id_carrera: 8 },
        { grupo: 'DE-702', id_carrera: 8 },
        { grupo: 'G-701', id_carrera: 5 },
        { grupo: 'G-702', id_carrera: 5 },
        { grupo: 'ME-701', id_carrera: 17 },
        { grupo: 'ME-702', id_carrera: 17 },
        { grupo: 'TI-702', id_carrera: 14 },
        { grupo: 'M-101', id_carrera: 13 },
        { grupo: 'M-102', id_carrera: 13 },
        { grupo: 'M-103', id_carrera: 13 },
        { grupo: 'T-101', id_carrera: 18 },
        { grupo: 'E-101', id_carrera: 1 },
        { grupo: 'E-102', id_carrera: 1 },
        { grupo: 'A-101', id_carrera: 9 },
        { grupo: 'P-101', id_carrera: 2 },
        { grupo: 'D-101', id_carrera: 4 },
        { grupo: 'D-102', id_carrera: 4 },
        { grupo: 'D-103', id_carrera: 4 },
        { grupo: 'D-104', id_carrera: 4 },
        { grupo: 'G-101', id_carrera: 3 },
        { grupo: 'G-102', id_carrera: 3 },
        { grupo: 'G-103', id_carrera: 3 },
        { grupo: 'G-104', id_carrera: 3 }
    ];
    $scope.carreras = [
        { id_carrera: 1, nombre: 'Técnico Superior Universitario en Energías Renovables' },
        { id_carrera: 2, nombre: 'Técnico Superior Universitario en Procesos alimentarios' },
        { id_carrera: 3, nombre: 'Técnico Superior Universitario en Gastronomía' },
        { id_carrera: 4, nombre: 'Técnico Superior Universitario en Desarrollo de Negocios' },
        { id_carrera: 5, nombre: 'Licenciatura en Gastronomía' },
        { id_carrera: 6, nombre: 'Ingeniería en Energías Renovables' },
        { id_carrera: 7, nombre: 'Ingeniería en Tecnologías Bioalimentarias' },
        { id_carrera: 8, nombre: 'Ingeniería en Desarrollo e Innovación Empresarial' },
        { id_carrera: 9, nombre: 'Técnico Superior Universitario en Agricultura Sustentable y Protegida' },
        { id_carrera: 10, nombre: 'Tecnico Superior Universitario en Tecnologias de la Informacion y Comunicacion' },
        { id_carrera: 11, nombre: 'Tecnico Superior Universitario en Comercialización' },
        { id_carrera: 12, nombre: 'Tecnico Superior Universitario en Procesos Agroindustriales' },
        { id_carrera: 13, nombre: 'Tecnico Superior Universitario en Mecatrónica' },
        { id_carrera: 14, nombre: 'Ingeniería en Tecnologías de la Información' },
        { id_carrera: 15, nombre: 'Ingeniería Agricultura Sustentable y Protegida' },
        { id_carrera: 17, nombre: 'Ingenieria en Mecatrónica' },
        { id_carrera: 18, nombre: 'Técnico Superior Universitario en Tecnologías de la Información' }
    ];
    $scope.niveles = ['PRIMARIA', 'SECUNDARIA', 'BACHILLERATO / PREPARATORIA', 'LICENCIATURA', 'MAESTRIA', 'DOCTORADO'];
    $scope.asistentes = [];
    $scope.correos = [];
    $scope.gruposFiltrados = [];
    $scope.asistenteAnterior = {};
    $scope.carreraSeleccionada = {};
    $scope.grupoSeleccionado = {};
    $scope.filtrarPor = '';
    $scope.editando = false;
    $scope.seleccionarGrupo = false;
    $scope.correoValido = true;
    $scope.codigoGenerado = false;
    ////////////////////////////////////////////////////////////////////////////
    $scope.declaraAsistente = function() {
        $scope.asistente = {
            nombre: '',
            codigo: '',
            appat: '',
            apmat: '',
            nivelEstudios: '',
            edad: 1,
            nacionalidad: '',
            lugarNacimiento: '',
            ocupacion: '',
            telefono: '',
            correo: '',
            tipo: '',
            matricula: '',
            carrera: '',
            grupo: '',
            esAdmin: 0
        };
        $scope.seleccionarGrupo = false;
        $scope.correoValido = true;
    };
    $scope.imprimir = function() {
        window.print();
    }
    $scope.generaCodigo = function() {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        for (var i = 0; i < 10; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        $scope.asistente.codigo = text;
    };
    $scope.actualizaGrupos = function(carrera) {
        $scope.asistente.carrera = carrera.nombre;
        $scope.gruposFiltrados = _.filter($scope.grupos, { id_carrera: carrera.id_carrera });
        $scope.seleccionarGrupo = true;
    }
    $scope.setUt = function(tipo) {
        if (tipo == 'admin') {
            $scope.asistente.esAdmin = 1;
        } else {
            $scope.asistente.esAdmin = 0;
            if (tipo != 'utvco') {
                $scope.asistente.carrera = '';
                $scope.asistente.matricula = '';
                $scope.asistente.grupo = '';
            }
        }
    };
    /*********************** S E D E  S *****************************************/
    $scope.generarCodigo = function(p) {
        $scope.asistente = angular.copy(p);
        $scope.generaCodigo();
        $http.post('php/dbIris.php?action=guardaCodigoAsistente', {
            'id_usuario': $scope.asistente.id_usuario,
            'cod': $scope.asistente.codigo
        }).success(function(data, status, headers, config) {
            var idx = _.findIndex($scope.asistentes, {
                id_usuario: $scope.asistente.id_usuario
            });
            if (idx > -1) {
                $scope.asistentes[idx] = $scope.asistente;
            }
            alertify.success('Codigo Guardado!');
            $scope.declaraAsistente();
        });
    };
    /*********************** U S U A R I O S *****************************************/
    $scope.obtieneAsistentes = function() {
        $http.get("php/dbIris.php?action=getAsistentes").success(function(data) {

            $scope.asistentes = data;
            console.log(data);
        });
    };
    $scope.obtieneMails = function() {
        $http.get("php/dbIris.php?action=getCorreos").success(function(data) {
            $scope.correos = data;
        });
    };
    $scope.validaCorreo = function(mail) {
        var idx = _.findIndex($scope.correos, { correo: mail });
        idx > -1 ? $scope.correoValido = false : $scope.correoValido = true;
    };
    $scope.guardarAsistente = function() {
        if ($scope.editando) {
            $http.post('php/dbIris.php?action=editaAsistente', {
                'asistente': $scope.asistente
            }).success(function(data, status, headers, config) {
                var idx = _.findIndex($scope.asistentes, $scope.asistenteAnterior);
                if (idx > -1) {
                    $scope.asistentes[idx] = $scope.asistente;
                }
                alertify.success('Asistente Guardado!');
                $scope.declaraAsistente();
            }).error(function(data, status, headers, config) {});
            $scope.editando = false;
        } else {
            $scope.generaCodigo();
            $http.post('php/dbIris.php?action=guardaAsistente', {
                'asistente': $scope.asistente
            }).success(function(data, status, headers, config) {
                $('#modalCodigo').modal('show');
                $scope.asistentes.push($scope.asistente);
                alertify.success('Asistente Guardado!');
            });
        }
    };

    $scope.editarAsistente = function(p) {
        $scope.editando = true;
        $scope.asistente = angular.copy(p);
        $scope.asistenteAnterior = angular.copy($scope.asistente);
    };

    $scope.eliminarAsistente = function(p) {
        // console.log('Asistente a eliminar: ', p);
        $http.post("php/dbIris.php?action=borraAsistente", {
            'id_usuario': p.id_usuario
        }).success(function(data, status, headers, config) {
            var idx = _.findIndex($scope.asistentes, p);
            if (idx > -1) {
                $scope.asistentes.splice(idx, 1);
                alertify.success('Asistente Eliminado!');
            }
        });
    };
}]);