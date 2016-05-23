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
					$resultado = mysql_query("SELECT * FROM Profesor WHERE dniprofesor=$dni", $conexion);
					$nfilas = mysql_num_rows($resultado);
				
					if($nfilas != 0)
					{
						$fila = mysql_fetch_assoc($resultado);
						$nombre = $fila['nombre'];
						$apellidos = $fila['apellidos'];
						$email1 = $fila['email'];
						$web = $fila['weblink'];
						$comentario = $fila['acercademi'];
					}
			   ?>
			<div class="tituloConMenu">PÁGINA PERSONAL DE PROFESOR</div>
			<table ALIGN="center" class="tabla_registro"> 
				<tr> 
					<td>
						<FORM ALIGN="right" id="login" ACTION="personalProfesorEditar.php" METHOD="POST">
							Nombre: <span class="areaTexto"><?=$nombre;?></span>
							<br>
							<br>
							Apellidos: <span class="areaTexto"><?=$apellidos;?></span>
							<br>
							<br>
							Correo electrónico: <span class="areaTexto"><?=$email1;?></span> 
							<br>
							<br>
							Página web: <span class="areaTexto"><a class="enlace" href="<?=$web;?>"><?=$web;?></a></span> 
							<br>
							<br>
							<textarea name="comentario" rows="10" cols="40"><?=$comentario;?></textarea>
							<br>
							<br>
							<INPUT TYPE="submit" NAME="enviado" VALUE="Editar" class="button medium orange">
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