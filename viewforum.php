<?php
/**
 * @Author: RicardoMZH
 * @Date:   2016-03-28 15:17:23
 * @Last Modified by:   RicardoMZH
 * @Last Modified time: 2016-04-06 10:46:18
 */
$page_title = '看帖';
require('include/header.php');
$theme_id = false;
if (isset($_GET['theme_id'])&&filter_var($_GET['theme_id'],FILTER_VALIDATE_INT,array('min_range'=>0))) {
	$theme_id = $_GET['theme_id'];

	$query = "SELECT theme_title,theme_info,user_name,theme_post_date FROM users AS u,theme AS t WHERE u.user_id=t.user_id AND t.theme_id=$theme_id";
	$result = mysqli_query($dbc,$query);

	if (mysqli_num_rows($result)!=1) {
		$theme_id = false;
		echo '<p class="error">该主题不存在</p>';
	}else{
		$row = mysqli_fetch_array($result);
		echo '
		<table>
			<tr><td colspan = "2"><h2>'.$row[0].'</h2></td></tr>
			<tr>
				<td>发帖人:'.$row[2].'</td>
				<td>发帖日期:'.$row[3].'</td>
			</tr>
			<tr><td colspan = "2"><h3>'.$row[1].'</h3></td></tr>';
		$query = "SELECT message_info,user_name,message_post_date FROM users AS u,message AS m WHERE u.user_id=m.user_id AND m.theme_id=$theme_id";
	  $result = mysqli_query($dbc,$query);

	  if (mysqli_num_rows($result)==0) {
	  	echo '<tr><td colspan = "2">尚无回帖</td></tr></table>';
	  }else{
	  	while ($row =mysqli_fetch_array($result)) {
	  		echo '
			  	<tr>
						<td>回帖人:'.$row[1].'</td>
						<td>回帖日期:'.$row[2].'</td>
					</tr>
					<tr><td colspan = "2"><h3>'.$row[0].'</h3></td></tr>';
	  	}
	  	echo '</table>';
	  }
	}
}else{
	echo '<p class="error">错误的主题</p>';
}
require_once('include/post.php');
require_once('include/footer.html');
?>
