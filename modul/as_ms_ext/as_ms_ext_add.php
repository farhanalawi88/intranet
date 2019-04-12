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

		if(count($message)==0){

			// INSERT DATA EXTENTION TELEPON
			$sqlSave="INSERT INTO as_ms_ext (as_ms_ext_nama,
												as_ms_ext_ket,
												as_ms_ext_line,
												as_ms_ext_created,
												as_ms_ext_createdby)
										VALUES ('$txtNama',
												'$txtKeterangan',
												'$txtLineTelepon',											
												'".date('Y-m-d H:i:s')."',
												'".$_SESSION['sys_role_id']."')";
			$qrySave	= mysqli_query($koneksidb, $sqlSave) or die ("Gagal Insert Ext Telepon ". mysqli_errors());
			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data Pembuatan user extention Berhasil Ditambahkan';
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
	
	$dataNama				= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
	$dataKeterangan			= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
	$dataLineTelepon		= isset($_POST['txtLineTelepon']) ? $_POST['txtLineTelepon'] : ''; 
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