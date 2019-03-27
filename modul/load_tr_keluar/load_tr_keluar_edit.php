<?php
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtTglKeluar'])=="") {
			$message[] = "Tgl. keluar tidak boleh kosong!";		
		}
		if (trim($_POST['cmbKendaraan'])=="") {
			$message[] = "Jenis kendaraan tidak boleh kosong!";		
		}
		if (trim($_POST['txtTglUnload'])=="") {
			$message[] = "Tgl. akhir bongkar/muat tidak boleh kosong!";		
		}
		if (trim($_POST['txtTglLoad'])=="") {
			$message[] = "Tgl. awal bongkar/muat tidak boleh kosong!";		
		}

				
		$txtTglKeluar		= $_POST['txtTglKeluar'];
		$txtKeterangan		= $_POST['txtKeterangan'];
		$cmbKendaraan		= $_POST['cmbKendaraan'];
		$cmbPetugas			= $_POST['cmbPetugas'];
		$txtBerat			= $_POST['txtBerat'];
		$cmbKlasifikasi		= $_POST['cmbKlasifikasi'];
		$txtKode			= $_POST['txtKode'];
		$txtTglLoad			= $_POST['txtTglLoad'];
		$txtTglUnload		= $_POST['txtTglUnload'];
		$txtSupir			= $_POST['txtSupir'];
		$txtDokumen			= $_POST['txtDokumen'];
		$txtAksi			= $_POST['txtAksi'];
		
		if(count($message)==0){	
			$sqlSave	= "UPDATE load_tr_inout SET load_tr_inout_tgl_keluar='$txtTglKeluar',
													load_tr_inout_ket='$txtKeterangan',
													load_tr_inout_berat='$txtBerat',
													load_ms_jns_kend_id='$cmbKendaraan',
													load_ms_petugas_id='$cmbPetugas',
													load_tr_inout_sts='Y',
													load_tr_inout_tgl_aktual='$txtAksi',
													load_tr_inout_tgl_load='$txtTglLoad',
													load_tr_inout_tgl_unload='$txtTglUnload',
													load_tr_inout_supir='$txtSupir',
													load_tr_inout_dokumen='$txtDokumen',
													load_ms_klasifikasi_id='$cmbKlasifikasi',
													load_tr_inout_updated='".date('Y-m-d H:i:s')."',
													load_tr_inout_updatedby='".$userRow['sys_role_id']."'
												WHERE load_tr_inout_id='$txtKode'";
			$qrySave	= mysqli_query($koneksidb, $sqlSave) or die ("gagal insert". mysqli_errors());

			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data masuk kendaraan berhasil diberbaharui';
				echo '<script>window.location="?page='.base64_encode(loaddttrkeluar).'"</script>';
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
	$sqlShow 			= "SELECT 
							convert(char(16),load_tr_inout_tgl_masuk,120) as load_tr_inout_tgl_masuk,
							load_tr_inout_ket,
							load_ms_jns_kend_id,
							load_ms_petugas_id,
							load_tr_inout_nopol,
							load_tr_inout_berat,
							load_ms_klasifikasi_id,
							load_tr_inout_id,
							load_tr_inout_supir,
							load_tr_inout_dokumen,
							load_tr_inout_aktual
							FROM load_tr_inout WHERE load_tr_inout_id='$KodeEdit'";
	$qryShow 			= mysqli_query($koneksidb, $sqlShow)  or die ("Query ambil data libur salah : ".mysqli_errors());
	$dataShow 			= mysqli_fetch_array($qryShow);		

	$dataKode 			= $dataShow['load_tr_inout_id'];
	$dataTglMasuk		= $dataShow['load_tr_inout_tgl_masuk'];
	$dataTglKeluar		= isset($_POST['txtTglKeluar']) ? $_POST['txtTglKeluar'] : date('Y-m-d H:i');
	$dataKeterangan		= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : $dataShow['load_tr_inout_ket'];
	$dataPetugas		= isset($_POST['cmbPetugas']) ? $_POST['cmbPetugas'] : $dataShow['load_ms_petugas_id'];
	$dataNopol			= isset($_POST['txtNopol']) ? $_POST['txtNopol'] : $dataShow['load_tr_inout_nopol'];
	$dataBerat			= isset($_POST['txtBerat']) ? $_POST['txtBerat'] : $dataShow['load_tr_inout_berat'];
	$dataKlasifikasi	= isset($_POST['cmbKlasifikasi']) ? $_POST['cmbKlasifikasi'] : $dataShow['load_ms_klasifikasi_id'];
	$dataKendaraan		= isset($_POST['cmbKendaraan']) ? $_POST['cmbKendaraan'] : $dataShow['load_ms_jns_kend_id'];
	$dataTglLoad		= isset($_POST['txtTglLoad']) ? $_POST['txtTglLoad'] : date('Y-m-d H:i');
	$dataTglUnload		= isset($_POST['txtTglUnload']) ? $_POST['txtTglUnload'] : date('Y-m-d H:i');
	$dataSupir			= isset($_POST['txtSupir']) ? $_POST['txtSupir'] : $dataShow['load_tr_inout_supir'];
	$dataDokumen		= isset($_POST['txtDokumen']) ? $_POST['txtDokumen'] : $dataShow['load_tr_inout_dokumen'];
	$dataAksi			= isset($_POST['txtAksi']) ? $_POST['txtAksi'] : $dataShow['load_tr_inout_aktual'];
?>
<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase bold">Form Keluar Kendaraan</span></div>
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
                            <input type="text" class="form-control" value="<?php echo $dataTglMasuk ?>" disabled>
                            <input type="hidden" name="txtKode" class="form-control" value="<?php echo $dataKode ?>">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Tgl. Keluar :</label>
					<div class="col-md-3">
						<div class="input-group">
                            <input type="text" name="txtTglKeluar" class="form-control form_datetime" value="<?php echo $dataTglKeluar ?>">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
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
					<label class="col-md-2 control-label">Nama Supir :</label>
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
					<label class="col-md-2 control-label">Nama Petugas :</label>
					<div class="col-md-3">
						<select name="cmbPetugas" data-placeholder="- Pilih Petugas -" class="select2 form-control">
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM load_ms_petugas ORDER BY load_ms_petugas_id DESC";
								  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
								  while ($dataRow = mysqli_fetch_array($dataQry)) {
									if ($dataPetugas == $dataRow['load_ms_petugas_id']) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$dataRow[load_ms_petugas_id]' $cek>$dataRow[load_ms_petugas_nm]</option>";
								  }
								  $sqlData ="";
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Klasifikasi Muatan :</label>
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
					<label class="col-md-2 control-label">Bongkar/Muat :</label>
					<div class="col-md-4">
						<div class="input-group">
                            <input type="text" name="txtTglLoad" class="form-control form_datetime" value="<?php echo $dataTglLoad ?>">
                            <span class="input-group-addon">s/d</span>
                            <input type="text" name="txtTglUnload" class="form-control form_datetime" value="<?php echo $dataTglUnload ?>">
                        </div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Berat Muatan :</label>
					<div class="col-md-3">
						<input class="form-control" type="text" name="txtBerat"  value="<?php echo $dataBerat; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Uraian Muatan :</label>
					<div class="col-md-10">
						<textarea class="form-control" type="text" name="txtKeterangan" onkeyup="javascript:this.value=this.value.toUpperCase();" ><?php echo $dataKeterangan; ?></textarea>
					</div>
				</div>
				<div class="form-group last">
					<label class="col-md-2 control-label">Keterangan :</label>
					<div class="col-md-10">
						<textarea class="form-control" type="text" name="txtAksi" onkeyup="javascript:this.value=this.value.toUpperCase();" ><?php echo $dataAksi; ?></textarea>
					</div>
				</div>
			</div>
			<div class="form-actions">
			    <div class="row">
		            <div class="col-lg-offset-2 col-lg-10">
		                <button type="submit" name="btnSave" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-save"></i> Simpan Data</button>
		                <a href="?page=<?php echo base64_encode(loaddttrkeluar) ?>" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-undo"></i> Batalkan</a>
		            </div>
			    </div>
			</div>
		</form>
	</div>
</div>