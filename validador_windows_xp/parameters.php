<?php
	//folders - rutas absolutas
	$ida = '/var/www/html/validador/admifarm/valida/admifarm/ida';
	$bkp = '/var/www/html/validador/admifarm/valida/admifarm/bkp';
	$rta = '/var/www/html/validador/admifarm/valida/admifarm/rta';

	//log - nombre del folder
	$logger = 'log';
	
	//wsdl desarrollo
	$wsdl = 'http://npievo.admifarmgroup.com/awsvalidacion.aspx?wsdl';

	//archivos wsdl para produccion - para que sea mas rápido
	//$wsdl = './wsdl/awsvalidacion.aspx';

	$method = 'Execute';
	
	// frecuencia en segundos
	$frecuency = 5; 
?>