<?php
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtTglMasuk'])=="") {
			$message[] = "Tgl. Masuk tidak boleh kosong!";		
		}
				
		$txtTglMasuk		= $_POST['txtTglMasuk'];
		$txtKeterangan		= $_POST['txtKeterangan'];
		$txtNopol			= $_POST['txtNopol'];
		$cmbKendaraan		= $_POST['cmbKendaraan'];
		$cmbPetugas			= $_POST['cmbPetugas'];
		$txtBerat			= $_POST['txtBerat'];
		$cmbKlasifikasi		= $_POST['cmbKlasifikasi'];
		$txtCard			= $_POST['txtCard'];
		$txtKode			= $_POST['txtKode'];
		$txtSupir			= $_POST['txtSupir'];
		$txtDokumen			= $_POST['txtDokumen'];
				
		
		if(count($message)==0){	
			$sqlSave	= "UPDATE load_tr_inout SET load_tr_inout_tgl_masuk='$txtTglMasuk',
													load_tr_inout_ket='$txtKeterangan',
													load_tr_inout_nopol='$txtNopol',
													load_tr_inout_berat='$txtBerat',
													load_ms_jns_kend_id='$cmbKendaraan',
													load_ms_identitas_id='$cmbPetugas',
													load_ms_klasifikasi_id='$cmbKlasifikasi',
													load_tr_inout_supir='$txtSupir',
													load_tr_inout_dokumen='$txtDokumen',
													load_tr_inout_card='$txtCard',
													load_tr_inout_updated='".date('Y-m-d H:i:s')."',
													load_tr_inout_updatedby='".$userRow['sys_role_id']."'
												WHERE load_tr_inout_id='$txtKode'";
			$qrySave	= mysqli_query($koneksidb, $sqlSave) or die ("gagal insert". mysqli_errors());

			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data masuk kendaraan berhasil diberbaharui';
				echo '<script>window.location="?page='.base64_encode(loaddttrmasuk).'"</script>';
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
	
	$KodeEdit			= isset($_GET['id']) ?  $_GET['id'] : $_POST['txtTglLibur']; 
	$sqlShow 			= "SELECT * FROM load_tr_inout WHERE load_tr_inout_id='$KodeEdit'";
	$qryShow 			= mysqli_query($koneksidb, $sqlShow)  or die ("Query ambil data libur salah : ".mysqli_errors());
	$dataShow 			= mysqli_fetch_array($qryShow);		

	$dataKode 			= $dataShow['load_tr_inout_id'];
	$dataTglMasuk		= isset($_POST['txtTglMasuk']) ? $_POST['txtTglMasuk'] : $dataShow['load_tr_inout_tgl_masuk'];
	$dataKeterangan		= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : $dataShow['load_tr_inout_ket'];
	$dataKendaraan		= isset($_POST['cmbKendaraan']) ? $_POST['cmbKendaraan'] : $dataShow['load_ms_jns_kend_id'];
	$dataPetugas		= isset($_POST['cmbPetugas']) ? $_POST['cmbPetugas'] : $dataShow['load_ms_identitas_id'];
	$dataNopol			= isset($_POST['txtNopol']) ? $_POST['txtNopol'] : $dataShow['load_tr_inout_nopol'];
	$dataBerat			= isset($_POST['txtBerat']) ? $_POST['txtBerat'] : $dataShow['load_tr_inout_berat'];
	$dataKlasifikasi	= isset($_POST['cmbKlasifikasi']) ? $_POST['cmbKlasifikasi'] : $dataShow['load_ms_klasifikasi_id'];
	$dataCard			= isset($_POST['txtCard']) ? $_POST['txtCard'] : $dataShow['load_tr_inout_card'];
	$dataSupir			= isset($_POST['txtSupir']) ? $_POST['txtSupir'] : $dataShow['load_tr_inout_supir'];
	$dataDokumen		= isset($_POST['txtDokumen']) ? $_POST['txtDokumen'] : $dataShow['load_tr_inout_dokumen'];
?>
<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase">Form Masuk Kendaraan & Tamu</span></div>
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
					<label class="col-md-2 control-label">Tgl. Masuk :</label>
					<div class="col-md-3">
						<div class="input-group">
                            <input type="text" name="txtTglMasuk" class="form-control form_datetime" value="<?php echo $dataTglMasuk ?>">
                            <input type="hidden" name="txtKode" class="form-control" value="<?php echo $dataKode ?>">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">No. Kartu :</label>
					<div class="col-md-3">
						<input class="form-control" type="text" name="txtCard"  value="<?php echo $dataCard; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Jenis Kendaraan :</label>
					<div class="col-md-3">
						<select name="cmbKendaraan" data-placeholder="- Pilih Kendaraan -" class="select2 form-control">
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM load_ms_jns_kend ORDER BY load_ms_jns_kend_id DESC";
								  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
								  while ($dataRow = mysqli_fetch_array($dataQry)) {
									if ($dataKendaraan == $dataRow['load_ms_jns_kend_id']) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$dataRow[load_ms_jns_kend_id]' $cek>$dataRow[load_ms_jns_kend_nm]</option>";
								  }
								  $sqlData ="";
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Nama Identitas :</label>
					<div class="col-md-3">
						<select name="cmbPetugas" data-placeholder="- Pilih Identitas -" class="select2 form-control">
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM load_ms_identitas ORDER BY load_ms_identitas_id DESC";
								  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
								  while ($dataRow = mysqli_fetch_array($dataQry)) {
									if ($dataPetugas == $dataRow['load_ms_identitas_id']) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$dataRow[load_ms_identitas_id]' $cek>$dataRow[load_ms_identitas_nm]</option>";
								  }
								  $sqlData ="";
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Klasifikasi :</label>
					<div class="col-md-3">
						<select name="cmbKlasifikasi" data-placeholder="- Pilih Klasifikasi -" class="select2 form-control">
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM load_ms_klasifikasi ORDER BY load_ms_klasifikasi_id DESC";
								  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
								  while ($dataRow = mysqli_fetch_array($dataQry)) {
									if ($dataKlasifikasi == $dataRow['load_ms_klasifikasi_id']) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$dataRow[load_ms_klasifikasi_id]' $cek>$dataRow[load_ms_klasifikasi_nm]</option>";
								  }
								  $sqlData ="";
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">No. Kendaraan :</label>
					<div class="col-md-3">
						<input class="form-control" type="text" name="txtNopol"  value="<?php echo $dataNopol; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Nama Tamu/Supir :</label>
					<div class="col-md-3">
						<input class="form-control" type="text" name="txtSupir"  value="<?php echo $dataSupir; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">No. Dokumen :</label>
					<div class="col-md-3">
						<input class="form-control" type="text" name="txtDokumen"  value="<?php echo $dataDokumen; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Berat Muatan :</label>
					<div class="col-md-3">
						<input class="form-control" type="text" name="txtBerat"  value="<?php echo $dataBerat; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
					</div>
				</div>
				<div class="form-group last">
					<label class="col-md-2 control-label">Uraian Muatan :</label>
					<div class="col-md-10">
						<textarea class="form-control" type="text" name="txtKeterangan" onkeyup="javascript:this.value=this.value.toUpperCase();" ><?php echo $dataKeterangan; ?></textarea>
					</div>
				</div>
			</div>
			<div class="form-actions">
			    <div class="row">
		            <div class="col-lg-offset-2 col-lg-10">
		                <button type="submit" name="btnSave" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-save"></i> Simpan Data</button>
		                <a href="?page=<?php echo base64_encode(loaddttrmasuk) ?>" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-undo"></i> Batalkan</a>
		            </div>
			    </div>
			</div>
		</form>
	</div>
</div>