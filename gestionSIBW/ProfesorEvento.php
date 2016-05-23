<?PHP
	include 'conexion.php';
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>SIBW</title>
	<link rel="stylesheet" href="estiloPortada.css">
	
	<script type="text/javascript" src="js/jquery-1.3.1.min.js"></script>
    <script type="text/javascript" src="js/jquery.functions.js"></script>
</head>

<body>
	<div id="body_wrapper">
	<?PHP
		include 'menu.php';
	?>
		<div id="pan_central">
			<?PHP
				//comenzamos recogiendo los datos
				function recogeDato($campo){ 
				return isset($_REQUEST[$campo])?$_REQUEST[$campo]:'';
				} //la función recogeDatos comprueba si se ha recibido un dato y recoge su valor
		   
				//si no se ha recibido, le asigna un valor vacío.
				 	
				$fechaComprobar = isset($_GET["fecha"]) ? $_GET["fecha"] : 4 ;

				$titulo 	= recogeDato('titulo');
				$fecha 	= recogeDato('fecha');
				$hora	 	= recogeDato('hora');
				$id	 	= recogeDato('id');
				$dniprofesor	 	= recogeDato('dniprofesor');
				

				$comentario = recogeDato('comentario');;
				$algunerror = FALSE;
			    
				$conexion = mysql_connect('127.0.0.1:3306', 'root', '');
				    mysql_select_db(getbdcurso(), $conexion);
					if(mysqli_connect_errno())
					{
						echo "Fallo en la conexión MYSQL: " . mysqli_connect_error();
					}

				
				$error_titulo = "";
				$error_fecha = "";
				$error_hora = "";
				$error_dniprofesor = "";
				$error_id = "";
				
		   
				if (isset($_REQUEST['enviadoEditar']))
				{
					if($titulo=="")
					{ //si esta vacio
						$algunerror = TRUE;
						$error_titulo = '<br><span class="erroneo"><br>Campo vacio</span>';
					}
					if($fecha=="")
					{ //si esta vacio
						$algunerror = TRUE;
						$error_fecha = '<br><span class="erroneo">Campo vacio</span>';
					}
					elseif($hora=="")
					{ //si esta vacio
							$algunerror = TRUE;
							$error_hora = '<br><span class="erroneo"><br>Campo vacio</span>';
					}
					elseif($dniprofesor=="")
					{ //si esta vacio
							$algunerror = TRUE;
							$error_dniprofesor = '<br><span class="erroneo"><br>Campo vacio</span>';
					}
					
					elseif($id=="")
					{ //si esta vacio
							$algunerror = TRUE;
							$error_id = '<br><span class="erroneo"><br>Campo vacio</span>';
					}
				}
			   // echo '<div class="aviso">Eventos creados:</div>';
		       //echo ' <input id="b1" type="button" onclick="location.href=resumeneventos.php;" />';
			// echo " <td><a href=resumeneventos.php?fecha=$fechaComprobar style=\"color:red;cursor:pointer;\" onclick=\"\"></a></td> ";

				if (isset($_REQUEST['enviadoEditar'])&&!$algunerror)
				{
					//HAY QUE METER EN LA BASE DE DATOS LOS DATOS Y PASAR A LA SIGUIENTE WEB (MENU PROFESOR O MENU ALUMNO)
					if($titulo!='' && $fecha!='' && $hora!=''&& $dniprofesor!='' &&  $comentario!=''  &&  $id!='')
					{
					
						
						//INSERT INTO `evento`(`titulo`, `fecha`, `hora`, `lugar`, `ddescripcion`) VALUES ('correr','2013-05-10','13:00','espacio','lol');
						$sql = "INSERT INTO evento  VALUES ('$fecha', '$titulo','$comentario', '$dniprofesor', '$id', '$hora')";					
                       

						
						
						if(!mysql_query($sql, $conexion))
					{
						die("Fallo en la conexión MYSQL: " . mysql_error());
						//die(header('Location: insercionFAIL.php'));
					}
					else echo '<div class="aviso">Se ha creado el nuevo evento </div>';
					}
					
				} 
				else 
				{
					if (isset($_REQUEST['enviadoEditar']))
					{
						echo '<div class="aviso">Por vavor, corrige los  errores:</div>';
					} 
					else 
					{
						echo '<div class="aviso">Por favor, rellene este formulario para continuar:</div>';
					}
				}
			   ?>
				      
			<div class="tituloConMenu">PÁGINA CREACION EVENTO</div>
			<table ALIGN="center" class="tabla_registro"> 
				<tr> 
					<td>
						<FORM ALIGN="right" id="login" ACTION="ProfesorEvento.php" METHOD="POST">
							Titulo del evento: <INPUT TYPE="text" NAME="titulo" VALUE="<?=$titulo?>"> <?=$error_titulo;?>
							<br>
							Fecha del evento: <INPUT TYPE="text" NAME="fecha" VALUE="<?=$fecha?>"> <?=$error_fecha;?>
							<br>
							Hora del evento: <INPUT TYPE="text" NAME="hora" VALUE="<?=$hora?>"> <?=$error_hora;?>
							<br>
							<br>
							DNI Creador: <INPUT TYPE="text" NAME="dniprofesor" VALUE="<?=$dniprofesor?>"> <?=$error_dniprofesor;?>
							<br>
							ID del evento: <INPUT TYPE="text" NAME="id" VALUE="<?=$id?>"> <?=$error_id;?>
							<br>
                             Descripcion del evento:
							<br>
							<textarea name="comentario" rows="10" cols="40"><?=$comentario;?></textarea>
							<br>
							<INPUT TYPE="submit" NAME="enviadoEditar" VALUE="Aceptar" class="boton">
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