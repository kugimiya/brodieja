<?php
	
	class Main {

		function ereg_replace( $pattern ,  $replacement ,  $string ){
			//  preg_replace (  $pattern ,  $replacement ,  $subject  )
			return preg_replace (  $pattern ,  $replacement ,  $subject  );
		}

		function set_db($dblink){
			$this->db = $dblink;
		}

		function fn_query($query){
			return mysqli_query($this->db, $query);
		}

		function fn_fetching($arr, $countarr){
			$res = [];

			for ($i=0; $i < $countarr; $i++) 
				$res[$i] = mysqli_fetch_array($arr);
			
			return $res;
		}

		function fn_findcount($value1){
			global $allPosts;
			$res = 0;

			for ($i=0; $i < count($allPosts); $i++) {
				if ($value1['ID'] == $allPosts[$i]['THREAD']) {
					$res++;} 
			}
					
			return $res;
		}

		function fn_sort($what, $type, $mode){
			for ($i=0; $i < count($what); $i++) 
				for ($j=0; $j < count($what); $j++) 
					if ($i != $j) 
						if ($mode == 'up'){
							if ($what[$j][$type] > $what[$i][$type]){
								$x = $what[$i];
								$what[$i] = $what[$j];
								$what[$j] = $x;
							}
						} else {
							if ($what[$j][$type] < $what[$i][$type]){
								$x = $what[$i];
								$what[$i] = $what[$j];
								$what[$j] = $x;
							}
						}
			return $what;
		}

		function fn_get_data(){

			global $allThreads, $allPosts, $allLogs, $countThreads, $countPosts, $countLogs, $config, $index;

			$allThreads   = $this->fn_query("SELECT * FROM {$config['threadsTable']}");
			$countThreads = mysqli_num_rows($allThreads);
			$allThreads   = $this -> fn_fetching($allThreads, $countThreads);
			if ($index == true) 
				$allThreads   = $this -> fn_sort($allThreads, 'TIME', 'low');

			$allPosts     = $this->fn_query("SELECT * FROM {$config['postsTable']}");
			$countPosts   = mysqli_num_rows($allPosts);
			$allPosts     = $this -> fn_fetching($allPosts, $countPosts);
			$allPosts     = $this -> fn_sort($allPosts, 'ID', 'up');

			$allLogs      = $this->fn_query("SELECT * FROM {$config['logTable']}");
			$countLogs    = mysqli_num_rows($allLogs);
			$allLogs      = $this -> fn_fetching($allLogs, $countLogs);
			//$allLogs      = $this -> fn_sort($allLogs, 'SESSION');			
		}

		function fn_include(){
			global $style_sheet, $index, $services;
			$actioninfo = $index ? 'index.php' : 'thread.php';

			include "templates/view/header.tpl";
			include "templates/view/adminbar.tpl";
			//include "templates/view/logo.tpl";
			include "templates/view/postarea.tpl";
		}

		function fn_logging($action){
			global $config;

			$ip 		  = $_SERVER["REMOTE_ADDR"];
			$session_name = $_SESSION['name'];
			$session_time = date("U");
			$useragent    = $_SERVER["HTTP_USER_AGENT"];

			$Thour = date("H"); $Tmin  = date("i"); $Tsec  = date("s");
			$Dtime = "${Thour}:${Tmin}:${Tsec}";

			$Dday  = date("d"); $Dmout = date("m"); $Dyear = date("y");
			$Ddate = "${Dday}.${Dmout}.${Dyear}";

			$session_time = $Ddate.'  ..  '.$Dtime;

			$str = "INSERT INTO {$config['logTable']}
			VALUES ('${ip}','${useragent}','${session_name}','${session_time}','${action}') ";

			$this->fn_query($str) or die();
		}

		function fn_processing_picture(){

			global $filepath;
			if ( ($_FILES["fileblock"]["size"] > 0) ) {
			    if (($_FILES["fileblock"]["size"] < 1024*2.5*1024)  ) {
			    	$track = false;

			    	$timed = date("U");
			        $filepath = "img/".$timed;
			        if ($_FILES["fileblock"]["type"] == "image/png")  {  $filepath .= ".png" ; $track = true; }
			        if ($_FILES["fileblock"]["type"] == "image/jpeg") {  $filepath .= ".jpg" ; $track = true; }
			        if ($_FILES["fileblock"]["type"] == "image/gif")  {  $filepath .= ".gif" ; $track = true; }

			        if ( (is_uploaded_file($_FILES["fileblock"]["tmp_name"]) && ($track == true)) ) {
			            move_uploaded_file($_FILES["fileblock"]["tmp_name"], $filepath);


			        // also, there creating thumbnail

					$source=$filepath;
					$rgb=0;
					$height=200; 
					$width=200;
					$size = getimagesize($source);
					// file-format
					$format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
					//определение функции соответственно типу файла
					$icfunc = "imagecreatefrom" . $format;
					//если нет такой функции прекращаем работу скрипта
					if (!function_exists($icfunc)) return false;
					// пропорции
					$x_ratio = $width / $size[0];
					$y_ratio = $height / $size[1];
					$ratio       = min($x_ratio, $y_ratio);
					$use_x_ratio = ($x_ratio == $ratio);
					$new_width   = $use_x_ratio  ? $width  : floor($size[0] * $ratio);
					$new_height  = !$use_x_ratio ? $height : floor($size[1] * $ratio);
					$new_left    = $use_x_ratio  ? 0 : floor(($width - $new_width) / 2); 
					$new_top     = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);
					$img = imagecreatetruecolor($new_width,$new_height);
					imagefill($img, 0, 0, $rgb);
					$photo = $icfunc($source);
					imagecopyresampled($img, $photo, 0, 0, 0, 0, $new_width, $new_height, $size[0], $size[1]);
					imagejpeg($img, $filepath."thumb.jpg", 75);
					// Очищаем память после выполнения скрипта
					imagedestroy($img);
					imagedestroy($photo);

			        } else { $filepath = 'noneanyimg'; }

			    } else { 
			    	$filepath = 'noneanyimg'; 
			    	echo "file is too big, master! .///."; exit;
						}
			} else {
				$filepath = 'noneanyimg'; 
			}
		}

		function auto_link($proto){
	  		//$proto = $this->ereg_replace("(https?|ftp|news|http)(://[[:alnum:]\+\$\;\?\.%,!#~*/:@&=_-]+)","<a href=\"\\1\\2\" target=\"_blank\">\\1\\2</a>",$proto);
	  		return $proto;
		}

		function addiction($str) {
			$res = str_replace("'", '"', $str);
			$res = str_replace("&", '^', $str);
			$res = htmlspecialchars($res, ENT_COMPAT);
			$res = str_replace("^", '&', $str);
			return $res;
		}

		function fn_get_strings($str){
			$output = array();
			$count = 0;
			for ($i=0; $i <= strlen($str); $i++) { 

				if ($str[$i] != '
') {
					$output[$count] .= $str[$i];
				} else {
					$count++;
				}

			}
			return $output;
		}

		function fn_reply($str){

			if ($str[0] == '>') $str = "<span class = reply>{$str}</span>";

			return $str;
		}

		function fn_regular($value,$reason,$repopen,$repclose){

			$arr1 = array();
			$str = $value;
			$koef = 0;

			for ($i=0; $i < strlen($value); $i++) if ($value[$i] == $reason) $arr1[] = $i;

			for ($i=0; $i < count($arr1); $i++) { 

				if ( (((int)(($i+1) % 2)) == 1) && ($i != count($arr1)-1) ){

					$part1 = substr($str, 0, $arr1[$i]+$koef);
					$part2 = substr($str, $arr1[$i]+$koef+1, $arr1[$i+1] - $arr1[$i] - 1);
					$part3 = substr($str, $arr1[$i+1]+$koef+1, strlen($str));

					$koef = $koef + 5;  //Смещение

					$str = $part1.$repopen.$part2.$repclose.$part3;
				}

			}

			return $str;
		}

		function ume_mark($str){
			global $aliases, $replace1, $replace2;
			
			$strings = $this -> fn_get_strings($str);
			$str = '';

			foreach ($strings as $value) {
				$value = $this -> fn_reply($value);
				for ($i=0; $i < count($aliases); $i++) { 
					$value = $this -> fn_regular($value,$aliases[$i],$replace1[$i],$replace2[$i]);
				}
				$str = $str.$value;
			}

			return $str;
		}

		function fn_slashes($text) { return str_replace("'", "\\'", $text); }

		function fn_processing_text(){
			global $text, $theme, $email;
			$text   =  $this -> addiction($text);
		    	$theme  =  $this -> addiction($theme);
			$email  =  $this -> addiction($email);
		 	$text   = nl2br( $this -> ume_mark($text) );  // Разметка
		    	$text   = $this -> auto_link($text);
		    $text = $this -> fn_slashes($text);
			//if(!$theme||ereg("^[ |<81>@|]*$",$theme)) $theme="";
		}

		function fn_check_doublePost(){
			global $allPosts, $countPosts, $text, $check;

			foreach ($allPosts as $value) {
				if ($text == $value['TEXT']) 
					if ($filepath == 'noneanyimg') $check = false;
					else $check = true;
			}
		}

		function fn_crt_thread(){
			global $countThreads, $ThreadID, $config;
			
			$this -> fn_get_data();
			$ThreadID = $countThreads + 1;

			$timestamp = date("U");
			$hashstamp = bin2hex(mhash(MHASH_SHA1, $timestamp));

			$this->fn_query("INSERT INTO {$config['threadsTable']}
			VALUES ('${ThreadID}','${timestamp}','${hashstamp}') ") or die();

			$this -> fn_logging("created thread {$hashstamp}");
		}

		function fn_crt_post($PostOwner){
			global $countPosts, $allPosts, $theme, $text, $email, $filepath, $ThreadID, $config;
			
			$this -> fn_get_data();
			//var_dump($allPosts[$countPosts-1]['ID']);
			$PostID = $allPosts[$countPosts-1]['ID'] + 1;

			$Thour = date("H"); $Tmin  = date("i"); $Tsec  = date("s");
			$Dtime = "${Thour}:${Tmin}:${Tsec}";
			$Dday  = date("d"); $Dmout = date("m"); $Dyear = date("y");
			$Ddate = "${Dday}.${Dmout}.${Dyear}";

			if ($email == '') $email = $PostOwner;

			$this->fn_query("INSERT INTO {$config['postsTable']}
			VALUES ('${PostID}','${ThreadID}','${PostOwner}','${theme}','${text}','${email}','${Dtime}','${Ddate}','${filepath}') ") or die();

			$this -> fn_logging("created post {$PostID}");
		}

		function fn_create_thread(){
			$this -> fn_crt_thread();
			$this -> fn_crt_post('OP');
		}

		function fn_bump_thread(){
			global $threadNum, $ThreadID, $threadHash, $config;

			$ThreadID = $threadNum + 1;
			$timeTHRD = date("U"); 

			$str = "UPDATE {$config['threadsTable']}
			SET TIME = '{$timeTHRD}'
			WHERE HASH like '{$threadHash}'";
			//echo "<br> $str <br>";
			$this->fn_query($str) or die();

			$this -> fn_crt_post('Cirno');
		}

		function fn_post_data($postData){
			$returnedPostData = array(
				'picture_info' => 'pic'
			);

			if ($postData['IMG'] != 'noneanyimg') {
			    $picname = basename($config['domain'].$postData['IMG']);
			    $picsize = filesize($postData['IMG']) % 1024;
			    $imgsize = getimagesize($postData['IMG']);
			    $returnedPostData['picture_info'] = "Файл : {$picname} ({$picsize}Кб, {$imgsize[0]}x{$imgsize[1]})";
			    $returnedPostData['picture_info'] = $this->ereg_replace("(https?|ftp|news|http)(://[[:alnum:]\+\$\;\?\.%,!#~*/:@&=_-]+)","<a href=\"\\1\\2\" target=\"_blank\">{$picname}</a>",$returnedPostData['picture_info']);
				return $returnedPostData;
			} else {
				return 0;
			}
		}

		function fn_output_thread($value){
			global $countPosts, $allPosts, $countPostInThisThread, $outputMode, $PostData, $viewform, $config;

			//echo "{$value[TIME]} {$value['ID']} <br>";
			$counts = 0;
			$posting = true;

			for ($i=0; $i < $countPosts; $i++) {

				if ($allPosts[$i]['THREAD'] == $value['ID']){

					if ( ($countPostInThisThread > 3) ) {
						if ( ($counts == 0) || ($counts > $countPostInThisThread-3) ) {
							$posting = true;
							//echo "heh {$counts}";
						} else { $posting = false; }
					} else {  }

					if ( ($posting == true) || ($countPostInThisThread < 3) ) {

						$PostData = $this -> fn_post_data($allPosts[$i]);
						if ($counts == 0) {
							// output OP POST

							$countCut = ($countPostInThisThread-3);
					        $cutStr   = '';
					        if ( ($posting == true) && ($countCut > 0) ) {
					            if ($countCut == 1) {
					                $ss1 = 'Пропущен';
					                $ss2 = 'пост';
					            } else {
					                $ss1 = 'Пропущено';
					                $ss2 = 'постов';
					                if ( ($countCut > 1) && ($countCut < 5) ) {$ss2 = 'поста';}
					            }
					            $cutStr = "<br clear=both>".$ss1." {$countCut} ".$ss2.", нажмите <b>Ответить</b> чтобы увидеть.<br clear=both>";
					        }
					        
					        $outputModePost = 'op';
							include "templates/output/post.tpl";
							echo $cutStr;
						} else {
							// output CIRNO POST
							$outputModePost = 'cirno';
							include "templates/output/post.tpl";
						}
					}
					$counts++;
				}
			}

			echo "<hr>";
		}

		function fn_output_threads(){
			global $allThreads,$countPostInThisThread;
			$this -> fn_get_data();

			// then foreach kek
			foreach ($allThreads as $value) {
				$countPostInThisThread = $this -> fn_findcount($value);
				if ($countPostInThisThread > 0) $this -> fn_output_thread($value);
			}
		}

		function fn_setstyle(){
			
		}

	} 

	// there init all names
	// and simple init

	include "config.php";
	$link = mysqli_connect($config['host'],$config['user'],$config['pass']) or die();
	mysqli_select_db($link, $config['database']) or die();

	$fn = new Main;
	$fn -> set_db($link);
	$fn -> fn_get_data();	
	ini_set('display_errors', 0);

	$aliases = array();
	$replace1 = array();
	$replace2 = array();

	$aliases[] = '*'; $replace1[] = '<i>'; $replace2[] = '</i>';
	$aliases[] = '&'; $replace1[] = '<b>'; $replace2[] = '</b>';
	$aliases[] = '%'; $replace1[] = '<s>'; $replace2[] = '</s>';
	//$aliases[] = '*'; $replace1[] = '<i>'; $replace2[] = '</i>';

	return $fn;

//echo "all right";
?>
