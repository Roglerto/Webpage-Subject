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
			<div class="tituloConMenu">SUBIR ARCHIVOS</div>
			
			<?php 
			$conexion = mysql_connect('127.0.0.1:3306', 'root', '');
			mysql_select_db(getbdcurso(), $conexion);
					
			if(!$conexion)
			{
				die("Fallo en la conexión MYSQL: " . mysql_error());
			}
			
			$allowExt=array("gif","jpeg","jpg","png","zip","txt","pdf");
			$nomArch=explode(".",$_FILES["archivo"]["name"]);
			$extension=end($nomArch);
			
			if( ( ($_FILES["archivo"]["type"]=="image/gif") || ($_FILES["archivo"]["type"]=="image/jpeg")
				|| ($_FILES["archivo"]["type"]=="image/jpg") || ($_FILES["archivo"]["type"]=="image/pjpeg")
				|| ($_FILES["archivo"]["type"]=="image/png") || ($_FILES["archivo"]["type"]=="image/x-png")
				|| ($_FILES["archivo"]["type"]=="application/zip") || ($_FILES["archivo"]["type"]=="text/plain")
				|| ($_FILES["archivo"]["type"]=="application/pdf") || ($_FILES["archivo"]["type"]=="application/x-pdf"))
				&& ($_FILES["archivo"]["size"] <= 20971520)     && in_array($extension, $allowExt))
			{
				if($_FILES["archivo"]["error"] > 0)
				{
					echo "Error: ". $_FILES["archivo"]["error"] . "<br>";
				}
				else
				{
					if($tipo=="profesor" || $tipo=="gestor")
					{
						$carpeta="Grupos".DIRECTORY_SEPARATOR.$_POST['grupo'];
						if(file_exists($carpeta .DIRECTORY_SEPARATOR. $_FILES["archivo"]["name"]))
						{
							echo '<div class="aviso">El archivo que intenta subir ya existe.</div>';
						}
						else
						{
						
							if(!is_dir($carpeta))
							{
								mkdir($carpeta,0,TRUE);
							}
							move_uploaded_file($_FILES["archivo"]["tmp_name"], $carpeta.DIRECTORY_SEPARATOR. $_FILES["archivo"]["name"]);
							echo '<div class="aviso">Archivo subido correctamente.</div>';
						}
					}
					else 
					{
						$carpeta="Alumnos".DIRECTORY_SEPARATOR.$dni.DIRECTORY_SEPARATOR.$_POST['grupo'];
						if(file_exists($carpeta.DIRECTORY_SEPARATOR. $_FILES["archivo"]["name"]))
						{
							echo '<div class="aviso">El archivo que intenta entregar ya existe.</div>';
						}
						else
						{
						
							if(!is_dir($carpeta))
							{
								mkdir($carpeta,0,TRUE);
							}
							move_uploaded_file($_FILES["archivo"]["tmp_name"], $carpeta.DIRECTORY_SEPARATOR. $_FILES["archivo"]["name"]);
							echo '<div class="aviso">Archivo entregado correctamente.</div>';
						}
					}
				}
			}
			?>
		</div>
		
		<div id="pan_inferior">
			<p>SIBW 2012-2013</p>
		</div>
	</div>
</body>
</html>
			