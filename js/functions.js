$(document).ready(function()
{
	//sistemaOperativo();

	$( "#btn_password" ).click(function() {
	  validacion();
	});

});

function sistemaOperativo()
{
	var OSName="Unknown OS";
	if (navigator.appVersion.indexOf("Win")!=-1) OSName="Windows";
	if (navigator.appVersion.indexOf("Mac")!=-1) OSName="MacOS";
	if (navigator.appVersion.indexOf("X11")!=-1) OSName="UNIX";
	if (navigator.appVersion.indexOf("Linux")!=-1) OSName="Linux";

	if (OSName != 'Linux')
	{
		$('#div_contenedor').css('display','none');
		$('#modal').css('display','block');
		$('#contenido-modal').html('<b>Lo sentimos, <br> Su dispositivo no es compatible.</b>');
		$('#resultado-modal').html('<button id="btn_modal" class="btn-modal" onClick="cerrar_modal()">Aceptar</button>');
	}
}

function cerrar_modal()
{
	$('#modal').css('display','none');
}

function validacion()
{
	var usuario = $( "#inp_usuario" ).val();
	var password = $( "#inp_password" ).val();
	if(password.length > 3 && usuario.length > 3)
	{
		descargar(usuario,password);
	}
	else
	{
		$('#modal').css('display','block');
		$('#titulo-modal').text('');
		$('#contenido-modal').text('Verifique los datos ingrese.');
		$('#resultado-modal').html('<button id="btn_modal" class="btn-modal" onClick="cerrar_modal()">Aceptar</button>');
		$('.inp_contenedor').val('');
	}
}

function descargar(usuario,password)
{
	$.ajax({
	  method: "POST",
	  url: "php/Consult.php",
	  data: { data_usuario: usuario, data_password: password, action: 'searchUser'}
	})
	.done(function( msg ) 
	{
		if(msg.length == 0)
		{
			$('#modal').css('display','block');
			$('#titulo-modal').text('');
			$('#contenido-modal').text('Usuario y/o contraseña invalida.');
			$('#resultado-modal').html('<button id="btn_modal" class="btn-modal" onClick="cerrar_modal()">Aceptar</button>');
			$('.inp_contenedor').val('');
		}
		else
		{
			$('#modal').css('display','block');
			$('#titulo-modal').html('<i>Instrucciones para instalar apk</i>');
			$('#contenido-modal').html('<ol type="1" style="padding-left:10px"><li>En el menú principal seleccione <b>Ajustes</b></li><li>Seleccione <b>Seguridad</b></li><li>Active la opción de <b>"ORIGENES DESCONOCIDOS"</b><li>Seleccione <b>Aceptar</b><li>Descargue la aplicación e instale en el dispositivo móvil</li></ol>');
			$('#resultado-modal').html('<a class="btn-modal" href="'+msg+'" donwload>descargar</a>');
		}
	});
}

