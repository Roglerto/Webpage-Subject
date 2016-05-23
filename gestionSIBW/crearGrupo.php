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
				$grupo	= recogeDato('grupo');
				
				$algunerror = FALSE;

				$error_grupo = "";
				
				if (isset($_REQUEST['enviadoGrupo']))
				{
					if($grupo=='')
					{ //comprobamos que el contenido del dni no esté vacío
						$algunerror = TRUE;
						$error_grupo = '<br><span class="erroneo">Campo requerido</span>';						
					}
				}
				
				if (isset($_REQUEST['enviadoGrupo'])&&!$algunerror)
				{		
					$conexion = mysql_connect('127.0.0.1:3306', 'root', '');
					mysql_select_db(getbdcurso(), $conexion);
						
					if(!$conexion)
					{
						die("Fallo en la conexión MYSQL: " . mysql_error());
					}
					
					$sql = "INSERT INTO Grupo VALUES ('$grupo')";
						
					$realizadoSQL = mysql_query($sql, $conexion);
					
					if($realizadoSQL==1){
						echo '<div class="aviso">Grupo creado correctamente</div>';
					} else {
						echo '<div class="aviso">Se produjo un problema al crear el grupo, puede que ya exista un gurpo con ese nombre</div>';
					}
				}
				else
				{
					if (isset($_REQUEST['enviadoGrupo']))
					{
						echo '<div class="aviso">Por favor, corrige los siguientes errores:</div>';
					}
				}
				 
			?>
			<div class="tituloConMenu">CREACIÓN DE UN GRUPO</div>
			<table ALIGN="center" class="tabla_registro"> 
				<tr> 
					<td>
						<FORM ALIGN="right" id="login" ACTION="crearGrupo.php" METHOD="POST">
							Letra del grupo:<INPUT TYPE="text" maxlength="1" NAME="grupo" VALUE="<?=$grupo?>"> <?=$error_grupo;?>
							<br>
							<INPUT TYPE="submit" NAME="enviadoGrupo" VALUE="Aceptar" class="button medium orange">
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