<?php
	if ( ( status('leer') == 'started' ) )
	{
    	status('escribir', 'stoping');
	}
	
	function status($accion, $valor='')
	{
		if($accion == 'leer')
		{
			return file_get_contents('control/status.txt', "r");
		} else {
			file_put_contents('control/status.txt', '');
			return file_put_contents('control/status.txt', $valor, FILE_APPEND);
		}
	}
?>
