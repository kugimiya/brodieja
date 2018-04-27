<?php

	if ($_COOKIE['ume_style'] == 'umelight'){ $style_sheet = 'gurochan.css'; }
	if ($_COOKIE['ume_style'] == 'umedark'){ $style_sheet = 'umedark.css'; }
	if ( ($_COOKIE['ume_style'] != 'umedark') && ($_COOKIE['ume_style'] != 'umelight') ){
		$style_sheet = 'gurochan.css'; }

	require "function.php";

	$fn -> fn_get_data();

	$login = $_GET['login'];
	$passw = $_GET['passw'];

	$num  = -1;
	$hash = '';

	if ( ($config['owner_passw'] == $passw) && ($config['owner_login'] == $login) ) {

		include "templates/view/header.tpl";

		echo "<form method='post' action='admin.php?login={$login}&passw={$passw}' enctype='multipart/form-data'><input type='hidden' name='nuke' value='nuke'><input type='submit' value='DANGEROUS DROP ALL DATABASE'></form><hr>";

		echo "<table bgcolor=ededed bordercolor=fff border=1>";
		for ($i=0; $i < $countLogs; $i++) { 
			echo "<tr>";
			echo "<td> {$i} </td>";
			echo "<td> {$allLogs[$i][TIME]} </td>";
			echo "<td> {$allLogs[$i][IP]} </td>";
			echo "<td> {$allLogs[$i][ACTION]} </td>";
			echo "<td> {$allLogs[$i][SESSION]} </td>";
			echo "<td> {$allLogs[$i][USERAGENT]} </td>";
			echo "</tr>";
		}
		echo "</table><hr>";

		if ($_POST['postnum'] > 0) { $num = $_POST['postnum']; }
		if ($_POST['threadhash'] != '') { $hash = $_POST['threadhash']; }
		if ($_POST['nuke'] == 'nuke') { echo "LLDFLSLSG"; $fn -> fn_nuke; }
		
		if ($num != -1) { 
			mysql_query("
				DELETE
				FROM {$config['postsTable']}
				WHERE ID = {$num}") or die(mysql_error());
		}

		if ($hash != '') {
			mysql_query("
				DELETE
				FROM {$config['threadsTable']}
				WHERE HASH = '{$hash}'") or die(mysql_error());
		}

		$fn -> fn_get_data();

		for ($i=0; $i < $countThreads; $i++) {
			if ($fn -> fn_findcount($allThreads[$i],$allPosts) == 0) {
				echo "THIS IS EMPTY THREAD! // ";
			}
			echo "{$allThreads[$i][ID]} .. {$allThreads[$i][HASH]}";
			echo "<form method='post' action='admin.php?login={$login}&passw={$passw}' enctype='multipart/form-data'><input type='hidden' name='threadhash' value='{$allThreads[$i][HASH]}'><input type='submit' value='delete this thread'></form><hr>";
		}

		for ($i=0; $i < $countPosts; $i++) {
			$outputModePost = 'cirno';
			include "templates/output/post.tpl";
			echo "<form method='post' action='admin.php?login={$login}&passw={$passw}' enctype='multipart/form-data'><input type='hidden' name='postnum' value='{$allPosts[$i][ID]}'><input type='submit' value='delete this post'></form><hr>";
		}

	} else { die('not access!'); }
	

?>