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
				$titulo 	= " ";
				$fechaComprobar 	= $_GET["fecha"];
				$hora 	= "";
				$lugar 		= " ";
				$fecha	= "";
				$comentario = 	"  ";
			
								
				$conexion = mysql_connect('127.0.0.1:3306', 'root', '');
				mysql_select_db(getbdcurso(), $conexion);
				if(mysqli_connect_errno())
				{
					echo "Fallo en la conexión MYSQL: " . mysqli_connect_error();
				}
				
				$SQL = "SELECT * FROM evento WHERE fecha='$fechaComprobar'";
				$result = mysql_query($SQL,$conexion);
				
				$nfilas = mysql_num_rows($result);
				
				if($nfilas != 0)
				{
					$fila = mysql_fetch_assoc($result);
					
					
					
				}
				
				$consulta = mysql_query("SELECT * FROM evento WHERE fecha='$fechaComprobar'") or die ("Error en la consulta");
			?>
			<div class="tituloConMenu">PÁGINA DE EVENTOS </div>
			
			<table ALIGN="center" class="tabla_registro"> 
				<tr> 
					<td>
													

						    <?php
							while($fila=mysql_fetch_array($consulta)){
                             $titulo	= $fila["titulo"];
							 $id	= $fila["id"];
				         
							
			
 ?>  
							<td><a href="AlumnoEvento.php?id=<?=$id?> " onclick=\"Titulo: <span class="areaTexto"><?=$titulo;?></span></a></td> 
<?php 
     }

?>
						<br>
							
						
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