<?php

require "../../database.php";

function getBlogs() {
	global $mysqli;
	$query = "SELECT * FROM blogs";
	$result = mysqli_query($mysqli, $query);
	if ($result) {
		if (mysqli_num_rows($result) > 0) {
			$res = mysqli_fetch_all($result, MYSQLI_ASSOC);
			$data = [
				'status' => 200,
				'message' => 'Fetched Successfully',
				'data' => $res,
			];

			header("HTTP/1.1 200 OK");
			return json_encode($data);
		} else {
			$data = [
				'status' => 404,
				'message' => 'Content Not Found',
			];

			header("HTTP/1.1 404 Not Found");
			return json_encode($data);
		}
	} else {
		$data = [
			'status' => 500,
			'message' => 'Internal Server Error',
		];

		header("HTTP/1.1 500 Internal Server Error");
		return json_encode($data);
	}

}

function getBlog($blogParam) {
	global $mysqli;

	$id = mysqli_real_escape_string($mysqli, $blogParam['id']);
	$query = "SELECT * FROM blogs WHERE blog_id='$id'";
	$result = mysqli_query($mysqli, $query);
	if ($result) {
		if (mysqli_num_rows($result) == 1) {
			$res = mysqli_fetch_all($result, MYSQLI_ASSOC);
			$data = [
				'status' => 200,
				'message' => 'Fetched Successfully',
				'data' => $res,
			];

			header("HTTP/1.1 200 OK");
			return json_encode($data);
		} else {
			$data = [
				'status' => 404,
				'message' => 'Content Not Found',
			];

			header("HTTP/1.1 404 Not Found");
			return json_encode($data);
		}
	} else {
		$data = [
			'status' => 500,
			'message' => 'Internal Server Error',
		];

		header("HTTP/1.1 500 Internal Server Error");
		return json_encode($data);
	}

}


function createBlog($blogData) {
	global $mysqli;

	$user_id = mysqli_real_escape_string($mysqli, $blogData['user_id']);
	$title = mysqli_real_escape_string($mysqli, $blogData['title']);
	$content = mysqli_real_escape_string($mysqli, $blogData['content']);

	$validate = empty(trim($title)) || empty(trim($content));
	if ($validate) {
		$data = [
			'status' => 422,
			'message' => 'Missing Blog Data',
		];

		header("HTTP/1.1 422 Unprocessable Entity");
		return json_encode($data);
	} else {
		$query = "INSERT INTO blogs (user_id, title, content) VALUES ('$user_id', '$title', '$content')";
		$result = mysqli_query($mysqli, $query);

		if ($result) {
			$data = [
				'status' => 201,
				'message' => 'Created Successfully',
			];

			header("HTTP/1.1 201 Created");
			return json_encode($data);
		} else {
			$data = [
				'status' => 500,
				'message' => 'Internal Server Error',
			];

			header("HTTP/1.1 500 Internal Server Error");
			return json_encode($data);
		}
	}

}

function deleteBlog($blogParam) {
	global $mysqli;

	$id = mysqli_real_escape_string($mysqli, $blogParam['id']);
	$query = "DELETE FROM blogs WHERE blog_id='$id' LIMIT 1";
	$result = mysqli_query($mysqli, $query);
	if ($result) {
		$data = [
			'status' => 200,
			'message' => 'Deleted Successfully',
		];

		header("HTTP/1.1 200 OK");
		return json_encode($data);
	} else {
		$data = [
			'status' => 404,
			'message' => 'Content Not Found',
		];

		header("HTTP/1.1 404 Not Found");
		return json_encode($data);
	}
}

?>
