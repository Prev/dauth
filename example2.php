<?php
	
	session_start();
	header('Content-Type: text/html; charset=utf-8');
	
	if ($_GET['q'] == 'login' && isset($_GET['token'])) {
		$result = file_get_contents('http://api.dimigo.hs.kr/dauth?token='.$_GET['token']);
		$result = json_decode($result);

		if (!$result || !$result->data) {
			echo '오류가 발생했습니다';
			return;
		}

		$_SESSION['user_name'] = $result->data->name;
		header('Location: example2.php');

	}else if ($_GET['q'] == 'logout') {
		unset($_SESSION['user_name']);
		header('Location: example2.php');
	}

?>
<?php if (!$_SESSION['user_name']) { ?>

<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>로그인 필요</title>

		<script type="text/javascript" src="http://developer.dimigo.hs.kr/get/dauth.sdk.js"></script>
		<script type="text/javascript">
			function openPopup() {
				DAuth.login("name", function (result) {
					location.href = "example2.php?q=login&token=" + result.token;
				});
			}
		</script>
	</head>
	
	<body>
		<button class="dauth-login-btn" onclick="openPopup()">디미고 계정으로 로그인</button>
	</body>
</html>

<?php }else{ ?>

<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>메인화면</title>
	</head>
	
	<body>
		<?php echo $_SESSION['user_name']; ?>님, 환영합니다! <a href="example2.php?q=logout">로그아웃</a>
	</body>
</html>

<?php } ?>