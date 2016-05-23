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
			<?PHP
				//comenzamos recogiendo los datos
				function recogeDato($campo){ 
				return isset($_REQUEST[$campo])?$_REQUEST[$campo]:'';
				} //la función recogeDatos comprueba si se ha recibido un dato y recoge su valor
		   
				//si no se ha recibido, le asigna un valor vacío.
				$nombre 	= recogeDato('nombre');
				$apellidos 	= recogeDato('apellidos');
				$email1	 	= recogeDato('email1');
				$email2	 	= recogeDato('email2');
				$pwVieja 	= recogeDato('claveVieja');
				$pw1 		= recogeDato('clave1');
				$pw2 		= recogeDato('clave2');
				$web		= recogeDato('web');
				$comentario = recogeDato('comentario');
											
				$resultado = mysql_query("SELECT * FROM Profesor WHERE dniprofesor=$dni", $conexion);
				$nfilas = mysql_num_rows($resultado);
				$fila = mysql_fetch_assoc($resultado);
				
				$algunerror = FALSE;
			
				$error_nombre = "";
				$error_apellidos = "";
				$error_email1 = "";
				$error_email2 = "";
				$error_pw = "";
				$error_pw1 = "";
				$error_pw2 = "";
		   
				if (isset($_REQUEST['enviadoEditar']))
				{
					if($email1!=$email2)
					{ //si tiene algo, que coincida con la repetición
						$algunerror = TRUE;
						$error_email2 = '<br><span class="erroneo"><br>No coinciden</span>';
					}
					if($pw1!='' && $pwVieja=='')
					{ //comprobamos que el contenido de la pw no esté vacío
						$algunerror = TRUE;
						$error_pw = '<br><span class="erroneo">Campo requerido</span>';
					}
					else
					{
						if($pw1!=$pw2)
						{ //si tiene algo, que coincida con la repetición
							$algunerror = TRUE;
							$error_pw2 = '<br><span class="erroneo"><br>No coinciden</span>';
						}
						elseif($pwVieja!=$fila['password'] && $pwVieja!='')
						{
							$algunerror = TRUE;
							$error_pw = '<br><span class="erroneo">Contraseña erronea</span>';
						}
					}
				}
				else
				{
					// Si no se ha enviado todavía el formulario hay que coger los datos de la BD
					$nombre 	= $fila['nombre'];
					$apellidos 	= $fila['apellidos'];
					$web		= $fila['weblink'];
					$comentario = $fila['acercademi'];
					$email1 = $email2 = $pwVieja = $pw1 = $pw2 = '';
				}
			   
				if (isset($_REQUEST['enviadoEditar'])&&!$algunerror)
				{
					echo '<div class="aviso">todo correcto</div>';
					
					if($nombre!=$fila['nombre'] && $nombre!='')
					{
						$sql = "UPDATE Profesor SET nombre='$nombre' WHERE dniprofesor=$dni";					
						mysql_query($sql, $conexion);
					}
					if($apellidos!=$fila['apellidos'] && $apellidos!='')
					{
						$sql = "UPDATE Profesor SET apellidos='$apellidos' WHERE dniprofesor=$dni";	
						mysql_query($sql, $conexion);
					}
					if($email1!=$fila['email'] && $email1!='')
					{
						$sql = "UPDATE Profesor SET email='$email1' WHERE dniprofesor=$dni";	
						mysql_query($sql, $conexion);
					}
					if($pw1!=$fila['password'] && $pw1!='')
					{
						$sql = "UPDATE Profesor SET password='$pw1' WHERE dniprofesor=$dni";	
						mysql_query($sql, $conexion);
					}
					if($web!=$fila['weblink'] && $web!='')
					{
						$sql = "UPDATE Profesor SET weblink='$web' WHERE dniprofesor=$dni";	
						mysql_query($sql, $conexion);
					}
					if($comentario!=$fila['acercademi'] && $comentario!='')
					{
						$sql = "UPDATE Profesor SET acercademi='$comentario' WHERE dniprofesor=$dni";	
						mysql_query($sql, $conexion);
					}
					
					echo "<script language='JavaScript'>";
					echo "location = 'personalProfesor.php'";
					echo "</script>";
				} 
				else 
				{
					if (isset($_REQUEST['enviadoEditar']))
					{
						echo '<div class="aviso">Por vavor, corrige los siguientes errores:</div>';
					} 
					else 
					{
						echo '<div class="aviso">Por favor, rellene este formulario para continuar:</div>';
					}
				}
			   ?>
			<div class="tituloConMenu">PÁGINA PERSONAL DE PROFESOR</div>
			<table ALIGN="center" class="tabla_registro"> 
				<tr> 
					<td>
						<FORM ALIGN="right" id="login" ACTION="personalProfesorEditar.php" METHOD="POST">
							Nombre: <INPUT TYPE="text" NAME="nombre" VALUE="<?=$nombre?>"> <?=$error_nombre;?>
							<br>
							Apellidos: <INPUT TYPE="text" NAME="apellidos" VALUE="<?=$apellidos?>"> <?=$error_apellidos;?>
							<br>
							Correo electrónico (preferiblamente UGR): <INPUT TYPE="text" NAME="email1" VALUE="<?=$email1?>"> <?=$error_email1;?>
							<br>
							Repita el correo eletrónico: <INPUT TYPE="text" NAME="email2" VALUE="<?=$email2?>"> <?=$error_email2;?>
							<br>
							Contraseña actual: <INPUT TYPE="password" NAME="claveVieja"> <?=$error_pw;?>
							<br>
							Nueva Contraseña: <INPUT TYPE="password" NAME="clave1"> <?=$error_pw1;?>
							<br>
							Repite nueva Contraseña: <INPUT TYPE="password" NAME="clave2"> <?=$error_pw2;?>
							<br>	
							WEB: <INPUT TYPE="text" NAME="web" VALUE="<?=$web?>">
							<br>
							<textarea name="comentario" rows="10" cols="40"><?=$comentario;?></textarea>
							<br>
							<INPUT TYPE="submit" NAME="enviadoEditar" VALUE="Aceptar" class="button medium orange">
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