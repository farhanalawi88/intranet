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
			if($_POST['cmbSumber']==''){
				$sumber = '%';
			}else{
				$sumber = $_POST['cmbSumber'];
			}
			if($_POST['cmbKategori']==''){
				$kategori = '%';
			}else{
				$kategori = $_POST['cmbKategori'];
			}
			if($_POST['cmbBagian']==''){
				$bag = '%';
			}else{
				$bag = $_POST['cmbBagian'];
			}
			if($_POST['cmbTindak']==''){
				$tindak = '%';
			}else{
				$tindak = $_POST['cmbTindak'];
			}
			if($_POST['cmbMonitor']==''){
				$monitor = '%';
			}else{
				$monitor = $_POST['cmbMonitor'];
			}
			$act 			= $_POST['cmbAct'];

			echo '<script>window.open("./output/ptkp_report_by_tgl.php?tgl1='.$tgl1.'&tgl2='.$tgl2.'&sumber='.$sumber.'&act='.$act.'&kategori='.$kategori.'&bagian='.$bag.'&tindak='.$tindak.'&monitor='.$monitor.'","_blank")</script>';

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
	$dataSumber		= isset($_POST['cmbSumber']) ? $_POST['cmbSumber'] : '';
	$dataBagian		= isset($_POST['cmbBagian']) ? $_POST['cmbBagian'] : '';
	$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : '';	
	$dataTindak		= isset($_POST['cmbTindak']) ? $_POST['cmbTindak'] : '';	
	$dataMonitor	= isset($_POST['cmbMonitor']) ? $_POST['cmbMonitor'] : '';	
	$dataAct		= isset($_POST['cmbAct']) ? $_POST['cmbAct'] : '';	
?>	
<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase bold">Laporan PTKP Berdasarkan Tgl. Pembuatan</span></div>
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
					<label class="col-md-2 control-label">Sumber :</label>
					<div class="col-md-3">
						<select name="cmbSumber" data-placeholder="- Sumber PTKP -" class="select2 form-control">
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM ptkp_ms_sumber ORDER BY ptkp_ms_sumber_id ASC";
								  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
								  while ($dataRow = mysqli_fetch_array($dataQry)) {
									if ($dataSumber == $dataRow['ptkp_ms_sumber_id']) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$dataRow[ptkp_ms_sumber_id]' $cek>$dataRow[ptkp_ms_sumber_nm]</option>";
								  }
								  $sqlData ="";
							?>
						</select>
					</div>
				</div>	
				<div class="form-group">
					<label class="col-md-2 control-label">Nama Bagian :</label>
					<div class="col-md-3">
						<select name="cmbBagian" data-placeholder="- Pilih Bagian -" class="select2 form-control">
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM sys_bagian ORDER BY sys_bagian_id DESC";
								  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
								  while ($dataRow = mysqli_fetch_array($dataQry)) {
									if ($dataBagian == $dataRow['sys_bagian_id']) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$dataRow[sys_bagian_id]' $cek>$dataRow[sys_bagian_nm]</option>";
								  }
								  $sqlData ="";
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Kategori :</label>
					<div class="col-md-4">
						<select name="cmbKategori" data-placeholder="- Pilih Kategori -" class="select2 form-control">
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM ptkp_ms_kategori ORDER BY ptkp_ms_kategori_id DESC";
								  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
								  while ($dataRow = mysqli_fetch_array($dataQry)) {
									if ($dataKategori == $dataRow['ptkp_ms_kategori_id']) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$dataRow[ptkp_ms_kategori_id]' $cek>$dataRow[ptkp_ms_kategori_nm]</option>";
								  }
								  $sqlData ="";
							?>
						</select>
					</div>
				</div>	
				<div class="form-group">
					<label class="col-md-2 control-label">Koreksi :</label>
					<div class="col-md-2">
						<select name="cmbTindak" class="select2 form-control" data-placeholder="Pilih Status">
							<option value=""></option>
							<?php
								$arrTindak	= array("Y","N");
							  	foreach ($arrTindak as $index => $value) {
								if ($value==$dataTindak) {
									$cek="selected";
								} else { $cek = ""; }
								echo "<option value='$value' $cek>$value</option>";
							  	}
							?>
						</select>
					</div>
				</div>		
				<div class="form-group">
					<label class="col-md-2 control-label">Status PTKP :</label>
					<div class="col-md-2">
						<select name="cmbMonitor" class="select2 form-control" data-placeholder="Pilih Status">
							<option value=""></option>
							<?php
								$arrMonitor	= array("Y","N");
							  	foreach ($arrMonitor as $index => $value) {
								if ($value==$dataMonitor) {
									$cek="selected";
								} else { $cek = ""; }
								echo "<option value='$value' $cek>$value</option>";
							  	}
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