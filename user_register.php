<?php
 /*
 * @Author: RicardoMZH
 * @Date:   2016-03-20 13:56:39
 * @Last Modified by:   RicardoMZH
 * @Last Modified time: 2016-04-07 17:29:41
 */
$page_title = '用户注册';
require('include/header.php');

	if ($_SERVER['REQUEST_METHOD']=='POST') {

		// require_once('db/db_connect.php');
		$errors = array();
		$trimmed = array_map('trim',$_POST);

		if (!filter_var($trimmed['user_email'],FILTER_VALIDATE_EMAIL)) {
			$errors[] =  '请输入正确的邮箱地址';
		}else{
			$user_email = mysqli_escape_string($dbc,$trimmed['user_email']);
		}

		if (!preg_match("/^[\w\/\\\\.~`\'·_-]{4,20}$/i", $trimmed['user_name'])) {
			$errors[] =  '请输入正确的用户名';
		}else{
			$user_name = mysqli_escape_string($dbc,$trimmed['user_name']);
		}

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
			$query = "SELECT user_id FROM users WHERE user_name='$user_name' OR user_email='$user_email'";
			$result = @mysqli_query($dbc,$query);
			if (mysqli_num_rows($result)==0) {
				// $salt = @mysqli_real_escape_string($dbc,mcrypt_create_iv(32));
				$salt = md5(mcrypt_create_iv(32));
				$user_passwd=hash('sha256',$user_passwd.$salt);
				$active = md5(uniqid(rand(),true));
				$query = "INSERT INTO users (user_name,user_passwd,user_email,user_reg_date,salt,active) VALUES ('$user_name','$user_passwd','$user_email',NOW(),'$salt','$active')";
				$result = mysqli_query($dbc,$query);
				if (mysqli_affected_rows($dbc)==1) {
					echo '<h1>注册成功！感谢！</h1>';
					echo '<p>我们已经向您的电子邮件账户发送了一封确认邮件，请及时查收以激活您的账户</p>';
					$body = "感谢注册,请点击下面的链接激活账户：\n\n".BASE_URL.'active.php?user_email='.urlencode($user_email)."&active=$active";
					$email = array($trimmed['user_email'],"注册激活账户",$body);
					foreach ($email as $key => $value) {
						$email[$key] = iconv("utf-8","gb2312",$value);
					}
					mail($email[0],$email[1],$email[2],'From:ricardomzh@sina.com');
				}else{
				echo '<h1>注册失败！抱歉！</h1><p class="error">一个系统错误发生导致您不能注册，十分抱歉！</p>';
				echo '<p>'.mysqli_error($dbc).'<br /><br />Query:'.$query.'</p>';//debug
				}
				mysqli_close($dbc);
				require('include/footer.html');
				exit();
			}else{
				echo '<h1>注册失败！</h1><p class="error">用户名或邮箱已被注册</p>';
				echo "</p><p>请重试</p>\n";
			}
		}else{
		echo '<h1>注册失败！</h1><p class="error">错误：<br />';
		foreach ($errors as $message) {
			echo "$message<br />\n";
		}
		echo "</p><p>请重试</p>\n";
		}
	}
?>
<p>
<fieldset>
	<legend>欢迎注册</legend>
	<form action="#" method="post" accept-charset="utf-8">
		<p>注册邮箱:<input type="text" name="user_email" size="20" maxlength="40" value="<?php if (isset($trimmed['user_email'])) echo $trimmed['user_email']; ?>"></p>
 		<p>用 户 名:<input type="text" name="user_name" size="20" maxlength="20" value="<?php if (isset($trimmed['user_name'])) echo $trimmed['user_name']; ?>"></p>
 		<p>你的密码:<input type="password" name="user_passwd" size="20" maxlength="20"></p>
		<p>确认密码:<input type="password" name="cofirmpassword" size="20" maxlength="20"></p>
		<p><input type="submit" name="submit" value="确认注册"/></p>
	</form>
</fieldset>
</p>
<?php require('include/footer.html'); ?>
