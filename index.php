<?php
	
	session_start();
  	if (isset($_SESSION['name'])) $name = $_SESSION['name'];
  	else $_SESSION['name'] = date("U");

  	if ( ($_COOKIE['ume_style'] != 'umedark') && ($_COOKIE['ume_style'] != 'umelight') && ($_COOKIE['ume_style'] != 'shirodark') ){
		SetCookie("ume_style","umelight",time()+(12*31*24*3600)); $style_sheet = 'gurochan.css';
	}

	if ($_COOKIE['ume_style'] == 'umelight'){ $style_sheet = 'gurochan.css'; }
	if ($_COOKIE['ume_style'] == 'umedark'){ $style_sheet = 'umedark.css'; }
	if ($_COOKIE['ume_style'] == 'shirodark'){ $style_sheet = 'shirodark.css'; }

	if (isset($_GET['st'])) {
	  	if ($_GET['st'] == 'umelight') {
	  		SetCookie("ume_style","umelight",time()+(12*31*24*3600));
	  		$style_sheet = 'gurochan.css';
	  	}

	  	if ($_GET['st'] == 'umedark') {
	  		SetCookie("ume_style","umedark",time()+(12*31*24*3600));
	  		$style_sheet = 'umedark.css';
	  	}

	  	if ($_GET['st'] == 'shirodark') {
	  		SetCookie("ume_style","shirodark",time()+(12*31*24*3600));
	  		$style_sheet = 'shirodark.css';
	  	}
	  }

  	require "function.php";
  	$index  = true;
	$fn -> fn_get_data();

	// add header

	$fn -> fn_include();
	$fn -> fn_logging('viewed index.php');

	// process variable
	// POST-first ; GET-second
	if (isset($_POST['textblock']) || isset($_FILES["fileblock"])) {
		$email = $_POST['emailblock'];
		$theme = $_POST['themeblock'];
		$text  = $_POST['textblock'];
		// include "picture.tpl";

		if ($_FILES["fileblock"] != NULL) {
			$fn -> fn_processing_picture();
		} else {
			$filepath = 'noneanyimg';
		}

		// there process posting
		$check = ( ($filepath != 'noneanyimg') || (strlen($theme) > 0) || (strlen($text) > 0) );

		if ($check == 1) {

			$fn -> fn_processing_text();
			$fn -> fn_check_doublePost();

			if ($check == 0) {
				echo "<center><span class=redverybig><hr>Something Bad! :< <hr><hr></span> </center>"; 
			} else {
				$fn -> fn_create_thread();
			}
			
		}

	}

	$fn -> fn_output_threads();

	die('</body></html><!kek>');

?>