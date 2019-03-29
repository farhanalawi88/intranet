<?php
	
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtNama'])=="") {
			$message[] = "<b>Nama menu</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtIcon'])=="") {
			$message[] = "<b>Icon menu</b> tidak boleh kosong !";		
		}
		
		$txtKode		= $_POST['txtKode'];
		$txtNama		= $_POST['txtNama'];
		$txtIcon		= $_POST['txtIcon'];
		$txtUrutan		= $_POST['txtUrutan'];
		
		if(count($message)==0){
			$sqlSave	= "UPDATE sys_menu SET sys_menu_nama='$txtNama', 
					 							sys_menu_icon='$txtIcon', 
												sys_menu_urutan='$txtUrutan',
												sys_menu_updated='".date('Y-m-d')."'
									WHERE sys_menu_id='$txtKode'";
			$qrySave	= mysqli_query($koneksidb, $sqlSave) or die ("gagal insert". mysqli_errors());
			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data menu berhasil diperbaharui';
				echo '<script>window.location="?page='.base64_encode(dtmenu).'"</script>';
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
	$sqlShow			= "SELECT * FROM sys_menu WHERE sys_menu_id='$KodeEdit'";
	$qryShow 			= mysqli_query($koneksidb, $sqlShow)  or die ("Query ambil data department salah : ".mysqli_errors());
	$dataShow			= mysqli_fetch_array($qryShow);
	
	$dataKode			= $dataShow['sys_menu_id'];
	$dataNama			= isset($_POST['txtNama']) ? $_POST['txtNama'] : $dataShow['sys_menu_nama'];
	$dataIcon			= isset($_POST['txtIcon']) ? $_POST['txtIcon'] : $dataShow['sys_menu_icon'];
	$dataUrutan			= isset($_POST['txtUrutan']) ? $_POST['txtUrutan'] : $dataShow['sys_menu_urutan'];
?>
<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
        <div class="caption">
            <span class="caption-subject uppercase">Form Data Main Menu</span>
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
					<label class="col-lg-2 control-label">Nama Menu :</label>
					<div class="col-lg-3">
						<input type="text" name="txtNama" value="<?php echo $dataNama; ?>" class="form-control"/>
						<input type="hidden" name="txtKode" value="<?php echo $dataKode; ?>" class="form-control"/>
		             </div>
				</div>
		        <div class="form-group">
					<label class="col-lg-2 control-label">Icon Menu :</label>
					<div class="col-lg-3">
						<input type="text" name="txtIcon" value="<?php echo $dataIcon; ?>" class="form-control"/>
		             </div>
				</div>
				<div class="form-group last">
					<label class="col-lg-2 control-label">Urutan Menu :</label>
					<div class="col-lg-2">
						<input type="number" name="txtUrutan" value="<?php echo $dataUrutan; ?>" class="form-control"/>
		             </div>
				</div>
    		</div>
	    	<div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-2 col-md-10">
		                <button type="submit" name="btnSave" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-save"></i> Simpan Data</button>
		                <a href="?page=<?php echo base64_encode(dtmenu) ?>" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-undo"></i> Batalkan</a>
			        </div>
			    </div>
			</div>
		</form>
	</div>
</div>
		