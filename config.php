<?php

	$config = array(
		'version'     		=> '0.5.1',
		'release_name'		=> 'veroniEngine',
		'host'       		=> 'localhost',
		'domain' 		=> 'http://umechan.strangled.net/',
		'user'        		=> '',
		'pass'        		=> '',
		'database'    		=> '',
		'postsTable'  		=> 'posts',
		'threadsTable'		=> 'threads',
		'logTable'    		=> 'logging',
		'owner_login' 		=> '',
		'owner_passw' 		=> ''
	);

	$services = array(
		'0' => array( '1' => 'Несвежий', '0' => 'http://ume.mooo.com/' ),
		'1' => array( '1' => 'Галерея', '0' => 'http://pic.neko.pp.ua/' ),
		'2' => array( '1' => 'Пастач', '0' => 'http://paste.neko.pp.ua/' ),
		'3' => array( '1' => 'Багтрекер', '0' => 'https://bitbucket.org/ridouchire/brodieja-track' ),
	);

//NB
// owner_login and owner_passw need for accessing to admin.php
// look like
// domain.net/admin.php?login=LOGIN&passw=PASSWORD

?>
