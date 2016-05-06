<?php
/**
 * @Author: RicardoMZH
 * @Date:   2016-03-20 14:09:15
 * @Last Modified by:   RicardoMZH
 * @Last Modified time: 2016-03-28 21:09:25
 */
require_once('config/config_db.inc.php');

$dbc = @mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME) or die('打开数据库失败：'.mysqli_connect_error());

mysqli_set_charset($dbc,'utf8');
?>
