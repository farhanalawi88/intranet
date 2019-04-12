<?php
	
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtMonitoring'])=="") {
			$message[] = "<b>Monitoring</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtTglMonitoring'])=="") {
			$message[] = "<b>Tgl. Monitoring</b> tidak boleh kosong !";		
		}
		if (trim($_POST['cmbStatus'])=="") {
			$message[] = "<b>Status</b> tidak boleh kosong !";		
		}
		
		$txtTglMonitoring	= InggrisTgl($_POST['txtTglMonitoring']);
		$cmbStatus			= $_POST['cmbStatus'];
		$txtMonitoring		= $_POST['txtMonitoring'];
		$txtKode			= $_POST['txtKode'];

		if(count($message)==0){
			$sqlSave="UPDATE ptkp_tr_ptkp SET ptkp_tr_ptkp_tgl_monitoring='$txtTglMonitoring', 
												ptkp_tr_ptkp_monitoring='$txtMonitoring',
												ptkp_tr_ptkp_sts='$cmbStatus'
											WHERE ptkp_tr_ptkp_id='$txtKode'";
			$qrySave	= mysqli_query($koneksidb, $sqlSave) or die ("gagal update ptkp ". mysqli_errors());
			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data penerimaan ptkp berhasil dilakukan monitoring/verifikasi';
				echo '<script>window.location="?page='.base64_encode(ptkpdttrtrmptkp).'"</script>';
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

	$KodeEdit			= isset($_GET['id']) ?  base64_decode($_GET['id']) : $_POST['txtKode']; 
	$sqlShow			= "SELECT 
							a.ptkp_tr_ptkp_tgl,
							a.ptkp_tr_ptkp_no,
							a.ptkp_ms_sumber_id,
							a.sys_bagian_id,
							a.ptkp_ms_dampak_id,
							a.ptkp_ms_kategori_id,
							a.ptkp_ms_terkait_id,
							a.ptkp_tr_ptkp_kegiatan,
							a.ptkp_tr_ptkp_deskripsi,
							a.ptkp_tr_ptkp_referensi,
							a.doc_ms_doc_id,
							b.doc_ms_doc_kd,
							a.ptkp_tr_ptkp_id,
							a.ptkp_tr_ptkp_masalah,
							a.ptkp_tr_ptkp_sts,
							a.ptkp_tr_ptkp_tgl_koreksi,
							a.ptkp_tr_ptkp_tgl_pencegahan,
							a.ptkp_tr_ptkp_tgl_monitoring,
							a.ptkp_tr_ptkp_koreksi,
							a.ptkp_tr_ptkp_pencegahan,
							a.ptkp_tr_ptkp_monitoring
							FROM ptkp_tr_ptkp a
							LEFT JOIN doc_ms_doc b ON a.doc_ms_doc_id=b.doc_ms_doc_id
							WHERE a.ptkp_tr_ptkp_id='$KodeEdit'";
	$qryShow 			= mysqli_query($koneksidb, $sqlShow)  or die ("Query ambil data department salah : ".mysqli_errors());
	$dataShow			= mysqli_fetch_array($qryShow);

	$dataKode 			= $dataShow['ptkp_tr_ptkp_id'];
	$dataNomor 			= $dataShow['ptkp_tr_ptkp_no'];
	$dataTanggal		= $dataShow['ptkp_tr_ptkp_tgl'];
	$dataSumber			= $dataShow['ptkp_ms_sumber_id'];
	$dataBagian			= $dataShow['sys_bagian_id']; 
	$dataKegiatan		= $dataShow['ptkp_tr_ptkp_kegiatan'];  
	$dataKategori		= $dataShow['ptkp_ms_kategori_id'];  
	$dataDeskripsi		= $dataShow['ptkp_tr_ptkp_deskripsi']; 
	$dataDampak			= $dataShow['ptkp_ms_dampak_id']; 
	$dataTerkait		= $dataShow['ptkp_ms_terkait_id']; 
	$dataReferensi		= $dataShow['doc_ms_doc_kd'];
	$dataDokumen		= $dataShow['doc_ms_doc_id'];
	$dataMasalah		= $dataShow['ptkp_tr_ptkp_masalah'];
	$dataMasalah		= $dataShow['ptkp_tr_ptkp_masalah'];
	$dataMasalah		= $dataShow['ptkp_tr_ptkp_masalah'];
	$dataMasalah		= $dataShow['ptkp_tr_ptkp_masalah'];
	$dataMasalah		= $dataShow['ptkp_tr_ptkp_masalah'];
	$dataMasalah		= $dataShow['ptkp_tr_ptkp_masalah'];
	$dataKoreksi		= $dataShow['ptkp_tr_ptkp_koreksi'];
	$dataTglKoreksi		= $dataShow['ptkp_tr_ptkp_tgl_koreksi'];
	$dataPencegahan		= $dataShow['ptkp_tr_ptkp_pencegahan'];
	$dataTglPencegahan	= $dataShow['ptkp_tr_ptkp_tgl_pencegahan'];
	$dataMonitoring		= isset($_POST['txtMonitoring']) ? $_POST['txtMonitoring'] : $dataShow['ptkp_tr_ptkp_monitoring'];
	$dataTglMonitoring	= isset($_POST['txtTglMonitoring']) ? $_POST['txtTglMonitoring'] : $dataShow['ptkp_tr_ptkp_tgl_monitoring'];
	$dataStatus			= isset($_POST['cmbStatus']) ? $_POST['cmbStatus'] : $dataShow['ptkp_tr_ptkp_sts'];
?>
<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
        <div class="caption">
            <span class="caption-subject uppercase bold">Form Monitoring PTKP</span>
        </div>
        <div class="tools">
            <a href="" class="collapse"> </a>
            <a href="#portlet-config" data-toggle="modal" class="config"> </a>
            <a href="" class="reload"> </a>
            <a href="" class="remove"> </a>
        </div>
    </div>
	<div class="portlet-body form">
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal form-bordered" autocomplete="off" name="form1">
        	<div class="form-body">
		        <div class="form-group">
					<label class="col-lg-2 control-label">No. PTKP :</label>
					<div class="col-lg-2">
						<input type="text" value="<?php echo $dataNomor; ?>" class="form-control" disabled/>
						<input type="hidden" value="<?php echo $dataKode; ?>" name="txtKode"/>
		             </div>
				</div>
		        <div class="form-group">
					<label class="col-lg-2 control-label">Tanggal :</label>
					<div class="col-lg-3">
						<input type="text" value="<?php echo $dataTanggal; ?>" class="form-control" disabled/>
		             </div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Sumber :</label>
					<div class="col-md-4">
						<select disabled data-placeholder="Pilih Sumber" class="select2 form-control">
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM ptkp_ms_sumber WHERE ptkp_ms_sumber_sts='Y' ORDER BY ptkp_ms_sumber_id ASC";
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
					<label class="col-md-2 control-label">Departemen :</label>
					<div class="col-md-3">
						<select disabled data-placeholder="Pilih Departemen" class="select2 form-control" disabled>
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM sys_bagian WHERE sys_bagian_sts='Y' ORDER BY sys_bagian_id ASC";
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
					<label class="col-lg-2 control-label">Kegiatan :</label>
					<div class="col-lg-8">
						<input type="text" disabled value="<?php echo $dataKegiatan; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control" placeholder="Input Kegiatan"/>
		             </div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Kategori :</label>
					<div class="col-md-4">
						<select disabled data-placeholder="Pilih Kategori" class="select2 form-control">
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM ptkp_ms_kategori WHERE ptkp_ms_kategori_sts='Y' ORDER BY ptkp_ms_kategori_id ASC";
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
					<label class="col-md-2 control-label">Dampak Temuan :</label>
					<div class="col-md-4">
						<select data-placeholder="Pilih Dampak" class="select2 form-control" disabled>
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM ptkp_ms_dampak WHERE ptkp_ms_dampak_sts='Y' ORDER BY ptkp_ms_dampak_id ASC";
								  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
								  while ($dataRow = mysqli_fetch_array($dataQry)) {
									if ($dataDampak == $dataRow['ptkp_ms_dampak_id']) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$dataRow[ptkp_ms_dampak_id]' $cek>$dataRow[ptkp_ms_dampak_nm]</option>";
								  }
								  $sqlData ="";
							?>
						</select>
					</div>
				</div>	
				<div class="form-group">
					<label class="col-md-2 control-label">Keterkaitan :</label>
					<div class="col-md-4">
						<select data-placeholder="Pilih Keterkaitan" class="select2 form-control" disabled>
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM ptkp_ms_terkait WHERE ptkp_ms_terkait_sts='Y' ORDER BY ptkp_ms_terkait_id ASC";
								  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
								  while ($dataRow = mysqli_fetch_array($dataQry)) {
									if ($dataTerkait == $dataRow['ptkp_ms_terkait_id']) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$dataRow[ptkp_ms_terkait_id]' $cek>$dataRow[ptkp_ms_terkait_nm]</option>";
								  }
								  $sqlData ="";
							?>
						</select>
					</div>
				</div>		
				<div class="form-group">
					<label class="col-lg-2 control-label">Monitoring :</label>
					<div class="col-lg-10">
						<textarea type="text" name="txtMonitoring" class="form-control ckeditor" onkeyup="javascript:this.value=this.value.toUpperCase();"><?php echo $dataMonitoring; ?></textarea>
		             </div>
				</div>	
				<div class="form-group">
					<label class="col-lg-2 control-label">Tgl. Monitoring :</label>
					<div class="col-lg-3">
						<input type="text" value="<?php echo $dataTglMonitoring; ?>" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="txtTglMonitoring"/>
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
		                <a href="?page=<?php echo base64_encode(ptkpdtmonitortrptkp) ?>" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-undo"></i> Kembali</a>
			        </div>
			    </div>
			</div>
		</form>
	</div>
</div>
