<?php
	if(isset($_POST['btnExport'])){
		$message = array();
		if (trim($_POST['txtTglAwal'])=="") {
			$message[] = "Data periode awal tidak boleh kosong!";		
		}
		if (trim($_POST['txtTglAkhir'])=="") {
			$message[] = "Data periode akhir tidak boleh kosong!";		
		}
		if (trim($_POST['cmbAct'])=="") {
			$message[] = "Outout laporan tidak boleh kosong!";		
		}

		

		if(count($message)==0){		
			
			$tgl1 			= InggrisTgl($_POST['txtTglAwal']);
			$tgl2 			= InggrisTgl($_POST['txtTglAkhir']);
			if($_POST['cmbKategori']==''){
				$kat = '%';
			}else{
				$kat = $_POST['cmbKategori'];
			}
			if($_POST['cmbModul']==''){
				$mdl = '%';
			}else{
				$mdl = $_POST['cmbModul'];
			}
			$act 			= $_POST['cmbAct'];

			echo '<script>window.open("./output/tic_report_start.php?tgl1='.$tgl1.'&tgl2='.$tgl2.'&kat='.$kat.'&act='.$act.'&mdl='.$mdl.'","_blank")</script>';

		}


		if (! count($message)==0 ){
			echo "<div class='alert note note-warning'>";
				$Num=0;
				foreach ($message as $indeks=>$pesan_tampil) { 
				$Num++;
					echo "&nbsp;&nbsp;$Num. $pesan_tampil<br>";	
				} 
			echo "</div>"; 
		}
	}

	
	$dataTglAwal	= isset($_POST['txtTglAwal']) ? $_POST['txtTglAwal'] : date('d-m-Y');
	$dataTglAkhir	= isset($_POST['txtTglAkhir']) ? $_POST['txtTglAkhir'] : date('d-m-Y');
	$dataModul		= isset($_POST['cmbModul']) ? $_POST['cmbModul'] : '';
	$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : '';
	$dataAct		= isset($_POST['cmbAct']) ? $_POST['cmbAct'] : '';	
?>	
<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase bold">Laporan Ketercapaian Ticket</span></div>
		<div class="tools">
			<a href="javascript:;" class="collapse"></a>
			<a href="javascript:;" class="reload"></a>
			<a href="javascript:;" class="remove"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" class="form-horizontal form-bordered">
			<div class="form-body">
				<div class="form-group">
					<label class="col-md-2 control-label">Periode :</label>
					<div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control date-picker" name="txtTglAwal" data-date-format="dd-mm-yyyy" value="<?php echo $dataTglAwal ?>">
                            <span class="input-group-addon"> to </span>
                            <input type="text" class="form-control date-picker" name="txtTglAkhir" data-date-format="dd-mm-yyyy" value="<?php echo $dataTglAkhir ?>"> 
                        </div>
                    </div>
                </div>
				<div class="form-group">
					<label class="col-md-2 control-label">Kategori :</label>
					<div class="col-md-3">
						<select name="cmbKategori" data-placeholder="- Pilih Kategori -" class="select2 form-control">
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM tic_ms_kat ORDER BY tic_ms_kat_id DESC";
								  $dataQry = sqlsrv_query($koneksidb, $dataSql) or die ("Gagal Query".sqlsrv_errors());
								  while ($dataRow = sqlsrv_fetch_array($dataQry)) {
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
					<label class="col-md-2 control-label">Modul & Ticket :</label>
					<div class="col-md-3">
						<select name="cmbModul" data-placeholder="- Pilih Modul -" class="select2 form-control">
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM tic_ms_modul ORDER BY tic_ms_modul_id DESC";
								  $dataQry = sqlsrv_query($koneksidb, $dataSql) or die ("Gagal Query".sqlsrv_errors());
								  while ($dataRow = sqlsrv_fetch_array($dataQry)) {
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
				<div class="form-group last">
					<label class="col-md-2 control-label">Outout Type :</label>
					<div class="col-md-3">
						<select name="cmbAct" class="select2 form-control" data-placeholder="Pilih Output">
							<option value=""></option>
							<?php
								$arrAct	= array("EXCEL","PDF");
							  	foreach ($arrAct as $index => $value) {
								if ($value==$dataAct) {
									$cek="selected";
								} else { $cek = ""; }
								echo "<option value='$value' $cek>$value</option>";
							  	}
							?>
						</select>
					</div>
				</div>				
			</div>
			<div class="form-actions">
		        <div class="form-group">
		            <div class="col-lg-offset-2 col-lg-10">
		                <button type="submit" name="btnExport" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-download"></i> Export Report</button>
		            </div>
		        </div>
			</div>
		</form>
	</div>
</div>