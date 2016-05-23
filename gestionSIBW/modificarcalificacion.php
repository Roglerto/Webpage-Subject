<?php
include 'conexion.php';
include 'getbdcurso.php';
$conexion = mysql_connect('127.0.0.1:3306', 'root', '');
mysql_select_db(getbdcurso(), $conexion);

if(!$conexion)
{
	die("Fallo en la conexión MYSQL: " . mysql_error());
}

$id=$_REQUEST['id'];
$_SESSION['modificar']=TRUE;

$consulta = "UPDATE Calificacion SET nota='$_POST[calificacion]', observaciones='$_POST[observaciones]', 
dniprofesor='$_SESSION[DNI]', dnialumno='$_POST[DNI]', nombre='$_POST[grupo]' WHERE id='$id'";
if(!mysql_query($consulta, $conexion))
{
	die(header('Location: insercionFAIL.php?id=' . $id));
}


echo "1 fila insertada";

mysql_close($conexion);

header('Location: insercionOK.php?id=' . $id);

?>