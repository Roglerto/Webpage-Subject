<?PHP
	include 'conexion.php';
	if($tipo=="alumno")
		header('Location: personalAlumno.php');
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>SIBW</title>
	<link rel="stylesheet" href="estiloPortada.css">
</head>

<?php 
if($_SESSION['modificar']==FALSE)
{
	?>
	<body onload='<?php header('Refresh: 3; url=gestioncalificaciones.php');?>' >
		<div id="body_wrapper">
			<?php include 'menu.php'?>
			<div id="pan_central">
				<div class="aviso"> HUBO UN ERROR AL INSERTAR LA NOTA EN LA BASE DE DATOS. POR FAVOR COMPRUEBE QUE LOS DATOS SON CORRECTOS.</div>
				
			</div>
			<!-- Firma y fecha de la p�gina, �s�lo por cortes�a! -->
			<div id="pan_inferior">
				<p>SIBW 2012-2013</p>
			</div>
		</div>
	</body>
<?php 
} 
else {

$id=$_REQUEST['id'];
?>

	<body onload='<?php header('Refresh: 3; url=modificarcalificaciones.php?id=' . $id);?> '>
		<div id="body_wrapper">
			<?php include 'menu.php'?>
			<div id="pan_central">
				<div class="aviso"> HUBO UN ERROR AL ACTUALIZAR LA BASE DE DATOS. COMPRUEBE QUE LOS DATOS SON CORRECTOS.</div>
				
			</div>
			<!-- Firma y fecha de la p�gina, �s�lo por cortes�a! -->
			<div id="pan_inferior">
				<p>SIBW 2012-2013</p>
			</div>
		</div>
	</body>
<?php 

}?>
</html>