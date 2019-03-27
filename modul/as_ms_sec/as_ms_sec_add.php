<?php
	
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtNama'])=="") {
			$message[] = "<b>Judul</b> tidak boleh kosong !";		
		}
		if (trim($_POST['cmbStatus'])=="") {
			$message[] = "<b>Status</b> tidak boleh kosong !";		
		}
		if (trim($_POST['cmbBagian'])=="") {
			$message[] = "<b>Nama Bagian</b> tidak boleh kosong !";		
		}
		
		$txtNama		= $_POST['txtNama'];
		$cmbStatus		= $_POST['cmbStatus'];
		$cmbBagian		= $_POST['cmbBagian'];

		if(count($message)==0){
			// UPLOAD FILE
			$tgl 		 = date('ymdhis');
			if (! empty($_FILES['txtFilePDF']['tmp_name'])) {
				$file_upload_pdf 	= $_FILES['txtFilePDF']['name'];
				$file_upload_pdf 	= stripslashes($file_upload_pdf);
				$file_upload_pdf 	= str_replace("'","",$file_upload_pdf);
				$txtExtPDF			= pathinfo($file_upload_pdf, PATHINFO_EXTENSION);
				$file_upload_pdf	= $tgl."_".$_POST['txtNama'].".".$txtExtPDF;
				copy($_FILES['txtFilePDF']['tmp_name'],"file/".$file_upload_pdf);
			}
			else {
				$file_upload_pdf 	= "";
			}	
			if (! empty($_FILES['txtVideo']['tmp_name'])) {
				$file_upload_word 	= $_FILES['txtVideo']['name'];
				$file_upload_word 	= stripslashes($file_upload_word);
				$file_upload_word 	= str_replace("'","",$file_upload_word);
				$txtExtWord			= pathinfo($file_upload_word, PATHINFO_EXTENSION);
				$file_upload_word	= $tgl."_".$_POST['txtNama'].".".$txtExtWord;
				copy($_FILES['txtVideo']['tmp_name'],"file/".$file_upload_word);
			}
			else {
				$file_upload_word	= "";
			}	
			$sqlSave="INSERT INTO as_sec (as_sec_name,
										as_sec_tgl,
										as_sec_sts,
										as_sec_created,
										as_sec_createdby,
										sys_bagian_id,
										as_sec_video,
										as_sec_pdf)
								VALUES('$txtNama',
										'".date('Y-m-d H:i:s')."',
										'$cmbStatus',
										'".date('Y-m-d H:i:s')."',
										'".$_SESSION['sys_role_id']."',
										'$cmbBagian',
										'$file_upload_word',
										'$file_upload_pdf')";
			$qrySave	= mysqli_query($koneksidb, $sqlSave) or die ("gagal insert". mysqli_errors());
			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data materi / education center berhasil ditambahkan';
				echo '<script>window.location="?page='.base64_encode(dtsec).'"</script>';
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
	
	$dataBagian		= isset($_POST['cmbBagian']) ? $_POST['cmbBagian'] : '';
	$dataNama		= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
	$dataStatus		= isset($_POST['cmbStatus']) ? $_POST['cmbStatus'] : ''; 
?>
<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
        <div class="caption">
            <span class="caption-subject uppercase">Form Data Education Center</span>
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
					<label class="col-lg-2 control-label">Nama Bagian :</label>
					<div class="col-lg-4">
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
					<label class="col-lg-2 control-label">Judul Materi :</label>
					<div class="col-lg-10">
						<input type="text" name="txtNama" value="<?php echo $dataNama; ?>" class="form-control" placeholder="Enter Name" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
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
					<label class="control-label col-md-2">Upload Video :</label>
					<div class="col-md-9">
						<div class="fileinput fileinput-new" data-provides="fileinput">
							<span class="btn default btn-file">
								<span class="fileinput-new">Select file</span>
								<span class="fileinput-exists">Change</span>
								<input type="file" name="txtVideo">
							</span>
							<span class="fileinput-filename"></span>&nbsp;
							<a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"></a>
						</div>
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
		                <a href="?page=<?php echo base64_encode(dtsec) ?>" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-undo"></i> Batalkan</a>
			        </div>
			    </div>
			</div>
		</form>
	</div>
</div>
		