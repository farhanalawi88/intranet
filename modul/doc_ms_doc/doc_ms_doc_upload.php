<?php
	if(isset($_POST['btnHapus'])){
		$sqlShow			= "SELECT * FROM doc_ms_file WHERE doc_ms_file_id='".$_POST['btnHapus']."'";
		$qryShow 			= mysqli_query($koneksidb, $sqlShow)  or die ("Query ambil data department salah : ".mysqli_errors());
		$dataShow			= mysqli_fetch_array($qryShow);

		$hapus 	= mysqli_query($koneksidb,"DELETE FROM doc_ms_file WHERE doc_ms_file_id='".$_POST['btnHapus']."'") 
					or die ("Gagal kosongkan tmp".mysqli_errors());
		$file 	= $dataShow['doc_ms_file_upload'];

		$target = "file/".$file."";

		if(file_exists($target)){
			unlink($target);
		}
	}
	if(isset($_POST['btnUpload'])){
		$message = array();
		if (empty($_FILES['txtFile']['tmp_name'])) {
			$message[] = "<b>File</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtKode'])=="") {
			$message[] = "<b>ID</b> tidak terdeteksi !";		
		}
		if (trim($_POST['txtIsi'])=="") {
			$message[] = "<b>Isi dokumen</b> tidak terdeteksi !";		
		}
		if (trim($_POST['txtNomor'])=="") {
			$message[] = "<b>No. dokumen</b> tidak terdeteksi !";		
		}


		if(count($message)==0){
			if (! empty($_FILES['txtFile']['tmp_name'])) {
				$tgl 		 = date('ymdhis');
				$file_upload = $_FILES['txtFile']['name'];
				$file_upload = stripslashes($file_upload);
				$file_upload = str_replace("'","",$file_upload);
				$txtExt		 = pathinfo($file_upload, PATHINFO_EXTENSION);
				$file_upload = $tgl."_".$_POST['txtNomor']."_".$_POST['txtIsi']."_"."".$_POST['txtRevisi'].".".$txtExt;
				copy($_FILES['txtFile']['tmp_name'],"file/".$file_upload);
			}
			else {
				$file_upload = "";
			}	
			$sqlSave="INSERT INTO doc_ms_file (doc_ms_file_upload,
												doc_ms_file_type,
												doc_ms_doc_id,
												doc_ms_file_created,
												doc_ms_file_createdby,
												doc_ms_file_sts,
												doc_ms_file_masa)
										VALUES('$file_upload',
												'$txtExt',
												'".$_POST['txtKode']."',
												'".date('Y-m-d H:i:s')."',
												'".$_SESSION['sys_role_id']."',
												'Y',
												'B')";
			$qrySave	= mysqli_query($koneksidb, $sqlSave) or die ("gagal insert". mysqli_errors());
			
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
	
	
	
	$KodeEdit		= isset($_GET['id']) ?  base64_decode($_GET['id']) : $_POST['txtKode']; 
	$sqlShow 		= "SELECT 
						doc_ms_doc_id,
						doc_ms_doc_kd,
						doc_ms_doc_nm,
						doc_ms_doc_rev
						FROM doc_ms_doc WHERE doc_ms_doc_id='$KodeEdit'";
	$qryShow 		= mysqli_query($koneksidb, $sqlShow)  or die ("Query ambil data libur salah : ".mysqli_errors());
	$dataShow 		= mysqli_fetch_array($qryShow);		

	$dataKode 		= $dataShow['doc_ms_doc_id'];
	$dataNomor 		= $dataShow['doc_ms_doc_kd'];
	$dataIsi 		= $dataShow['doc_ms_doc_nm'];
	$dataRevisi		= $dataShow['doc_ms_doc_rev'];
	$dataRevisi		= $dataShow['doc_ms_doc_rev'];
?>

<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
        <div class="caption">
            <span class="caption-subject uppercase bold">Form Upload Master Dokumen</span>
        </div>
        <div class="tools">
            <a href="" class="collapse"> </a>
            <a href="#portlet-config" data-toggle="modal" class="config"> </a>
            <a href="" class="reload"> </a>
            <a href="" class="remove"> </a>
        </div>
    </div>
	<div class="portlet-body form">
        <form action="<?php $_SERVER['PHP_SELF']; ?>" name="form1" method="post" class="form-horizontal form-bordered" autocomplete="off" enctype="multipart/form-data">
        	<div class="form-body">
        		<div class="form-group">
					<label class="col-md-2 control-label">No. Dokumen :</label>
					<div class="col-md-3">
                        <input type="text" class="form-control" name="txtNomor" value="<?php echo $dataNomor ?>" readonly>
                        <input type="hidden" class="form-control" value="<?php echo $dataKode ?>" name="txtKode">
                        <input type="hidden" class="form-control" value="<?php echo $dataIsi ?>" name="txtIsi">
                        <input type="hidden" class="form-control" value="<?php echo $dataRevisi ?>" name="txtRevisi">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">Dokumen Upload :</label>
					<div class="col-md-9">
						<div class="fileinput fileinput-new" data-provides="fileinput">
							<span class="btn default btn-file">
								<span class="fileinput-new">
									 Select file
								</span>
								<span class="fileinput-exists">
									 Change
								</span>
								<input type="file" name="txtFile">
							</span>
							<span class="fileinput-filename">
							</span>
							 &nbsp;
							<a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"></a>

							<?php 
								$dataSql = "SELECT * FROM doc_ms_file 
											WHERE doc_ms_doc_id='".$dataKode."'
											AND doc_ms_file_masa='B'
											ORDER BY doc_ms_file_id DESC";
								$dataQry = mysqli_query($koneksidb, $dataSql);
								$nomor  = 0; 
								while ($data = mysqli_fetch_array($dataQry)) {
								$nomor++;
								$ID = $data['doc_ms_file_id'];
								if($data ['doc_ms_file_type']=='pdf'){
									$dataFile= '<i class="fa fa-file-pdf-o"></i>';
									$dataWarna = 'red';
								}elseif($data ['doc_ms_file_type']=='docx'){
									$dataFile= '<i class="fa fa-file-word-o"></i>';
									$dataWarna = 'blue';
								}elseif($data ['doc_ms_file_type']=='doc'){
									$dataFile= '<i class="fa fa-file-word-o"></i>';
									$dataWarna = 'blue';
								}elseif($data ['doc_ms_file_type']=='xlsx'){
									$dataFile= '<i class="fa fa-file-excel-o"></i>';
									$dataWarna = 'green-jungle';
								}elseif($data ['doc_ms_file_type']=='xls'){
									$dataFile= '<i class="fa fa-file-excel-o"></i>';
									$dataWarna = 'green-jungle';
								}
							?>
							<button type="submit" name="btnHapus" class="btn <?php echo $dataWarna; ?>" value="<?php echo $ID ?>"><?php echo $dataFile ?> </button>
							<?php } ?>
						</div>
						
					</div>
				</div>
				<div class="form-group last">
                    <label class="col-md-2 control-label">Catatan :</label>
                    <div class="col-md-10">
                    	<div class="note note-warning">
	                        <span class="help-block">1. Lampirkan 2 file dokumen : file PDF & file MS Word/Excel</span>
	                        <span class="help-block">2. Apabila ingin menghapus data upload klik pada icon dokumen</span>
	                    </div>
                    </div>
                </div>
			</div>
	    	<div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-2 col-md-10">
		               	<button type="submit" name="btnUpload" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-upload"></i> Proses Upload</button>
		               	<a href="?page=<?php echo base64_encode(docdtmsdoc) ?>" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-folder-o"></i> Data Dokumen</a>
			        </div>
			    </div>
			</div>
		</form>
	</div>
</div>  
		