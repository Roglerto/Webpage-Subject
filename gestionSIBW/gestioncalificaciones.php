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

<body>
	<div id="body_wrapper">
		<?php include 'menu.php'?>
		<div id="pan_central">
			<?PHP
				//comenzamos recogiendo los datos
				function recogeDato($campo){ 
				return isset($_REQUEST[$campo])?$_REQUEST[$campo]:'';
				} //la función recogeDatos comprueba si se ha recibido un dato y recoge su valor
		   
				//si no se ha recibido, le asigna un valor vacío.
				$DNI		= recogeDato('DNI');
				$algunerror = FALSE;
				$grupo		= "A";				
				$calificacion	= recogeDato('calificacion');				
				$observaciones = recogeDato('observaciones');
				$error_DNI="";
				$error_grupo = "";
				$error_calificacion = "";
				$error_observaciones = "";
		   
				if (isset($_REQUEST['enviado']))
				{
					if($DNI=='')
					{
						$algunerror=TRUE;
						$error_DNI = '<br><span class="erroneo"> Campo requerido</span>';
					}
					if($grupo=='')
					{
						$algunerror = TRUE;
						$error_grupo = '<br><span class="erroneo"> Campo requerido</span>';
					}
					else
					{
						$grupo=recogeDato('grupo');
					}
					if($calificacion=='')
					{
						$algunerror = TRUE;
						$error_calificacion = '<br><span class="erroneo"> Valor de calificacion entre -1(no presentado) y 10</span>';
					}
					if($observaciones=='')
					{
						$algunerror = TRUE;
						$error_observaciones = '<br><span class="erroneo">Debe indicar (al menos) tipo de examen (Teoría, Práctica...)</span>';
					}
				}
			   
				if (isset($_REQUEST['enviado'])&&!$algunerror)
				{
					echo '<div class="aviso">todo correcto</div>';
					//HAY QUE METER EN LA BASE DE DATOS LOS DATOS Y PASAR A LA SIGUIENTE WEB (MENU PROFESOR O MENU ALUMNO)
					
					$DNI="";
					$calificacion="";
					$observaciones="";					
				} 
				else 
				{
					if (isset($_REQUEST['enviado']))
					{
						echo '<div class="aviso">Por vavor, corrige los siguientes errores:</div>';
					} 
					else 
					{
						echo '<div class="aviso">Por favor, rellene este formulario para continuar:</div>';
					}
				}
			   ?>
			<div class="tituloConMenu">PANEL GESTIÓN CALIFICACIONES </div>
			<table ALIGN="center" class="tabla_registro"> 
				<tr> 
					<td>
						<FORM ALIGN="right" id="login" ACTION="insertarcalificacion.php" METHOD="POST">
							<?php 
							$resultado = mysql_query("SELECT * FROM gestiona WHERE dniprofesor='$dni'", $conexion);
							$nfilas = mysql_num_rows($resultado);
							?>
							Grupo: <select name = "grupo">
							<?php 
							while($fila = mysql_fetch_array($resultado))
							{
								$grupos= $fila['nombre'];
	
							?>
							<option value=<?=$grupos?>><?php echo $grupos?></option>
										
							<?php 
							}
							?>
							</select>
							<?=$error_grupo?>
							
							DNI: <INPUT TYPE="text" NAME="DNI" value=<?=$DNI?>> <?=$error_DNI?>
							<br>
							Calificación: <INPUT TYPE="number" NAME ="calificacion" min="-1" max="10" step="any" value=<?=$calificacion?>> <?=$error_calificacion?>
							<br>
							Observaciones: <INPUT TYPE="text" NAME = "observaciones" value=<?=$observaciones?>> <?=$error_observaciones?>
							<br>
							<INPUT TYPE="submit" NAME="enviado" VALUE="Enviar nota" class="button medium orange">
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