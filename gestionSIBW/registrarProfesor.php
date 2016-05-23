<?PHP
	include 'conexion.php';
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
		<?PHP
			include 'menu.php';
		?>
		<div id="pan_central">
			<?php 
				//comenzamos recogiendo los datos
				function recogeDato($campo){
					return isset($_REQUEST[$campo])?$_REQUEST[$campo]:'';
				} //la función recogeDatos comprueba si se ha recibido un dato y recoge su valor
				
				//si no se ha recibido, le asigna un valor vacío.
				$dniProf	= recogeDato('dniProf');
				$nombre 	= recogeDato('nombre');
				$apellidos 	= recogeDato('apellidos');
				$email1	 	= recogeDato('email1');
				$email2	 	= recogeDato('email2');
				$pw1 		= recogeDato('clave1');
				$pw2 		= recogeDato('clave2');
				$web		= recogeDato('web');
				$comentario = recogeDato('comentario');
				
				$algunerror = FALSE;

				$error_dni = "";
				$error_nombre = "";
				$error_apellidos = "";
				$error_email1 = "";
				$error_email2 = "";
				$error_pw1 = "";
				$error_pw2 = "";
				
				if (isset($_REQUEST['enviadoProfesor']))
				{
					if($dniProf=='')
					{ //comprobamos que el contenido del dni no esté vacío
						$algunerror = TRUE;
						$error_dni = '<br><span class="erroneo">Campo requerido</span>';						
					}
					if($email1!=$email2)
					{ //si tiene algo, que concida con la repetición
						$algunerror = TRUE;
						$error_email2 = '<br><span class="erroneo">No coinciden los e-mail</span>';
					}
					if($pw1=='')
					{ //comprobamos que el contenido de la pw no esté vacío
						$algunerror = TRUE;
						$error_pw1 = '<br><span class="erroneo">Campo requerido</span>';
					}
					elseif($pw1!=$pw2)
					{ //si tiene algo, que concida con la repetición
						$algunerror = TRUE;
						$error_pw2 = '<br><span class="erroneo">No coincidieron las contraseñas</span>';
					}
				}
				
				if (isset($_REQUEST['enviadoProfesor'])&&!$algunerror)
				{		
					$conexion = mysql_connect('127.0.0.1:3306', 'root', '');
					mysql_select_db(getbdcurso(), $conexion);
						
					if(!$conexion)
					{
						die("Fallo en la conexión MYSQL: " . mysql_error());
					}
					
					$sql = "INSERT INTO Profesor VALUES ('$dniProf', '$nombre', '$apellidos', '$email1', '$pw1', FALSE, '$web', '$comentario')";
						
					$realizadoSQL=mysql_query($sql, $conexion);
					
					if($realizadoSQL==1){
						echo '<div class="aviso">Profesor registrado correctamente</div>';
					} else {
						echo '<div class="aviso">Se produjo un problema al registrar al profesor, puede que ya exista un profesor con ese DNI</div>';
					}
				}
				else
				{
					if (isset($_REQUEST['enviadoProfesor']))
					{
						echo '<div class="aviso">Por favor, corrige los siguientes errores:</div>';
					}
				}
				 
			?>
			<div class="tituloConMenu">REGISTRO DE UN PROFESOR</div>
			<table ALIGN="center" class="tabla_registro"> 
				<tr> 
					<td>
						<FORM ALIGN="right" id="login" ACTION="registrarProfesor.php" METHOD="POST">
							<font color="#FF0000"><sup>*</sup></font>DNI: <INPUT TYPE="text" NAME="dniProf" VALUE="<?=$dniProf?>"> <?=$error_dni;?>
							<br>
							Nombre: <INPUT TYPE="text" NAME="nombre" VALUE="<?=$nombre?>"> <?=$error_nombre;?>
							<br>
							Apellidos: <INPUT TYPE="text" NAME="apellidos" VALUE="<?=$apellidos?>"> <?=$error_apellidos;?>
							<br>
							Correo electrónico: <INPUT TYPE="text" NAME="email1" VALUE="<?=$email1?>"> <?=$error_email1;?>
							<br>
							Repita el correo eletrónico: <INPUT TYPE="text" NAME="email2" VALUE="<?=$email2?>"> <?=$error_email2;?>
							<br>
							<font color="#FF0000"><sup>*</sup></font>Contraseña: <INPUT TYPE="password" NAME="clave1"> <?=$error_pw1;?>
							<br>
							<font color="#FF0000"><sup>*</sup></font>Repita Contraseña: <INPUT TYPE="password" NAME="clave2"> <?=$error_pw2;?>
							<br>	
							WEB: <INPUT TYPE="text" NAME="web" VALUE="<?=$web?>">
							<br>
							<textarea name="comentario" rows="10" cols="40"><?=$comentario;?></textarea>
							<br>
							<font color="#FF0000"><sup>(*) Campos obligatorios</sup></font><br>
							<INPUT TYPE="submit" NAME="enviadoProfesor" VALUE="Aceptar" class="button medium orange">
						</FORM>
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
	