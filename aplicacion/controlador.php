<?php
  	require('database.php');
  	$db=new BancorBD();
  	$db->connect();
  	$consulta=$_POST['consulta'];
  	switch ($consulta) {
      /*INICIAR SESIÓN*/
  		case 'login':
    		$usuario=$db->escapeString($_POST['usuario']);
    		$contra=$db->escapeString($_POST['contra']);
    		$db->sql("SELECT * FROM usuarios WHERE usuario='$usuario' AND pass='$contra'");
    		if($res=$db->getResult()){
    			session_start();
    			$_SESSION['usuario']=$usuario;
    			echo "OK";
    		}
        $db->disconnect();
      break;
      /*MOSTRAR A TODOS LOS TRABAJADORES*/
      case 'trabajadores':
        if($trabajadores=$db->listarTrabajadores()){
          echo json_encode($trabajadores);
        }
        else{
          echo json_encode(array('status'=>'FALSE'));
        }
        $db->disconnect();
      break;
      case 'trabajadores_celda':
        $celda=$_POST['celda'];
        if($personas_celda=$db->select_celda_JSON($celda)){
          echo json_encode($personas_celda);
        }
        else{
          echo json_encode(array('status'=>'FALSE'));
        }
        $db->disconnect();
      break;
      case 'comodines':
        $fecha=$_POST['fecha'];
        $celda=$_POST['celda'];
        if($comodines=$db->personal_comodin($fecha,$celda)){
          echo json_encode($comodines);
        }
        else{
          echo json_encode(array('status'=>'FALSE'));
        }
        $db->disconnect();
      break;
      /*AGREGAR PERSONAL*/
      case 'registrar_personal':
        $nombre=$db->escapeString($_POST['nombre']);
        $area=$db->escapeString($_POST['area']);
        if($db->insert('personal',array('nombre'=>utf8_decode($nombre),'area'=>$area))){
          echo 'TRUE';
        }
        else{
          echo 'FALSE';
        }
        $db->disconnect();
      break;
      /*EDITAR EL PERSONAL*/
      case 'editar_personal':
        $idpersonal=$_POST['idpersonal'];
        $nombre=$_POST['nombre'];
        $area=$_POST['area'];
        if($db->update('personal',array('nombre' =>utf8_decode($nombre) ,'area'=>$area),"idpersonal=$idpersonal")){
          echo 'TRUE';
        }
        else{
          echo 'FALSE';
        }
        $db->disconnect();
      break;
      /*ELIMINAR PERSONAL*/
      case 'eliminar_personal':
        $idpersonal=$_POST['idpersonal'];
        if($db->delete('personal',"idpersonal=$idpersonal")){
          echo 'TRUE';
        }
        else{
          echo 'FALSE';
        }
        $db->disconnect();
      break;

      case 'json_acentos':
      echo json_encode($db->json_acentos());
      break;
      case 'mostrar_asistencias':
        $fecha=$_POST['fecha'];
        $celda=$_POST['celda'];
        if($asis=$db->mostrar_asistencias($fecha,$celda)){
          echo json_encode($asis);
        }
        else{
          echo json_encode(array('status' =>'FALSE'));
        }
      break;
  	}
?>