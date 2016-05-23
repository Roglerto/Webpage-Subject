<?PHP
	session_start();
	if(isset($_SESSION['DNI']))
	{
		if($_SESSION['TIPO']=='alumno')
			header('Location: personalAlumno.php');
		elseif($_SESSION['TIPO']=='profesor' || $_SESSION['TIPO']=='gestor' )
			header('Location: personalprofesor.php');
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  	<title>SIBW</title>
  	<link rel="stylesheet" href="estiloPortada.css">
</head>

<body>
<div id="body_wrapper">
	<div id="pan_superior">
		<table align="center"> 
			<tr> 
				<td>
					<IMG SRC="logoLSI.png" height="63" align="middle">
				</td>
			</tr>
		</table>
	</div>
	<!-- Contenido principal -->
	<div id="pan_central">
			<table ALIGN="center" class="tabla_login"> 
			<tr>
				<td> 
					<IMG SRC="logo_ugr.jpg" ID="logo_login" WIDTH=350 HEIGHT=100>	
				</td> 
			</tr> 
			<tr> 
				<td>
					<FORM ALIGN="right" ID="login" ACTION="./log/procesarLogin.php" METHOD="POST">
						ID (DNI/pasaporte): <INPUT TYPE="text" NAME="id">
						<br>
						Contraseña: <INPUT TYPE="password" NAME="clave">
						<br>
						<INPUT TYPE="submit" NAME="enviar" VALUE="Aceptar" class="button small orange">
					</FORM>
				</td>
			</tr>
			<tr>
				<td align="CENTER">
					<a href="./log/recuperarContrasena.php">¿Ha olvidado su contraseña?</a>
				</td>
			</tr>
			</table>
	</div>
	
	<!-- Firma y fecha de la página, ¡sólo por cortesía! -->
	<div id="pan_inferior">
		<p>SIBW 2012-2013</p>
	</div>
</div>
</body>
</html>