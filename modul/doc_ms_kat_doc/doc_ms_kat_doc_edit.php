<?php
	
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtKode'])=="") {
			$message[] = "<b>Kode</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtNama'])=="") {
			$message[] = "<b>Nama</b> tidak boleh kosong !";		
		}
		if (trim($_POST['cmbStatus'])=="") {
			$message[] = "<b>Status</b> tidak boleh kosong !";		
		}
		
		$txtKode		= $_POST['txtKode'];
		$txtID			= $_POST['txtID'];
		$txtNama		= $_POST['txtNama'];
		$txtKeterangan	= $_POST['txtKeterangan'];
		$cmbStatus		= $_POST['cmbStatus'];
		
		if(count($message)==0){
			$sqlSave	= "UPDATE doc_ms_kat_doc SET doc_ms_kat_doc_kd='$txtKode', 
					 							doc_ms_kat_doc_nm='$txtNama', 
												doc_ms_kat_doc_ket='$txtKeterangan', 
												doc_ms_kat_doc_sts='$cmbStatus',
												doc_ms_kat_doc_updated='".date('Y-m-d H:i:s')."',
												doc_ms_kat_doc_updatedby='".$_SESSION['sys_role_id']."'
										WHERE doc_ms_kat_doc_id='$txtID'";
			$qrySave	= mysqli_query($koneksidb, $sqlSave) or die ("gagal insert". mysqli_errors());
			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data kategori dokumen berhasil diperbaharui';
				echo '<script>window.location="?page='.base64_encode(docdtmskatdoc).'"</script>';
			}
			exit;
		}	
		
		if (! count($message)==0 ){
			echo "<div class='alert note note-warning'>
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
	$sqlShow			= "SELECT * FROM doc_ms_kat_doc WHERE doc_ms_kat_doc_id='$KodeEdit'";
	$qryShow 			= mysqli_query($koneksidb, $sqlShow)  or die ("Query ambil data department salah : ".mysqli_errors());
	$dataShow			= mysqli_fetch_array($qryShow);
	
	$dataID				= $dataShow['doc_ms_kat_doc_id'];
	$dataKode			= isset($_POST['txtKode']) ? $_POST['txtKode'] : $dataShow['doc_ms_kat_doc_kd'];
	$dataNama			= isset($_POST['txtNama']) ? $_POST['txtNama'] : $dataShow['doc_ms_kat_doc_nm'];
	$dataKeterangan		= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : $dataShow['doc_ms_kat_doc_ket'];
	$dataStatus			= isset($_POST['cmbStatus']) ? $_POST['cmbStatus'] : $dataShow['doc_ms_kat_doc_sts'];
?>
<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
        <div class="caption">
            <span class="caption-subject uppercase">Form Data Kategori Dokumen</span>
        </div>
        <div class="tools">
            <a href="" class="collapse"> </a>
            <a href="#portlet-config" data-toggle="modal" class="config"> </a>
            <a href="" class="reload"> </a>
            <a href="" class="remove"> </a>
        </div>
    </div>
	<div class="portlet-body form">
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal form-bordered" autocomplete="off">
        	<div class="form-body">
		        <div class="form-group">
					<label class="col-lg-2 control-label">Kode Urut :</label>
					<div class="col-lg-2">
						<input type="hidden" name="txtID" value="<?php echo $dataID ?>">
						<input type="text" name="txtKode" value="<?php echo $dataKode; ?>" class="form-control" placeholder="Enter Code" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
		             </div>
				</div>
		        <div class="form-group">
					<label class="col-lg-2 control-label">Nama Kategori :</label>
					<div class="col-lg-3">
						<input type="text" name="txtNama" value="<?php echo $dataNama; ?>" class="form-control" placeholder="Enter Name" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
		             </div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Keterangan :</label>
					<div class="col-lg-10">
						<input type="text" name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" class="form-control" placeholder="Enter Description" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
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
		                <a href="?page=<?php echo base64_encode(docdtmskatdoc) ?>" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-undo"></i> Batalkan</a>
			        </div>
			    </div>
			</div>
		</form>
	</div>
</div>
		