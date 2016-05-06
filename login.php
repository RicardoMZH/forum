<?php
/**
 * @Author: RicardoMZH
 * @Date:   2016-03-13 15:24:09
 * @Last Modified by:   RicardoMZH
 * @Last Modified time: 2016-03-28 17:16:16
 */
$page_title = '用户登录';
require('include/header.php');

if ($_SERVER['REQUEST_METHOD']=='POST') {
	// require('db/db_connect.php');

	if (!empty($_POST['user_email'])) {
		$user_email = mysqli_real_escape_string($dbc,$_POST['user_email']);
	}else{
		$user_email = false;
		echo '<p class="error">请输入邮箱地址</p>';
	}

	if (!empty($_POST['user_passwd'])) {
		$user_passwd = mysqli_real_escape_string($dbc,$_POST['user_passwd']);
	}else{
		$user_passwd = false;
		echo '<p class="error">请输入密码</p>';
	}

	if ($user_email&&$user_passwd) {
		$query = "SELECT salt FROM users WHERE user_email='$user_email'";
		$result = mysqli_query($dbc,$query);
		$salt = mysqli_fetch_array($result);
		$user_passwd=hash('sha256',$user_passwd.$salt[0]);
		$query = "SELECT user_id,user_name FROM users WHERE user_email='$user_email' AND user_passwd='$user_passwd' AND active IS NULL";
		$result = mysqli_query($dbc,$query);

		if (mysqli_num_rows($result)==1) {
			$_SESSION = mysqli_fetch_assoc($result);
			mysqli_free_result($result);
			mysqli_close($dbc);

			$url = 'index.php';
			// $url = BASE_URL.'index.php';
			ob_end_clean();
			header("Location:$url");
			exit();
		}else{
			echo '<p class="error">邮箱地址与密码组合不存在或者你还未激活你的账户</p>';
		}
	}else{
		echo '<p class="error">请重试</p>';
	}
	mysqli_close($dbc);
}
?>
<fieldset>
	<legend>用户登录</legend>
	<form action="login.php" method="post">
	<p>用户名：<input type="text" name="user_email" size="20" maxlength="20"></p>
	<p>密&nbsp;&nbsp;码：<input type="password" name="user_passwd" size="20" maxlength="20"></p>
	<p><input type="submit" name="submit" value="登录"></p>
</form>
</fieldset>

<?php include('include/footer.html');?>
