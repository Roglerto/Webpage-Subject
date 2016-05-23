<?PHP
function getbdcurso()
{
	$fechaactual = date('Y-m-d');
	$empiezacurso = date('Y-10-01');
	$fechaactualtime = strtotime($fechaactual);
	$empiezacursotime = strtotime($empiezacurso);

	$cursotag = '';
	if ($empiezacursotime > $fechaactualtime)
	{
		$cursotag = date('Y-m-d', strtotime('-1 year')) ; // resta 1 año
		$cursotag = substr($cursotag,0,4);
	}
	else
	{
		$cursotag = date('Y-m-d');
		$cursotag = substr($cursotag,0,4);;
	}
	return "bd".$cursotag;
}
?>