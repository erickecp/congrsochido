<?php
  header("Cache-Control: no-cache,must-revalidate");
  header("Expires: 0");
  include("connect.php");
  switch ($_REQUEST['action']){
    case 'getAsistencia':
        getAsistencia();
        break;
    case 'getAsistentes':
        getAsistentes();
        break;
    case 'editaAsistente':
        editaAsistente();
        break;
    case 'guardaAsistente':
        guardaAsistente();
        break;
    case 'borraAsistente':
        borraAsistente();
        break;
    case 'guardaCodigoAsistente':
        guardaCodigoAsistente();
        break;
    case 'getSedes':
        getSedes();
        break;
    case 'getCarreras':
        getCarreras();
        break;
    case 'getCorreos':
        getCorreos();
        break;
    case 'getHorasInicio':
        getHorasInicio();
        break;
    case 'getHorasTermino':
        getHorasTermino();
        break;
    case 'guardaCupos':
        guardaCupos();
        break;
    case 'editaCupos':
        editaCupos();
        break;
    case 'getEventos':
        getEventos();
        break;
    case 'editaEvento':
        editaEvento();
        break;
    case 'guardaEvento':
        guardaEvento();
        break;
    case 'borraEvento':
        borraEvento();
        break;
  }

  function getSedes(){
      global $con;
      $qry = mysqli_query ($con,'SELECT * from sedes');
      $data = array();
       while($rows = mysqli_fetch_array($qry)){
          $data[] = array(
          "id_sede" => $rows['id_sede'],
          "nombre" => $rows['nombre'],
          "capacidad" => $rows['capacidad']
          );
      }
      print_r(json_encode($data));
      return json_encode($data);
  };
  function getCarreras(){
      global $con;
      $qry = mysqli_query ($con,'SELECT * from carreras');
      $data = array();
       while($rows = mysqli_fetch_array($qry)){
          $data[] = array(
          "id_carrera" => intval($rows['id_carrera']),
          "nombre" => $rows['nombre'],
          "cantidad" => 0,
        );
      }
      print_r(json_encode($data));
      return json_encode($data);
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
  function getHorasInicio(){
      global $con;
      $qry = mysqli_query ($con,'SELECT * from horas_inicio');
      $data = array();
       while($rows = mysqli_fetch_array($qry)){
          $data[] = array(
          "id_hora" => $rows['id_hora'],
          "hora" => $rows['hora'],
          "dia" => $rows['dia'],
        );
      }
      print_r(json_encode($data));
      return json_encode($data);
  };
  function getHorasTermino(){
      global $con;
      $qry = mysqli_query ($con,'SELECT * from horas_termino');
      $data = array();
       while($rows = mysqli_fetch_array($qry)){
          $data[] = array(
            "id_hora" => $rows['id_hora'],
            "hora" => $rows['hora'],
            "dia" => $rows['dia'],
        );
      }
      print_r(json_encode($data));
      return json_encode($data);
  };


  ////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////
  ////////////////////    ASISTENTES / USUARIOS            ///////////////////////
  ////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////
  function getAsistentes(){
     
      global $con;
      $qry = mysqli_query ($con,'SELECT * from usuarios WHERE activo=1 and esAdmin=0');
      $data = array();
       while($rows = mysqli_fetch_array($qry)){
          $data[] = array(
          "id_usuario" => $rows['id_usuario'],
          "nombre" => $rows['nombre'],
          "appat" => $rows['appat'],
          "apmat" => $rows['apmat'],
          "edad" => $rows['edad'],
          "telefono" => $rows['telefono'],
          "correo" => $rows['correo'],
          "ocupacion" => $rows['ocupacion'],
          "lugarNacimiento" => $rows['lugarNacimiento'],
          "nacionalidad" => $rows['nacionalidad'],
          "nivelEstudios" => $rows['nivelEstudios'],
          "matricula" => $rows['matricula'],
          "tipo" => $rows['tipo'],
          "grupo" => $rows['grupo'],
          "carrera" => $rows['carrera'],
          "codigo" => $rows['codigo'],
          "esAdmin" => $rows['esAdmin']
          );
      }
      print_r(json_encode($data));
     // exit();
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
      $esAdmin = intval($data->asistente->esAdmin);

      $qry = 'INSERT INTO usuarios (nombre,codigo,appat,apmat,nivelEstudios,edad,nacionalidad,lugarNacimiento,ocupacion,
                     telefono,correo,tipo,matricula,carrera,grupo,esAdmin) VALUES
                     ("'.$nombre.'","'.$codigo.'","'.$appat.'","'.$apmat.'","'.$nivelEstudios.'",'.$edad.',"'.$nacionalidad.'",
                      "'.$lugarNacimiento.'","'.$ocupacion.'","'.$telefono.'","'.$correo.'","'.$tipo.'","'.$matricula.'",
                      "'.$carrera.'","'.$grupo.'",'.$esAdmin.')';

      $qry_res = mysqli_query($con,$qry);
      if($qry_res){
        $arr = array('msg' => "Success!!", 'error' => 'Error');
        echo "Datos insertados ";
        $jsn = json_encode($arr);
      }
      else{
        $arr = array('msg' => "",'error' => 'Error al isertar datos');
        $jsn = json_encode($arr);
      }
  };
  function editaAsistente(){
      global $con;
      $data = json_decode(file_get_contents("php://input"));
      $id_usuario = intval($data->asistente->id_usuario);
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
      $esAdmin = intval($data->asistente->esAdmin);

      $qry = 'UPDATE usuarios SET nombre="'.$nombre.'",codigo="'.$codigo.'",appat="'.$appat.'",apmat="'.$apmat.'",nivelEstudios="'.$nivelEstudios.'",
                       edad='.$edad.',nacionalidad="'.$nacionalidad.'",lugarNacimiento="'.$lugarNacimiento.'",ocupacion="'.$ocupacion.'",
                       telefono="'.$telefono.'",correo="'.$correo.'",tipo="'.$tipo.'",matricula="'.$matricula.'",
                      carrera="'.$carrera.'",grupo="'.$grupo.'",esAdmin='.$esAdmin.' WHERE id_usuario='.$id_usuario.'';

      $qry_res = mysqli_query($con,$qry);

      if ($qry_res) {
          $arr = array('msg' => "Usuario Actualizado Correctamente!!!", 'error' => '');
          $jsn = json_encode($arr);
      } else {
          $arr = array('msg' => "", 'error' => 'Error Al Actualizar Usuario');
          $jsn = json_encode($arr);
      }
  };
  function borraAsistente(){
      global $con;
      $data = json_decode(file_get_contents("php://input"));
      $index = $data->id_usuario;
      $del = mysqli_query($con,'UPDATE usuarios SET activo=0 WHERE id_usuario='.$index);
      if($del){
        $arr = array('msg' => "Success!!", 'error' => 'Error');
        echo "Datos eliminado ";
        $jsn = json_encode($arr);
      }
      else{
        $arr = array('msg' => "",'error' => 'Error al realizar borrado');
        $jsn = json_encode($arr);
      }
  };
  function guardaCodigoAsistente(){
      global $con;
      $data = json_decode(file_get_contents("php://input"));
      $index = intval($data->id_usuario);
      $cod = $data->cod;
      $del = mysqli_query($con,'UPDATE usuarios SET codigo="'.$cod.'" WHERE id_usuario='.$index);
      if($del){
        $arr = array('msg' => "Success!!", 'error' => 'Error');
        echo "Codigo generado";
        $jsn = json_encode($arr);
      }
      else{
        $arr = array('msg' => "",'error' => 'Error al realizar borrado');
        $jsn = json_encode($arr);
      }
  };

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
////////////////////////////    EVENTOS             ///////////////////////////
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
  function getEventos(){
      
      global $con;
      $qry = mysqli_query ($con,'SELECT ev.id_evento as id_evento,
                                        ev.nombre as nombre,
                                        ev.ods as ods,
                                        ev.tipo as tipo,
                                        ev.edadMin as edadMin,
                                        ev.edadMax as edadMax,
                                        sd.nombre as sede,
                                        ev.capacidad as capacidad,
                                        ev.cantidad as cantidad,
                                        hrI.hora as horaInicio,
                                        hrT.hora as horaTermino,
                                        hrI.dia as dia
                                        from eventos as ev
                                                JOIN sedes as sd ON ev.sede=sd.id_sede
                                                JOIN horas_inicio as hrI ON ev.hora_inicio=hrI.id_hora
                                                JOIN horas_termino as hrT ON ev.hora_fin=hrT.id_hora
                                                          AND ev.activo=1');
      $data = array();
       while($rows = mysqli_fetch_array($qry)){
          $data[] = array(
          "id_evento" => $rows['id_evento'],
          "nombre" => $rows['nombre'],
          "sede" => $rows['sede'],
          "ods" => $rows['ods'],
          "tipo" => $rows['tipo'],
          "edadMin" => $rows['edadMin'],
          "edadMax" => $rows['edadMax'],
          "capacidad" => $rows['capacidad'],
          "cantidad" => $rows['cantidad'],
          "horaInicio" => $rows['horaInicio'],
          "horaTermino" => $rows['horaTermino'],
          "dia" => $rows['dia']
          );
      }
      print_r(json_encode($data));
      return json_encode($data);
  };
  function guardaEvento(){
      global $con;
      $data = json_decode(file_get_contents("php://input"));
      $nombre = $data->evento->nombre;
      $sede = $data->evento->sede;
      // $ods = $data->evento->ods;
      // $tipo = $data->evento->tipo;
      $horaInicio = $data->evento->horaInicio;
      $horaTermino = $data->evento->horaTermino;
      // $edadMin = $data->evento->edadMin;
      // $edadMax = $data->evento->edadMax;
      $capacidad = $data->evento->capacidad;

      $qry = 'INSERT INTO eventos(nombre,sede,hora_inicio,hora_fin,capacidad)
                    VALUES ("'.$nombre.'",'.$sede.','.$horaInicio.','.$horaTermino.','.$capacidad.')';

      $qry_res = mysqli_query($con,$qry);
      if($qry_res){
        $arr = array('msg' => "Success!!", 'error' => 'Error');
        echo "Datos insertados ";
        $jsn = json_encode($arr);
      }
      else{
        $arr = array('msg' => "",'error' => 'Error al isertar datos');
        $jsn = json_encode($arr);
      }
  };
  function guardaCupos(){
      global $con;
      $res = array();
      $carreras = array();
      $id_carrera = 0;
      $cantidad = 0;
      $index = 0;

      $data = json_decode(file_get_contents("php://input"));
      $qry = mysqli_query ($con,'SELECT MAX(id_evento)as result from eventos');
      $carreras = $data->carreras;
      while($rows = mysqli_fetch_array($qry)){$res = array("resultado" => $rows['result']);}//obtengo el id del evento
      $id_evento = $res['resultado'];

      foreach($carreras as $posicion=>$jugador){
         $id_carrera = $jugador->id_carrera;
         $cantidad = $jugador->cantidad;
         $qry_res = mysqli_query($con,'INSERT INTO cupos(id_evento,id_carrera,cantidad) values('.$id_evento.','.$id_carrera.','.$cantidad.')');
	    }
  };
  function editaCupos(){
      global $con;
      $res = array();
      $carreras = array();
      $id_carrera = 0;
      $cantidad = 0;
      $index = 0;

      $data = json_decode(file_get_contents("php://input"));

      $qry = mysqli_query ($con,'SELECT MAX(id_evento)as result from eventos');
      $carreras = $data->carreras;
      $id_evento = $data->id_evento;
      while($rows = mysqli_fetch_array($qry)){$res = array("resultado" => $rows['result']);}//obtengo el id del evento
      $id_evento = $res['resultado'];

      foreach($carreras as $posicion=>$jugador){
         $id_carrera = $jugador->id_carrera;
         $cantidad = $jugador->cantidad;
         $qry_res = mysqli_query($con,'UPDATE cupos SET cantidad='.$cantidad.' WHERE id_evento='.$id_evento.')');
	    }
  };
  function editaEvento(){
      global $con;
      $data = json_decode(file_get_contents("php://input"));
      $id_evento = $data->evento->id_evento;
      $nombre = $data->evento->nombre;
      $sede = $data->evento->sede;
      $ods = $data->evento->ods;
      $tipo = $data->evento->tipo;
      $hora_inicio = $data->evento->horaInicio;
      $hora_fin = $data->evento->horaTermino;
      $edadMin = $data->evento->edadMin;
      $edadMax = $data->evento->edadMax;
      $capacidad = $data->evento->capacidad;
      $qry_res = mysqli_query($con,'UPDATE eventos set nombre   ="'.$nombre.'",
                                  sede    ="'.$sede.'",
                                  ods     ="'.$ods.'",
                                  tipo    ="'.$tipo.'",
                                  hora_inicio ='.$hora_inicio.',
                                  hora_fin ='.$hora_fin.',
                                  edadMin ='.$edadMin.',
                                  capacidad ='.$capacidad.',
                                  edadMax ='.$edadMax.'
                                          WHERE id_evento='.$id_evento);
      if ($qry_res) {
          $arr = array('msg' => "Evento Actualizado Correctamente!!!", 'error' => '');
          $jsn = json_encode($arr);
      } else {
          $arr = array('msg' => "", 'error' => 'Error Al Actualizar Evento');
          $jsn = json_encode($arr);
      }
  };
  function borraEvento(){
      global $con;
      $data = json_decode(file_get_contents("php://input"));
      $index = $data->id_evento;
      $del = mysqli_query($con,'UPDATE eventos SET activo=0 WHERE id_evento='.$index);
      if($del){
        $arr = array('msg' => "Success!!", 'error' => 'Error');
        echo "Elemento eliminado ";
        $jsn = json_encode($arr);
      }
      else{
        $arr = array('msg' => "",'error' => 'Error al realizar borrado');
        $jsn = json_encode($arr);
      }
  };

  ////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////    ASISTENCIA             ///////////////////////////
  ////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////
  function getAsistencia(){
    global $con;
    $data = json_decode(file_get_contents("php://input"));
    $id = $data->id_evento;
    $qry = mysqli_query ($con,'select usu.nombre,
    usu.appat,usu.apmat,usu.edad,usu.ocupacion,usu.lugarNacimiento
    from usuarios as usu
    join asistencia_evento as a_ev on a_ev.id_usuario=usu.id_usuario AND a_ev.estado=1
    join eventos as ev on ev.id_evento=a_ev.id_evento and ev.id_evento='.$id);
    $data = array();
     while($rows = mysqli_fetch_array($qry)){
        $data[] = array(
        "nombre" => $rows['nombre'],
        "appat" => $rows['appat'],
        "apmat" => $rows['apmat'],
        "edad" => $rows['edad'],
        "ocupacion" => $rows['ocupacion'],
        "lugarNacimiento" => $rows['lugarNacimiento']
      );
    }
    print_r(json_encode($data));
  };
?>
