<?php
$peticion=$_POST['peticion'];
$idpersonal=$_POST['idpersonal'];
require('database.php');
$db=new BancorBD();
$db->connect();
$datos_personal=$db->detallePersonal($idpersonal);
$areas=$db->areas();
$db->disconnect();
?>
<div class="modal fade" id="modal-mod-del">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<?php if($peticion=='Editar'):?>
					<h4 class="modal-title"><?php echo $peticion;?> a <?php echo utf8_encode($datos_personal[1]);?></h4>
				<?php else:?>
					<h4 class="modal-title">Estás por eliminar a:</h4>
				<?php endif;?>
				
			</div>
			<?php if($peticion=='Editar'): ?>
				<div class="modal-body">
					<div class="form-group">
						<div class="col-lg-4"><label for="tidpersonal" class="control-label"><i class="glyphicon glyphicon-tags"></i> ID de Personal</label></div>
						<div class="col-lg-8"><input type="text" class="form-control" id="tidpersonal" value="<?php echo $datos_personal[0];?>" readonly></div>
					</div>
					<div class="form-group">
						<div class="col-lg-4"><label for="nombrepersonal" class="control-label"><i class="glyphicon glyphicon-user"></i> Nombre</label></div>
						<div class="col-lg-8"><input type="text" class="form-control" id="nombrepersonal" value="<?php echo utf8_encode($datos_personal[1]);?>"></div>
					</div>
					<div class="form-group">
						<div class="col-lg-4"><label for="nombrepersonal" class="control-label"><i class="glyphicon glyphicon-home"></i> Area</label></div>
						<div class="col-lg-8">
							<select id="slcarea" class="form-control">
								<?php
								foreach ($areas as $value) {
									if($datos_personal[2]==$value['id']){
										?>
										<option value="<?php echo $value['id'];?>" selected><?php echo $value['nombre'];?></option>	
										<?php
									}
									else{
										?>
										<option value="<?php echo $value['id'];?>"><?php echo $value['nombre'];?></option>
										<?php
									}
								}
								?>
							</select>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button id="frm-editar" type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i> Editar</button>
				</div>
				<?php elseif ($peticion=='Eliminar'):?>
				<div class="modal-body">
					<div class="form-group">
						<div class="col-lg-4"><label for="teidpersonal" class="control-label"><i class="glyphicon glyphicon-tags"></i> ID de Personal</label></div>
						<div class="col-lg-8"><input type="text" class="form-control" id="teidpersonal" value="<?php echo $datos_personal[0];?>" readonly></div>
					</div>
					<div class="form-group">
						<div class="col-lg-4"><label for="nombrepersonal" class="control-label"><i class="glyphicon glyphicon-user"></i> Nombre</label></div>
						<div class="col-lg-8"><input type="text" class="form-control" value="<?php echo utf8_encode($datos_personal[1]);?>"></div>
					</div>
				</div>
				<div class="modal-footer" style="margin-top:50px;">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button id="frm-elimiar" type="submit" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Eliminar</button>
				</div>
				<?php endif;?>
		</div>
	</div>
</div>
