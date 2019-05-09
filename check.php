<?php
	include "credentials.php"; // Trong file này chứa các thông tin xác thực của server
	$conn = new mysqli($mysql_server, $mysql_username, $mysql_password, $mysql_database);
	if (!$conn) die("Failed to connect to database.");
	$response = [];
	$response['messages'] = [];
	
	$question = $_GET['question'];
	$answer = $_GET['answer'];
	
	$check = $conn->query("SELECT * FROM `questions` WHERE `id` = $question AND `answer` = '$answer'");
	if ($check -> num_rows == 0) {
		// sai
		$response['messages'][] = array(
			"text" => "Sai rồi...",
			"quick_replies" => [
				array(
					"title" => "Tiếp tục",
					"type" => "json_plugin_url",
					"url" => "http://ngoctram.ml/webhook.php"
				)
			]
		);
	} else {
		$response['messages'][] = array(
			"text" => "Đúng rồi!",
			"quick_replies" => [
				array(
					"title" => "Tiếp tục",
					"type" => "json_plugin_url",
					"url" => "http://ngoctram.ml/webhook.php"
				)
			]
		);
	}
	echo json_encode($response);
?>