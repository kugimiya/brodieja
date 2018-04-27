<?php

	require "config.php";
	$link = mysqli_connect($config['host'],$config['user'],$config['pass']) or die('mysqli err');

	mysqli_query($link, "DROP DATABASE IF EXISTS {$config['database']}") or die('mysqli err');

	mysqli_query($link, "CREATE DATABASE ".$config['database']) or die('mysqli err');
	mysqli_select_db($link, $config['database']) or die('mysqli err');

	echo "database {$config['database']} was created <br>";

	// Создаем таблицу постов в ней
	mysqli_query($link, "CREATE TABLE {$config['postsTable']} (
			  ID int,
		      THREAD int,
		      OWNER varchar(25),
		      TITLE varchar(255),
		      TEXT varchar(8196),
		      EMAIL varchar(255),
		      TIME varchar(10),
		      DATA varchar(25),
		      IMG varchar(50)
	)") or die('mysqli err');
	echo "table {$config['postsTable']} was created <br>";

	// Создаем таблицу тредов в ней
	mysqli_query($link, "CREATE TABLE {$config['threadsTable']} (
		      ID int,
		      TIME int,
		      HASH varchar(255)
	)") or die('mysqli err');
	echo "table {$config['threadsTable']} was created <br>";

	// Создаем таблицу логов в ней
	mysqli_query($link, "CREATE TABLE {$config['logTable']} (
		        IP varchar(255),
		        USERAGENT varchar(255),
		        SESSION varchar(255),
		        TIME varchar(255),
		        ACTION varchar(255)
	)") or die('mysqli err');
	echo "table {$config['logTable']} was created <br>";

?>
