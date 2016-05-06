<?php
/**
 * @Author: RicardoMZH
 * @Date:   2016-03-28 16:01:45
 * @Last Modified by:   RicardoMZH
 * @Last Modified time: 2016-04-06 11:10:05
 */
$page_title = '新的帖子';
require('include/header.php');
if ($_SERVER['REQUEST_METHOD']=='POST') {
	if (isset($_POST['theme_id'])&&filter_var($_POST['theme_id'],FILTER_VALIDATE_INT,array('min_range'=>0))) {
		$theme_id = $_POST['theme_id'];
	}else{
		$theme_id = false;
	}

	if (isset($_POST['parent_message_id'])&&filter_var($_POST['parent_message_id'],FILTER_VALIDATE_INT,array('min_range'=>0))) {
		$parent_message_id = $_POST['parent_message_id'];
	}else{
		$parent_message_id = false;
	}

	if ($theme_id&&$parent_message_id) {
		if (!empty($_POST['message_info'])) {
			$message_info = mysqli_real_escape_string($dbc,$_POST['message_info']);
			$query = "INSERT INTO message (user_id,theme_id,parent_message_id,message_info,message_post_date) VALUES ({$_SESSION['user_id']},{$_POST['theme_id']},{$_POST['parent_message_id']},'$message_info',NOW())";
			$result = mysqli_query($dbc,$query);
			if (mysqli_affected_rows($dbc)!=1) {
				echo '<p class="error">回复失败</p>'.mysqli_error($dbc);
			}else{
				$query = "UPDATE theme SET reply_number=reply_number+1 WHERE theme_id='".$_POST['theme_id']."'";
				$result = mysqli_query($dbc,$query);
				echo '回复成功';
				exit();
			}
		}else{
			echo '<p class="error">输入不能为空</p>';
		}
	}elseif($theme_id&&!$parent_message_id){
		if (!empty($_POST['message_info'])) {
			$message_info = mysqli_real_escape_string($dbc,$_POST['message_info']);
			$query = "INSERT INTO message (user_id,theme_id,message_info,message_post_date) VALUES ({$_SESSION['user_id']},{$_POST['theme_id']},'$message_info',NOW())";
			$result = mysqli_query($dbc,$query);
			if (mysqli_affected_rows($dbc)!=1) {
				echo '<p class="error">回复失败</p>'.mysqli_error($dbc);
			}else{
				$query = "UPDATE theme SET reply_number=reply_number+1 WHERE theme_id='".$_POST['theme_id']."'";
				$result = mysqli_query($dbc,$query);
				echo '回复成功';
				exit();
			}
		}else{
			echo '<p class="error">输入不能为空</p>';
		}
	}elseif(!$theme_id&&!$parent_message_id){
		if (!empty($_POST['theme_title'])) {
			$theme_title = mysqli_real_escape_string($dbc,$_POST['theme_title']);
			$theme_info = mysqli_real_escape_string($dbc,$_POST['theme_info']);
			$query = "INSERT INTO theme (user_id,theme_title,theme_info,theme_post_date) VALUES ({$_SESSION['user_id']},'$theme_title','$theme_info',NOW())";
			$result = mysqli_query($dbc,$query);
			if (mysqli_affected_rows($dbc)!=1) {
				echo '<p class="error">发布失败</p>'.mysqli_error($dbc);
			}else{
				$query = "INSERT INTO message (user_id,theme_id,message_info,message_post_date) VALUES ({$_SESSION['user_id']},'$theme_title','$theme_info',NOW())";
				echo '发布成功';
				exit();
			}
		}else{
			echo '<p class="error">输入不能为空</p>';
		}
	}
}
include('include/post.php');
require('include/footer.html');
?>
