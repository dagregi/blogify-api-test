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

			header("HTTP/1.1 200 Ok");
			return json_encode($data);
		} else {
			$data = [
				'status' => 404,
				'message' => 'Content Does not exist',
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

?>
