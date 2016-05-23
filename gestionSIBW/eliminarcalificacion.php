<?php
include 'conexion.php';
include 'getbdcurso.php';
$conexion = mysql_connect('127.0.0.1:3306', 'root', '');
mysql_select_db(getbdcurso(), $conexion);

$id= $_REQUEST['id'];

if(!$conexion)
{
	die("Fallo en la conexión MYSQL: " . mysql_error());
}

$consulta = "DELETE FROM Calificacion WHERE id='$id'";
$_SESSION['modificar']=FALSE;	

if(!mysql_query($consulta, $conexion))
{
	die(header('Location: insercionFAIL.php'));
}

echo "1 fila eliminada";

mysql_close($conexion);

header('Location: vercalificaciones.php');

?>