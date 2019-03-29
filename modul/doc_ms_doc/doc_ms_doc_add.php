<?php
	
	
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['cmbBagian'])=="") {
			$message[] = "<b>Bagian</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtNama'])=="") {
			$message[] = "<b>Judul</b> tidak boleh kosong !";		
		}
		if (trim($_POST['cmbKategori'])=="") {
			$message[] = "<b>Kategori</b> tidak boleh kosong !";		
		}
		if (trim($_POST['cmbJenis'])=="") {
			$message[] = "<b>Jenis</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtNomor'])=="") {
			$message[] = "<b>Nomor</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtTanggal'])=="") {
			$message[] = "<b>Tanggal</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtRevisi'])=="") {
			$message[] = "<b>Revisi</b> tidak boleh kosong !";		
		}
		if (empty($_FILES['txtFilePDF']['tmp_name'])) {
			$message[] = "<b>File PDF</b> tidak boleh kosong !";		
		}
		if (empty($_FILES['txtFileWord']['tmp_name'])) {
			$message[] = "<b>File Word</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtLink'])=="") {
			$message[] = "<b>Link</b> tidak boleh kosong !";		
		}
		
		$txtRevisi		= $_POST['txtRevisi'];
		$txtNama		= $_POST['txtNama'];
		$cmbBagian		= $_POST['cmbBagian'];
		$cmbJenis		= $_POST['cmbJenis'];
		$cmbKategori	= $_POST['cmbKategori'];
		$txtKeterangan	= $_POST['txtKeterangan'];
		$txtNomor		= $_POST['txtNomor'];
		$txtTanggal		= InggrisTgl($_POST['txtTanggal']);
		$txtLink		= $_POST['txtLink'];

		if(count($message)==0){
			// GET KODE JENIS
			$tgl 		 = date('ymdhis');
			if (! empty($_FILES['txtFilePDF']['tmp_name'])) {
				$file_upload_pdf 	= $_FILES['txtFilePDF']['name'];
				$file_upload_pdf 	= stripslashes($file_upload_pdf);
				$file_upload_pdf 	= str_replace("'","",$file_upload_pdf);
				$txtExtPDF			= pathinfo($file_upload_pdf, PATHINFO_EXTENSION);
				$file_upload_pdf	= $tgl."_".$_POST['txtNomor']."_".$_POST['txtNama']."_"."".$_POST['txtRevisi'].".".$txtExtPDF;
				copy($_FILES['txtFilePDF']['tmp_name'],"file/".$file_upload_pdf);
			}
			else {
				$file_upload_pdf 	= "";
			}	
			if (! empty($_FILES['txtFileWord']['tmp_name'])) {
				$file_upload_word 	= $_FILES['txtFileWord']['name'];
				$file_upload_word 	= stripslashes($file_upload_word);
				$file_upload_word 	= str_replace("'","",$file_upload_word);
				$txtExtWord			= pathinfo($file_upload_word, PATHINFO_EXTENSION);
				$file_upload_word	= $tgl."_".$_POST['txtNomor']."_".$_POST['txtNama']."_"."".$_POST['txtRevisi'].".".$txtExtWord;
				copy($_FILES['txtFileWord']['tmp_name'],"file/".$file_upload_word);
			}
			else {
				$file_upload_word	= "";
			}	
			$sqlSave="INSERT INTO doc_ms_doc (doc_ms_doc_nm,
												doc_ms_doc_kd,
												doc_ms_doc_ket,
												doc_ms_doc_rev,
												doc_ms_doc_type,
												sys_bagian_id,
												doc_ms_doc_sts,
												doc_ms_kat_doc_id,
												doc_ms_doc_created,
												doc_ms_doc_createdby,
												doc_ms_doc_tgl,
												doc_ms_doc_pdf,
												doc_ms_doc_link,
												doc_ms_doc_word)
										VALUES('$txtNama',
												'$txtNomor',
												'$txtKeterangan',
												'$txtRevisi',
												'$cmbJenis',
												'$cmbBagian',
												'Y',
												'$cmbKategori',
												'".date('Y-m-d H:i:s')."',
												'".$_SESSION['sys_role_id']."',
												'$txtTanggal',
												'$file_upload_pdf',
												'$txtLink',
												'$file_upload_word')";
			$qrySave	= mysqli_query($koneksidb, $sqlSave) or die ("gagal insert". mysqli_errors());
			if($qrySave){

				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data master document berhasil ditambahkan';
				echo '<script>window.location="?page='.base64_encode(docdtmsdoc).'"</script>';
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
	
	$dataJenis		= isset($_POST['cmbJenis']) ? $_POST['cmbJenis'] : '';
	$dataNama		= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
	$dataNomor		= isset($_POST['txtNomor']) ? $_POST['txtNomor'] : ''; 
	$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : ''; 
	$dataBagian		= isset($_POST['cmbBagian']) ? $_POST['cmbBagian'] : ''; 
	$dataRevisi		= isset($_POST['txtRevisi']) ? $_POST['txtRevisi'] : ''; 
	$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : ''; 
	$dataTanggal	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : ''; 
	$dataLink		= isset($_POST['txtLink']) ? $_POST['txtLink'] : ''; 
?>
<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
        <div class="caption">
            <span class="caption-subject uppercase">Form Data Master Document</span>
        </div>
        <div class="tools">
            <a href="" class="collapse"> </a>
            <a href="#portlet-config" data-toggle="modal" class="config"> </a>
            <a href="" class="reload"> </a>
            <a href="" class="remove"> </a>
        </div>
    </div>
	<div class="portlet-body form">
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal form-bordered" autocomplete="off" enctype="multipart/form-data">
        	<div class="form-body">
		        <div class="form-group">
					<label class="col-lg-2 control-label">No. Dokumen :</label>
					<div class="col-lg-3">
						<input type="text" name="txtNomor" value="<?php echo $dataNomor; ?>" class="form-control" placeholder="Enter Number" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
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
					<label class="col-md-2 control-label">Jenis Dokumen :</label>
					<div class="col-md-3">

						<select class="form-control select2" data-placeholder="Select Type" name="cmbJenis">
		                	<option value=""></option>
		               		<?php
							  $pilihan	= array("PEDOMAN MUTU", "PROSEDUR","INSTRUKSI KERJA","RENCANA MUTU","STANDAR MUTU","FORMAT STANDAR");
							  foreach ($pilihan as $nilai) {
								if ($dataJenis==$nilai) {
									$cek=" selected";
								} else { $cek = ""; }
								echo "<option value='$nilai' $cek>$nilai</option>";
							  }
							?>
		              	</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Nama Bagian :</label>
					<div class="col-md-4">
						<select name="cmbBagian" data-placeholder="Select Departemen" class="select2 form-control">
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM sys_bagian WHERE sys_bagian_sts='Y' ORDER BY sys_bagian_id DESC";
								  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
								  while ($dataRow = mysqli_fetch_array($dataQry)) {
									if ($dataBagian == $dataRow['sys_bagian_id']) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$dataRow[sys_bagian_id]' $cek>$dataRow[sys_bagian_kd] - $dataRow[sys_bagian_nm]</option>";
								  }
								  $sqlData ="";
							?>
						</select>
					</div>
				</div>
		        <div class="form-group">
					<label class="col-lg-2 control-label">Judul Dokumen :</label>
					<div class="col-lg-10">
						<input type="text" name="txtNama" value="<?php echo $dataNama; ?>" class="form-control" placeholder="Enter Title" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
		             </div>
				</div>
		        <div class="form-group">
					<label class="col-lg-2 control-label">Revisi :</label>
					<div class="col-lg-2">
						<input type="text" name="txtRevisi" value="<?php echo $dataRevisi; ?>" class="form-control" placeholder="Enter Revision" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
		             </div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Tgl. Pengesahan :</label>
					<div class="col-lg-3">
						<input type="text" name="txtTanggal" value="<?php echo $dataTanggal; ?>" class="form-control date-picker" placeholder="Enter Date" data-date-format="dd-mm-yyyy"/>
		             </div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">Upload PDF :</label>
					<div class="col-md-9">
						<div class="fileinput fileinput-new" data-provides="fileinput">
							<span class="btn default btn-file">
								<span class="fileinput-new">Select file</span>
								<span class="fileinput-exists">Change</span>
								<input type="file" name="txtFilePDF">
							</span>
							<span class="fileinput-filename"></span>&nbsp;
							<a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"></a>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">Upload MS Word :</label>
					<div class="col-md-9">
						<div class="fileinput fileinput-new" data-provides="fileinput">
							<span class="btn default btn-file">
								<span class="fileinput-new">Select file</span>
								<span class="fileinput-exists">Change</span>
								<input type="file" name="txtFileWord">
							</span>
							<span class="fileinput-filename"></span>&nbsp;
							<a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"></a>
						</div>
					</div>
				</div>
				<div class="form-group last">
					<label class="col-lg-2 control-label">Link :</label>
					<div class="col-lg-3">
						<input type="text" name="txtLink" value="<?php echo $dataLink; ?>" class="form-control" placeholder="Enter Link" />
		             </div>
				</div>
			</div>
	    	<div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-2 col-md-10">
		                <button type="submit" name="btnSave" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-save"></i> Simpan Data</button>
		                <a href="?page=<?php echo base64_encode(docdtmsdoc) ?>" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-undo"></i> Batalkan</a>
			        </div>
			    </div>
			</div>
		</form>
	</div>
</div>
		