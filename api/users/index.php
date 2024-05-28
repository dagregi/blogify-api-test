<?php

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Method: GET, POST, DELETE');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

require "../functions.php";
$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == "GET") {
	if (isset($_GET['id'])) {
		$user = getUser($_GET);
		echo $user;
	} else {
		$userList = getUsers();
		echo $userList;
	}
} elseif ($requestMethod == "POST") {
	$inputData = json_decode(file_get_contents("php://input"), true);
	if (empty($inputData)) {
		$createUser = createUser($_POST);
	} else {
		$createUser = createUser($inputData);
	}
	echo $createUser;
} elseif ($requestMethod == "DELETE") {
	$deleteUser = deleteUser($_GET);
	echo $deleteUser;
} else {
	$data = [
		'status' => 405,
		'message' => $requestMethod . ' Method Not Allowed',
	];

	header("HTTP/1.0 405 Method Not Allowed");
	echo json_encode($data);
}

?>
