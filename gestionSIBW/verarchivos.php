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
			<div class="tituloConMenu">VER ARCHIVOS</div>
			
			<?php 
			$conexion = mysql_connect('127.0.0.1:3306', 'root', '');
			mysql_select_db(getbdcurso(), $conexion);
					
			if(!$conexion)
			{
				die("Fallo en la conexión MYSQL: " . mysql_error());
			}
			
			if($tipo=="profesor" || $tipo=="gestor")
			{
				$consulta=mysql_query("SELECT nombre FROM gestiona WHERE dniprofesor='$dni'",$conexion);
				$nrows=mysql_num_rows($consulta);
				while($fila = mysql_fetch_array($consulta)){
					$nomGr=$fila['nombre'];
					?>
					<table align ="CENTER" border="0" cellpadding="0" cellspacing="0" class="tablaCalif">
					<tr>
					<th>Nombre</th>
					<th>Grupo</th>
					</tr>
					<?php 
					
					if(isset($_REQUEST['dir'])){
						$direc=getcwd()."/Grupos/".$nomGr."/".$_REQUEST['dir'];
					}
					else {
						$direc=getcwd()."/Grupos/".$nomGr;
					}
					if($handle=opendir($direc))
					{
						$i=0;
						$j=getcwd();
						while(false !== ($entry = readdir($handle))){
							if(in_array($entry,array(".",".."))){continue;}
							$path=$direc."/".$entry;
							if($i%2==0){?><tr class="modo1"> <?php }
						    else {?> <tr class="modo2"> <?php }?>  
						    <td> <?php 
						    	if(is_file($path))
								{
						        	$tfr=substr($path,strlen($j)+1);
						            echo '<a href="download.php?id='.$tfr.'">'.$entry."\n</a><br/>";
						            $tmp=explode(".",$entry);
						            echo "<td>Archivo ".end($tmp)."</td>";
						        }
						        else
								{
						        	$tfd=substr($path,strlen($j));
						        	echo '<a href="verarchivos.php?dir='.$tfd.'">'.$entry."\n</a><br/>";
						        	echo "<td>Carpeta</td>";
						        }
						        ?>
						    	</td>
						        </tr>
						        <?php 
						        $i++;
						}
						closedir($handle);
					}
					?>
					</table>
					<?php 
				}
			}
			//Parte de Alumno
			else
			{
				$consulta=mysql_query("SELECT nombre FROM alumno WHERE dnialumno='$dni'",$conexion);
				$nrows=mysql_num_rows($consulta);
				$fila=mysql_fetch_array($consulta);
				$idal=$fila['nombre'];
				?>
				<table align ="CENTER" border="0" cellpadding="0" cellspacing="0" class="tablaCalif">
				<tr>
				<th>Nombre</th>
				<th>Tipo</th>
				</tr>
				<?php 
									
				if(isset($_REQUEST['dir'])){
				$direc=getcwd().DIRECTORY_SEPARATOR."Alumnos".DIRECTORY_SEPARATOR.$dni.DIRECTORY_SEPARATOR.$idal.DIRECTORY_SEPARATOR.$_REQUEST['dir'];
				}
				else {
				$direc=getcwd().DIRECTORY_SEPARATOR."Alumnos".DIRECTORY_SEPARATOR.$dni.DIRECTORY_SEPARATOR.$idal;
				}
				if($handle=opendir($direc))
				{
					$i=0;
					$j=getcwd();
					while(false !== ($entry = readdir($handle))){
						if(in_array($entry,array(".",".."))){continue;}
						$path=$direc."/".$entry;
						if($i%2==0){?><tr class="modo1"> <?php }
					    else {?> <tr class="modo2"> <?php } ?>  
					    <td> <?php 
					    if(is_file($path)){
					    	$tfr=substr($path,strlen($j)+1);
					        echo '<a href="download.php?id='.$tfr.'">'.$entry."\n</a><br/>";
					        $tmp=explode(".",$entry);
					        echo "<td>Archivo ".end($tmp)."</td>";
					    }
					    else
						{
					    	$tfd=substr($path,strlen($j));
					    	echo '<a href="verarchivos.php?dir='.$tfd.'">'.$entry."\n</a><br/>";
					    	echo "<td>Carpeta</td>";
					    }
					    ?>
					    </td>
					    </tr>
					    <?php 
					    $i++;
					}
					closedir($handle);
				}
			}
			?>
			</table>
	</div>
	<div id="pan_inferior">
			<p>SIBW 2012-2013</p>
	</div>
</div>
</body>
</html>