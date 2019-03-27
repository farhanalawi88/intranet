<?php
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtNama'])=="") {
			$message[] = "Nama petugas tidak boleh kosong!";		
		}
		if (trim($_POST['cmbStatus'])=="") {
			$message[] = "Status tidak boleh kosong!";		
		}
				
		$txtNama		= $_POST['txtNama'];
		$txtKeterangan	= $_POST['txtKeterangan'];
		$cmbStatus		= $_POST['cmbStatus'];
				
		$sqlCek			= "SELECT COUNT(*) as total FROM load_ms_petugas WHERE load_ms_petugas_nm='$txtNama'";
		$qryCek			= mysqli_query($koneksidb, $sqlCek) or die ("Gagal cek value".mysqli_errors()); 
		$qryRow			= mysqli_fetch_array($qryCek);
		if($qryRow['total']>=1){
			$message[] = "Maaf, nama petugas <b> $txtNama </b> sudah ada, ganti dengan nama lain";
		}
		
		if(count($message)==0){		
			$sqlSave	= "INSERT INTO load_ms_petugas (load_ms_petugas_nm,
													load_ms_petugas_ket,
													load_ms_petugas_sts,
													load_ms_petugas_created,
													load_ms_petugas_createdby) 
											VALUES ('$txtNama',
													'$txtKeterangan',
													'$cmbStatus',
													'".date('Y-m-d H:i:s')."',
													'".$userRow['sys_role_id']."')";
			$qrySave	= mysqli_query($koneksidb, $sqlSave) or die ("gagal insert". mysqli_errors());

			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data petugas berhasil ditambahkan';
				echo '<script>window.location="?page='.base64_encode(loaddtmspetugas).'"</script>';
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
	$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
	$dataStatus		= isset($_POST['cmbStatus']) ? $_POST['cmbStatus'] : '';
?>
<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase bold">Form Petugas</span></div>
		<div class="tools">
			<a href="javascript:;" class="collapse"></a>
			<a href="javascript:;" class="reload"></a>
			<a href="javascript:;" class="remove"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmadd" class="form-horizontal form-bordered" autocomplete="off">
			<div class="form-body">
				<div class="form-group">
					<label class="col-md-2 control-label">Nama Petugas :</label>
					<div class="col-md-5">
						<input class="form-control" type="text" name="txtNama"  value="<?php echo $dataNama; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Keterangan :</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="txtKeterangan"  value="<?php echo $dataKeterangan; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
					</div>
				</div>
				<div class="form-group last">
					<label class="col-md-2 control-label">Status :</label>
					<div class="col-md-2">
						<select class="form-control select2" data-placeholder="Pilih Status" name="cmbStatus">
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
		            <div class="col-lg-offset-2 col-lg-10">
		                <button type="submit" name="btnSave" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-save"></i> Simpan Data</button>
		                <a href="?page=<?php echo base64_encode(loaddtmspetugas) ?>" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-undo"></i> Batalkan</a>
		            </div>
			    </div>
			</div>
		</form>
	</div>
</div>