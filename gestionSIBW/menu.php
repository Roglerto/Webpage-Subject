<?php
	require('calendario.php');
	require('getbdcurso.php');
?>
		<div id="pan_superior">
			<div id="logo">
				<IMG SRC="logoLSI.png" height="64" align="middle">
			</div>
			<div id="login_superior">
				<?PHP
				
					$conexion = mysql_connect('127.0.0.1:3306', 'root', '');
					mysql_select_db(getbdcurso(), $conexion);
					
					if(!$conexion)
					{
						die("Fallo en la conexión MYSQL: " . mysql_error());
					}
					if($tipo == 'alumno')
					{
						$resultado = mysql_query("SELECT * FROM Alumno WHERE dnialumno=$dni", $conexion);
						$nfilas = mysql_num_rows($resultado);
						$fila = mysql_fetch_assoc($resultado);
						
						echo "<a id='nombreLog' href='personalAlumno.php'>";
						echo "<IMG id='fotoUsuario' SRC='usuario.gif' alt='usuario' width='30' height='30'>";
						echo $fila['nombrealumnoa'];
						echo " ";
						echo $fila['apellidos'];
						echo "</a>";
					}
					elseif($tipo == 'profesor' || $tipo == 'gestor')
					{
						$resultado = mysql_query("SELECT * FROM Profesor WHERE dniprofesor=$dni", $conexion);
						$nfilas = mysql_num_rows($resultado);
						$fila = mysql_fetch_assoc($resultado);
						
						echo "<a id='nombreLog' href='personalProfesor.php'>";
						echo "<IMG id='fotoUsuario' SRC='usuario.gif' alt='usuario' width='30' height='30'>";
						echo $fila['nombre'];
						echo " ";
						echo $fila['apellidos'];
						echo "</a>";
					}
				?>
		
				<FORM ACTION="conexion.php" METHOD="POST" STYLE="DISPLAY: inline;">		
					<INPUT TYPE="submit" NAME="logout" VALUE="Cerrar Sesion" class="button medium blue">
				</FORM>
			</div>
		</div>
	
		<div id="pan_izquierdo">
			<?PHP 
			
				
				if($tipo == 'alumno')
				{	
					$conexion = mysql_connect('127.0.0.1:3306', 'root', '');
					mysql_select_db(getbdcurso(), $conexion);
					$resultado= mysql_query("SELECT * from tiene WHERE dnialumno='$dni'",$conexion);
					$var = mysql_num_rows($resultado) ;
	
					$notif = "NOTIFICACIONES (";
					$notif = $notif . $var;
					$notif = $notif . ")";
					echo'
				
					<ul class="navbar">
						<li><a href="panelAlumno.php">PAGINA PRINCIPAL</a></li>
						<li><a href="personalAlumno.php">PAGINA PERSONAL</a>
							<ul class="submenu">
								<li><a href="personalAlumno.php">VER</a></li>
								<li><a href="personalAlumnoEditar.php">EDITAR</a></li>
							</ul>
						<li><a href="#">DOCENCIA</a>
							<ul class="submenu">
								<li><a href="vercalificaciones.php">VER CALIFICACIONES</a></li>
								<li><a href="verarchivos.php">VER ARCHIVOS</a></li>
								<li><a href="subirarchivos.php">SUBIR ARCHIVOS</a></li>
							</ul>
						</li>
						<li><a href="verNotificaciones.php">';
						echo $notif;
						echo '</a></li>
					</ul>
				';
				}
				else
					if($tipo == 'profesor')
					{
						echo'
					<ul class="navbar">
						<li><a href="panelProfesor.php">PAGINA PRINCIPAL</a></li>
						<li><a href="personalProfesor.php">PAGINA PERSONAL</a>
							<ul class="submenu">
								<li><a href="personalProfesor.php">VER</a></li>
								<li><a href="personalProfesorEditar.php">EDITAR</a></li>
							</ul>
						<li><a href="#">DOCENCIA</a>
							<ul class="submenu">
								<li><a href="gestioncalificaciones.php">GESTIONAR CALIFICACIONES</a></li>
								<li><a href="vercalificaciones.php">VER CALIFICACIONES</a></li>
								<li><a href="verarchivos.php">VER ARCHIVOS</a></li>
								<li><a href="subirarchivos.php">SUBIR ARCHIVOS</a></li>
							</ul>
						</li>
					</ul>
						';
					}
					else
						if($tipo == 'gestor')
						{
							echo'
					<ul class="navbar">
						<li><a href="panelProfesor.php">PAGINA PRINCIPAL</a></li>
						<li><a href="personalProfesor.php">PAGINA PERSONAL</a>
							<ul class="submenu">
								<li><a href="personalProfesor.php">VER</a></li>
								<li><a href="personalProfesorEditar.php">EDITAR</a></li>
							</ul>
						<li><a href="#">DOCENCIA</a>
							<ul class="submenu">
								<li><a href="gestioncalificaciones.php">GESTIONAR CALIFICACIONES</a></li>
								<li><a href="vercalificaciones.php">VER CALIFICACIONES</a></li>
								<li><a href="verarchivos.php">VER ARCHIVOS</a></li>
								<li><a href="subirarchivos.php">SUBIR ARCHIVOS</a></li>
							</ul>
						</li>	
						<li><a href="#">GESTION</a>
							<ul class="submenu">
								<li><a href="registrarProfesor.php">REGISTRAR PROFESOR</a></li>
								<li><a href="modificarProfesor.php">MODIFICAR PROFESOR</a></li>
								<li><a href="registrarAlumno.php">REGISTRAR ALUMNO</a></li>
								<li><a href="modificarAlumno.php">MODIFICAR ALUMNO</a></li>
								<li><a href="crearGrupo.php">CREAR GRUPO</a></li>
								<li><a href="modificarGrupo.php">MODIFICAR GRUPO</a></li>
							</ul>
						</li>
					</ul>
							';
						}
						elseif($tipo == 'admin')
							echo'
					<ul class="navbar">
						<li><a href="apmake.php">CREAR CURSO</a></li>
						<li><a href="apdelete.php">ELIMINAR CURSO</a>
					</ul>';
			?>
			<form id="formulario" class="calendarioEstilo">
				<p>
					<?php
						$hora = getdate(time());
						//print( $hora["hours"] . ":" . $hora["minutes"] . ":" . $hora["seconds"] . "    | " ); 

						echo gmdate('d-m-Y ');
					?>
					<input type="text" name="fecha" id="fecha"  /> <a "show_calendar()" style="cursor: pointer;"><small>(calendario)</small></a>
					<a onclick="show_calendar()" style="cursor: pointer;"></a>
					<div id="calendario">
						<?php calendar_html() ?>
					</div>
				</p>
			</form>
		</div>