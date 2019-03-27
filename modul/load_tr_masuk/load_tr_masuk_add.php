<?php
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtTglMasuk'])=="") {
			$message[] = "Tgl. Masuk tidak boleh kosong!";		
		}
		if (trim($_POST['cmbKendaraan'])=="") {
			$message[] = "Jenis kendaraan tidak boleh kosong!";		
		}
		if (trim($_POST['txtNopol'])=="") {
			$message[] = "No. kendaraan tidak boleh kosong!";		
		}

				
		$txtTglMasuk		= $_POST['txtTglMasuk'];
		$txtKeterangan		= $_POST['txtKeterangan'];
		$txtNopol			= $_POST['txtNopol'];
		$cmbKendaraan		= $_POST['cmbKendaraan'];
		$cmbPetugas			= $_POST['cmbPetugas'];
		$txtBerat			= $_POST['txtBerat'];
		$cmbKlasifikasi		= $_POST['cmbKlasifikasi'];
		$txtSupir			= $_POST['txtSupir'];
		$txtDokumen			= $_POST['txtDokumen'];
				
		
		if(count($message)==0){		
			// STAR GENERATE KODE 
			$nomorTrans		= "/".date('m/y');
			$queryTrans		= "SELECT max(load_tr_inout_reg) as maxKode 
								FROM load_tr_inout 
								WHERE convert(char(4),load_tr_inout_created,112)='".date('Y')."'";
			$hasilTrans		= mysqli_query($koneksidb, $queryTrans);
			$dataTrans		= mysqli_fetch_array($hasilTrans);
			$noTrans		= $dataTrans['maxKode'];
			$noUrutTrans	= $noTrans + 1;
			$IDTrans		= sprintf("%04s", $noUrutTrans);
			$dataNomor		= $IDTrans.$nomorTrans;
			// END GENERATE KODE
			$sqlSave	= "INSERT INTO load_tr_inout (load_tr_inout_reg,
													load_tr_inout_tgl_masuk,
													load_tr_inout_sts,
													load_ms_jns_kend_id,
													load_tr_inout_nopol,
													load_tr_inout_berat,
													load_ms_petugas_id,
													load_ms_klasifikasi_id,
													load_tr_inout_ket,
													load_tr_inout_supir,
													load_tr_inout_dokumen,
													load_tr_inout_created,
													load_tr_inout_createdby) 
											VALUES ('$dataNomor',
													'$txtTglMasuk',
													'N',
													'$cmbKendaraan',
													'$txtNopol',
													'$txtBerat',
													'$cmbPetugas',
													'$cmbKlasifikasi',
													'$txtKeterangan',
													'$txtSupir',
													'$txtDokumen',
													'".date('Y-m-d H:i:s')."',
													'".$_SESSION['sys_role_id']."')";
			$qrySave	= mysqli_query($koneksidb, $sqlSave) or die ("gagal insert". mysqli_errors());

			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data masuk kendaraan berhasil ditambahkan No. Registrasi '.$dataNomor.'';
				echo '<script>window.location="?page='.base64_encode(loadcardtrmasuk).'&id='.$dataNomor.'"</script>';
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
			
	$dataTglMasuk		= isset($_POST['txtTglMasuk']) ? $_POST['txtTglMasuk'] : date('Y-m-d H:s');
	$dataKeterangan		= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
	$dataKendaraan		= isset($_POST['cmbKendaraan']) ? $_POST['cmbKendaraan'] : '';
	$dataPetugas		= isset($_POST['cmbPetugas']) ? $_POST['cmbPetugas'] : '';
	$dataNopol			= isset($_POST['txtNopol']) ? $_POST['txtNopol'] : '';
	$dataBerat			= isset($_POST['txtBerat']) ? $_POST['txtBerat'] : '';
	$dataKlasifikasi	= isset($_POST['cmbKlasifikasi']) ? $_POST['cmbKlasifikasi'] : '';
	$dataSupir			= isset($_POST['txtSupir']) ? $_POST['txtSupir'] : '';
	$dataDokumen		= isset($_POST['txtDokumen']) ? $_POST['txtDokumen'] : '';
?>
<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase bold">Form Masuk Kendaraan</span></div>
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
					<label class="col-md-2 control-label">No. Kendaraan :</label>
					<div class="col-md-3">
						<input class="form-control" type="text" name="txtNopol"  value="<?php echo $dataNopol; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
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