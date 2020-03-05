<?php
  header("Cache-Control: no-cache,must-revalidate");
  header("Expires: 0");
  include("connect.php");
  switch ($_REQUEST['action']){
    case 'getEventos':
        getEventos();
        break;
    case 'getUsuario':
        getUsuario();
        break;
    case 'getCupo':
        getCupo();
        break;
    case 'getHorasInicio':
        getHorasInicio();
        break;
    case 'getHorasTermino':
        getHorasTermino();
        break;
    case 'getSelected':
        getSelected();
        break;
    case 'guardaAsistencia':
        guardaAsistencia();
        break;
    case 'quitaAsistencia':
        quitaAsistencia();
        break;
  }
  function getHorasInicio(){
      global $con;
      $qry = mysqli_query ($con,'SELECT * from horas_inicio');
      $data = array();
       while($rows = mysqli_fetch_array($qry)){
          $data[] = array(
          "id_hora" => $rows['id_hora'],
          "hora" => $rows['hora'],
          "dia" => $rows['dia']
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
          "dia" => $rows['dia']
          );
      }
      print_r(json_encode($data));
      return json_encode($data);
  };
  function getUsuario(){
    global $con;
    $data = json_decode(file_get_contents("php://input"));
    $id = $data->id_usuario;
    $qry = mysqli_query ($con,'SELECT * from usuarios WHERE activo=1 AND id_usuario='.$id);
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
        );
    }
    print_r(json_encode($data[0]));
    return json_encode($data[0]);
  };
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
////////////////////////////    EVENTOS             ///////////////////////////
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
  function getEventos(){
      global $con;
      $data = json_decode(file_get_contents("php://input"));
      $edad = $data->edad;
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
                                                          AND ev.activo=1 AND ev.edadMin<='.$edad.' AND ev.edadMax>='.$edad.'');
      $data = array();
       while($rows = mysqli_fetch_array($qry)){
          $data[] = array(
          "id_evento" => $rows['id_evento'],
          "nombre" => $rows['nombre'],
          "sede" => $rows['sede'],
          "ods" => $rows['ods'],
          "tipo" => $rows['tipo'],
          "capacidad" => $rows['capacidad'],
          "cantidad" => $rows['cantidad'],
          "horaInicio" => $rows['horaInicio'],
          "horaTermino" => $rows['horaTermino'],
          "edadMin" => $rows['edadMin'],
          "edadMax" => $rows['edadMax'],
          "dia" => $rows['dia']
          );
      }
      print_r(json_encode($data));
  };

  function getSelected(){
      global $con;
      $data = json_decode(file_get_contents("php://input"));
      $idU = $data->id_usuario;
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
                                            JOIN asistencia_evento as a_ev ON ev.id_evento=a_ev.id_evento
                                            JOIN usuarios as us ON a_ev.id_usuario='.$idU.' AND a_ev.id_usuario = us.id_usuario AND a_ev.estado=1
                                                          AND ev.activo=1');
      $data = array();
       while($rows = mysqli_fetch_array($qry)){
          $data[] = array(
          "id_evento" => $rows['id_evento'],
          "nombre" => $rows['nombre'],
          "sede" => $rows['sede'],
          "ods" => $rows['ods'],
          "tipo" => $rows['tipo'],
          "capacidad" => $rows['capacidad'],
          "cantidad" => $rows['cantidad'],
          "horaInicio" => $rows['horaInicio'],
          "horaTermino" => $rows['horaTermino'],
          "edadMin" => $rows['edadMin'],
          "edadMax" => $rows['edadMax'],
          "dia" => $rows['dia']
          );
      }
      print_r(json_encode($data));
  };

  function guardaAsistencia(){
      global $con;
      $data = json_decode(file_get_contents("php://input"));
      $idU = $data->id_usuario;
      $idE = intval($data->id_evento);
      $idC = $data->id_carrera;
      $qry_res = mysqli_query($con,'INSERT INTO asistencia_evento(id_usuario,id_evento,pregunta) VALUES ('.$idU.','.$idE.',"")');
      if($qry_res){
        $qry = 'UPDATE eventos SET cantidad=cantidad+1 WHERE id_evento='.$idE.'';
        $qry_res = mysqli_query($con,$qry);
        if($qry_res){
          $qry = 'UPDATE cupos SET cantidad_actual=cantidad_actual+1 WHERE id_evento='.$idE.' AND id_carrera='.$idC.' ';
          $qry_res = mysqli_query($con,$qry);
          $qry_res? $arr = array('msg' => "Success!!", 'error' => ''): $arr = array('msg' => "",'error' => 'Error al sumar la asistencia');
        }else{
          $arr = array('msg' => "",'error' => 'Error al insertar datos');
        }
      }
      else{
        $arr = array('msg' => "",'error' => 'Error al insertar datos');
      }
      print_r(json_encode($arr));
  };
  function quitaAsistencia(){
      global $con;
      $data = json_decode(file_get_contents("php://input"));
      $idU = $data->id_usuario;
      $idE = $data->id_evento;
      $idC = $data->id_carrera;
      $qry_res = mysqli_query($con,'UPDATE asistencia_evento SET estado=0 WHERE id_usuario='.$idU.' AND id_evento='.$idE.'');
      if($qry_res){
        $qry = 'UPDATE eventos SET cantidad=cantidad-1 WHERE id_evento='.$idE.'';
        $qry_res = mysqli_query($con,$qry);
        if($qry_res){
          $qry = 'UPDATE cupos SET cantidad_actual=cantidad_actual-1 WHERE id_evento='.$idE.' AND id_carrera='.$idC.' ';
          $qry_res = mysqli_query($con,$qry);
          $qry_res? $arr = array('msg' => "Success!!", 'error' => ''): $arr = array('msg' => "",'error' => 'Error al sumar la asistencia');
        }else{
          $arr = array('msg' => "",'error' => 'Error al insertar datos');
        }
      }
      else{
        $arr = array('msg' => "",'error' => 'Error al insertar datos');
      }
      print_r(json_encode($arr));
  };
  function getCupo(){
    global $con;
    $data = json_decode(file_get_contents("php://input"));
    $idE = intval($data->id_evento);
    $idC = $data->id_carrera;

    $qry = mysqli_query ($con,'SELECT * from cupos WHERE id_carrera='.$idC.' AND id_evento='.$idE);
    $data = array();
     while($rows = mysqli_fetch_array($qry)){
        $data[] = array(
        "id_evento" => $rows['id_evento'],
        "id_carrera" => $rows['id_carrera'],
        "cantidad" => $rows['cantidad'],
        "cantidad_actual" => $rows['cantidad_actual']
        );
    }
    print_r(json_encode($data[0]));
    return json_encode($data[0]);
  };
?>
