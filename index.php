<?php
/**
 * @Author: RicardoMZH
 * @Date:   2016-03-21 16:44:46
 * @Last Modified by:   RicardoMZH
 * @Last Modified time: 2016-05-06 23:23:44
 */
$page_title = 'Ri论坛';
require_once('include/header.php');
require_once('db/db_connect.php');

$query = "SELECT theme_title,theme_info,user_name,theme_post_date,reply_number,last_reply_date,theme_id FROM users AS u,theme AS t WHERE u.user_id=t.user_id ORDER BY last_reply_date DESC";
$result = mysqli_query($dbc,$query);

if (mysqli_num_rows($result)==0) {
	echo '<h1>现在还没有人发帖</h1>';
}else{
	while ($row = mysqli_fetch_array($result)) {
		echo '
		<table>
			<tr><td colspan = "4"><a href="viewforum.php?theme_id='.$row[6].'"><h2>'.$row[0].'</h2></a></td></tr>
			<tr>
				<td>发帖人:'.$row[2].'</td>
				<td>发帖日期:'.$row[3].'</td>
				<td>回帖数:'.$row[4].'</td>
				<td>最后回复日期:'.$row[5].'</td>
			</tr>
			<tr><td colspan = "4"><h3>'.$row[1].'</h3></td></tr>';
	}
	echo '</table>';
}
require('include/footer.html');
?>
