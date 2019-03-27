<?php
	
	
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtIsi'])=="") {
			$message[] = "<b>Isi</b> tidak boleh kosong !";		
		}
		if (trim($_POST['cmbKategori'])=="") {
			$message[] = "<b>Kategori</b> tidak boleh kosong !";		
		}
		if (trim($_POST['cmbSubject'])=="") {
			$message[] = "<b>Jenis</b> tidak boleh kosong !";		
		}
		if (trim($_POST['cmbJenis'])=="") {
			$message[] = "<b>Jenis</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtDokumen'])=="" AND trim($_POST['cmbJenis'])==2) {
			$message[] = "<b>Nomor dokumen</b> tidak boleh kosong !";		
		}
		
		$txtAlasan		= $_POST['txtAlasan'];
		$txtIsi			= $_POST['txtIsi'];
		$cmbSubject		= $_POST['cmbSubject'];
		$cmbJenis		= $_POST['cmbJenis'];
		$cmbKategori	= $_POST['cmbKategori'];
		$txtUsulan		= $_POST['txtUsulan'];
		$txtDokumen		= $_POST['txtDokumen'];
		$txtKode		= $_POST['txtKode'];


		if(count($message)==0){
			// GET KODE JENIS
			$sqlSave="UPDATE doc_tr_usul SET doc_ms_jns_doc_id='$cmbSubject',
											doc_ms_kat_doc_id='$cmbKategori',
											doc_ms_doc_id='$txtDokumen',
											doc_tr_usul_jns='$cmbJenis',
											doc_tr_usul_isi='$txtIsi',
											doc_tr_usul_usulan='$txtUsulan',
											doc_tr_usul_alasan='$txtAlasan',
											doc_tr_usul_updated='".date('Y-m-d H:i:s')."',
											doc_tr_usul_updatedby='".$_SESSION['sys_role_id']."'
										WHERE doc_tr_usul_id='$txtKode'";
			$qrySave	= mysqli_query($koneksidb, $sqlSave) or die ("gagal insert". mysqli_errors());
			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data usulan perubahan dokumen berhasil diperbaharui';
				echo '<script>window.location="?page='.base64_encode(docdttrusul).'"</script>';
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
							a.doc_tr_usul_id,
							a.doc_tr_usul_no,
							CONVERT(CHAR,a.doc_tr_usul_tgl,105) as doc_tr_usul_tgl,
							a.doc_ms_kat_doc_id,
							a.doc_ms_jns_doc_id,
							a.doc_tr_usul_isi,
							a.doc_ms_doc_id,
							a.doc_tr_usul_jns,
							a.doc_tr_usul_usulan,
							a.doc_tr_usul_alasan,
							b.doc_ms_doc_kd
							FROM doc_tr_usul a
							LEFT JOIN doc_ms_doc b ON a.doc_ms_doc_id=b.doc_ms_doc_id
							WHERE a.doc_tr_usul_id='$KodeEdit'";
	$qryShow 			= mysqli_query($koneksidb, $sqlShow)  or die ("Query ambil data department salah : ".mysqli_errors());
	$dataShow			= mysqli_fetch_array($qryShow);
	
	$dataKode			= $dataShow['doc_tr_usul_id'];
	$dataNomor			= $dataShow['doc_tr_usul_no'];
	$dataTanggal		= $dataShow['doc_tr_usul_tgl'];
	$dataDokumen		= $dataShow['doc_ms_doc_id'];
	$dataJenis			= isset($_POST['cmbJenis']) ? $_POST['cmbJenis'] : $dataShow['doc_tr_usul_jns'];
	$dataNoDoc			= isset($_POST['txtNoDoc']) ? $_POST['txtNoDoc'] : $dataShow['doc_ms_doc_kd'];
	$dataIsi			= isset($_POST['txtIsi']) ? $_POST['txtIsi'] : $dataShow['doc_tr_usul_isi'];
	$dataKategori		= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $dataShow['doc_ms_kat_doc_id']; 
	$dataSubject		= isset($_POST['cmbSubject']) ? $_POST['cmbSubject'] : $dataShow['doc_ms_jns_doc_id']; 
	$dataUsulan			= isset($_POST['txtUsulan']) ? $_POST['txtUsulan'] : $dataShow['doc_tr_usul_usulan']; 
	$dataAlasan			= isset($_POST['txtAlasan']) ? $_POST['txtAlasan'] : $dataShow['doc_tr_usul_alasan']; 
?>
<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT>
<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
        <div class="caption">
            <span class="caption-subject uppercase bold">Form Data Usulan Perubahan</span>
        </div>
        <div class="tools">
            <a href="" class="collapse"> </a>
            <a href="" class="reload"> </a>
            <a href="" class="remove"> </a>
        </div>
    </div>
	<div class="portlet-body form">
        <form action="<?php $_SERVER['PHP_SELF']; ?>" name="form1" method="post" class="form-horizontal form-bordered" autocomplete="off">
        	<div class="form-body">
        		<div class="form-group">
					<label class="col-md-2 control-label">No. Pengajuan :</label>
					<div class="col-md-2">
                        <input type="text" name="txtNomor" class="form-control" value="<?php echo $dataNomor ?>" readonly>
                        <input type="hidden" name="txtKode" class="form-control" value="<?php echo $dataKode ?>" readonly>
					</div>
				</div>
        		<div class="form-group">
					<label class="col-md-2 control-label">Tgl. Pengajuan :</label>
					<div class="col-md-3">
						<div class="input-group">
                            <input type="text" name="txtTanggal" class="form-control" value="<?php echo $dataTanggal ?>" readonly>
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
					</div>
				</div>
		        <div class="form-group">
					<label class="col-md-2 control-label">Kategori :</label>
					<div class="col-md-3">
						<select name="cmbKategori" data-placeholder="Select Category" class="select2 form-control">
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM doc_ms_kat_doc WHERE doc_ms_kat_doc_sts='Y' ORDER BY doc_ms_kat_doc_id DESC";
								  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
								  while ($dataRow = mysqli_fetch_array($dataQry)) {
									if ($dataKategori == $dataRow['doc_ms_kat_doc_id']) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$dataRow[doc_ms_kat_doc_id]' $cek>$dataRow[doc_ms_kat_doc_nm]</option>";
								  }
								  $sqlData ="";
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Subjek Dokumen :</label>
					<div class="col-md-4">
						<select name="cmbSubject" data-placeholder="Select Subject" class="select2 form-control">
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM doc_ms_jns_doc WHERE doc_ms_jns_doc_sts='Y' ORDER BY doc_ms_jns_doc_id DESC";
								  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
								  while ($dataRow = mysqli_fetch_array($dataQry)) {
									if ($dataSubject == $dataRow['doc_ms_jns_doc_id']) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$dataRow[doc_ms_jns_doc_id]' $cek>$dataRow[doc_ms_jns_doc_nm]</option>";
								  }
								  $sqlData ="";
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Jenis Usulan :</label>
					<div class="col-lg-3">
						<select name="cmbJenis" class="form-control select2" data-placeholder="Select Type" onChange="javascript:submitform();">
							<option value=""></option> 
							<?php
								$namaBulan = array("1" => "BARU", "2" => "PERUBAHAN");
								foreach($namaBulan as $bulanKe => $bulanNM) {
									if ($bulanKe == $dataJenis) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$bulanKe' $cek>$bulanNM</option>";
							  	}
							?>
						</select>
					</div>
				</div>
				<?php 
					if($dataJenis==2){
				?>
		        <div class="form-group">
					<label class="col-md-2 control-label">No. Dokumen :</label>
					<div class="col-md-3">
						<div class="input-group last">
                            <input type="text" name="txtNoDoc" value="<?php echo $dataNoDoc ?>" id="doc_ms_doc_kd" class="form-control" readonly>
                            <input type="hidden" name="txtDokumen" id="doc_ms_doc_id" class="form-control" value="<?php echo $dataDokumen ?>">
                            <span class="input-group-btn">
                                <button data-toggle="modal" data-target="#barang" class="btn <?php echo $dataPanel; ?>" type="button"><i class="fa fa-search" /></i></button>
                            </span>
                        </div>
					</div>
				</div>
				<?php } ?>
				<div class="form-group">
					<label class="col-lg-2 control-label">Isi Dokumen :</label>
					<div class="col-lg-8">
						<input type="text" name="txtIsi" placeholder="Enter Value" class="form-control" id="doc_ms_doc_nm" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $dataIsi; ?>">
		             </div>
				</div>
		        <div class="form-group">
					<label class="col-lg-2 control-label">Usulan :</label>
					<div class="col-lg-10">
						<textarea type="text" name="txtUsulan" placeholder="Enter Revision" class="form-control"  onkeyup="javascript:this.value=this.value.toUpperCase();"><?php echo $dataUsulan; ?></textarea>
		             </div>
				</div>
				<div class="form-group last">
					<label class="col-lg-2 control-label">Alasan :</label>
					<div class="col-lg-10">
						<textarea type="text" name="txtAlasan" placeholder="Enter Description" class="form-control"  onkeyup="javascript:this.value=this.value.toUpperCase();"><?php echo $dataAlasan; ?></textarea>
		             </div>
				</div>
			</div>
	    	<div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-2 col-md-10">
		                <button type="submit" name="btnSave" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-save"></i> Simpan Data</button>
		                <a href="?page=<?php echo base64_encode(docdttrusul) ?>" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-undo"></i> Batalkan</a>
			        </div>
			    </div>
			</div>
		</form>
	</div>
</div> 
		