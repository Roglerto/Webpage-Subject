<?php
	include 'conexion.php';
	include 'getbdcurso.php';
	$conexion = mysql_connect('127.0.0.1:3306', 'root', '');
	mysql_select_db(getbdcurso(), $conexion);
	if(!$conexion)
	{
		die("Fallo en la conexión MYSQL: " . mysql_error());
	}
    $encrypted=getcwd()."/".$_REQUEST['id'];
    $encrypted=str_replace(' ', '_', $encrypted);
    $rr=basename($encrypted);
    header('Content-disposition: attachment; filename='.$rr);
    header('Content-type: application/octet-stream');
    readfile($nom);
?>