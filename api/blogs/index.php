<?php

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Method: GET');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

require "../functions.php";
$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == "GET") {
	$userList = getBlogs();
	echo $userList;
} else {
	$data = [
		'status' => 405,
		'message' => $requestMethod . ' Method Not Allowed',
	];

	header("HTTP/1.0 405 Method Not Allowed");
	echo json_encode($data);
}

?>
