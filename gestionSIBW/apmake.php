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
	<!-- Contenido principal -->
			<div id="pan_central">
			<?PHP
				//comenzamos recogiendo los datos
				function recogeDato($campo){ 
				return isset($_REQUEST[$campo])?$_REQUEST[$campo]:'';
				} //la función recogeDatos comprueba si se ha recibido un dato y recoge su valor
				
				$asignatura 	= recogeDato('asignatura');
				$fechainicio 	= recogeDato('fechainicio');
				$dniprofesor	= recogeDato('dnigestor');
								
				$conexion = mysql_connect('127.0.0.1:3306', 'root', '');
				mysql_select_db(getbdcurso(), $conexion);
				if(!$conexion)
				{
					die("Fallo en la conexión MYSQL: " . mysql_error());
				}
				
				$algunerror = FALSE;
				
				$error_asignatura = "";
				$error_fechainicio = "";
				$error_dnigestor = "";
			
				if (isset($_REQUEST['enviadoEditar']))
				{

					if (strlen($fechainicio) > 4 || strlen($fechainicio) < 4)
					{
						$algunerror = TRUE;
						if ($fechainicio != '')
						{
							$error_fechainicio = '<br><span class="erroneo">La fecha de inicio debe tener estar en formato de 4 números, ejemplo: 2012</span>';
						}
						else
						{
							$error_fechainicio = '<br><span class="erroneo">El campo del año del curso no puede estar vacío</span>';
						}
					}
					if ($asignatura == '')
					{
						$algunerror = TRUE;
						$error_asignatura = '<br><span class="erroneo">El campo asignatura no puede estar vacío</span>';
					}
					
					if ($dniprofesor == '')
					{
						$algunerror = TRUE;
						$error_dnigestor = '<br><span class="erroneo">El campo DNI no puede estar vacío</span>';
					}
					
					$existecurso = mysql_query("SELECT * FROM Curso WHERE asignatura='$asignatura' AND fechainicio='$fechainicio'", $conexion);
					$filascurso = mysql_num_rows($existecurso);
					if ($filascurso > 0)
					{
						$algunerror = TRUE;
						$error_asignatura = '<br><span class="erroneo">Ya existe una asignatura con este nombre y fecha</span>';
						$error_fechainicio = '<br><span class="erroneo">Ya existe una asignatura con este nombre y fecha</span>';
					}
					
					$existeprofefecha = mysql_query("SELECT * FROM Curso WHERE dniprofesor='$dniprofesor' AND fechainicio='$fechainicio'", $conexion);
					$filasprofefecha = mysql_num_rows($existeprofefecha);
					if ($filasprofefecha > 0)
					{
						$algunerror = TRUE;
						$error_asignatura = '<br><span class="erroneo">Este profesor ya ha sido asignado ese año para otra asignatura</span>';
						$error_fechainicio = '<br><span class="erroneo">Este profesor ya ha sido asignado ese año para otra asignatura</span>';
					}

				}
				if (isset($_REQUEST['enviadoEditar'])&&!$algunerror)
				{
					$bdnueva = "bd" . $fechainicio;
					$sqlcreabd = 'CREATE DATABASE ' . $bdnueva . ' DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci';
					$sqlcreagestor = "INSERT INTO Profesor VALUES ('$dniprofesor', NULL, NULL, NULL, '$dniprofesor', FALSE, NULL, NULL)";
					$sqlcreacurso = "INSERT INTO Curso VALUES ('$asignatura', '$fechainicio', '$dniprofesor')";
					
					if(!mysql_query($sqlcreabd, $conexion))
					{
						echo '<div class="aviso">Ya existe ese curso.</div>';
					}
					else
					{
						if(!mysql_select_db( $bdnueva, $conexion ) )
						{
							echo '2 ';
							die("Fallo MYSQL: " . mysql_error());
						}
						else
						{
							$file_content = file('sql/soloestructura.txt');
							$query = "";
							foreach($file_content as $sql_line)
							{
								if(trim($sql_line) != "" && strpos($sql_line, "--") === false)
								{
									$query .= $sql_line;
									if (substr(rtrim($query), -1) == ';')
									{
										//echo $query;
										$result = mysql_query($query)or die(mysql_error());
										$query = "";
									}
								}
							}
							if (!mysql_query($sqlcreagestor, $conexion) || !mysql_query($sqlcreacurso, $conexion))
							{
								echo '3 ';
								mysql_query('DROP DATABASE ' . $bdnueva, $conexion);
								die("Fallo MYSQL: " . mysql_error());
							}
							else
							{
								echo "<script language='JavaScript'>";
								echo "location = 'apmakeOK.php'";
								echo "</script>";
							}
						}
					}
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
			<div class="tituloConMenu">CREAR NUEVO CURSO</div>
			<table ALIGN="center" class="tabla_registro"> 
				<tr> 
					<td>
						<FORM ALIGN="right" id="creacurso" ACTION="apmake.php" METHOD="POST">
							Nombre de asignatura: <INPUT TYPE="text" NAME="asignatura" VALUE="<?=$asignatura?>"> <?=$error_asignatura;?>
							<br>
							Año de inicio del curso: <INPUT TYPE="text" NAME="fechainicio" VALUE="<?=$fechainicio?>"> <?=$error_fechainicio;?>
							<br>
							DNI del gestor de la asignatura: <INPUT TYPE="text" NAME="dnigestor" VALUE="<?=$dniprofesor?>"> <?=$error_dnigestor;?>
							<br>
							<br>
							<INPUT TYPE="submit" NAME="enviadoEditar" VALUE="Crear curso" class="button medium orange">
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