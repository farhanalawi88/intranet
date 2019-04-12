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
// KONEKSI POSTGRES
$db_host_pgsql	= "192.168.2.17";
$db_user_pgsql	= "postgres";
$db_pass_pgsql	= "postgres";
$db_port_pgsql 	= "5432";
$db_name_pgsql 	= "obsutrado";
 
$koneksipg= pg_connect("host=".$db_host_pgsql." port=".$db_port_pgsql." dbname=".$db_name_pgsql." user=".$db_user_pgsql." password=".$db_pass_pgsql) or die("Koneksi gagal");
 
 
?>

