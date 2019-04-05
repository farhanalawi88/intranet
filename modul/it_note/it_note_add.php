<?php
	
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtNama'])=="") {
			$message[] = "<b>Nama</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtUsername'])=="") {
			$message[] = "<b>User Name</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtPassword'])=="") {
			$message[] = "<b>Password</b> tidak boleh kosong !";		
		}
		if (trim($_POST['cmbStatus'])=="") {
			$message[] = "<b>Status</b> tidak boleh kosong !";		
		}
		
		$txtNama            		= $_POST['txtNama'];
		$txtUsername				= $_POST['txtUsername'];
		$txtPassword				= $_POST['txtPassword'];
		$txtIpAddress				= $_POST['txtIpAddress'];		
		$txtKeterangan				= $_POST['txtKeterangan'];
		$cmbStatus					= $_POST['cmbStatus'];

		if(count($message)==0){
			$sqlSave="INSERT INTO it_note (nama,
											username,
											password,
											ip_address,
											keterangan,
											status,
											created,
											createdby)
								VALUES ('$txtNama',
										'$txtUsername',
										'$txtPassword',
										'$txtIpAddress',
										'$txtKeterangan', 
										'$cmbStatus',
										'".date('Y-m-d H:i:s')."',
										'".$_SESSION['sys_role_id']."')";
			$qrySave	= mysqli_query($koneksidb, $sqlSave) or die ("gagal insert". mysqli_errors());
			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data IT Note Berhasil Ditambahkan';
				echo '<script>window.location="?page='.base64_encode(itnotedata).'"</script>';
			}
			exit;
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
	
	$dataNama		= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
	$dataUsername	= isset($_POST['txtUsername']) ? $_POST['txtUsername'] : '';
	$dataPassword	= isset($_POST['txtPassword']) ? $_POST['txtPassword'] : '';
	$dataIpAddress	= isset($_POST['txtIpAddress']) ? $_POST['txtIpAddress'] : '';
	$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : ''; 
	$dataStatus		= isset($_POST['cmbStatus']) ? $_POST['cmbStatus'] : ''; 
?>
<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
        <div class="caption">
            <span class="caption-subject uppercase bold">Form IT Note</span>
        </div>
        <div class="tools">
            <a href="" class="collapse"> </a>
            <a href="#portlet-config" data-toggle="modal" class="config"> </a>
            <a href="" class="reload"> </a>
            <a href="" class="remove"> </a>
        </div>
    </div>
	<div class="portlet-body form">
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal form-bordered" autocomplete="off">
        	<div class="form-body">
		        <div class="form-group">
					<label class="col-lg-2 control-label">Nama :</label>
					<div class="col-lg-4">
						<input type="text" name="txtNama" value="<?php echo $dataNama; ?>" class="form-control" placeholder="Input Nama"/>
		             </div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">User Name :</label>
					<div class="col-lg-4">
						<input type="text" name="txtUsername" value="<?php echo $dataUsername; ?>" class="form-control" placeholder="Input User Name"/>
		             </div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Password :</label>
					<div class="col-lg-4">
						<input type="text" name="txtPassword" value="<?php echo $dataPassword; ?>" class="form-control" placeholder="Input Password"/>
		             </div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">IP Address :</label>
					<div class="col-lg-4">
						<input type="text" name="txtIpAddress" value="<?php echo $dataIpAddress; ?>" class="form-control" placeholder="Input IP Address"/>
		             </div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Keterangan :</label>
					<div class="col-lg-10">
						<input type="text" name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" class="form-control" placeholder="Input Keterangan"/>
		             </div>
				</div>
				<div class="form-group last">
					<label class="col-md-2 control-label">Status :</label>
					<div class="col-md-2">
						<select class="form-control select2" data-placeholder="Select Status" name="cmbStatus">
		                	<option value=""></option>
		               		<?php
							  $pilihan	= array("Y", "N");
							  foreach ($pilihan as $nilai) {
								if ($dataStatus==$nilai) {
									$cek=" selected";
								} else { $cek = ""; }
								echo "<option value='$nilai' $cek>$nilai</option>";
							  }
							?>
		              	</select>
					</div>
				</div>
			</div>
	    	<div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-2 col-md-10">
		                <button type="submit" name="btnSave" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-save"></i> Simpan Data</button>
		                <a href="?page=<?php echo base64_encode(itnotedata) ?>" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-undo"></i> Batalkan</a>
			        </div>
			    </div>
			</div>
		</form>
	</div>
</div>
		