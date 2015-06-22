<?php
session_start();
if(isset($_SESSION['usuario'])){
	header("Location:Sistema");
}
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/estilos.css" rel="stylesheet">
	<title>Bancor</title>
</head>
<body>
	<div class="container">
		<div class="form-login">
			<div class="panel panel-default">
  				<div class="panel-body">
    				<h4>Iniciar Sesión</h4>
    				<div class="row imagen">
    					<img src="img/bancor-logo.png" alt="Logo Bancor" clas="img-responsive">
    				</div>
    				<form id="frm-iniciar">
	    				<div class="row">
	    					<div class="form-group">
	    						<label class="col-lg-2 control-label">Usuario</label>
	    						<div class="col-lg-12">
	    							<input type="text" class="form-control" id="txtusuario" required>
	    						</div>
	    					</div>
	    				</div>
	    				<div class="row">
	    					<div class="form-group">
	    						<label class="col-lg-2 control-label">Contraseña</label>
	    						<div class="col-lg-12">
	    							<input type="password" class="form-control" id="txtcontraseña" required>
	    						</div>
	    					</div>
	    				</div>
	    				<div class="row">
	    					<button class="btn btn-primary" type="submit">Iniciar</button>
	    				</div>
    				</form>
  				</div>
			</div>
		</div>
	</div>
	<script src="js/jquery.min.js" type="text/javascript"></script>
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
	<script type="text/javascript">
	$(function () {
		$('#frm-iniciar').submit(function(event){
        	if(this.checkValidity())
	        {
	            event.preventDefault();
	            $.ajax({
	            	url: 'aplicacion/controlador.php',
	            	type: 'post',
	            	data: {
	            		consulta:'login',
	            		usuario:$('#txtusuario').val(),
	            		contra:$('#txtcontraseña').val()
	            	},
	            	success: function (data) {
	            		if(data=="OK"){
	            			window.location.href="Sistema";
	            		}
	            		else{
	            			alert('El usuario y/o la contraseña son incorrectos');
	            			return false;
	            		}
	            	},
	            	error:function(x,h,r){
	            		console.log(x+h+r);
	            	}
	            });
	        }
   		});
	});
	</script>
</body>
</html>