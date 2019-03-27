<?php
	
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtNama'])=="") {
			$message[] = "<b>Nama</b> tidak boleh kosong !";		
		}
		if (trim($_POST['cmbStatus'])=="") {
			$message[] = "<b>Status</b> tidak boleh kosong !";		
		}
		
		$txtNama		= $_POST['txtNama'];
		$cmbStatus		= $_POST['cmbStatus'];
		$txtKeterangan	= $_POST['txtKeterangan'];

		if(count($message)==0){
			$sqlSave="INSERT INTO ptkp_ms_kategori (ptkp_ms_kategori_nm,
												ptkp_ms_kategori_ket,
												ptkp_ms_kategori_sts,
												ptkp_ms_kategori_created,
												ptkp_ms_kategori_createdby)
										VALUES('$txtNama',
												'$txtKeterangan', 
												'$cmbStatus',
												'".date('Y-m-d H:i:s')."',
												'".$_SESSION['sys_role_id']."')";
			$qrySave	= mysqli_query($koneksidb, $sqlSave) or die ("gagal insert". mysqli_errors());
			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data kategori temuan ptkp berhasil ditambahkan';
				echo '<script>window.location="?page='.base64_encode(ptkpdtmskategori).'"</script>';
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
	
	$dataKode		= isset($_POST['txtKode']) ? $_POST['txtKode'] : '';
	$dataNama		= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
	$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : ''; 
	$dataStatus		= isset($_POST['cmbStatus']) ? $_POST['cmbStatus'] : ''; 
?>
<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
        <div class="caption">
            <span class="caption-subject uppercase bold">Form Data kategori Temuan PTKP</span>
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
					<label class="col-lg-2 control-label">Nama Kategori :</label>
					<div class="col-lg-4">
						<input type="text" name="txtNama" value="<?php echo $dataNama; ?>" class="form-control" placeholder="Enter Name" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
		             </div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Keterangan :</label>
					<div class="col-lg-10">
						<input type="text" name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" class="form-control" placeholder="Enter Description" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
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
		                <a href="?page=<?php echo base64_encode(ptkpdtmskategori) ?>" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-undo"></i> Batalkan</a>
			        </div>
			    </div>
			</div>
		</form>
	</div>
</div>
		