<?php

	// so fuckin special
	// including my mysql-libr
	// and server-config file
	
	include 'html/fn_db.php';
	include 'html/config.php';
	
	//include 'html/fn_en.php';
	//$en_worker = new mainEN;
	
	$db_worker = new mainDB;

	$link = $db_worker -> fn_connect($db_configuration);
	mysql_select_db($db_configuration['database'],$link) 
		or $db_worker -> fn_createDataBase($db_configuration['database'])
			or die(mysql_error());

	// so, then we must processing POST-data

	if ( $_POST['mode'] == 'request' ) {

		if ( $_POST['type'] == 'thread' ) {

			if ( $_POST['option'] == 'all_indef' ) {
				//	1. Возвращать список всех тредов на доске.
				//	пока не буду трогать тему нескольких досок

				$condition = array();
				$all_data = $db_worker -> fn_SelectFromTable('THREADS', $condition);

				$reversed_threads_array = array();

				for ($i=0; $i < count($all_data); $i++) { 
					$reversed_threads_array[] = $all_data[$i]['HASH'];
				}

				$reverse = array 
				(
					"access_token" => "blahblah",
					"request_num" => $_POST['request_num'],
					"threads_id_list" => $reversed_threads_array
				);

				header('Content-type:application/json;charset=utf-8');
				echo json_encode($reverse);

			}

			if ( $_POST['option'] == 'all_data') {
				//2. Возвращать тред с постами и прочей мишурой.

				$condition = array
				(
					'HASH' => $_POST['thread_id']
				);

				$reversed_at_thread = $db_worker -> fn_SelectFromTable(
					'THREADS', $condition
				);


				$condition = array
				(
					'THREAD' => $reversed_at_thread[0]['ID']
				);
				$reversed_at_posts = $db_worker -> fn_SelectFromTable(
					'POSTS', $condition
				);

				//var_dump($reversed_at_posts);

				$reverse = array 
				(
					"access_token" => "blahblah",
					"request_num" => $_POST['request_num'],
					"thread" => array 
						(
							"thread_id" => $reversed_at_thread[0]['ID'],
							"thread_status" => 1,
							"thread_posts" => $reversed_at_posts
						)
				);
				
				header('Content-type:application/json;charset=utf-8');
				echo json_encode($reverse);
			}
		}
	}

?>