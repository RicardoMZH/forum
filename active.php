<?php
/**
 * @Author: RicardoMZH
 * @Date:   2016-03-27 16:56:38
 * @Last Modified by:   RicardoMZH
 * @Last Modified time: 2016-03-28 17:15:59
 */
$page_title = '账户激活';
require('include/header.php');

if (isset($_GET['user_email'],$_GET['active'])&&filter_var($_GET['user_email'],FILTER_VALIDATE_EMAIL)&&(strlen($_GET['active'])==32)) {
	// require_once('db/db_connect.php');
	$query = "UPDATE users SET active=NULL WHERE user_email='".mysqli_real_escape_string($dbc,$_GET['user_email'])."' AND active='".mysqli_real_escape_string($dbc,$_GET['active'])."' LIMIT 1";
	$result = mysqli_query($dbc,$query);

	if (mysqli_affected_rows($dbc)==1) {
		echo '感谢您的注册，您的账户已经激活。';
	}else{
		echo '<p class="error">出现系统错误，您的账户无法激活</p>';
		echo mysqli_error($dbc);
	}

	mysqli_close($dbc);
}else{
	// $url = BASE_URL.'index.php';
	$url = 'index.php';
	ob_end_clean();
	header("Location:$url");
	exit();
}
require('include/footer.html');
?>
