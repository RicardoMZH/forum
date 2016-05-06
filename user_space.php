<?php
/**
 * @Author: RicardoMZH
 * @Date:   2016-04-06 10:54:53
 * @Last Modified by:   RicardoMZH
 * @Last Modified time: 2016-04-06 11:27:31
 */
$page_title = '用户空间';
require_once('include/header.php');
$user_id = false;
if (isset($_GET['user_id'])&&filter_var($_GET['user_id'],FILTER_VALIDATE_INT,array('min_range'=>0))) {
	$user_id = $_GET['user_id'];
	if ($user_id==$_SESSION['user_id']) {
		$query = "SELECT user_email,user_reg_date FROM users WHERE user_id=$user_id";
		$result = mysqli_query($dbc,$query);
		$row = mysqli_fetch_array($result);
		echo '<table>
						<tr><td>用户名:'.$_SESSION['user_name'].'</td></tr>
						<tr><td>邮箱地址:'.$row[0].'</td></tr>
						<tr><td>注册时间:'.$row[1].'</td></tr>
						<tr><td><a href="change_passwd.php">更改密码</a></td></tr>
					</table>';
	}else{
		echo '<p class="error">无权查看</p>';
	}
}else{
	echo '<p class="error">无效的用户</p>';
}
?>
