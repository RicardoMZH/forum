<?php
/**
 * @Author: RicardoMZH
 * @Date:   2016-04-06 11:40:47
 * @Last Modified by:   RicardoMZH
 * @Last Modified time: 2016-04-08 14:30:20
 */
$page_title = '用户注销';
require_once('include/header.php');
if (isset($_SESSION['user_id'])) {
	$_SESSION[] = array();
	session_destroy();
	header("Refresh:3;url=index.php");
}else{
	echo '无效命令';
	exit();
}
?>

<?php require_once('include/footer.html'); ?>
