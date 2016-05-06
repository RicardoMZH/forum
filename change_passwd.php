<?php
/**
 * @Author: RicardoMZH
 * @Date:   2016-04-06 11:52:16
 * @Last Modified by:   RicardoMZH
 * @Last Modified time: 2016-04-07 17:33:26
 */
$page_title = '修改密码';
require_once('include/header.php');
if (isset($_SESSION['user_id'])) {
	if ($_SERVER['REQUEST_METHOD']=='POST') {

		$trimmed = array_map('trim',$_POST);

		if (!preg_match("/^[\w-.`_]{4,20}$/",$trimmed['user_passwd'])) {
			$errors[] =  '请输入正确的密码';
		}else{
			if ($trimmed['user_passwd']===$trimmed['cofirmpassword']) {
				$user_passwd = mysqli_escape_string($dbc,$trimmed['user_passwd']);
			}else{
				$errors[] =  '两次密码不匹配';
			}
		}
		if (empty($errors)) {
			$salt = md5(mcrypt_create_iv(32));
			$user_passwd=hash('sha256',$user_passwd.$salt);
			$query = "UPDATE users SET user_passwd='$user_passwd',salt='$salt' WHERE user_id={$_SESSION['user_id']}";
			$result = mysqli_query($dbc,$query);
			if (mysqli_affected_rows($dbc)==1) {
				echo '修改成功';
				exit();
			}else{
				echo '<p class="error">修改失败</p>'.mysqli_error($dbc);
			}
		}else{
			echo '<h1>注册失败！</h1><p class="error">错误：<br />';
			foreach ($errors as $message) {
				echo "$message<br />\n";
			}
		}
	}
}else{
	echo '无效命令';
	exit();
}
?>
<fieldset>
	<legend>修改密码</legend>
	<form action="change_passwd.php" method="post">
	<p>新 密 码：<input type="password" name="user_passwd" size="20" maxlength="20"></p>
	<p>重复密码：<input type="password" name="cofirmpassword" size="20" maxlength="20"></p>
	<p><input type="submit" name="submit" value="确认"></p>
</form>
</fieldset>
<?php require_once('include/footer.html'); ?>
