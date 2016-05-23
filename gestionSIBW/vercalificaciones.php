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

<script language="javascript">

function confirmar() {
	if(confirm("¿Está seguro que quiere eliminar esta calificación?")){
		return true;
	} else {
		return false;
	}
}

</script>

<body>
	<div id="body_wrapper">
		<?php include 'menu.php'?>
		<!-- Datos de ejemplo, habría que coger las calificaciones de la base de datos! -->
		<div id="pan_central">
			<div class="tituloConMenu">TABLA VER CALIFICACIONES </div>
			<?php 
			$conexion = mysql_connect('127.0.0.1:3306', 'root', '');
			mysql_select_db(getbdcurso(), $conexion);
					
			if(!$conexion)
			{
				die("Fallo en la conexión MYSQL: " . mysql_error());
			}
			if($tipo=="profesor" || $tipo=="gestor")
			{
				$resultado = mysql_query("SELECT * FROM Calificacion WHERE dniprofesor='$dni'", $conexion);
				$nfilas = mysql_num_rows($resultado);
				?>
				<table align ="CENTER" border="0" cellpadding="0" cellspacing="0" class="tablaCalif">
				<tr>
				<th>Grupo</th>
				<th>DNI Alumno</th>
				<th>Calificación </th>
				<th>Observaciones</th>
				<th> Modificar </th> 
				<th> Eliminar </th> </tr>
				<?php 
				$i=0;
				
				while($fila = mysql_fetch_array($resultado))
				{
					if($i%2==0)
						$modo="modo1";
					else $modo="modo2";
					$nombre=$fila['nombre'];
					$dnialumno=$fila['dnialumno'];
					$nota = $fila['nota'];
					$observaciones = $fila['observaciones'];
					$id = $fila['id'];
					?>
					<tr class = <?=$modo?>>
					<td><?php  echo $nombre?></td>	
					<td> <?php echo $dnialumno?></td>
					<td> <?php echo $nota?></td>
					<td> <?php echo $observaciones?></td>
					<td> <a href="modificarcalificaciones.php?id=<?=$id?>" action=<?php $_SESSION['modo']="modificar";?>> Modificar </a></td>
					<td> <a onclick="return confirmar();" href="eliminarcalificacion.php?id=<?=$id?>"> Eliminar </a></td>
					</tr>
					<?php 
					$i++;
				}
			}
			else
			{
				$resultado= mysql_query("SELECT * from Calificacion WHERE dnialumno = '$dni'",$conexion);
				$nfilas = mysql_num_rows($resultado);
				?>
								<table align ="CENTER" border="0" cellpadding="0" cellspacing="0" class="tablaCalif">
								<tr>
								<th>Grupo</th>
								<th>DNI </th>
								<th>Calificación </th>
								<th>Observaciones</th>
								</tr>
								<?php 
								$i=0;
								
								while($fila = mysql_fetch_array($resultado))
								{
									if($i%2==0)
										$modo="modo1";
									else $modo="modo2";
									?>
									<tr class = <?=$modo?>>
									<td><?php  echo $fila['nombre']?></td>
									<td> <?php echo $fila['dnialumno']?></td>
									<td> <?php echo $fila['nota']?></td>
									<td> <?php echo $fila['observaciones']?></td>
									
									</tr>
									<?php 
									$i++;
								}
			}
			?>
				
			</table>
		</div>
		<!-- Firma y fecha de la página, ¡sólo por cortesía! -->
		<div id="pan_inferior">
			<p>SIBW 2012-2013</p>
		</div>
	</div>
</body>
</html>