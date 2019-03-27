<?php
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtNopol'])=="") {
			$message[] = "No. Kendaraan tidak boleh kosong!";		
		}
				
		$txtNopol		= $_POST['txtNopol'];
		$txtKode		= $_POST['txtKode'];

		$sqlCek			= "SELECT 
							COUNT(*) as total
							FROM load_tr_inout WHERE load_tr_inout_card='$txtNopol' AND load_tr_inout_sts='N'";
		$qryCek			= mysqli_query($koneksidb, $sqlCek) or die ("Gagal cek value".mysqli_errors()); 
		$qryRow			= mysqli_fetch_array($qryCek);
		if($qryRow['total']==0){
			$message[] = 'No. Kartu 	 '.$txtNopol.' tidak ditemukan';
		}
				
		
		if(count($message)==0){	
			$sqlCek			= "SELECT 
								COUNT(*) as total, 
								load_tr_inout_id 
								FROM load_tr_inout WHERE load_tr_inout_card='$txtNopol' AND load_tr_inout_sts='N'
								GROUP BY load_tr_inout_id";
			$qryCek			= mysqli_query($koneksidb, $sqlCek) or die ("Gagal cek value".mysqli_errors()); 
			$qryRow			= mysqli_fetch_array($qryCek);
			if($qryRow['total']>=1){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data masuk kendaraan berhasil ditemukan dengan No. Kartu '.$txtNopol.'';
				echo '<script>window.location="?page='.base64_encode(loadedttrkeluar).'&id='.$qryRow['load_tr_inout_id'].'"</script>';
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
		<div class="caption"><span class="caption-subject uppercase bold">Form Keluar Kendaraan</span></div>
		<div class="tools">
			<a href="javascript:;" class="collapse"></a>
			<a href="javascript:;" class="reload"></a>
			<a href="javascript:;" class="remove"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmadd" class="form-horizontal form-bordered" autocomplete="off">
			<div class="form-body">
				<div class="form-group last">
					<label class="col-md-2 control-label">No. Kartu :</label>
					<div class="col-md-3">
						<div class="input-group">
							<input class="form-control" type="text" name="txtNopol"  value="<?php echo $dataNopol; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();" autofocus/>
							<input type="hidden" name="txtKode" class="form-control" value="<?php echo $dataKode ?>">
                            <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                        </div>
					</div>
				</div>
			</div>
			<div class="form-actions">
			    <div class="row">
		            <div class="col-lg-offset-2 col-lg-10">
		                <button type="submit" name="btnSave" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-search"></i> Cari Data</button>
		            </div>
			    </div>
			</div>
		</form>
	</div>
</div>