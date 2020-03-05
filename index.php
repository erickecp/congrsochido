<?php
  require('php/conexion.php');
  session_start();

  if(isset($_SESSION['nombre'])){
    $esAdmin  = $_SESSION['esAdmin'];
    if($esAdmin){
      header("location: home.php");
    }else{
      header("location: main.php");
    }
  }

  if(!empty($_POST))
  {
    $usuario = mysqli_real_escape_string($con,$_POST['correo']);
    $password = mysqli_real_escape_string($con,$_POST['password']);

    $result=mysqli_query($con,'SELECT * FROM usuarios WHERE correo="'.$usuario.'" AND codigo="'.$password.'" and activo=1');
    // $rows = $result->num_rows;
    if($result) {
        $row = $result->fetch_assoc();
        $_SESSION['nombre'] = $row['nombre'];
        $_SESSION['id_usuario'] = $row['id_usuario'];
        $_SESSION['codigo'] = $row['codigo'];
        $_SESSION['esAdmin'] = $row['esAdmin'];
        if($row['esAdmin']){
            header("location: home.php");
        }else{
            header("location: main.php");
        }
    } else {
        $error = "Datos incorrectos";
    }
  }
?>
<html  lang="es" ng-app="iris-app">
  <head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8" />
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <!-- Document Title -->
  <title>IRIS 2018</title>

  <!-- Favicon -->
  <link rel="shortcut icon" href="images/fondo2.ico" type="image/x-icon">
  <link rel="icon" href="images/icono.png" type="image/x-icon">

  <!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->

  <!-- StyleSheets -->
  <link rel="stylesheet" href="css/ionicons.min.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/anim.css">
  <link rel="stylesheet" href="fawe/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/estilosnuevos.css">
  <link rel="stylesheet" href="css/responsive.css">

  <link href="php/dbIndex.php">
  <script src="js/vendors/lodash.js"></script>

  <script type="text/javascript" src="./js/AngularJs/angular4.min.js"></script>
  <script src="js/indexController.js"></script>
  <!-- JavaScripts -->
  <!-- JavaScript -->
  <script src="js/alertify/alertify.min.js"></script>

  <!-- CSS -->
  <link rel="stylesheet" href="css/alertifycss/alertify.min.css"/>
  <!-- Default theme -->
  <link rel="stylesheet" href="css/alertifycss/themes/default.min.css"/>
  <!-- Semantic UI theme -->
  <link rel="stylesheet" href="css/alertifycss/themes/semantic.min.css"/>
  <!-- Bootstrap theme -->
  <link rel="stylesheet" href="css/alertifycss/themes/bootstrap.min.css"/>


  <script>
    var es_ie = navigator.userAgent.indexOf("MSIE") > -1 ;
    if(es_ie){
    			    alert("Para navegar mejor, te recomendamos utilizar Chrome como navegador");
    }
  </script>
  </head>
  <body class="fondo" ng-controller="indexController" ng-init="obtieneMatriculas()">

    <nav class=" navbar-expand-lg navbar navbar-dark bg-dark shadow-lg">
  <a class="navbar-brand" href="#"><img src="images/thinki.png" width="150px" style="padding-bottom: 4px;"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse " id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#"> <span class="sr-only">(current)</span></a>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         <i class="fas fa-download"></i> Descargar Programas
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item"href="images/programa.pdf" download="ProgramaIRIS2018">Programa IRIS 2030</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="images/hack.pdf" download="Hackaton">Hackathon</a>

          <a class="dropdown-item" href="images/meca.pdf" download="Prototipos">Prototipos Mecátronicos</a>
        </div>
      </li>


    </ul>
  <span class="p-1"><a class="btn btn-primary my-2 my-sm-0"   data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modalRegistro"><i class="glyphicon glyphicon-user"></i> Registrarse
                   </a></span>
    
                   <span class="p-1"> <a class="btn btn-primary my-2 my-sm-0 "   data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modalLogin"><i class="glyphicon glyphicon-check"></i> Ingresar
                      </a></span>

  </div>
