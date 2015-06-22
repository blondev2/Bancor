function array_a_json (selector) {
	var ary = $(selector).serializeArray();
	var obj = {};
	for (var a = 0; a < ary.length; a++) obj[ary[a].name] = ary[a].value;
	return obj;
}
function mostrar_personal(tabla){
	$.ajax({
		url: '../aplicacion/controlador.php',
		type: 'post',
		data: {consulta:'trabajadores'},
		success: function (data) {
			var trabajadores=$.parseJSON(data);
			$(tabla).empty();
			if(trabajadores.status!='FALSE'){
				$.each(trabajadores, function(index, persona) {
					if(trabajadores[index].id){
						var boton_mod="<button type='button' class='btn btn-warning btn-sm btn-edit'><i class='glyphicon glyphicon-pencil'></i></button>";
						var boton_del="<button type='button' class='btn btn-danger btn-sm btn-del'><i class='glyphicon glyphicon-trash'></i></button>"
						$(tabla).append("<tr data-id="+persona.id+"><td>"+persona.nombre+"</td><td>"+persona.area+"</td><td>"+boton_mod+"</td><td>"+boton_del+"</td></tr>");
					}
				});
			}
			else{
				$(tabla).append("<tr><td>No hay personal registrado</td></tr>");
			}
		},
		error:function(x,h,r){
			console.log("Algo anda mal en mostrar_personal");
		}
	});
}
function mostar_personal_comodin(tabla,fecha_c,celda_C){
	$.ajax({
			url: '../aplicacion/controlador.php',
			type: 'post',
			data: {consulta:'comodines',fecha:fecha_c,celda:celda_C},
			success: function (data) {
				console.log(data);
				var comodines=$.parseJSON(data);
				$(tabla).empty();
				if(comodines.status!="FALSE"){
					$.each(comodines, function(index, persona) {
						if(comodines[index].id){
							var asistencia="<select id=selectcomodin"+persona.id+" class='form-control' style='width:100%'><option>Asistencia</option><option>Falta</option><option>Permiso</option><option>Incapacidad</option></select>";
							var celda="<select id=selectceldacomodin"+persona.id+" class='form-control' style=''width:100%><option value=1>Celda 1</option><option value=2>Celda 2</option><option value=3>Celda 3</option><option value=4>Celda 4</option><option value=5>Celda 5</option><option value=6>Celda 6</option><option value=7>Celda 7</option><option value=8>Celda 8</option><option value=T>Tampografía</option></select>";
							$(tabla).append("<tr data-id="+persona.id+"><td><input type='checkbox' id=check"+persona.id+"></td><td>"+persona.id+"</td><td>"+persona.nombre+"</td><td>"+asistencia+"</td><td>"+celda+"</td></tr>").fadeIn(3000);
						}
					});
				}
				else{
					$(tabla).append("<tr><td>No hay personal comodín.</td></tr>").fadeIn(3000);
				}
			},
			error:function(x,h,r){
				console.log("El formato JSON para comodines no es correcto");
			}
		});
}
function mostrar_personal_celda(tabla,celda_valor){
	$.ajax({
		url: '../aplicacion/controlador.php',
		type: 'post',
		data: {consulta:'trabajadores_celda',celda:celda_valor},
		success: function (data) {
			var datos=$.parseJSON(data);
			$(tabla).empty();
			if(datos.status!="FALSE"){
				$.each(datos, function(index, persona) {
					if(datos[index].id){
						var asistencia="<select id=select"+persona.id+" class='form-control' style='width:100%'><option value='A'>Asistencia</option><option value='F'>Falta</option><option value='P'>Permiso</option><option value='I'>Incapacidad</option></select>";
						var celda="<select id=selectcelda"+persona.id+" class='form-control' style=''width:100%><option value=1>Celda 1</option><option value=2>Celda 2</option><option value=3>Celda 3</option><option value=4>Celda 4</option><option value=5>Celda 5</option><option value=6>Celda 6</option><option value=7>Celda 7</option><option value=8>Celda 8</option><option value=T>Tampografía</option></select>";
						$(tabla).append("<tr data-id="+persona.id+"><td>"+persona.id+"</td><td>"+persona.nombre+"</td><td>"+asistencia+"</td><td>"+celda+"</td></tr>").fadeIn(3000);
					}
				});
			}
			else{
				$(tabla).append("<tr><td>No hay personal para la celda "+celda_valor+"</td></tr>");
			}
		},
		error:function(x,h,r){
			console.log(x,h,r);
		}
	});
}
function mostrar_asistencias(fecha_as,celda_as){
	$.ajax({
			url: '../aplicacion/controlador.php',
			type: 'post',
			data: {consulta:'mostrar_asistencias',fecha:fecha_as,celda:celda_as},
			success: function (data) {
				var asis=$.parseJSON(data);
				var tabla=$('#tabla_r_asistencias');
				tabla.empty();
				if(asis.status!='FALSE'){
					$('#tabla_personal_celda').empty();
					$('#tabla_comodines').empty();
					$.each(asis, function(index, val) {
						if(asis[index].id){
							tabla.append("<tr><td>"+val.id+"</td><td>"+val.nombre+"</td><td>"+val.estado+"</td></tr>");	
						}
					});
				}
				else{
					mostrar_personal_celda($('#tabla_personal_celda'),celda_as);
					mostar_personal_comodin($('#tabla_comodines'),fecha_as,celda_as);
					tabla.append("<tr><td>No has pasado lista para el dia "+fecha_as+" en la celda "+celda_as+"</td></tr>");
				}
			},error:function(x,h,r){
				console.log("Algo anda mal con el JSON de asistencias");
			}
		});
}
$(function () {
	/*Fecha de Hoy*/
	document.getElementById('fecha').valueAsDate = new Date()
	//mostrar_personal_celda($('#tabla_personal_celda'),$('#select_celda').val());
	//mostar_personal_comodin($('#tabla_comodines'));
	mostrar_asistencias($('#fecha').val(),$('#select_celda').val());
	/*AGREGAR*/
	$('#frm_nuevo_personal').submit(function(event){
		if(this.checkValidity()){
			event.preventDefault();
			t=array_a_json($(this));
			t['consulta']='registrar_personal';
			$.ajax({
				url: '../aplicacion/controlador.php',
				type: 'post',
				data:t,
				success: function (data) {
					if(data=='TRUE'){
						$('#modal-nuevo-personal').modal('hide');
						$('input.form-control:text').val('');
						 mostrar_personal('#tabla_personal');	
					}
					else{
						alert('no se pudo agregar el personal');
					}
				},
				error:function(x,h,r){
					console.log(x+h+r);
				}
			});
		}
	});
	/*Mostrar Modal EDITAR*/
	$('#tabla_personal').on('click','.btn-edit', function (e) {
		var id=$(e.target).closest('tr').data('id');
		$.ajax({
			url: '../aplicacion/mod_del.php',
			type: 'post',
			data: {peticion:'Editar',idpersonal:id},
			success: function (data) {
				$('#div-modal-mod-del').empty().append(data);
				$('#modal-mod-del').modal('show');
			},
			error:function(x,h,r){
				console.log(x+h+r);
			}
		});
	});
	/*Editar Personal*/
	$(document).on('click','#frm-editar',function(){
		$.ajax({
			url: '../aplicacion/controlador.php',
	   		type: 'post',
	   		data: {consulta:'editar_personal',idpersonal:$('#tidpersonal').val(),nombre:$('#nombrepersonal').val(),area:$('#slcarea').val()},
	   		success: function (data) {
	   			if(data=='TRUE'){
	   				alert('El personal se modifico');
	   				$('#modal-mod-del').modal('hide');
	   				mostrar_personal('#tabla_personal');
	   			}
	   			else{
	   				alert('No se pudo modificar los datos del personal');
	   			}
	   		},
	   		error:function(x,h,r){
	   			console.log("Error al tratar de actualizar al personal"+x+h+r);
	   			return false;
	   		}
	   	});
	});
	/*Mostrar Modal ELIMINAR*/
	$('#tabla_personal').on('click','.btn-del', function (e) {
			var id=$(e.target).closest('tr').data('id');
			$.ajax({
				url: '../aplicacion/mod_del.php',
				type: 'post',
				data: {peticion:'Eliminar',idpersonal:id},
				success: function (data) {
					$('#div-modal-mod-del').empty().append(data);
					$('#modal-mod-del').modal('show');
				},
				error:function(x,h,r){
					console.log(x+h+r);
				}
			});
	});
	/*Eliminar Personal*/
	$(document).on('click','#frm-elimiar',function(){
		$.ajax({
			url: '../aplicacion/controlador.php',
			type: 'post',
			data: {consulta:'eliminar_personal',idpersonal:$('#teidpersonal').val()},
			success: function (data) {
				if(data=='TRUE'){
					alert('El personal se elimino');
			   		$('#modal-mod-del').modal('hide');
			   		mostrar_personal('#tabla_personal');
			   		mostar_personal_comodin($('#tabla_comodines'));
		   		}
		   		else{
		   			alert('No se pudo eliminar al personal');
		   		}
			},
			error:function(x,h,r){
				console.log("Error al tratar de eliminar al personal");
			}
		});
	});
	/*DELETE*/
	$('#tabla_personal').on('click','.btn-del', function (e) {
		var id=$(e.target).closest('tr').data('id');
	});
	/*CAMBIO DE CELDA*/
	$('#select_celda').on('change', function() {
		var celda=$(this).val();
		var fecha=$('#fecha').val();
		mostrar_asistencias(fecha,celda);
  		//mostrar_personal_celda($('#tabla_personal_celda'),celda);
  		//mostar_personal_comodin($('#tabla_comodines'));
	});
	/*CAMBIO FECHA*/
	$('#fecha').on('change',function(){
		var celda=$('#select_celda').val();
		var fecha=$(this).val();
		mostrar_asistencias(fecha,celda);
	});
	/*Cambio de TAB*/
	$('a[data-toggle="tab"]').click(function (e) {
		e.preventDefault();
		mostrar_personal('#tabla_personal');
	  	//mostrar_personal_celda($('#tabla_personal_celda'),$('#select_celda').val());
	  	//mostar_personal_comodin($('#tabla_comodines'));
	});

	/*Pasar Asistencia*/
	$('#pasar_asistencia').click(function (e) {
		var fecha=$('#fecha').val();
		$('#tabla_personal_celda tr').each(function(indextr) {
			var id,nombre,asistencia,celda;
			$(this).children('td').each(function(indextd) {
				switch(indextd){
					case 0:id=$(this).text();
					break;
					case 1:nombre=$(this).text();
					break;
					case 2:asistencia=$('#select'+id).val();
					break;
					case 3:celda=$('#selectcelda'+id).val();
				}
			});
			alert("Renglon "+indextr+" ID:"+id+ " nombre: "+nombre+" asistencia "+asistencia+"celda "+celda);
		});
		$('#tabla_comodines tr').each(function(indextrc) {
			var idc,nombrec,asistenciac,celda;
			$(this).children('td').each(function(indextdc) {
				switch(indextdc){
					case 0:idc=$(this).text();break;
					case 1:nombrec=$(this).text();break;
					case 2:asistenciac=$('#selectcomodin'+idc).val();break;
					case 3:celda=$('#selectceldacomodin'+idc).val();break;
				}
			});
			alert("COMODIN Renglon "+indextrc+" ID:"+idc+ " nombre: "+nombrec+" asistencia "+asistenciac+"celda "+celda);
		});
	});
});
