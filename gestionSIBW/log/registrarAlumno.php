
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>SIBW</title>
	<link rel="stylesheet" href="../estiloPortada.css">
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
	
		<!--COMENTAR ESTO PARA QUE NO HAYA MENU-->
		<!--<div id="pan_izquierdo">
			<ul class="navbar">
				<li><a href="../../../../Users/cojonuo/Documents/Facultad/3º/2nd Cuatrimestre/SIBW/Codigos/indice.html">PAGINA PRINCIPAL</a></li>
				<li><a href="../../../../Users/cojonuo/Documents/Facultad/3º/2nd Cuatrimestre/SIBW/Codigos/meditaciones.html">MEDITACIONES</a></li>
				<li><a href="../../../../Users/cojonuo/Documents/Facultad/3º/2nd Cuatrimestre/SIBW/Codigos/ciudad.html">MI CIUDAD</a></li>
				<li><a href="../../../../Users/cojonuo/Documents/Facultad/3º/2nd Cuatrimestre/SIBW/Codigos/enlaces.html">ENLACES</a></li>
			</ul>
		</div>-->
		<div id="pan_central">
			<?PHP
				require('../getbdcurso.php');
				//comenzamos recogiendo los datos
				function recogeDato($campo){ 
				return isset($_REQUEST[$campo])?$_REQUEST[$campo]:'';
				} //la función recogeDatos comprueba si se ha recibido un dato y recoge su valor
		   
				//si no se ha recibido, le asigna un valor vacío.
				$nombre 	= recogeDato('nombre');
				$apellidos 	= recogeDato('apellidos');
				$email1	 	= recogeDato('email1');
				$email2	 	= recogeDato('email2');
				$pw1 		= recogeDato('clave');
				$pw2 		= recogeDato('clave2');
				
				if (!isset($_REQUEST['enviadoAlumno']))
				{
					$id		= $_GET["id"];
				}
				else
					$id		= recogeDato('id');
				
				$algunerror = FALSE;
			
				$error_nombre = "";
				$error_apellidos = "";
				$error_email1 = "";
				$error_email2 = "";
				$error_pw = "";
				$error_pw2 = "";
				
				if (isset($_REQUEST['enviadoAlumno']))
				{
					if($nombre=='')
					{ //comprobamos que el nombre no haya quedado vacío
						$algunerror = TRUE;
						$error_nombre = '<br><span class="erroneo">Campo requerido</span>';
					}
					if($apellidos=='')
					{			   
						$algunerror = TRUE;
						$error_apellidos = '<br><span class="erroneo">Campo requerido</span>';
					}
					if(strlen($email1) > 15)
					{
						if(!strpos  ( $email1, "correo.ugr.es"))
						{ //validamos los que el email no esté vacio
								$algunerror = TRUE;
								$error_email1 = '<br><span class="erroneo">Correo erroneo</span>';
						}  
						elseif($email1!=$email2)
						{ //si tiene algo, que concida con la repetición
							$algunerror = TRUE;
							$error_email2 = '<br><span class="erroneo"><br>No coinciden</span>';
						}
					}
					else
					{
						$algunerror = TRUE;
						$error_email1 = '<br><span class="erroneo">Correo erroneo</span>';
					}
					
					if($pw1=='')
					{ //comprobamos que el contenido de la pw no esté vacío
						$algunerror = TRUE;
						$error_pw = '<br><span class="erroneo">Campo requerido</span>';
					} 
					elseif($pw1!=$pw2)
					{ //si tiene algo, que concida con la repetición
						$algunerror = TRUE;
						$error_pw2 = '<br><span class="erroneo"><br>No coinciden</span>';
					}
				}
			   
				if (isset($_REQUEST['enviadoAlumno'])&&!$algunerror)
				{
					echo '<div class="avisoSinMenu">todo correcto</div>';
				
					session_start();
					$_SESSION['DNI'] = $id;
					$_SESSION['TIPO'] = 'alumno';
					
					$conexion = mysql_connect('127.0.0.1:3306', 'root', '');
					mysql_select_db(getbdcurso(), $conexion);
					
					if(!$conexion)
					{
						die("Fallo en la conexión MYSQL: " . mysql_error());
					}
					
					$sql = "UPDATE Alumno SET nombrealumnoa='$nombre', apellidos='$apellidos', email='$email1', password='$pw1', isregister=TRUE WHERE dnialumno=$id";
					mysql_query($sql, $conexion);

					header('Location: ../panelAlumno.php');
				} 
				else 
				{
					if (isset($_REQUEST['enviadoAlumno']))
					{
						echo '<div class="avisoSinMenu">Por vavor, corrige los siguientes errores:</div>';
					} 
					else 
					{
						echo '<div class="avisoSinMenu">Por favor, rellene este formulario para continuar:</div>';
					}
				}
				
				$conexion = mysql_connect('127.0.0.1:3306', 'root', '');
				mysql_select_db(getbdcurso(), $conexion);
				
				$resultado = mysql_query("SELECT * FROM Alumno WHERE dnialumno=$id", $conexion);
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
			<div class="titulo">PANEL REGISTRO DE ALUMNO</div>
			<table ALIGN="center" class="tabla_registro"> 
				<tr> 
					<td>
						<FORM ALIGN="right" id="login" ACTION="registrarAlumno.php" METHOD="POST">
							<INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>">
							Nombre: <INPUT TYPE="text" NAME="nombre" VALUE="<?=$nombre?>"> <?=$error_nombre;?>
							<br>
							Apellidos: <INPUT TYPE="text" NAME="apellidos" VALUE="<?=$apellidos?>"> <?=$error_apellidos;?>
							<br>
							Correo electrónico UGR (ej: XXXX@correo.ugr.es): <INPUT TYPE="text" NAME="email1" VALUE="<?=$email1?>"> <?=$error_email1;?>
							<br>
							Repita el correo eletrónico: <INPUT TYPE="text" NAME="email2" VALUE="<?=$email2?>"> <?=$error_email2;?>
							<br>
							Nueva Contraseña: <INPUT TYPE="password" NAME="clave"> <?=$error_pw;?>
							<br>
							<br>
							Repita Contraseña: <INPUT TYPE="password" NAME="clave2"> <?=$error_pw2;?>
							<br>
							<br>
							<INPUT TYPE="submit" NAME="enviadoAlumno" VALUE="Aceptar"class="button medium orange">
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