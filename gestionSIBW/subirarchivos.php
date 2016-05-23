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
			<div class="tituloConMenu">SUBIR ARCHIVOS</div>
			
			<?php 
			$conexion = mysql_connect('127.0.0.1:3306', 'root', '');
			mysql_select_db(getbdcurso(), $conexion);
					
			if(!$conexion)
			{
				die("Fallo en la conexión MYSQL: " . mysql_error());
			}
				
			
			if($tipo=="profesor" || $tipo=="gestor")
			{
				$consulta=mysql_query("SELECT nombre FROM gestiona WHERE dniprofesor='$dni'",$conexion);
				$nrows=mysql_num_rows($consulta);
				
				?>
				
				<form method = "post" action="upload_result.php" enctype = "multipart/form-data">
            		<label for="file"><vb class="p1">Archivo a subir:</vb></label>
            		<input type="file" name="archivo" id="id_archivo"><br>
            		<input type="submit" name="submit" value="Cargar">
            		Subir en carpeta de grupo:
					<select name="grupo">
					<?php 
					$i=0;
					for($i=0;$i<$nrows;$i++){
						$fila=mysql_fetch_array($consulta);
						echo '<option value="'.$fila['nombre'].'">'.$fila['nombre'].'</option>';
						}
					?>
					</select>
       			</form>
       			
       			<?php
			}
			
			else 
			{
				$consulta=mysql_query("SELECT nombre FROM alumno WHERE dnialumno='$dni'",$conexion);
				$nrows=mysql_num_rows($consulta);
				
				?>
				<table class="tabla_registro">
				<tr><td>
				<form method = "post" action="upload_result.php" enctype = "multipart/form-data">
            		<label for="file"><vb class="p1">Archivo a entregar:</vb></label>
            		<input type="file" name="archivo" id="id_archivo"><br>
            		Entregar en grupo:
					<select name="grupo">
					<?php 
					$i=0;
					for($i=0;$i<$nrows;$i++){
						$fila=mysql_fetch_array($consulta);
						echo '<option value="'.$fila['nombre'].'">'.$fila['nombre'].'</option>';
						}
					?>
					</select>
					<input type="submit" name="submit" value="Cargar">
       			</form>
       			</td></tr>
       			</table>
       			<?php
				}
			?>
			
			</div>
			
			<div id="pan_inferior">
			<p>SIBW 2012-2013</p>
			</div>
		</div>
		
	</body>
</html>