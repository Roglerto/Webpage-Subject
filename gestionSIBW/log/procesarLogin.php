<html>
<head>
<title>SIBW</title>
</head>

<body>
	<?PHP
		require('../getbdcurso.php');
		$id = $_POST['id'];
		$pw = $_POST['clave'];
		
		if($id=='1234' && $pw=='1234')
		{
			session_start();
			$_SESSION['DNI'] = $id;
			$_SESSION['TIPO'] = 'admin';
			header("Location: ../apindex.php");
		}
		else
		{
			$conexion = mysql_connect('127.0.0.1:3306', 'root', '');
			mysql_select_db(getbdcurso(), $conexion);
			
			if(!$conexion)
			{
				die("Fallo en la conexión MYSQL: " . mysql_error());
			}
			$resultado = mysql_query("SELECT * FROM Alumno WHERE dnialumno=$id", $conexion);
			$nfilas = mysql_num_rows($resultado);
			
			if($nfilas != 0)
			{
				$fila = mysql_fetch_assoc($resultado);
				$_SESSION['DNI'] = $fila['dnialumno'];
				$_SESSION['TIPO'] = 'alumno';
				if($fila['isregister'] == TRUE)
					if($pw==$fila['password'])
					{
						session_start();
						$_SESSION['DNI'] = $id;
						$_SESSION['TIPO'] = 'alumno';
						header("Location: ../panelAlumno.php");
					}
					else
						header("Location: ../index.php");
				else
				{
					if($pw==$fila['password'])
						header("Location: registrarAlumno.php?id=$id");
					else
						header("Location: ../index.php");
				}
			}
			else
			{
				$resultado = mysql_query("SELECT * FROM profesor WHERE dniprofesor=$id", $conexion);
				$nfilas = mysql_num_rows($resultado);
				if($nfilas != 0)
				{
					$fila = mysql_fetch_assoc($resultado);
					if($fila['isregister'] == TRUE)
						if($pw==$fila['password']) // Comprobar que la pw es correcta
						{	
							$resultadoGestor = mysql_query("SELECT * FROM curso WHERE dniprofesor=$id", $conexion);
							$nfilasGestor = mysql_num_rows($resultadoGestor);
							if($nfilasGestor != 0)
							{
								session_start();
								$_SESSION['DNI'] = $fila['dniprofesor'];
								$_SESSION['TIPO'] = 'gestor';
								header("Location: ../panelProfesor.php");
							}
							else
							{
								session_start();
								$_SESSION['DNI'] = $fila['dniprofesor'];
								$_SESSION['TIPO'] = 'profesor';
								header("Location: ../panelProfesor.php");
							}
						}
						else
							header("Location: ../index.php");
					else
					{
						if($pw==$fila['password'])
							header("Location: registrarProfesor.php?id=$id");	
						else
							header("Location: ../index.php");
					}
				}
				else
					header("Location: ../index.php");
			}
		}
	?>
</body>
</html>
