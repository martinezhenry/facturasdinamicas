
$( document ).ready(function() {
    console.log( "ready!" );	
	$('#guardar_edit').hide();
	$('#rif').keyup(function(){
		var x = document.getElementById("rif");							
		x.value = x.value.toUpperCase();		
	});		
	
	$('#guardar').on('click',function(){
		var rif = $('#rif').val();
		var razon_social = $('#razon_social').val();
		var dir = $('#dir').val();
		var telefono = $('#telefono').val();
		var args = {'rif' : rif,'razon_social' : razon_social, 'direccion': dir, 'telefono':telefono}
		console.log(args);
		jQuery.ajax({
			type: "POST",
			url: 'controller/crud.php',
			dataType: 'json',
			data: {functionname: 'agregar_cliente', arguments:args},
			success: function (obj, textstatus){
				if(!('error' in obj)){															
					console.log(obj.result);
				}else{
					console.log(obj.error);
					$('#msg .modal-body').html(obj.error);
					$('#msg').addClass('error');
					$('#msg').modal();
					/*$('#msg').html(obj.error);
					$('#mesaje').modal();*/
				}
			}
		});							
	});
	
	$('#guardar_edit').on('click',function(){
		var rif = $('#rif').val();
		var razon_social = $('#razon_social').val();
		var dir = $('#dir').val();
		var telefono = $('#telefono').val();
		var args = {'rif' : rif,'razon_social' : razon_social, 'direccion': dir, 'telefono':telefono}
		console.log(args);
		jQuery.ajax({
			type: "POST",
			url: 'controller/crud.php',
			dataType: 'json',
			data: {functionname: 'editar_cliente', arguments:args},
			success: function (obj, textstatus){
				if(!('error' in obj)){															
					console.log(obj.result);
					console.log(obj.query);
				}else{
					console.log(obj.error);
					console.log(obj.query);
					$('#msg .modal-body').html(obj.error);
					$('#msg').addClass('error');
					$('#msg').modal();					
				}
			}
		});							
	});
	
	$('#guardar').on('click',function(){
		var rif = $('#rif').val();
		var razon_social = $('#razon_social').val();
		var dir = $('#dir').val();
		var telefono = $('#telefono').val();
		var args = {'rif' : rif,'razon_social' : razon_social, 'direccion': dir, 'telefono':telefono}
		console.log(args);
		jQuery.ajax({
			type: "POST",
			url: 'controller/crud.php',
			dataType: 'json',
			data: {functionname: 'agregar_cliente', arguments:args},
			success: function (obj, textstatus){
				if(!('error' in obj)){															
					console.log(obj.result);
					console.log(obj.query);
				}else{
					console.log(obj.error);
					console.log(obj.query);
					$('#msg .modal-body').html(obj.error);
					$('#msg').addClass('error');
					$('#msg').modal();					
				}
			}
		});							
	});
	
	$('#consultar').on('click', function(){
		console.log('Consultar todos los clientes');
		var rif = $('#rif').val();
		if($('#rif').val()==0){
			$('#msg .modal-body').html("Debe ingresar el Rif de la Empresa a Consultar");
			$('#msg').addClass('error');
			$('#msg').modal();			
		}else{
			var args = {'rif' : rif}			
			jQuery.ajax({
				type: "POST",
				url: 'controller/crud.php',
				dataType: 'json',
				data: {functionname: 'buscar_cliente', arguments:args},			
				success: function (obj, textstatus){
					if(!('error' in obj)){							
						console.log(obj.result);
						console.log(obj.query);
						$('#rif').val(obj.result['rif']);
						$("#razon_social").val(obj.result['RAZON_SOCIAL']);
						$('#dir').val(obj.result['DIRECCION']);
						$('#telefono').val(obj.result['TELEFONO']); 
						$('#guardar_edit').show();
						$('#guardar').hide();
						$('#rif').prop('disabled', true);
						/*$('#razon_social').val = "HOLA";*/
					}else{
						console.log(obj.error);	
						console.log(obj.query);
						$('#msg .modal-body').html(obj.error);
						$('#msg').addClass('error');
						$('#msg').modal();
					}
				}
			});				
		}				
	});
});

