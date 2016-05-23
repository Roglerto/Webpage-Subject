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
			 $idem = isset($_GET["id"]) ? $_GET["id"] : 4 ;
			
				//$idem 	= $_GET['id'];
				
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
				
				$SQL = "SELECT * FROM evento WHERE id='$idem'";
				$result = mysql_query($SQL,$conexion) or die ('Unable to run query:'.mysql_error());
				
				$nfilas = mysql_num_rows($result);
				//echo "$nfilas";
				
				if($nfilas != 0)
				{
					
					$fila = mysql_fetch_assoc($result);
					$titulo	= $fila["titulo"];
					$hora =$fila["hora"];
					$fecha	= $fila["fecha"];
					
					$comentario	= $fila["descripcion"];
					
				}

			?>
			<div class="tituloConMenu">PÁGINA DE EVENTO ALUMNO </div>
			<table ALIGN="center" class="tabla_registro"> 
				<tr> 
					<td>
						<FORM ALIGN="right" id="login" ACTION="personalAlumnoEditar.php" METHOD="POST">
							Titulo: <span class="areaTexto"><?=$titulo;?></span>
							<br>
							<br>
							Fecha: <span class="areaTexto"><?=$fecha;?></span>
							<br>
							<br>
							Hora: <span class="areaTexto"><?=$hora;?></span>
							<br>
							<br>
							Descripcion:  
							<br>
							<textarea name="comentario" rows="10" cols="40"><?=$comentario;?></textarea>
							<br>
							<br>
						
							
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