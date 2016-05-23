<?php

include 'conexion.php';
include 'getbdcurso.php';
$conexion = mysql_connect('127.0.0.1:3306', 'root', '');
mysql_select_db(getbdcurso(), $conexion);
	
if(!$conexion)
{
	die("Fallo en la conexión MYSQL: " . mysql_error());
}

$id =mysql_query("SELECT * FROM Calificacion WHERE id=(SELECT MAX(id) FROM Calificacion)");
$_SESSION['modificar']=FALSE;

$fila = mysql_fetch_assoc($id);	
$valor =  (int)$fila['id'];
$valor++;
$consulta = "INSERT INTO Calificacion (nota, id, observaciones, dniprofesor, dnialumno, nombre) VALUES ('$_POST[calificacion]', '$valor','$_POST[observaciones]', '$_SESSION[DNI]', '$_POST[DNI]', '$_POST[grupo]')";	
if(!mysql_query($consulta, $conexion))
{
	die(header('Location: insercionFAIL.php'));
}
$consulta2 = "INSERT INTO notificacion VALUES ('Calificacion', '$_POST[observaciones]', '$_SESSION[DNI]', '$valor')";
if(!mysql_query($consulta2, $conexion))
{
	die(header('Location: insercionFAIL.php'));
}
$consulta3 = "INSERT INTO tiene VALUES ('$_SESSION[DNI]', '$_POST[DNI]', '$_POST[grupo]', '$valor')";
if(!mysql_query($consulta3, $conexion))
{
	die(header('Location: insercionFAIL.php'));
}

echo "1 fila insertada";

mysql_close($conexion);

header('Location: insercionOK.php');

?>