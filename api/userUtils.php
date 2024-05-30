<?php

require "../../database.php";

function getUsers() {
	global $mysqli;
	$query = "SELECT user_id, username, fullname, email FROM users";
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
				'message' => 'User Not Found',
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

function getUser($userParam) {
	global $mysqli;

	$id = mysqli_real_escape_string($mysqli, $userParam['id']);
	$query = "SELECT user_id, username, fullname, email FROM users WHERE user_id='$id'";
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
				'message' => 'User Not Found',
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

function createUser($userData) {
	global $mysqli;

	$username = mysqli_real_escape_string($mysqli, $userData['username']);
	$email = mysqli_real_escape_string($mysqli, $userData['email']);
	$fullname = mysqli_real_escape_string($mysqli, $userData['fullname']);
	$password = mysqli_real_escape_string($mysqli, $userData['password']);
	$password_hash = password_hash($password, PASSWORD_DEFAULT);

	$validate = empty(trim($username)) || empty(trim($email)) || empty(trim($fullname)) || empty(trim($password));
	if ($validate) {
		$data = [
			'status' => 422,
			'message' => 'Missing User Data',
		];

		header("HTTP/1.1 422 Unprocessable Entity");
		return json_encode($data);
	} else {
		$query = "INSERT INTO users (username, fullname, email, password) VALUES ('$username', '$fullname', '$email', '$password_hash')";
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

function deleteUser($userParam) {
	global $mysqli;

	$id = mysqli_real_escape_string($mysqli, $userParam['id']);
	$query = "DELETE FROM users WHERE user_id='$id' LIMIT 1";
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
			'message' => 'User Not Found',
		];

		header("HTTP/1.1 404 Not Found");
		return json_encode($data);
	}
}

?>
