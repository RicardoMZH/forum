<?php
/**
 * @Author: RicardoMZH
 * @Date:   2016-03-27 16:56:38
 * @Last Modified by:   RicardoMZH
 * @Last Modified time: 2016-04-06 11:27:26
 */
	define('BASE_URL', 'localhost/');
	ob_start();
	session_start();
	require_once('db/db_connect.php');
	if (!isset($page_title)) {
		$page_title = '用户注册';
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $page_title; ?></title>
	<link rel="stylesheet" type="text/css" href="include/style.css">
</head>
<body>
<div>
	<img src="resource/Mylogo2.png" alt="logo" id="weblogo">
	<ul>
		<li><a id="link" href="index.php">首页</a></li>
		<li><a id="link" href="post_forum.php">新的帖子</a></li>
<?php
	if (isset($_SESSION['user_id'])) {
		echo '<li><a id="link" href="user_space.php?user_id='.$_SESSION['user_id'].'">我的页面</a></li>
		<li><a id="link" href="logout.php">用户登出</a></li>';
	}else{
		echo '<li><a id="link" href="user_register.php">用户注册</a></li>
		<li><a id="link" href="login.php">用户登录</a></li>';
	}
?>
	</ul>
</div>
