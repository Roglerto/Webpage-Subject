<?php
	session_start();
	if (isset($_REQUEST['logout']))
	{
		session_destroy(); 
		header('Location: index.php');
	}
	
	if(isset($_SESSION['DNI']) && isset($_SESSION['TIPO'])) 
    {
		$dni 	= $_SESSION['DNI'];
		$tipo 	= $_SESSION['TIPO'];
    }
	else
	{
		header('Location: index.php');
	}
?>