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
				
				$cursoelegido	= recogeDato('selectCurso');
				if($cursoelegido!='')
				{
					if(!mysql_query('DROP DATABASE ' . $cursoelegido, $conexion))
					{
						//die("Fallo MYSQL: " . mysql_error());
					}
					echo "<script language='JavaScript'>";
					echo "location = 'apdeleteOK.php'";
					echo "</script>";
				}
				
				$conexion = mysql_connect('127.0.0.1:3306', 'root', '');
				mysql_select_db(getbdcurso(), $conexion);
				if(!$conexion)
				{
					die("Fallo en la conexión MYSQL: " . mysql_error());
				}
			?>	
				<div class="tituloConMenu">DESTRUCCIÓN DE UN CURSO</div>
				<table align="CENTER" class="tabla_registro">
					<tr>
						<td>
							<form ALIGN="right" action="apdelete.php" METHOD="post">
				<?PHP
				$cursos = array();
				$result = mysql_query("SHOW DATABASES");
				?>
				Seleccione el curso:<select name = "selectCurso">
				<?PHP 
				while ($row = mysql_fetch_array($result))
				{
					if (strpos($row[0],'bd') !== false && strlen($row[0]) == 6)
						array_push($cursos, $row[0]);
				}
				foreach($cursos as $curso)
				{
					echo '<option VALUE="'.$curso.'"> '.$curso.'</option>';
				}
				?>
								</select>
								<?PHP $error_selectDNI?>
								<br>
								<INPUT TYPE="submit" NAME="cursoSeleccionado" VALUE="Eliminar" class="button medium orange"> 
							</form>
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