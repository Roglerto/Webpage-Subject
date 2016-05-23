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
				
				$nombre 	= recogeDato('nombre');
				$apellidos 	= recogeDato('apellidos');
				$email1	 	= recogeDato('email1');
				$email2	 	= recogeDato('email2');
				$web		= recogeDato('web');
				$pwVieja 	= recogeDato('claveVieja');
				$pw1 	= recogeDato('clave1');
				$pw2 	= recogeDato('clave2');
				$comentario = recogeDato('comentario');
				
				$tipo 		= $_SESSION['TIPO'];
				$dni 		= $_SESSION['DNI'];
				
				$conexion = mysql_connect('127.0.0.1:3306', 'root', '');
				mysql_select_db(getbdcurso(), $conexion);
				
				if(!$conexion)
				{
					die("Fallo en la conexión MYSQL: " . mysql_error());
				}
				
				$resultado = mysql_query("SELECT * FROM Alumno WHERE dnialumno=$dni", $conexion);
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
					if(strlen($email1) > 15)
					{
						if(!strpos  ( $email1, "correo.ugr.es"))
						{ //validamos los que el email no esté vacio
								$algunerror = TRUE;
								$error_email1 = '<br><span class="erroneo">Correo erroneo</span>';
						}  
						elseif($email1!=$email2)
						{ //si tiene algo, que coincida con la repetición
							$algunerror = TRUE;
							$error_email2 = '<br><span class="erroneo"><br>No coinciden</span>';
						}
					}
					elseif($email1!='')
					{ //validamos los que el email no esté vacio
								$algunerror = TRUE;
								$error_email1 = '<br><span class="erroneo">Correo erroneo</span>';
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
					$nombre 	= $fila['nombrealumnoa'];
					$apellidos 	= $fila['apellidos'];
					$web		= $fila['weblink'];
					$comentario = $fila['acercademi'];
					$email1 = $email2 = $pwVieja = $pw1 = $pw2 = '';
				}
				
				if (isset($_REQUEST['enviadoEditar'])&&!$algunerror)
				{
					echo '<div class="aviso">todo correcto</div>';
					//HAY QUE METER EN LA BASE DE DATOS LOS DATOS Y PASAR A LA SIGUIENTE WEB (MENU PROFESOR O MENU ALUMNO)
				
					if($nombre!=$fila['nombrealumnoa'] && $nombre!='')
					{
						$sql = "UPDATE Alumno SET nombrealumnoa='$nombre' WHERE dnialumno=$dni";					
						mysql_query($sql, $conexion);
					}
					if($apellidos!=$fila['apellidos'] && $apellidos!='')
					{
						$sql = "UPDATE Alumno SET apellidos='$apellidos' WHERE dnialumno=$dni";	
						mysql_query($sql, $conexion);
					}
					if($email1!=$fila['email'] && $email1!='')
					{
						$sql = "UPDATE Alumno SET email='$email1' WHERE dnialumno=$dni";	
						mysql_query($sql, $conexion);
					}
					if($pw1!=$fila['password'] && $pw1!='')
					{
						$sql = "UPDATE Alumno SET password='$pw1' WHERE dnialumno=$dni";	
						mysql_query($sql, $conexion);
					}
					if($web!=$fila['weblink'] && $web!='')
					{
						$sql = "UPDATE Alumno SET weblink='$web' WHERE dnialumno=$dni";	
						mysql_query($sql, $conexion);
					}
					if($comentario!=$fila['acercademi'] && $comentario!='')
					{
						$sql = "UPDATE Alumno SET acercademi='$comentario' WHERE dnialumno=$dni";	
						mysql_query($sql, $conexion);
					}
					
					echo "<script language='JavaScript'>";
					echo "location = 'personalAlumno.php'";
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
			<div class="tituloConMenu">PÁGINA PERSONAL DE ALUMNO</div>
			<table ALIGN="center" class="tabla_registro"> 
				<tr> 
					<td>
						<FORM ALIGN="right" id="login" ACTION="personalAlumnoEditar.php" METHOD="POST">
							Nombre: <INPUT TYPE="text" NAME="nombre" VALUE="<?=$nombre?>"> <?=$error_nombre;?>
							<br>
							Apellidos: <INPUT TYPE="text" NAME="apellidos" VALUE="<?=$apellidos?>"> <?=$error_apellidos;?>
							<br>
							Correo electrónico UGR (ej: XXXX@correo.ugr.es): <INPUT TYPE="text" NAME="email1" VALUE="<?=$email1?>"> <?=$error_email1;?>
							<br>
							Repita el correo eletrónico: <INPUT TYPE="text" NAME="email2" VALUE="<?=$email2?>"> <?=$error_email2;?>
							<br>
							WEB: <INPUT TYPE="text" NAME="web" VALUE="<?=$web?>">
							<br>
							Contraseña actual: <INPUT TYPE="password" NAME="claveVieja"> <?=$error_pw;?>
							<br>
							Nueva Contraseña: <INPUT TYPE="password" NAME="clave1"> <?=$error_pw1;?>
							<br>
							Repite nueva Contraseña: <INPUT TYPE="password" NAME="clave2"> <?=$error_pw2;?>
							<br>
							<br>
							<textarea NAME="comentario" rows="10" cols="40"><?=$comentario;?></textarea>
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