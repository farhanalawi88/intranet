<?php
session_start();
include "config/inc.connection.php";

 	$txtUsername 	= $_POST['username'];
	$txtPassword	= $_POST['password'];

	$toutf8 		= utf8_encode($txtPassword);
  	$var 			= sha1($txtPassword,true);
  	$password       = base64_encode($var);

		
	$cekLogin		= mysqli_query($koneksidb, "SELECT * FROM sys_role 
												WHERE sys_role_username='$txtUsername' 
												AND sys_role_password='$password'");
	if(mysqli_num_rows($cekLogin)==1){
		$login = mysqli_fetch_array($cekLogin);
		$_SESSION['sys_role_id'] 		= $login['sys_role_id'];
		$_SESSION['sys_org_id'] 		= $login['sys_org_id'];
		
		echo '<script>window.location="media.php"</script>';
		
	}else{
		$_SESSION['pesan'] = 'Username dan password anda salah';
		echo '<script>window.location="login.php"</script>';
	}

?>