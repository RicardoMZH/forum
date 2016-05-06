<?php
/**
 * @Author: RicardoMZH
 * @Date:   2016-03-28 15:23:07
 * @Last Modified by:   RicardoMZH
 * @Last Modified time: 2016-03-28 17:43:49
 */
// if (null!=BASE_URL) {
// 	header("Location:index.php");
// 	exit();
// }

if (isset($_SESSION['user_id'])) {
	echo '<form action="post_forum.php" method="post">';
	if (isset($theme_id)&&$theme_id) {
		echo '<h3>回复帖子</h3>';
		echo '<p><textarea name="message_info" type="text" cols="60" rows="10" maxlength="60">';
		if (isset($message_info)) {
			echo "value=\"$message_info\"";
		}
		echo '</textarea></p>';
		if (isset($parent_message_id)&&$parent_message_id) {
			echo '<input type="hidden" name="parent_message_id" value="'.$parent_message_id.'">';
		}
		echo '<input type="hidden" name="theme_id" value="'.$theme_id.'">';
	}else{
		echo '<h3>发布主题</h3>';
		echo '<input type="text" size="100" maxlength="100" name="theme_title"';
		if (isset($theme_title)) {
			echo "value=\"$theme_title\"";
		}
		echo '>
		<p><textarea name="theme_info" type="text" cols="60" rows="10" maxlength="60"';
		if (isset($theme_info)) {
			echo "value=\"$theme_info\"";
		}
		echo '></textarea></p>';
	}
	echo '<input type="submit" name="submit" value="发布帖子">
	</form>';
}else{
	echo '登录后才可以发帖';
}
?>
