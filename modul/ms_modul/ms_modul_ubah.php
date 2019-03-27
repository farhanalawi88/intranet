<?php
	
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtModul'])=="") {
			$message[] = "<b>Nama Modul</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtLink'])=="") {
			$message[] = "<b>Link modul</b> tidak boleh kosong !";		
		}
		if (trim($_POST['cmbMenu'])=="") {
			$message[] = "<b>Menu utama</b> tidak boleh kosong !";		
		}
		
		$txtKode		= $_POST['txtKode'];
		$txtModul		= $_POST['txtModul'];
		$txtLink		= $_POST['txtLink'];
		$cmbMenu		= $_POST['cmbMenu'];
		$txtUrutan		= $_POST['txtUrutan'];
		
		if(count($message)==0){
			$sqlSave	= "UPDATE sys_submenu SET sys_submenu_nama='$txtModul', 
					 							sys_submenu_link='$txtLink', 
												sys_menu_id='$cmbMenu', 
												sys_submenu_urutan='$txtUrutan',
												sys_submenu_updated='".date('Y-m-d')."'
									WHERE sys_submenu_id='$txtKode'";
			$qrySave	= mysqli_query($koneksidb, $sqlSave) or die ("gagal insert". mysqli_errors());
			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data modul berhasil diperbaharui';
				echo '<script>window.location="?page='.base64_encode(dtmdl).'"</script>';
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
	$sqlShow			= "SELECT * FROM sys_submenu WHERE sys_submenu_id='$KodeEdit'";
	$qryShow 			= mysqli_query($koneksidb, $sqlShow)  or die ("Query ambil data department salah : ".mysqli_errors());
	$dataShow			= mysqli_fetch_array($qryShow);
	
	$dataKode			= $dataShow['sys_submenu_id'];
	$dataModul			= isset($_POST['txtModul']) ? $_POST['txtModul'] : $dataShow['sys_submenu_nama'];
	$dataLink			= isset($_POST['txtLink']) ? $_POST['txtLink'] : $dataShow['sys_submenu_link'];
	$dataMenu			= isset($_POST['cmbMenu']) ? $_POST['cmbMenu'] : $dataShow['sys_menu_id'];
	$dataUrutan			= isset($_POST['txtUrutan']) ? $_POST['txtUrutan'] : $dataShow['sys_submenu_urutan'];
?>
<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
        <div class="caption">
            <span class="caption-subject uppercase bold">Form Data Menu & Modul</span>
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
					<label class="col-lg-2 control-label">Nama Modul :</label>
					<div class="col-lg-3">
						<input type="text" name="txtModul" value="<?php echo $dataModul; ?>" class="form-control"/>
						<input type="hidden" name="txtKode" value="<?php echo $dataKode; ?>" class="form-control"/>
		             </div>
				</div>
		        <div class="form-group">
					<label class="col-lg-2 control-label">Link Modul :</label>
					<div class="col-lg-3">
						<input type="text" name="txtLink" value="<?php echo $dataLink; ?>" class="form-control"/>
		             </div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Menu Utama :</label>
					<div class="col-lg-2">
						<select name="cmbMenu" data-placeholder="- Pilih Menu -" class="select2 form-control">
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM sys_menu ORDER BY sys_menu_id DESC";
								  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
								  while ($dataRow = mysqli_fetch_array($dataQry)) {
									if ($dataMenu == $dataRow['sys_menu_id']) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$dataRow[sys_menu_id]' $cek>$dataRow[sys_menu_nama]</option>";
								  }
								  $sqlData ="";
							?>
						</select>
					</div>
				</div>
				<div class="form-group last">
					<label class="col-lg-2 control-label">Urutan Modul :</label>
					<div class="col-lg-2">
						<input type="number" name="txtUrutan" value="<?php echo $dataUrutan; ?>" class="form-control"/>
		             </div>
				</div>
    		</div>
	    	<div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-2 col-md-10">
		                <button type="submit" name="btnSave" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-save"></i> Simpan Data</button>
		                <a href="?page=<?php echo base64_encode(dtmdl) ?>" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-undo"></i> Batalkan</a>
			        </div>
			    </div>
			</div>
		</form>
	</div>
</div>
		