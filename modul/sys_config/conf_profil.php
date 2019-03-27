<?php
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtNama'])=="") {
			$message[] = "Nama lengkap tidak boleh kosong!";		
		}
		if (trim($_POST['txtUsername'])=="") {
			$message[] = "Username tidak boleh kosong";		
		}
		if (trim($_POST['cmbKelamin'])=="") {
			$message[] = "Jenis kelamin tidak boleh kosong";		
		}
		
		$txtNama		= $_POST['txtNama'];
		$txtUsername	= $_POST['txtUsername'];
		$txtTelp		= $_POST['txtTelp'];
		$txtAlamat		= $_POST['txtAlamat'];
		$txtEmail		= $_POST['txtEmail'];
		$cmbKelamin		= $_POST['cmbKelamin'];
		$txtUsernameLm	= $_POST['txtUsernameLm'];

		$sqlCek="SELECT * FROM ms_user WHERE ms_user_username='$txtUser' AND NOT(ms_user_username='$txtUsernameLm')";
		$qryCek=pg_query($koneksidb, $sqlCek) or die ("Eror Query".pg_last_error()); 
		if(mysql_num_rows($qryCek)>=1){
			$message[] = "Maaf, Username <b> $ txtUsername </b> sudah ada, ganti dengan username lain";
		}
				
		if(count($message)==0){								

			$sqlSave="UPDATE ms_user SET ms_user_nama='$txtNama', 
											ms_user_telp='$txtTelp', 
											ms_user_alamat='$txtAlamat', 
											ms_user_email='$txtEmail', 
											ms_user_username='$txtUsername',
											ms_user_kelamin='$cmbKelamin'
									WHERE ms_user_id='".$_POST['txtKode']."'";
			$qrySave=pg_query($koneksidb, $sqlSave);
			if($qrySave){
				$_SESSION['pesan'] = 'Profile anda berhasil diperbaharui';
						echo '<script>window.location="?page='.base64_encode(confprofile).'"</script>';
			}
		}	
		
		if (! count($message)==0 ){
			echo "<div class='alert alert-danger alert-dismissable'>
                      <button type='button' class='close' data-dismiss='alert' aria-hidden='true'></button>";
				$Num=0;
				foreach ($message as $indeks=>$pesan_tampil) { 
				$Num++;
					echo "&nbsp;&nbsp;$Num. $pesan_tampil<br>";	
				} 
			echo "</div>"; 
		}
	} 
	$sqlShow 		= "SELECT * FROM ms_user WHERE ms_user_id='".$_SESSION['ms_user_id']."'";
	$qryShow 		= pg_query($koneksidb, $sqlShow)  or die ("Query ambil data user salah : ".pg_last_error());
	$dataShow 		= pg_fetch_array($qryShow);

	$dataKode		= $dataShow['ms_user_id'];
	$dataNama		= isset($dataShow['ms_user_nama']) ?  $dataShow['ms_user_nama'] : $_POST['txtNama'];
	$dataTelp		= isset($dataShow['ms_user_telp']) ?  $dataShow['ms_user_telp'] : $_POST['txtTelp'];
	$dataEmail		= isset($dataShow['ms_user_email']) ?  $dataShow['ms_user_email'] : $_POST['txtEmail'];
	$dataKelamin	= isset($dataShow['ms_user_kelamin']) ?  $dataShow['ms_user_kelamin'] : $_POST['cmbKelamin'];
	$dataAlamat		= isset($dataShow['ms_user_alamat']) ?  $dataShow['ms_user_alamat'] : $_POST['txtAlamat'];
	$dataUsername	= isset($dataShow['ms_user_username']) ?  $dataShow['ms_user_username'] : $_POST['txtUsername'];
	$dataUsernameLm	= $dataShow['ms_user_username'];
?>
<div class="portlet light">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase bold">Perubahan Profil</span></div>
		<div class="tools">
			<a href="javascript:;" class="collapse"></a>
			<a href="javascript:;" class="reload"></a>
			<a href="javascript:;" class="remove"></a>
		</div>
	</div>
	<div class="portlet-body form">			
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="post" class="form-horizontal">
			<div class="form-body">
				<div class="form-group">
					<label class="col-md-2 control-label">Nama Lengkap :</label>
					<div class="col-md-4">
						<input type="text" class="form-control" name="txtNama" value="<?php echo $dataNama; ?>">
						<input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Username :</label>
					<div class="col-md-3">
						<input class="form-control" type="text" name="txtUsername"  value="<?php echo $dataUsername; ?>"/>
						<input name="txtUsernameLm" type="hidden" value="<?php echo $dataUsernameLm; ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">No. Telp :</label>
					<div class="col-md-3">
						<input class="form-control" name="txtTelp" type="text"  value="<?php echo $dataTelp; ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Email :</label>
					<div class="col-md-3">
						<input class="form-control" name="txtEmail" type="text"  value="<?php echo $dataEmail; ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Alamat :</label>
					<div class="col-md-10">
						<textarea class="form-control" name="txtAlamat" type="text"/><?php echo $dataAlamat; ?></textarea>
					</div>
				</div>
				<div class="form-group">
	                <label class="col-md-2 control-label">Jenis Kelamin :</label>
	                <div class="col-md-10">
	                    <div class="md-radio-list">
	                    	<?php
								if($dataKelamin=='Pria'){
				                    echo " 	<div class='md-radio'>
				                    			<input type='radio' id='radio53' name='cmbKelamin' value='Pria' class='md-radiobtn' checked>
				                            	<label for='radio53'><span></span><span class='check'></span><span class='box'></span> Pria </label>
				                            </div>
				                        	<div class='md-radio'>
				                            	<input type='radio' id='radio54' name='cmbKelamin' value='Wanita' class='md-radiobtn'>
				                            	<label for='radio54'><span></span><span class='check'></span><span class='box'></span> Wanita </label>
				                        	</div>";
				                }elseif($dataKelamin=='Wanita'){
				                	echo "	<div class='md-radio'>
				                            	<input type='radio' id='radio53' name='cmbKelamin' value='Pria' class='md-radiobtn'>
				                            	<label for='radio53'><span></span><span class='check'></span><span class='box'></span> Pria </label>
				                        	</div>
				                        	<div class='md-radio'>
				                            	<input type='radio' id='radio54' name='cmbKelamin' value='Wanita' class='md-radiobtn' checked>
				                            	<label for='radio54'><span></span><span class='check'></span><span class='box'></span> Wanita </label>
				                            </div>";
				                }else{
				                	echo "	<div class='md-radio'>
				                            	<input type='radio' id='radio53' name='cmbKelamin' value='Pria' class='md-radiobtn'>
				                            	<label for='radio53'><span></span><span class='check'></span><span class='box'></span> Pria </label>
				                        	</div>
				                        	<div class='md-radio'>
				                            	<input type='radio' id='radio54' name='cmbKelamin' value='Wanita' class='md-radiobtn'>
				                            	<label for='radio54'><span></span><span class='check'></span><span class='box'></span> Wanita </label>
				                            </div>";
				                }
				            ?>
	                    </div>
	                </div>
	            </div>
			</div>
			<div class="form-actions">
			    <div class="row">
			        <div class="form-group">
			            <div class="col-lg-offset-2 col-lg-10">
			                <button type="submit" name="btnSave" class="btn blue"><i class="fa fa-save"></i> Simpan Data</button>
			            </div>
			        </div>
			    </div>
			</div>
		</form>
	</div>
</div>