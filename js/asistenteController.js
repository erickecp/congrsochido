var app = angular.module("Iris2018", ['ngRoute','ja.qr']);
app.run(['$rootScope',
  function($rootScope) {
    $rootScope.main = {
      user:{}
    };
    $rootScope.cargaUser = function(codigo,user,id_user) {
      $rootScope.main.user = {
        id_user:id_user,
        nombre:user,
        codigo:codigo,
        link:'http://eceutvcovirtual.com/iris2030/valida.php?id='+id_user+'&cve='+codigo
      };
    };
  }
]);
app.config(function($routeProvider) {
    $routeProvider
        .when('/gafete', {
            templateUrl: 'html/gafete.html'
        })
        .when('/selectEvento', {
            templateUrl: 'html/selectEvento.html'
        })
});
app.directive('headerPagina', [function() {
    return {
        restrict: 'E',
        templateUrl: 'html/headerAsistente.html'
    };
}]);
app.controller('asistenteController', ['$scope', '$http', function($scope, $http) {
    $scope.verPrograma = false;
    $scope.eventos = [];
    $scope.eventosSelected = [];
    $scope.eventosDia = [];
    $scope.eventosFiltrados=[];
    $scope.horasInicio=[];
    $scope.horasTermino=[];
    $scope.eventoSeleccionado=[];
    $scope.diaSeleccionado = '';
    $scope.usuario = {};
    $scope.evento = {
      nombre: '',
      sede: '',
      ods: '',
      tipo: '',
      horaInicio: '',
      horaTermino: '',
      dia: '',
      capacidad: 0,
      cantidad: 0
    };

    $scope.obtieneDatos = function (idU){
      $http.post("php/dbAsistente.php?action=getUsuario",{
        id_usuario: idU
      }).success(function(data) {
          $scope.usuario = data;
          $scope.usuario.id_usuario = parseInt(data.id_usuario);
          $scope.usuario.edad = parseInt(data.edad);
          $scope.obtieneSeleccionados($scope.usuario.id_usuario);
          $scope.obtieneEventos($scope.usuario.edad);
      });
    };
    $scope.cupoValido=true;
    $scope.actualizaCampos = function(ev){
      if(ev){
        $scope.cupo={};

        $scope.evento = $scope.eventos[ _.findIndex($scope.eventos, {id_evento:ev.id_evento})];
        // console.log($scope.usuario);
        /////////////////ASIGNAMOS EL ID DE LA CARRERA
        switch($scope.usuario.carrera){
          case 'Técnico Superior Universitario en Energías Renovables':
                $scope.idCarrera = 6;
              break;
          case 'Técnico Superior Universitario en Procesos alimentarios':
                $scope.idCarrera = 7;
              break;
          case 'Técnico Superior Universitario en Gastronomía':
                $scope.idCarrera = 3;
              break;
          case 'Técnico Superior Universitario en Desarrollo de Negocios':
                $scope.idCarrera = 2;
              break;
          case 'Licenciatura en Gastronomía':
                $scope.idCarrera = 3;
              break;
          case 'Ingeniería en Energías Renovables':
                $scope.idCarrera = 6;
              break;
          case 'Ingeniería en Tecnologías Bioalimentarias':
                $scope.idCarrera = 7;
              break;
          case 'Ingeniería en Desarrollo e Innovación Empresarial':
                $scope.idCarrera = 2;
              break;
          case 'Técnico Superior Universitario en Agricultura Sustentable y Protegida':
                $scope.idCarrera = 5;
              break;
          case 'Tecnico Superior Universitario en Tecnologias de la Informacion y Comunicacion':
                $scope.idCarrera = 1;
              break;
          case 'Tecnico Superior Universitario en Comercialización':
                $scope.idCarrera = 2;
              break;
          case 'Tecnico Superior Universitario en Procesos Agroindustriales':
                $scope.idCarrera = 7;
              break;
          case 'Tecnico Superior Universitario en Mecatrónica':
                $scope.idCarrera = 4;
              break;
          case 'Ingeniería en Tecnologías de la Información':
                $scope.idCarrera = 1;
              break;
          case 'Ingeniería Agricultura Sustentable y Protegida':
                $scope.idCarrera = 5;
              break;
          case 'Ingenieria en Mecatrónica':
                $scope.idCarrera = 4;
              break;
          case 'Técnico Superior Universitario en Tecnologías de la Información':
                $scope.idCarrera = 1;
              break;
        }
        $http.post("php/dbAsistente.php?action=getCupo",{
          id_evento:ev.id_evento,
          id_carrera:$scope.idCarrera
        }).success(function(data) {
            $scope.cupo=data;
            // console.log(data);
            if(parseInt($scope.cupo.cantidad)>parseInt($scope.cupo.cantidad_actual))
            {
              $scope.cupoValido=true;
              // console.log($scope.cupoValido);
            }else {
              $scope.cupoValido=false;
            }
        });
        ////////////////////////////
      }else{
        $scope.limpiaCampos();
      }
    };
    /*********************** E V E N T O S *****************************************/
    $scope.obtieneSeleccionados = function (idx) {
        $http.post("php/dbAsistente.php?action=getSelected",{
          id_usuario:idx
        }).success(function(data) {
            if(_.isArray(data)){
              $scope.eventosSelected = data;
            }
        });
    };
    $scope.obtieneEventos = function (edad) {
        $http.post("php/dbAsistente.php?action=getEventos",{
          edad: edad
        }).success(function(data) {
            $scope.eventos = data;
        });
    };
    $scope.obtieneHorasInicio = function () {
        $http.get("php/dbIris.php?action=getHorasInicio").success(function(data) {
            $scope.horasInicio = data;
        });
    };
    $scope.obtieneHorasTermino = function () {
        $http.get("php/dbIris.php?action=getHorasTermino").success(function(data) {
            $scope.horasTermino = data;
        });
    };
    $scope.actualizaEventos = function (diaS){
      $scope.limpiaCampos();
      $scope.eventosDia = _.filter($scope.eventos,{ dia : diaS });
      //necesito sacar el id de las horasInicio de cada elemento y compararla con las horasInicio de los eventosSelected para omitirlos y no agregarlos a otro arreglo
      //lo que es lo mismo: agregar a otro arreglo los elementos de eventosDias que no aparezcan en eventosSelected
      var encontrado=0;
      for(var i = 0;i<_.size($scope.eventosDia);i++){
        encontrado = 0;
        for(var j = 0; j<_.size($scope.eventosSelected);j++){
          if($scope.eventosDia[i].horaInicio==$scope.eventosSelected[j].horaInicio){
            encontrado ++;
          }
        }
        if(encontrado==0){
          $scope.eventosFiltrados.push($scope.eventosDia[i]);
        }
      }
      console.log('eventos ya filtrados: ',$scope.eventosFiltrados);
    };
    $scope.guardarAsistencia = function (){
      $http.post("php/dbAsistente.php?action=guardaAsistencia",{
        'id_usuario': $scope.usuario.id_usuario,
        'id_evento': $scope.evento.id_evento,
        'id_carrera':$scope.idCarrera
      }).success(function(data) {
          $scope.eventosSelected.push($scope.evento);
          alertify.success('Asistencia generada!');
          $scope.limpiaCampos();
      });
    };
    $scope.quitarAsistencia = function (idx){
      $http.post("php/dbAsistente.php?action=quitaAsistencia",{
        'id_usuario':$scope.usuario.id_usuario,
        'id_evento':idx,
        'id_carrera':$scope.idCarrera
      }).success(function(data) {
        // console.log( _.findIndex($scope.eventosSelected,['id_evento',idx]));
        var idE = _.findIndex($scope.eventosSelected,['id_evento',idx]);
        if(idE>-1){
          $scope.eventosSelected.splice(idE,1);
          alertify.success('Asistencia eliminada!');
        }
      });
    };
    $scope.limpiaCampos = function(){
      $scope.evento = {
        nombre: '',
        sede: '',
        ods: '',
        tipo: '',
        horaInicio: '',
        horaTermino: '',
        dia: '',
        capacidad: 0,
        cantidad: 0
      };
      $scope.eventosFiltrados=[];
      $scope.diaSeleccionado = '';
    };
}]);
