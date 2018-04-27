<?php
	
	session_start();
  	if (isset($_SESSION['name'])) $name = $_SESSION['name'];
  	else $_SESSION['name'] = date("U");

  	if ($_COOKIE['ume_style'] == 'umelight'){ $style_sheet = 'gurochan.css'; }
	if ($_COOKIE['ume_style'] == 'umedark'){ $style_sheet = 'umedark.css'; }
	if ($_COOKIE['ume_style'] == 'shirodark'){ $style_sheet = 'shirodark.css'; }
	if ( ($_COOKIE['ume_style'] != 'umedark') && ($_COOKIE['ume_style'] != 'umelight')&& ($_COOKIE['ume_style'] != 'shirodark') ){
		$style_sheet = 'gurochan.css'; }

  	$fn = require "function.php";
  	//$fn = new Main;
  	$index  = false;
  	$fn -> fn_get_data();

	$threadHash = $_GET['hash'];
	// определяем номер треда по хэшу, and you are my nya~ ! :3 ^...^
	$threadNum = -1;
	for ($i=0; $i < $countThreads; $i++) { 
		if ($allThreads[$i]['HASH'] == $threadHash) {
			$threadNum = $i;
		}
	}

	if ($threadNum == -1) { die('error occured! /bad thread indentification/'); }

	// POST-queries
	$email = $_POST['emailblock'];
	$theme = $_POST['themeblock'];
	$text  = $_POST['textblock'];
	$fn -> fn_processing_picture();

	// there process posting
	$check = ( ($filepath != 'noneanyimg') || (strlen($theme) > 0) || (strlen($text) > 0) );

	if ($check == 1) {

		$fn -> fn_processing_text();
		$fn -> fn_check_doublePost();

		if ($check == 0) {
			echo "<center><span class=redverybig><hr>Something Bad! :< <hr><hr></span> </center>"; 
		} else {
			$fn -> fn_bump_thread();
		}
		
	}

	// add header
	$fn -> fn_logging("viewed thread.php in ${threadHash}");
	$fn -> fn_include();

	// по номеру треда выводим соответствующие посты, кек
	$fn -> fn_get_data();

	$value = $allThreads[$threadNum];
	$outputMode = 'thread';
	$fn -> fn_output_thread($value);

	echo "<br><center><a href='index.php'>Назад</a></center>";

?>