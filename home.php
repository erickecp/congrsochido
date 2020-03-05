<?php
  session_start();
  if(!isset($_SESSION['nombre'])){
    header("location: index.php");
  }else{
    $esAdmin  = $_SESSION['esAdmin'];
    if($esAdmin){
      $usuario  = $_SESSION['nombre'];
      $codigo   = $_SESSION['codigo'];
    }else{
      header("location: main.php");
    }
  }
?>
<html class="no-js" lang="es" ng-app="IrisAPP" ng-cloak>
  <head class="oculto-impresion">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
      <!-- Document Title -->
    <title>IRIS 2018</title>
    <!-- Favicon -->
    <link rel="icon" href="images/icono.png" type="image/x-icon">
    <!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->
    <link rel="stylesheet" type="text/css" href="rs-plugin/css/settings.css" media="screen" />
    <!-- StyleSheets -->
    <link rel="stylesheet" href="css/ionicons.min.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="fawe/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/estilosnuevos.css">
  <link rel="stylesheet" href="css/responsive.css">


    <!-- JavaScripts -->
    <script type="text/javascript" src="./js/AngularJs/angular4.min.js"></script>
    <script type="text/javascript" src="./js/AngularJs/angular-route.min.js"></script>
    <script src="js/vendors/jquery/jquery.js"></script>
    <script src="js/vendors/bootstrap.min.js"></script>
    <script src="js/vendors/lodash.js"></script>
    <script src="js/appController.js"></script>
    <script src="js/eventosController.js"></script>
    <script src="js/asistentesController.js"></script>
    <script src="js/listaController.js"></script>
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
    
  </head>
  <body class="fondo" ng-init="cargaUser('<?php echo $usuario;?>')">
    <header-pagina></header-pagina>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
