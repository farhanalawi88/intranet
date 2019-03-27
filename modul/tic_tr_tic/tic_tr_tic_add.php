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
		$txtDeskripsi	= $_POST['txtDeskripsi'];
		$cmbLevel		= $_POST['cmbLevel'];
		$txtDiminta		= $_POST['txtDiminta'];
		$cmbKategori	= $_POST['cmbKategori'];
		$txtNoref		= $_POST['txtNoref'];
		$txtTanggal		= date('Y-m-d H:i:s');
				
		
		if(count($message)==0){		
			$bulan			= substr($txtTanggal,5,2);
			$romawi 		= getRomawi($bulan);
			$tahun			= substr($txtTanggal,2,2);
			$tahun2			= substr($txtTanggal,0,4);
			$nomorTrans		= "/".$romawi."/".$tahun;
			$queryTrans		= "SELECT max(tic_tr_ticket_no) as maxKode FROM tic_tr_ticket WHERE CONVERT(CHAR(4),tic_tr_ticket_tgl_start,112)='$tahun2' AND sys_group_id='".$userRow['sys_group_id']."'";
			$hasilTrans		= mysqli_query($koneksidb, $queryTrans);
			$dataTrans		= mysqli_fetch_array($hasilTrans);
			$noTrans		= $dataTrans['maxKode'];
			$noUrutTrans	= $noTrans + 1;
			$IDTrans		=  sprintf("%04s", $noUrutTrans);
			$kodeTrans		= $IDTrans.$nomorTrans;

			$sqlSave	= "INSERT INTO tic_tr_ticket (tic_tr_ticket_no,
													tic_tr_ticket_tgl_start,
													tic_tr_ticket_createdby,
													tic_tr_ticket_problem,
													tic_ms_kat_id,
													tic_ms_lvl_id,
													tic_tr_ticket_sts,
													tic_tr_ticket_ref,
													tic_ms_modul_id,
													tic_tr_ticket_app,
													tic_tr_ticket_description,
													sys_group_id,
													tic_tr_ticket_diminta) 
											VALUES ('$kodeTrans',
													'$txtTanggal',
													'".$userRow['sys_role_id']."',
													'$txtProblem',
													'$cmbKategori',
													'$cmbLevel',
													'N',
													'$txtNoref',
													'$cmbModul',
													'N',
													'$txtDeskripsi',
													'".$userRow['sys_group_id']."',
													'$txtDiminta')";
			$qrySave	= mysqli_query($koneksidb, $sqlSave) or die ("gagal insert". mysqli_errors());

			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data ticket berhasil ditambahkan dengan No. '.$kodeTrans.'';
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
	
	$dataModul		= isset($_POST['cmbModul']) ? $_POST['cmbModul'] : '';		
	$dataDiminta	= isset($_POST['txtDiminta']) ? $_POST['txtDiminta'] : strtoupper($userRow['sys_role_nama']);
	$dataProblem	= isset($_POST['txtProblem']) ? $_POST['txtProblem'] : '';
	$dataLevel		= isset($_POST['cmbLevel']) ? $_POST['cmbLevel'] : '';
	$dataNoref		= isset($_POST['txtNoref']) ? $_POST['txtNoref'] : '';
	$dataDeskripsi	= isset($_POST['txtDeskripsi']) ? $_POST['txtDeskripsi'] : '';
?>
<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase bold">Form Add Ticket</span></div>
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
					<div class="col-md-4">
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
