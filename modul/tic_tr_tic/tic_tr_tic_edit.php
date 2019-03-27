<?php
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['cmbModul'])=="") {
			$message[] = "Nama modul tidak boleh kosong!";		
		}
		if (trim($_POST['cmbLevel'])=="") {
			$message[] = "Level tidak boleh kosong!";		
		}
		if (trim($_POST['cmbKategori'])=="") {
			$message[] = "Kategori tidak boleh kosong!";		
		}
		if (trim($_POST['txtProblem'])=="") {
			$message[] = "Data perubahan tidak boleh kosong!";		
		}
		if (trim($_POST['txtDeskripsi'])=="") {
			$message[] = "Data alasan perubahan tidak boleh kosong!";		
		}
				
		$cmbModul		= $_POST['cmbModul'];
		$txtProblem		= $_POST['txtProblem'];
		$cmbLevel		= $_POST['cmbLevel'];
		$txtDiminta		= $_POST['txtDiminta'];
		$cmbKategori	= $_POST['cmbKategori'];
		$txtNoref		= $_POST['txtNoref'];
		$txtKode		= $_POST['txtKode'];
		$txtDeskripsi	= $_POST['txtDeskripsi'];
				
		
		if(count($message)==0){		

			$sqlSave	= "UPDATE tic_tr_ticket SET tic_tr_ticket_problem='$txtProblem',
													tic_ms_kat_id='$cmbKategori',
													tic_ms_lvl_id='$cmbLevel',
													tic_tr_ticket_ref='$txtNoref',
													tic_ms_modul_id='$cmbModul',
													tic_tr_ticket_description='$txtDeskripsi',
													tic_tr_ticket_diminta='$txtDiminta'
												WHERE tic_tr_ticket_id='$txtKode'";
			$qrySave	= mysqli_query($koneksidb, $sqlSave) or die ("gagal edit". mysqli_errors());

			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data ticket berhasil diperbaharui dengan No. '.$_POST['txtNomor'].'';
				echo '<script>window.location="?page='.base64_encode(ticdttic).'"</script>';
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
	$KodeEdit		= isset($_GET['id']) ?  $_GET['id'] : $_POST['txtTglLibur']; 
	$sqlShow 		= "SELECT * FROM tic_tr_ticket WHERE tic_tr_ticket_id='$KodeEdit'";
	$qryShow 		= mysqli_query($koneksidb, $sqlShow)  or die ("Query ambil data libur salah : ".mysqli_errors());
	$dataShow 		= mysqli_fetch_array($qryShow);		
	
	$dataKode		= $dataShow['tic_tr_ticket_id'];
	$dataNomor		= $dataShow['tic_tr_ticket_no'];
	$dataModul		= isset($_POST['cmbModul']) ? $_POST['cmbModul'] : $dataShow['tic_ms_modul_id'];		
	$dataDiminta	= isset($_POST['txtDiminta']) ? $_POST['txtDiminta'] : $dataShow['tic_tr_ticket_diminta'];
	$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $dataShow['tic_ms_kat_id'];
	$dataProblem	= isset($_POST['txtProblem']) ? $_POST['txtProblem'] : $dataShow['tic_tr_ticket_problem'];
	$dataLevel		= isset($_POST['cmbLevel']) ? $_POST['cmbLevel'] : $dataShow['tic_ms_lvl_id'];
	$dataNoref		= isset($_POST['txtNoref']) ? $_POST['txtNoref'] : $dataShow['tic_tr_ticket_ref'];
	$dataDeskripsi	= isset($_POST['txtDeskripsi']) ? $_POST['txtDeskripsi'] : $dataShow['tic_tr_ticket_description'];
?>
<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase bold">Form Edit Ticket</span></div>
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
					<label class="col-md-2 control-label">No. Ticket :</label>
					<div class="col-md-2">
	                    <input class="form-control" type="text" value="<?php echo $dataNomor ?>" name="txtNomor" readonly/>
	                    <input class="form-control" type="hidden" value="<?php echo $dataKode ?>" name="txtKode"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Kategori :</label>
					<div class="col-md-3">
						<select name="cmbKategori" data-placeholder="- Pilih Kategori -" class="select2 form-control">
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM tic_ms_kat ORDER BY tic_ms_kat_id DESC";
								  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
								  while ($dataRow = mysqli_fetch_array($dataQry)) {
									if ($dataKategori == $dataRow['tic_ms_kat_id']) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$dataRow[tic_ms_kat_id]' $cek>$dataRow[tic_ms_kat_nm]</option>";
								  }
								  $sqlData ="";
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Diminta Oleh :</label>
					<div class="col-md-3">
	                    <input class="form-control" type="text" value="<?php echo $dataDiminta ?>" name="txtDiminta" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Ticket & Modul :</label>
					<div class="col-md-3">
						<select name="cmbModul" data-placeholder="- Pilih Modul -" class="select2 form-control">
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM tic_ms_modul ORDER BY tic_ms_modul_id DESC";
								  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
								  while ($dataRow = mysqli_fetch_array($dataQry)) {
									if ($dataModul == $dataRow['tic_ms_modul_id']) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$dataRow[tic_ms_modul_id]' $cek>$dataRow[tic_ms_modul_nm]</option>";
								  }
								  $sqlData ="";
							?>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">No. Dokumen :</label>
					<div class="col-md-3">
	                    <input class="form-control" type="text" value="<?php echo $dataNoref ?>" name="txtNoref" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Perubahan :</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="txtProblem" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $dataProblem ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Alasan :</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="txtDeskripsi" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $dataDeskripsi ?>">
					</div>
				</div>
				<div class="form-group last">
					<label class="col-md-2 control-label">Level :</label>
					<div class="col-md-3">
						<select name="cmbLevel" data-placeholder="- Pilih Level -" class="select2 form-control">
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM tic_ms_lvl ORDER BY tic_ms_lvl_id DESC";
								  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
								  while ($dataRow = mysqli_fetch_array($dataQry)) {
									if ($dataLevel == $dataRow['tic_ms_lvl_id']) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$dataRow[tic_ms_lvl_id]' $cek>$dataRow[tic_ms_lvl_nm]</option>";
								  }
								  $sqlData ="";
							?>
						</select>
					</div>
				</div>
			</div>
			<div class="form-actions">
			    <div class="row">
		            <div class="col-lg-offset-2 col-lg-10">
		                <button type="submit" name="btnSave" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-save"></i> Simpan Data</button>
		                <a href="?page=<?php echo base64_encode(ticdttic) ?>" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-undo"></i> Batalkan</a>
		            </div>
			    </div>
			</div>
		</form>
	</div>
</div>
