<?php

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Method: GET, POST, DELETE');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

require "../blogUtils.php";
$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == "GET") {
	if (isset($_GET['id'])) {
		$blog = getBlog($_GET);
		echo $blog;
	} else {
		$blogList = getBlogs();
		echo $blogList;
	}
} elseif ($requestMethod == "POST") {
	$inputData = json_decode(file_get_contents("php://input"), true);
	if (empty($inputData)) {
		$createBlog = createBlog($_POST);
	} else {
		$createBlog = createBlog($inputData);
	}
	echo $createBlog;
} elseif ($requestMethod == "DELETE") {
	$deleteBlog = deleteBlog($_GET);
	echo $deleteBlog;
} else {
	$data = [
		'status' => 405,
		'message' => $requestMethod . ' Method Not Allowed',
	];

	header("HTTP/1.0 405 Method Not Allowed");
	echo json_encode($data);
}

?>
