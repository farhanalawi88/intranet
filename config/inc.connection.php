<?php
// KONEKSI MYSQL
$db_host_mysql = "192.168.2.9";
$db_user_mysql = "root";
$db_pass_mysql = "password";
$db_name_mysql = "intranet_db";
 
$koneksidb = mysqli_connect($db_host_mysql, $db_user_mysql, $db_pass_mysql, $db_name_mysql);
 
if(mysqli_connect_errno()){
	echo 'Gagal melakukan koneksi ke Database : '.mysqli_connect_error();
}

 
?>

