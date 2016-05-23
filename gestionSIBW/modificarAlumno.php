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
				$dniAlum	= recogeDato('dniAlum');
				$alum		= recogeDato('selectAlumno');
				$nombre 	= recogeDato('nombre');
				$apellidos 	= recogeDato('apellidos');
				$email1	 	= recogeDato('email1');
				$email2	 	= recogeDato('email2');
				$pw1 		= recogeDato('clave1');
				$pw2 		= recogeDato('clave2');
				$grupo		= recogeDato('grupo');
				$web		= recogeDato('web');
				$comentario = recogeDato('comentario');
				
				$algunerror = FALSE;

				$error_dni = "";
				$error_selectDNI = "";
				$error_nombre = "";
				$error_apellidos = "";
				$error_email1 = "";
				$error_email2 = "";
				$error_pw1 = "";
				$error_pw2 = "";
				$error_grupo = "";
				
				$sql = "";
				
				$conexion = mysql_connect('127.0.0.1:3306', 'root', '');
				mysql_select_db(getbdcurso(), $conexion);
				
				if(!$conexion)
				{
					die("Fallo en la conexión MYSQL: " . mysql_error());
				}
				
				
				if (isset($_REQUEST['enviadoEditar']))
				{
					if($dniAlum=='')
					{ //comprobamos que el contenido del dni no esté vacío
						$algunerror = TRUE;
						$error_dni = '<br><span class="erroneo">El DNI no puede estar vacío</span>';						
					}
					if($email1!=$email2)
					{ //si tiene algo, que concida con la repetición
						$algunerror = TRUE;
						$error_email2 = '<br><span class="erroneo">No coincidieron los e-mail</span>';
					}
					elseif($pw1!=$pw2)
					{ //si tiene algo, que concida con la repetición
						$algunerror = TRUE;
						$error_pw2 = '<br><span class="erroneo">No coincidieron las contraseñas</span>';
					}
					if($grupo=='')
					{ //comprobamos que se haya seleccionado un grupo
						$algunerror = TRUE;
						$error_dni = '<br><span class="erroneo">Campo de grupo requerido</span>';
					}
				}
				
				if (isset($_REQUEST['enviadoEditar']) && !$algunerror)
				{
					echo '<div class="avisoSinMenu">Edición realizada con éxito</div>';
					
					$resultado = mysql_query("SELECT * FROM Alumno WHERE dnialumno=$alum", $conexion);
					$nfilas = mysql_num_rows($resultado);
					$fila = mysql_fetch_assoc($resultado);
					
					if($nombre!=$fila['nombrealumnoa'] && $nombre!='')
					{
						$sql = "UPDATE Alumno SET nombrealumnoa='$nombre' WHERE dnialumno=$alum";
						mysql_query($sql, $conexion);
					}
					if($apellidos!=$fila['apellidos'] && $apellidos!='')
					{
						$sql = "UPDATE Alumno SET apellidos='$apellidos' WHERE dnialumno=$alum";
						mysql_query($sql, $conexion);
					}
					if($email1!=$fila['email'] && $email1!='')
					{
						$sql = "UPDATE Alumno SET email='$email1' WHERE dnialumno=$alum";
						mysql_query($sql, $conexion);
					}
					if($pw1!=$fila['password'] && $pw1!='')
					{
						$sql = "UPDATE Alumno SET password='$pw1' WHERE dnialumno=$alum";
						mysql_query($sql, $conexion);
					}
					if($web!=$fila['weblink'] && $web!='')
					{
						$sql = "UPDATE Alumno SET weblink='$web' WHERE dnialumno=$alum";
						mysql_query($sql, $conexion);
					}
					if($grupo!=$fila['nombre'] && $grupo!='')
					{
						$sql = "UPDATE Alumno SET nombre='$grupo' WHERE dnialumno=$alum";
						mysql_query($sql, $conexion);
					}
					if($comentario!=$fila['acercademi'] && $comentario!='')
					{
						$sql = "UPDATE Alumno SET acercademi='$comentario' WHERE dnialumno=$alum";
						mysql_query($sql, $conexion);
					}
					if($dniAlum!=$fila['dnialumno'] && $dniAlum!='')
					{
						$sql = "UPDATE Alumno SET dnialumno='$dniAlum' WHERE dnialumno=$alum";
						mysql_query($sql, $conexion);
						$alum = $dniAlum;
					}
					
					
				}
				else
				{
					if (isset($_REQUEST['enviadoEditar']))
					{
						echo '<div class="avisoSinMenu">Por favor, corrige los siguientes errores:</div>';
					}
				}
				 
			?>
			
			<?PHP
			if (!isset($_REQUEST['alumnoSeleccionado']) && !$algunerror) {
				?>
				<div class="tituloConMenu">SELECCIÓN DE UN ALUMNO</div>
				<table align="CENTER" class="tabla_registro">
					<tr>
						<td>
							<form ALIGN="right" action="modificarAlumno.php" METHOD="post">
								<?PHP
								$resultado = mysql_query("SELECT * FROM Alumno", $conexion);
								$nfilas = mysql_num_rows($resultado);
								?>
								Seleccione el alumno:<select name = "selectAlumno">
								<?PHP 
								while($fila = mysql_fetch_array($resultado))
								{
									$alum= $fila['dnialumno'];
									$nomAlum = $fila['nombrealumnoa'];
									$apellAlum = $fila['apellidos'];
									$grupAlum = $fila['nombre'];
									echo "<option value='$alum'>$alum - $nomAlum $apellAlum - $grupAlum</option>";								
								}
								?>
								</select>
								<?PHP $error_selectDNI?>
								<br>
								<INPUT TYPE="submit" NAME="alumnoSeleccionado" VALUE="Aceptar" class="button medium orange"> 
							</form>
						</td>
					</tr>
				</table>
				<?PHP 	
			} else {

				$resultado = mysql_query("SELECT * FROM Alumno WHERE dnialumno=$alum", $conexion);
				$nfilas = mysql_num_rows($resultado);
				$fila = mysql_fetch_assoc($resultado);
				
				$dniAlum	= $fila['dnialumno'];
				$nombre 	= $fila['nombrealumnoa'];
				$apellidos 	= $fila['apellidos'];
				$web		= $fila['weblink'];
				$comentario = $fila['acercademi'];
				$grupo		= $fila['nombre'];
				$email1 = $email2 = $fila['email'];
				$pw1 = $pw2 = '';
				?>
				<div class="tituloConMenu">MODIFICACIÓN DE UN ALUMNO</div>
				<table ALIGN="center" class="tabla_registro"> 
					<tr> 
						<td>
							<FORM ALIGN="right" id="login" ACTION="modificarAlumno.php" METHOD="POST">
								DNI: <INPUT TYPE="text" NAME="dniAlum" VALUE="<?=$dniAlum?>"> <?=$error_dni;?>
								<br>
								Nombre: <INPUT TYPE="text" NAME="nombre" VALUE="<?=$nombre?>"> <?=$error_nombre;?>
								<br>
								Apellidos: <INPUT TYPE="text" NAME="apellidos" VALUE="<?=$apellidos?>"> <?=$error_apellidos;?>
								<br>
								Correo electrónico: <INPUT TYPE="text" NAME="email1" VALUE="<?=$email1?>"> <?=$error_email1;?>
								<br>
								Repita el correo eletrónico: <INPUT TYPE="text" NAME="email2" VALUE="<?=$email2?>"> <?=$error_email2;?>
								<br>
								Contraseña: <INPUT TYPE="password" NAME="clave1"> <?=$error_pw1;?>
								<br>
								Repita Contraseña: <INPUT TYPE="password" NAME="clave2"> <?=$error_pw2;?>
								<br>
								<?PHP 
								$resultado = mysql_query("SELECT * FROM grupo", $conexion);
								$nfilas = mysql_num_rows($resultado);
								?>
								Grupo: <select name = "grupo">
								<?PHP 
								while($fila = mysql_fetch_array($resultado))
								{
									$grupos= $fila['nombre'];
									if($grupo == $grupos){ // Se selecciona por defecto el que tuviera el alumno
										echo "<option selected value='$grupos'>$grupos</option>";
									} else {
										echo "<option value='$grupos'>$grupos</option>";
									}								
								}
								?>
								</select>
								<?=$error_grupo?>
								<br>
								
								WEB: <INPUT TYPE="text" NAME="web" VALUE="<?=$web?>">
								<br>
								<textarea name="comentario" rows="10" cols="40"><?=$comentario;?></textarea>
								<br>
								<INPUT TYPE="hidden" NAME="selectAlumno" VALUE="<?=$alum?>">
								<INPUT TYPE="submit" NAME="enviadoEditar" VALUE="Aceptar" class="button medium orange">
							</FORM>
						</td>
					</tr>
				</table>
			<?PHP }?>
		</div>
		<!-- Firma y fecha de la página, ¡sólo por cortesía! -->
		<div id="pan_inferior">
			<p>SIBW 2012-2013</p>
		</div>
	</div>
</body>
</html>