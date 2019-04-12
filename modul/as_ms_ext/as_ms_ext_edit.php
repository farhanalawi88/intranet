<?php
	
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtNama'])=="") {
			$message[] = "<b>Nama</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtKeterangan'])=="") {
			$message[] = "<b>Departemen</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtLineTelepon'])=="") {
			$message[] = "<b>Line Telepon</b> tidak boleh kosong !";		
		}

		$txtNama			= $_POST['txtNama'];
		$txtKeterangan		= $_POST['txtKeterangan'];
		$txtLineTelepon		= $_POST['txtLineTelepon'];
		$txtKode			= $_POST['txtKode'];

		if(count($message)==0){
			$sqlSave="UPDATE as_ms_ext SET as_ms_ext_nama='$txtNama',
											as_ms_ext_ket='$txtKeterangan',
											as_ms_ext_line='$txtLineTelepon',
											as_ms_ext_updated='".date('Y-m-d H:i:s')."',
											as_ms_ext_updatedby='".$_SESSION['sys_role_id']."'
									WHERE as_ms_ext_id='$txtKode'";
			$qrySave	= mysqli_query($koneksidb, $sqlSave) or die ("Gagal Update Ext Telepon ". mysqli_errors());
			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data Pembuatan user extention Berhasil Diperbaharui';
				echo '<script>window.location="?page='.base64_encode(extentionnumberdata).'"</script>';
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
	$sqlShow			= "SELECT * FROM as_ms_ext a
							WHERE a.as_ms_ext_id='$KodeEdit'";
							
	$qryShow 			= mysqli_query($koneksidb, $sqlShow)  or die ("Query ambil data department salah : ".mysqli_errors());
	$dataShow			= mysqli_fetch_array($qryShow);

	$dataKode 			= $dataShow['as_ms_ext_id'];
	$dataNama			= isset($_POST['txtNama']) ? $_POST['txtNama'] : $dataShow['as_ms_ext_nama'];
	$dataDepartemen		= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : $dataShow['as_ms_ext_ket'];
	$dataLineTelepon	= isset($_POST['txtLineTelepon']) ? $_POST['txtLineTelepon'] : $dataShow['as_ms_ext_line'];

?>
<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
        <div class="caption">
            <span class="caption-subject uppercase">Form User Extention</span>
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
        	<input type="hidden" name="txtKode" value="<?php echo $dataKode ?>">
        	<div class="form-body">
        		<div class="form-group">
					<label class="col-lg-2 control-label">Nama :</label>
					<div class="col-lg-6">
						<input type="text" name="txtNama" value="<?php echo $dataNama; ?>" class="form-control" placeholder="Input Nama"/>
		             </div>
				</div>	
				<div class="form-group">
					<label class="col-lg-2 control-label">Keterangan :</label>
					<div class="col-lg-10">
						<input type="text" name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" class="form-control" placeholder="Input Keterangan"/>
		             </div>
				</div>	
		        <div class="form-group last">
					<label class="col-lg-2 control-label">Line Telepon :</label>
					<div class="col-lg-3">
						<input type="text" name="txtLineTelepon" value="<?php echo $dataLineTelepon; ?>" class="form-control" placeholder="Input Line Telepon"/>
		             </div>
				</div>			
			</div>
	    	<div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-2 col-md-10">
		                <button type="submit" name="btnSave" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-save"></i> Simpan Data</button>
		                <a href="?page=<?php echo base64_encode(extentionnumberdata) ?>" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-undo"></i> Batalkan</a>
			        </div>
			    </div>
			</div>
		</form>
	</div>
</div>	