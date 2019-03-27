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
		if (trim($_POST['txtKode'])=="") {
			$message[] = "<b>ID</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtTanggal'])=="") {
			$message[] = "<b>Tanggal</b> tidak boleh kosong !";		
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
		$txtKode		= $_POST['txtKode'];
		$txtTanggal		= InggrisTgl($_POST['txtTanggal']);
		$txtLink		= $_POST['txtLink'];


		if(count($message)==0){
			$tgl 		 = date('ymdhis');
			// UPLOAD FILE PDF
			if (empty($_FILES['txtPDF']['tmp_name'])) {
				$file_pdf = $_POST['txtPDFLama'];
			}
			else  {
				if(! $_POST['txtPDFLama']=="") {
					if(file_exists("file/".$_POST['txtPDFLama'])) {
						unlink("file/".$_POST['txtPDFLama']);	
					}
				}

				$file_pdf = $_FILES['txtPDF']['name'];
				$file_pdf = stripslashes($file_pdf);
				$file_pdf = str_replace("'","",$file_pdf);
				
				$file_pdf = $tgl.".".$file_pdf;
				copy($_FILES['txtPDF']['tmp_name'],"file/".$file_pdf);					
			}
			// UPLOAD FILE WORD
			if (empty($_FILES['txtWord']['tmp_name'])) {
				$file_word = $_POST['txtWordLama'];
			}
			else  {
				if(! $_POST['txtWordLama']=="") {
					if(file_exists("file/".$_POST['txtWordLama'])) {
						unlink("file/".$_POST['txtWordLama']);	
					}
				}

				$file_word = $_FILES['txtWord']['name'];
				$file_word = stripslashes($file_word);
				$file_word = str_replace("'","",$file_word);
				
				$file_word = $tgl.".".$file_word;
				copy($_FILES['txtWord']['tmp_name'],"file/".$file_word);					
			}
			$sqlSave="UPDATE doc_ms_doc SET doc_ms_doc_nm='$txtNama',
											doc_ms_doc_kd='$txtNomor',
											doc_ms_doc_ket='$txtKeterangan',
											doc_ms_doc_rev='$txtRevisi',
											doc_ms_doc_type='$cmbJenis',
											sys_bagian_id='$cmbBagian',
											doc_ms_doc_tgl='$txtTanggal',
											doc_ms_kat_doc_id='$cmbKategori',
											doc_ms_doc_pdf='$file_pdf',
											doc_ms_doc_word='$file_word',
											doc_ms_doc_link='$txtLink',
											doc_ms_doc_updated='".date('Y-m-d H:i:s')."',
											doc_ms_doc_updatedby='".$_SESSION['sys_role_id']."'
										WHERE doc_ms_doc_id='$txtKode'";
			$qrySave	= mysqli_query($koneksidb, $sqlSave) or die ("gagal insert". mysqli_errors());
			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data master document berhasil diperbaharui';
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
	$KodeEdit			= isset($_GET['id']) ?  base64_decode($_GET['id']) : $_POST['txtKode']; 
	$sqlShow			= "SELECT 
							doc_ms_doc_id,
							doc_ms_doc_type,
							doc_ms_doc_nm,
							doc_ms_doc_kd,
							doc_ms_kat_doc_id,
							sys_bagian_id,
							doc_ms_doc_rev,
							doc_ms_doc_ket,
							doc_ms_doc_tgl as doc_ms_doc_tgl,
							doc_ms_doc_pdf,
							doc_ms_doc_word,
							doc_ms_doc_link
							FROM doc_ms_doc WHERE doc_ms_doc_id='$KodeEdit'";
	$qryShow 			= mysqli_query($koneksidb, $sqlShow)  or die ("Query ambil data department salah : ".mysqli_errors());
	$dataShow			= mysqli_fetch_array($qryShow);
	
	$dataKode			= $dataShow['doc_ms_doc_id'];
	$dataJenis			= isset($_POST['cmbJenis']) ? $_POST['cmbJenis'] : $dataShow['doc_ms_doc_type'];
	$dataNama			= isset($_POST['txtNama']) ? $_POST['txtNama'] : $dataShow['doc_ms_doc_nm'];
	$dataNomor			= isset($_POST['txtNomor']) ? $_POST['txtNomor'] : $dataShow['doc_ms_doc_kd']; 
	$dataKategori		= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $dataShow['doc_ms_kat_doc_id']; 
	$dataBagian			= isset($_POST['cmbBagian']) ? $_POST['cmbBagian'] : $dataShow['sys_bagian_id']; 
	$dataRevisi			= isset($_POST['txtRevisi']) ? $_POST['txtRevisi'] : $dataShow['doc_ms_doc_rev']; 
	$dataKeterangan		= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : $dataShow['doc_ms_doc_ket']; 
	$dataTanggal		= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : IndonesiaTgl($dataShow['doc_ms_doc_tgl']); 
	$dataLink			= isset($_POST['txtLink']) ? $_POST['txtLink'] : $dataShow['doc_ms_doc_link']; 
?>
<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
        <div class="caption">
            <span class="caption-subject uppercase bold">Form Data Master Document</span>
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
						<input type="hidden" name="txtKode" value="<?php echo $dataKode; ?>"/>
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
					<div class="col-lg-9">
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
								<input type="file" name="txtPDF">
								<input name="txtPDFLama" type="hidden" value="<?php echo $dataShow['doc_ms_doc_pdf']; ?>" />
							</span>
							<span class="fileinput-filename"></span>&nbsp;
							<a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"></a>
						</div>
						<?php echo $dataShow['doc_ms_doc_pdf']; ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">Upload MS Word :</label>
					<div class="col-md-9">
						<div class="fileinput fileinput-new" data-provides="fileinput">
							<span class="btn default btn-file">
								<span class="fileinput-new">Select file</span>
								<span class="fileinput-exists">Change</span>
								<input type="file" name="txtWord">
								<input name="txtWordLama" type="hidden" value="<?php echo $dataShow['doc_ms_doc_word']; ?>" />
							</span>
							<span class="fileinput-filename"></span>&nbsp;
							<a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"></a>
						</div>
						<?php echo $dataShow['doc_ms_doc_word']; ?>
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
		