</nav>
<br>


      <div class="container-fluid ">
      <div class="row">
        <div class="col-md-12 center-block text-center">

        </div>
      </div>
    </div>

   <div id="modalLogin" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h4 class="modal-title text-center ">  Ingresar</h4>
          </div>
          <div class="modal-body">
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                 
                  <input class=" form-control"type="text"  name="correo" placeholder="Correo Electronico" autofocus required><br>
                  <input class=" form-control" type="password" name="password" placeholder="Código de Acceso" required>
            <div style = "font-size:16px; color:#cc0000;"><?php echo isset($error) ? utf8_decode($error) : '' ; ?></div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success"> <i class="fas fa-sign-in-alt"></i> Acceder</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fas fa-window-close"></i> Cerrar</button>
          </div>
        </form>
        </div>
      </div>
    </div>



    <div class="modal fade" tabindex="-1" role="dialog" id="modalRegistro">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            
            <h5 class="modal-title roboto">Datos del Asistente</h5>
        
          </div>
          <form name="formAsistente">
            <div class="modal-body">
                <div class="input-group">
                    <span class="input-group-addon">Nombre(s) *:</span>
                    <input type="text" class="form-control" ng-model="asistente.nombre" required>
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon">Apellido Paterno *:</span>
                    <input type="text" class="form-control" ng-model="asistente.appat" required>
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon">Apellido Materno:</span>
                    <input type="text" class="form-control" ng-model="asistente.apmat">
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon">Edad *:</span>
                    <input type="number" class="form-control" ng-model="asistente.edad" max="100" min="1" required>
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon">Nacionalidad:</span>
                    <input type="text" class="form-control" ng-model="asistente.nacionalidad">
                </div>

                   <br>

                  <div class="input-group">
                    <span class="input-group-addon">Lugar de Nacimiento:</span>
                    <input type="text" class="form-control" ng-model="asistente.lugarNacimiento">
                  </div>
                <br>

                  <div class="input-group">
                    <span class="input-group-addon">Tel&eacutefono:</span>
                    <input type="text" class="form-control" ng-model="asistente.telefono">
                  </div>
                <br>

                  <div class="input-group">
                    <span class="input-group-addon">Correo *:</span>
                    <input type="email" class="form-control" ng-model="asistente.correo" required>
                  </div>
                  <br>
                    <p align="center" style="color:white; background: red; padding:center; width:100%; border-radius:5px;" class="label label-warning" ng-show="!correoValido">El correo ya existe</p>


              <br>

                  <div class="input-group">
                    <span class="input-group-addon">Nivel de Estudios:</span>
                    <select type="text" class="form-control" ng-model="asistente.nivelEstudios">
                      <option ng-repeat="ne in niveles" value="{{ne}}">{{ne}}</option>
                    </select>
                  </div>
                <br>
                  <div class="input-group">
                    <span class="input-group-addon">Ocupaci&oacuten:</span>
                    <input type="text" class="form-control" ng-model="asistente.ocupacion">
                  </div>
                <br>
                  <div class="input-group">
                    <span class="input-group-addon">Estudiante UTVCO:</span>
                    <label><input type="radio" ng-model="asistente.tipo" value="utvco"> Si</label>
                    <label><input type="radio" ng-model="asistente.tipo" value="general" ng-click="quitaCarrera()"> No</label>
                  </div>
                <br>

                  <div class="input-group" ng-if="asistente.tipo=='utvco'">
                    <span class="input-group-addon">Carrera:</span>
                    <select class="form-control" ng-model="carreraSeleccionada" ng-change="actualizaGrupos(carreraSeleccionada)" ng-options="car as car.nombre for car in carreras track by car.id_carrera" >
                      <option value=""></option>
                    </select>
                  </div>
                <br>
                <div class="input-group" ng-if="asistente.tipo=='utvco'">
                  <span class="input-group-addon">Grupo:</span>
                  <select class="form-control" ng-model="grupoSeleccionado" ng-change="asistente.grupo=grupoSeleccionado.grupo" ng-options="gpo as gpo.grupo for gpo in gruposFiltrados track by gpo.grupo" >
                    <option value=""></option>
                  </select>
                </div>
                <br>
                  <div class="input-group"  ng-if="asistente.tipo=='utvco'">
                    <span class="input-group-addon">Matrícula:</span>
                    <input type="text" class="form-control" ng-model="asistente.matricula" ng-change="validaMatricula()">
                  </div>
                  <div class="input-group"  ng-if="asistente.tipo=='utvco' && matriculaValida">
                    <button type="button" class="btn btn-default" ng-click="generaCodigo()">Generar Código</button>
                  </div>
                <br>
                <div class="input-group"  ng-if="asistente.codigo">
                  <span class="input-group-addon">Codigo de Acceso:</span>
                  <input type="text" class="form-control" ng-model="asistente.codigo" disabled>
                </div>
                <br>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal" ng-click="reseteaAsistente()"> <i class="fas fa-window-close"></i> Cerrar</button>
              <button class="btn btn-success" ng-click="guardarAsistente()" ng-disabled="!formAsistente.$valid || !correoValido"><i class="fas fa-save"></i> Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

  </body>
</html>
