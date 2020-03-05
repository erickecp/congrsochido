var app = angular.module("iris-app", []);
app.controller('indexController', ['$scope', '$http', function($scope, $http) {
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
        carrera: 0,
        grupo: '',
    };
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
    $scope.matriculas = [];
    $scope.seleccionarGrupo = false;
    $scope.matriculaValida = false;
    $scope.grupoSeleccionado = null;
    $scope.carreraSeleccionada = null;
    $scope.correoValido = true;
    ////////////////////////////////////////////////////////////////////////////
    $scope.reseteaAsistente = function() {
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
            carrera: 0,
            grupo: '',
        };
        $scope.seleccionarGrupo = true;
        $scope.correoValido = true;
    }
    $scope.actualizaGrupos = function(carrera) {
        $scope.asistente.carrera = carrera.nombre; ////////////////
        $scope.gruposFiltrados = _.filter($scope.grupos, { id_carrera: carrera.id_carrera });
        $scope.seleccionarGrupo = true;
    };
    $scope.quitaCarrera = function() {
        $scope.asistente.carrera = '';
        $scope.asistente.grupo = '';
        $scope.asistente.matricula = '';
    };
    $scope.validaMatricula = function() {
        var idx = _.findIndex($scope.matriculas, { matricula: $scope.asistente.matricula });
        idx > -1 ? $scope.matriculaValida = true : $scope.matriculaValida = false;
    };
    $scope.validaCorreo = function(mail) {
        var idx = _.findIndex($scope.correos, { correo: mail });
        idx > -1 ? $scope.correoValido = false : $scope.correoValido = true;
    };
    $scope.generaCodigo = function() {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        for (var i = 0; i < 10; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        $scope.asistente.codigo = text;
    };
    /*********************** CONEXIONES *****************************************/
    $scope.obtieneMatriculas = function() {
        $http.get("php/dbIndex.php?action=getMatriculas").success(function(data) {
            $scope.matriculas = data;
        });
    };
    $scope.obtieneMails = function() {
        $http.get("php/dbIndex.php?action=getCorreos").success(function(data) {
            $scope.correos = data;
        });
    };
    $scope.guardarAsistente = function() {
        $http.post('php/dbIndex.php?action=guardaAsistente', {
            'asistente': $scope.asistente
        }).success(function(data, status, headers, config) {
            $('#modalRegistro').modal('hide');
            if ($scope.asistente.tipo == 'utvco') {
                alertify.success('Gracias por Registrarte!');
            } else {
                // console.log(data);
                alertify.success('Gracias por Registrarte!');
                alertify.warning('Preséntate en la UTVCO para solicitar tu código de acceso!');
            }
            $scope.reseteaAsistente();
        });
    };
}]);