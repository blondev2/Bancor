<?php
session_start();
if(!isset($_SESSION['usuario'])){
	header("Location:../");
}

$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
require('../aplicacion/database.php');
$db=new BancorBD();
$db->connect();
$areas=$db->areas();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Sistema</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/estilos.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Bancor</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="glyphicon glyphicon-user"></i>	<?php echo $_SESSION['usuario']." " ;?><span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#"><i class="glyphicon glyphicon-off"></i> Cerrar Sesión</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container" id="principal">
	<ul class="nav nav-tabs">
		<li class="active in"><a data-toggle="tab" href="#asistencia" aria-expanded="true">Asistencia</a></li>
		<li><a data-toggle="tab" href="#vales" aria-expanded="true">Vales</a></li>
		<li><a data-toggle="tab" href="#personal" aria-expanded="true">Personal</a></li>
	</ul>
	<div id="contenidotab" class="tab-content">
		<div class="tab-pane fade active in" id="asistencia">
            <h4><?php echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;?></h4>
            <div class="col-lg-6">

            	<div class="row">
            		<div class="form-group">
	            		<div class="col-lg-2">
	            			<label for="" class="control-label">Celda</label>
	            		</div>
	            		<div class="col-lg-4">
			            	<select id="select_celda" class="form-control">
			            		<?php foreach ($areas as $value):?>
			            			<option value="<?php echo $value['id']?>"><?php echo $value['nombre']?></option>
			            		<?php endforeach ?>
			            	</select>
	            		</div>
	            		<div class="col-lg-2">
	            			<label class="control-label">Fecha</label>
	            		</div>
	            		<div class="col-lg-4">
	            			<input type="date" class="form-control" id="fecha">
	            		</div>
	            	</div>
            	</div>
            	<div class="panel panel-default">
            		<div class="panel-heading">
            			<p>Personal para la celda</p>
            		</div>
            		<div class="panel-body">
            		   	<table class="table table-striped table-hover ">
            				<thead>
            					<tr>
            						<th>Id Personal</th>
				      				<th>Nombre</th>
				      				<th>Asistencia</th>
				      				<th>Celda</th>
				    			</tr>
				 			 </thead>
				  			<tbody id="tabla_personal_celda">
				  			</tbody>
						</table>
						<button id="pasar_asistencia" class="btn btn-success">Guardar</button> 
            		</div>
            	</div>
            </div>
            <div class="col-lg-6">
            	<div class="panel panel-primary" style="margin-top:55px;">
            		<div class="panel-heading">
            			<p id="tcomodin"></p>
            		</div>
            		<div class="panel-body">
            		   <table class="table table-hover">
            		   	<thead>
            		   		<tr>
            		   			<th></th>
            		   			<th>Id Personal</th>
            		   			<th>Nombre</th>
            		   			<th>Asistencia</th>
            		   			<th>Celda</th>
            		   		</tr>
            		   	</thead>
            		   	<tbody id="tabla_comodines">
            		   		
            		   	</tbody>
            		   </table>
            		</div>
            	</div>
            </div>

            <div class="col-lg-12">
            	<div class="panel panel-default">
            		<div class="panel-heading">
            			<p>Resumen de asistencias</p>
            		</div>
            		<div class="panel-body">
            		   <table class="table table-hover">
            		   	<thead>
            		   		<tr>
            		   			<th>Id Asistencia</th>
            		   			<th>Nombre</th>
            		   			<th>Fecha</th>
            		   			<th>Asistencia</th>
            		   			<th>Celda</th>
            		   		</tr>
            		   	</thead>
            		   	<tbody id="tabla_r_asistencias">
            		   	</tbody>
            		   </table>
            		</div>
            	</div>
            </div>







        </div>
        <div class="tab-pane fade" id="vales"> 
        </div>

















		<div class="tab-pane fade" id="personal">
		<h4>Administración del Personal</h4>
		<table class="table table-hover">
		 	<thead>
		 		<tr>
		 			<th>Nombre</th>
		 			<th>Area</th>
		 			<th class="col-md-1"><a class="btn btn-primary btn-sm" data-toggle="modal" href='#modal-nuevo-personal'><i class="glyphicon glyphicon-plus"></i> Agregar</a></th>
		 			<div class="modal fade" id="modal-nuevo-personal">
		 				<div class="modal-dialog">
		 					<div class="modal-content">
		 						<div class="modal-header">
		 							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		 							<h4 class="modal-title">Agregar personal</h4>
		 						</div>
		 						<div class="modal-body">
					                <form id="frm_nuevo_personal">
		 							<div class="form-group">
		 								<label for="txtnombre" class="control-label" style="margin:0;">Nombre</label>
		 								<input type="text" id="txtnombre" name="nombre" class="form-control" required>
					                </div>
					                <div class="form-group">
		 								<label for="sl_area" class="control-label" style="margin:0;">Area</label>
		 								<select name="area" id="sl_area" class="form-control">
						            		<?php foreach ($areas as $value):?>
			            						<option value="<?php echo $value['id']?>"><?php echo $value['nombre']?></option>
			            					<?php endforeach ?>
						            	</select>
					                </div>
					                <div class="form-group" id="res"></div>
		 						</div>
		 						<div class="modal-footer">
		 							<button type="submit" class="btn btn-primary">Guardar</button>
		 							</form>
		 						</div>
		 					</div>
		 				</div>
		 			</div>
		 			<th class="col-md-1"></th>
		 		</tr>
		 	</thead>
		 	<tbody id="tabla_personal">
		 		<tr>
		 			<!--
		 			<td>Martha Patricia B</td>
		 			<td>Celda 2</td>
		 			<td><button type="button" class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-pencil"></i></button></td>
		 			<td><button type="button" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-trash"></i></button></td>
		 		-->
		 		</tr>
		 	</tbody>
		 </table>
		 <div id="div-modal-mod-del"></div> 
        </div>
    </div>
</div>
<script src="../js/jquery.min.js" type="text/javascript"></script>
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<script src="../js/script.js" type="text/javascript"></script>
</body>
</html>