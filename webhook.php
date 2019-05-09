<?php
	include "credentials.php"; // Trong file này chứa các thông tin xác thực của server
	$conn = new mysqli($mysql_server, $mysql_username, $mysql_password, $mysql_database);
	if (!$conn) die("Failed to connect to database.");
	
	$row = $conn->query("SELECT * FROM `questions` WHERE 1 ORDER BY RAND() LIMIT 1");
	$question_row = $row->fetch_assoc();
	$question = json_decode(base64_decode($question_row['data']), true);
	
	$response = []; // tạo một mảng mặc định chúng ta sẽ reply lại cho chatfuel để gửi tới người dùng.
	$response['messages'] = []; // mảng các tin nhắn được trả về
	
	// một câu hỏi sẽ bao gồm 2 phần là header và text
	
	$question_text = $question['header'] . PHP_EOL . $question['text'] . PHP_EOL . PHP_EOL; // PHP_EOL là xuoogns dòng
	foreach ($question['choices'] as $choice) {
		$question_text .= $choice . PHP_EOL;
		
	}
	// đã có câu hỏi, giờ sẽ config cho câu trả lời
	
	$response['messages'][] = array(
		"text" => $question_text,
		"quick_replies" => [
			array(
				"title" => "A",
				"type" => "json_plugin_url",
				"url" => "http://ngoctram.ml/check.php?question={$question_row['id']}&answer=A"
			),
			array(
				"title" => "B",
				"type" => "json_plugin_url",
				"url" => "http://ngoctram.ml/check.php?question={$question_row['id']}&answer=B"
			),
			array(
				"title" => "C",
				"type" => "json_plugin_url",
				"url" => "http://ngoctram.ml/check.php?question={$question_row['id']}&answer=D"
			),
			array(
				"title" => "D",
				"type" => "json_plugin_url",
				"url" => "http://ngoctram.ml/check.php?question={$question_row['id']}&answer=D"
			)
		]
	);
	
	// giờ làm phần check câu hỏi nè
	
	
	echo json_encode($response);
	
	
/*
{
  "messages": [
    {
      "text":  "Did you enjoy the last game of the CF Rockets?",
      "quick_replies": [
        {
          "title":"Loved it!",
          "block_names": ["Block 1", "Block 2"]
        },
        {
          "title":"Not really...",
          "url": "https://rockets.chatfuel.com/api/sad-match",
          "type":"json_plugin_url"
        }
      ]
    }
  ]
}
*/
?>