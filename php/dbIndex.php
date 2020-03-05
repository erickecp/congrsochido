<?php
  header("Cache-Control: no-cache,must-revalidate");
  header("Expires: 0");
  include("connect.php");
  switch ($_REQUEST['action']){
    case 'guardaAsistente':
        guardaAsistente();
        break;
    case 'getMatriculas':
        getMatriculas();
        break;
    case 'getCorreos':
        getCorreos();
        break;
  }
  function getMatriculas(){
      global $con;
      $qry = mysqli_query ($con,'SELECT matricula from matriculas');
      $data = array();
       while($rows = mysqli_fetch_array($qry)){
          $data[] = array(
          "matricula" => $rows['matricula']
        );
      }
      print_r(json_encode($data));
  };
  function getCorreos(){
      global $con;
      $qry = mysqli_query ($con,'SELECT correo from usuarios where esAdmin=0');
      $data = array();
       while($rows = mysqli_fetch_array($qry)){
          $data[] = array(
          "correo" => $rows['correo']
        );
      }
      print_r(json_encode($data));
      return json_encode($data);
  };
  function guardaAsistente(){
      global $con;
      $data = json_decode(file_get_contents("php://input"));
      $nombre = $data->asistente->nombre;
      $codigo = $data->asistente->codigo;
      $appat = $data->asistente->appat;
      $apmat = $data->asistente->apmat;
      $nivelEstudios = $data->asistente->nivelEstudios;
      $edad = $data->asistente->edad;
      $nacionalidad = $data->asistente->nacionalidad;
      $lugarNacimiento = $data->asistente->lugarNacimiento;
      $ocupacion = $data->asistente->ocupacion;
      $telefono = $data->asistente->telefono;
      $correo = $data->asistente->correo;
      $tipo = $data->asistente->tipo;
      $matricula = $data->asistente->matricula;
      $carrera = $data->asistente->carrera;
      $grupo = $data->asistente->grupo;
      //print_r(json_encode($data));
      //return json_encode($data);



       $qry = 'INSERT INTO usuarios (nombre,codigo,appat,apmat,nivelEstudios,edad,nacionalidad,lugarNacimiento,ocupacion,
                     telefono,correo,tipo,matricula,carrera,grupo) VALUES
                     ("'.$nombre.'","'.$codigo.'","'.$appat.'","'.$apmat.'","'.$nivelEstudios.'",'.$edad.',"'.$nacionalidad.'",
                      "'.$lugarNacimiento.'","'.$ocupacion.'","'.$telefono.'","'.$correo.'","'.$tipo.'","'.$matricula.'",
                      "'.$carrera.'","'.$grupo.'")';

                      

      $qry_res = mysqli_query($con,$qry);
      if($qry_res){
        $arr = array('msg' => "Success!!", 'error' => 'Error');
                print_r($arr);
      }
      else{
        $arr = array('msg' => "",'error' => 'Error al isertar datos');
                print_r($arr);
      }
  };
?>
