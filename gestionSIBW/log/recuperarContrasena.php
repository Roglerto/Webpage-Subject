<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>SIBW</title>
	<link rel="stylesheet" href="../estiloPortada.css">
	<script>
		function alerta()
		{
			alert("Su correo llegará en unos minutos. Gracias.");
			window.location.href='../index.php';
		}
	</script>
</head>

<body>
	<div id="body_wrapper">
		<div id="pan_superior">
			<table align="center"> 
			<tr> 
				<td>
					LOGO DE SIBW	
				</td>
			</tr>
			</table>
		</div>
		
		<div id="pan_central">
			
			<table ALIGN="center" class="tabla_login">
				<tr>
					<td>
						Si ha olvidado su contraseña podrá recibir una nueva al correo que escribió en su ficha personal
					</td>
				</tr>
				<tr>
					<td>
						<FORM ALIGN="right" ID="login" ACTION="enviarCorreo.php" METHOD="POST">
							ID (DNI/pasaporte): <INPUT TYPE="text" NAME="id">
							<br>
							<INPUT TYPE="button" onClick="alerta()" VALUE="Enviar nueva contraseña" class="button small orange">
						</FORM>
					</td>
				</tr>
			</table>
		</div>
		<div id="pan_inferior">
			<p>SIBW 2012-2013</p>
		</div>
	</div>
</body>
</html>
