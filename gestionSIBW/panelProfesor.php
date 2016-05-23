<?PHP
	include 'conexion.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<title>Bienvenido</title>
<script type="text/javascript" src="js/jquery-1.3.1.min.js"></script>
<script type="text/javascript" src="js/jquery.functions.js"></script>

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
		<div class="tituloConMenu">
			Bienvenido a SIBW	
		</div>
		<p class="parrafo">
			<IMG id='fotoPortada' SRC='bob.gif' alt='usuario' width='320px' height='140px'>Bienvenido a la plataforma de docencia de la asignatura de Sistemas de Información Basados en Web.
		</p>
		<p class="parrafo">
			A través de este portal se gestionarán los recursos necesarios para llevar a cabo la distribución de contenidos, la gestión de grupos y calificaciones asi como todo lo relacionado con la asignatura. ;)
		</p>
	</div>
	
	<!-- Firma y fecha de la página, ¡sólo por cortesía! -->
	<div id="pan_inferior">
		<p>SIBW 2012-2013</p>
	</div>
</div>
 </body>
</html>

