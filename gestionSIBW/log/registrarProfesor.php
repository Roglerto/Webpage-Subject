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
				
				$algunerror = FALSE;
			
				if (!isset($_REQUEST['enviadoProfesor']))
				{
					$id		= $_GET["id"];
				}
				else
					$id		= recogeDato('id');
			
				$error_nombre = "";
				$error_apellidos = "";
				$error_email1 = "";
				$error_email2 = "";
				$error_pw = "";
				$error_pw2 = "";
		   
				if (isset($_REQUEST['enviadoProfesor']))
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
					if($email1=="")
					{
						$algunerror = TRUE;
						$error_email1 = '<br><span class="erroneo">Campo requerido</span>';
					}
					else
					{
						if($email1!=$email2)
						{ //si tiene algo, que concida con la repetición
							$algunerror = TRUE;
							$error_email2 = '<br><span class="erroneo"><br>No coinciden</span>';
						}
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
			   
				if (isset($_REQUEST['enviadoProfesor'])&&!$algunerror)
				{
					echo '<div class="avisoSinMenu">todo correcto</div>';
					
					session_start();
					$_SESSION['DNI'] = $id;
					$_SESSION['TIPO'] = 'profesor';
					
					$conexion = mysql_connect('127.0.0.1:3306', 'root', '');
					mysql_select_db(getbdcurso(), $conexion);
					
					if(!$conexion)
					{
						die("Fallo en la conexión MYSQL: " . mysql_error());
					}
					
					$sql = "UPDATE Profesor SET nombre='$nombre', apellidos='$apellidos', email='$email1', password='$pw1', isregister=TRUE WHERE dniprofesor=$id";
					mysql_query($sql, $conexion);
				
					$resultadoGestor = mysql_query("SELECT * FROM curso WHERE dniprofesor=$id", $conexion);
					$nfilasGestor = mysql_num_rows($resultadoGestor);
					if($nfilasGestor != 0)
					{
						$_SESSION['TIPO'] = 'gestor';
					}
					
					header('Location: ../panelProfesor.php');
				} 
				else 
				{
					if (isset($_REQUEST['enviadoProfesor']))
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
				
				$resultado = mysql_query("SELECT * FROM Profesor WHERE dniprofesor=$id", $conexion);
				$nfilas = mysql_num_rows($resultado);
				$fila = mysql_fetch_assoc($resultado);
				
				$nombre 	= $fila['nombre'];
				$apellidos 	= $fila['apellidos'];
				$web		= $fila['weblink'];
				$comentario = $fila['acercademi'];
				$email1 = $email2 = $fila['email'];
				$pw1 = $pw2 = '';
				?>   
			<div class="titulo">PANEL REGISTRO DE PROFESOR</div>
			<table ALIGN="center" class="tabla_registro"> 
				<tr> 
					<td>
						<FORM ALIGN="right" id="login" ACTION="registrarProfesor.php" METHOD="POST">
							<INPUT TYPE="hidden" NAME="id" VALUE="<?=$id?>">
							Nombre: <INPUT TYPE="text" NAME="nombre" VALUE="<?=$nombre?>"> <?=$error_nombre;?>
							<br>
							Apellidos: <INPUT TYPE="text" NAME="apellidos" VALUE="<?=$apellidos?>"> <?=$error_apellidos;?>
							<br>
							Correo electrónico (preferiblamente UGR): <INPUT TYPE="text" NAME="email1" VALUE="<?=$email1?>"> <?=$error_email1;?>
							<br>
							Repita el correo eletrónico: <INPUT TYPE="text" NAME="email2" VALUE="<?=$email2?>"> <?=$error_email2;?>
							<br>
							Nueva Contraseña: <INPUT TYPE="password" NAME="clave"> <?=$error_pw;?>
							<br>
							<br>
							Repita Contraseña: <INPUT TYPE="password" NAME="clave2"> <?=$error_pw2;?>
							<br>
							<br>
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