<?php
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtCard'])=="") {
			$message[] = "No. Kartu tidak boleh kosong!";		
		}
				
		$txtCard		= $_POST['txtCard'];
		$txtKode		= $_POST['txtKode'];

		$sqlCek			= "SELECT COUNT(*) as total FROM load_tr_inout WHERE load_tr_inout_card='$txtCard' AND load_tr_inout_sts='N'";
		$qryCek			= mysqli_query($koneksidb, $sqlCek) or die ("Gagal cek value".mysqli_errors()); 
		$qryRow			= mysqli_fetch_array($qryCek);
		if($qryRow['total']>=1){
			$message[] = "Maaf, No. Kartu <b> $txtCard </b> sudah digunakan, ganti dengan No. lain";
		}
				
		
		if(count($message)==0){	
			$sqlSave	= "UPDATE load_tr_inout SET load_tr_inout_card='$txtCard'
												WHERE load_tr_inout_id='$txtKode'";
			$qrySave	= mysqli_query($koneksidb, $sqlSave) or die ("gagal insert". mysqli_errors());

			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data masuk kendaraan berhasil ditambahkan dengan No. kartu '.$txtCard.'';
				echo '<script>window.location="?page='.base64_encode(loaddttrmasuk).'"</script>';
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
	
	$KodeEdit			= isset($_GET['id']) ?  $_GET['id'] : $_POST['txtKode']; 
	$sqlShow 			= "SELECT 
							load_tr_inout_id
							FROM load_tr_inout WHERE load_tr_inout_reg='$KodeEdit'";
	$qryShow 			= mysqli_query($koneksidb, $sqlShow)  or die ("Query ambil data libur salah : ".mysqli_errors());
	$dataShow 			= mysqli_fetch_array($qryShow);		

	$dataKode 			= $dataShow['load_tr_inout_id'];
?>
<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase bold">Form Masuk Kendaraan</span></div>
		<div class="tools">
			<a href="javascript:;" class="collapse"></a>
			<a href="javascript:;" class="reload"></a>
			<a href="javascript:;" class="remove"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmadd" class="form-horizontal form-bordered" autocomplete="off">
			<div class="form-body">
				<div class="form-group">
					<label class="col-md-2 control-label">No. Kartu :</label>
					<div class="col-md-3">
						<div class="input-group last">
                            <input type="text" name="txtCard" class="form-control" autofocus>
                            <input type="hidden" name="txtKode" class="form-control" value="<?php echo $dataKode ?>">
                            <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                        </div>
					</div>
				</div>
			</div>
			<div class="form-actions">
			    <div class="row">
		            <div class="col-lg-offset-2 col-lg-10">
		                <button type="submit" name="btnSave" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-save"></i> Simpan Data</button>
		            </div>
			    </div>
			</div>
		</form>
	</div>
</div>