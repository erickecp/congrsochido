<?php
  include("php/connect.php");
  $id = $_GET['id'];
  $cve = $_GET['cve'];
  if($id && $cve){
    global $con;
    $data = array();
    $qry = mysqli_query ($con,'CALL valid('.$id.','.$cve.')');
      while($rows = mysqli_fetch_array($qry)){
        $data = array(
        "nombre" => $rows['nombre'],
        "appat" => $rows['appat'],
        "apmat" => $rows['apmat']
        );
      }
      if(sizeof($data)>0){
        echo "USUARIO INSCRITO: ";
        echo "NOMBRE: {$data['nombre']}";
      }
      else {
        echo "USUARIO NO ENCONTRADO";
      }
   }
?>
