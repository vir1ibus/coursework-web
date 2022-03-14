<?php
	require_once('controller-database.php');
	session_start();
	if(isset($_POST['logout'])) {
		$sql = "DELETE FROM user_token WHERE token = '${_POST['token']}';";
		if(mysqli_query($connect_db, $sql)) {
			setcookie("token", "", -1);
			header("Location: http://builder-shop/index.php");
			unset($_POST['logout']);
			exit;
		}
	} else if(isset($_POST['login'])) {
		$username = mysqli_real_escape_string($connect_db, $_POST['username']);
		$sql = "SELECT * FROM user WHERE username = '${username}' AND password = '".hash('sha512', $_POST['password'])."';";
		$result = mysqli_query($connect_db, $sql);
		$error = mysqli_error($connect_db);
		if(mysqli_num_rows($result) == 0) {
			$_SESSION['error'] = "error_login";
			header("Location: http://builder-shop/index.php?page=authorizationpage");
			unset($_POST['login']);
			exit;
		} else {
			$row = mysqli_fetch_array($result);
			$user_id = $row['id'];
			$token = bin2hex(random_bytes(15));
			$time_expired = date_create();
			date_timestamp_set($time_expired, time() + 3600);
			$time_expired_str = date_format($time_expired, 'Y-m-d H:i:s');
			$sql = "INSERT INTO user_token (user_id, token, time_expired) VALUES (${user_id}, '${token}', '${time_expired_str}');";
			if(mysqli_query($connect_db, $sql)){
				$_SESSION['user_id'] = $user_id;
				$_SESSION['username'] = $row['username'];
                $_SESSION['token'] = $token;
				header('Location: http://builder-shop/index.php');
            } else {
				$_SESSION['error'] = "error_db";
				header("Location: http://builder-shop/index.php?page=authorizationpage");
            }
            unset($_POST['login']);
            exit;
        }
	}
?>