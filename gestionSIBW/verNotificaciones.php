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
			<div class="tituloConMenu">NOTIFICACIONES</div>
			<?php 
			$conexion = mysql_connect('127.0.0.1:3306', 'root', '');
			mysql_select_db(getbdcurso(), $conexion);
					
			if(!$conexion)
			{
				die("Fallo en la conexión MYSQL: " . mysql_error());
			}
			if($tipo=="profesor")
			{
				$resultado = mysql_query("SELECT * FROM tiene WHERE dniprofesor='$dni'", $conexion);
				$nfilas = mysql_num_rows($resultado);
				?>
				<table align ="CENTER" border="0" cellpadding="0" cellspacing="0" class="tablaCalif">
				<tr>
				<th>Titulo</th>
				<th>Descripcion</th></tr>
				<?php 
				$i=0;
				
				while($fila = mysql_fetch_array($resultado))
				{
					if($i%2==0)
						$modo="modo1";
					else 
						$modo="modo2";
						
					$titulo=$fila['titulo'];
					$descripcion=$fila['descripcion'];
					?>
					<tr class = <?=$modo?>>
						<td><?php echo $titulo?></td>
						<td><?php echo $descripcion?></td>
					</tr>
					<?php 
					$i++;
				}
			}
			else
			{
				$resultado= mysql_query("SELECT * from tiene WHERE dnialumno='$dni'",$conexion);
				$nfilas = mysql_num_rows($resultado);
				
				if($nfilas == 0)
					echo '<div class="aviso"> Enhorabuena, no tiene notificaciones</div>';
				else
				{
  
				?>
					<table align ="CENTER" border="0" cellpadding="0" cellspacing="0" class="tablaCalif">
						<tr>
							<th>Titulo</th>
							<th>Descripcion </th>
						</tr>
						<?php 
							$i=0;
								
							while($fila = mysql_fetch_array($resultado))
							{
								$dniprofesor = $fila['dniprofesor'];
								$id = $fila['id'];
								$resultado2=mysql_query("SELECT * from notificacion where id='$id'", $conexion);
									
								while($fila2 = mysql_fetch_array($resultado2))
								{
									if($i%2==0)
										$modo="modo1";
									else 
										$modo="modo2";
						?>
										
									<tr class = <?=$modo?>>
										<td><?php  echo $fila2['titulo']?></td>
										<td> <?php echo $fila2['descripcion']?></td>
													
									</tr>
									<?php 
										$i++;
								}
							}
				
					$sql2 = "DELETE FROM tiene WHERE dnialumno='$dni'";					
					mysql_query($sql2, $conexion);
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