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
				$grupo		= recogeDato('selectGrupo');
				$nombre 	= recogeDato('nombre');
				
				$algunerror = FALSE;

				$error_nombre = "";
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
					if($nombre=='')
					{ //comprobamos que el contenido del dni no esté vacío
						$algunerror = TRUE;
						$error_dni = '<br><span class="erroneo">Este campo no puede estar vacío</span>';						
					}
				}
				
				if (isset($_REQUEST['enviadoEditar']) && !$algunerror)
				{
					$resultado = mysql_query("SELECT * FROM Grupo WHERE nombre='$grupo'", $conexion);
					$nfilas = mysql_num_rows($resultado);
					$fila = mysql_fetch_assoc($resultado);
					
					if($nombre!=$fila['nombre'] && $nombre!='')
					{
						$sql = "UPDATE Grupo SET nombre='$nombre' WHERE nombre='$grupo'";
						$realizadoSQL=mysql_query($sql, $conexion);
						
						if($realizadoSQL==1){
							echo '<div class="aviso">Edición realizada con éxito</div>';
							$grupo = $nombre;
						} else {
							echo '<div class="aviso">Se produjo un problema al editar el nombre del grupo, puede que ya exista otro grupo con ese nombre</div>';
						}
						
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
			if (!isset($_REQUEST['grupoSeleccionado']) && !$algunerror) {
				?>
				<div class="tituloConMenu">SELECCIÓN DE UN GRUPO</div>
				<table align="CENTER" class="tabla_registro">
					<tr>
						<td>
							<form ALIGN="right" action="modificarGrupo.php" METHOD="post">
								<?PHP
								$resultado = mysql_query("SELECT * FROM Grupo", $conexion);
								$nfilas = mysql_num_rows($resultado);
								?>
								Seleccione el grupo:<select name = "selectGrupo">
								<?PHP 
								while($fila = mysql_fetch_array($resultado))
								{
									$grupo= $fila['nombre'];
									echo "<option value='$grupo'>$grupo</option>";								
								}
								?>
								</select>
								<?PHP $error_selectGrupo?>
								<br>
								<INPUT TYPE="submit" NAME="grupoSeleccionado" VALUE="Aceptar" class="button medium orange"> 
							</form>
						</td>
					</tr>
				</table>
				<?PHP 	
			} else {

				$resultado = mysql_query("SELECT * FROM Grupo WHERE nombre='$grupo'", $conexion);
				$nfilas = mysql_num_rows($resultado);
				$fila = mysql_fetch_assoc($resultado);
				
				$nombre 	= $fila['nombre'];
				?>
				<div class="tituloConMenu">MODIFICACIÓN DE UN GRUPO</div>
				<table ALIGN="center" class="tabla_registro"> 
					<tr> 
						<td>
							<FORM ALIGN="right" id="login" ACTION="modificarGrupo.php" METHOD="POST">
								Nombre del grupo: <INPUT TYPE="text" maxlength="1" NAME="nombre" VALUE="<?=$nombre?>"> <?=$error_nombre;?>
								<br>
								
								<INPUT TYPE="hidden" NAME="selectGrupo" VALUE="<?=$grupo?>">
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
