<?php
	
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtKode'])=="") {
			$message[] = "<b>Notulen</b> tidak boleh kosong, silahkan isi terlebih dahulu !";		
		}

		$txtKode		= $_POST['txtKode'];
		$txtNotulen		= $_POST['txtNotulen'];
		$txtAction		= $_POST['txtAction'];
		$txtUser		= $_POST['txtUser'];
		$txtFinished	= $_POST['txtFinished'];
		$txtID			= $_POST['txtID'];

		if(count($message)==0){
			$sqlSave="UPDATE as_trx_notulen SET as_trx_notulen_point= '$txtNotulen',
												as_trx_notulen_action='$txtAction',
												as_trx_notulen_user='$txtUser',
												as_trx_notulen_finished='$txtFinished',
												as_trx_notulen_updated='".date('Y-m-d H:i:s')."',
												as_trx_notulen_updatedby='".$_SESSION['sys_role_id']."'
											WHERE as_trx_notulen_id='$txtKode'";
			$qrySave	= mysqli_query($koneksidb, $sqlSave) or die ("gagal update Notulen Meeting ". mysqli_errors());
			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data Notulen Meeting berhasil diperbaharui';
				echo '<script>window.location="?page='.base64_encode(notulentrxmeetsch).'&id='.base64_encode($txtID).'"</script>';
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

	$KodeEdit		= isset($_GET['id']) ?  base64_decode($_GET['id']) : $_POST['txtKode']; 
	$sqlShow		= "SELECT * FROM as_trx_notulen WHERE as_trx_notulen_id='$KodeEdit'";
	$qryShow 		= mysqli_query($koneksidb, $sqlShow) or die ("Query ambil data department salah : ".mysqli_errors());
	$dataShow		= mysqli_fetch_array($qryShow);

	$dataID 		= $dataShow['as_trx_meet_sch_id'];
	$dataKode 		= $dataShow['as_trx_notulen_id'];
	$dataNotulen	= isset($_POST['txtNotulen']) ? $_POST['txtNotulen'] : $dataShow['as_trx_notulen_point'];
	$dataAction		= isset($_POST['txtAction']) ? $_POST['txtAction'] : $dataShow['as_trx_notulen_action'];
	$dataUser		= isset($_POST['txtUser']) ? $_POST['txtUser'] : $dataShow['as_trx_notulen_user'];
	$dataFinished	= isset($_POST['txtFinished']) ? $_POST['txtFinished'] : $dataShow['as_trx_notulen_finished'];

?>
<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
        <div class="caption">
            <span class="caption-subject uppercase">Form Notulen</span>
        </div>
        <div class="tools">
            <a href="" class="collapse"> </a>
            <a href="" class="reload"> </a>
            <a href="" class="remove"> </a>
        </div>
    </div>
	<div class="portlet-body form">
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal form-bordered" autocomplete="off" name="form1">
        	<div class="form-body">
		        <div class="form-group">
					<label class="col-lg-2 control-label">Uraian Pembahasan & Point Meeting :</label>
					<div class="col-lg-10">
						<textarea name="txtNotulen" rows="4" class="form-control" placeholder="Input Uraian Pembahasan" onkeyup="javascript:this.value=this.value.toUpperCase();"><?php echo $dataNotulen; ?></textarea>
						<input type="hidden" name="txtKode" value="<?php echo $dataKode ?>">
						<input type="hidden" name="txtID" value="<?php echo $dataID ?>">
		             </div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Action Plan :</label>
					<div class="col-lg-10">
						<textarea name="txtAction" rows="4" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();" placeholder="Input Action Plan"><?php echo $dataAction; ?></textarea>
		             </div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Penanggung Jawab :</label>
					<div class="col-lg-6">
						<input type="text" name="txtUser" value="<?php echo $dataUser; ?>" class="form-control" placeholder="Input Penanggung Jawab" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
		             </div>
				</div>
				<div class="form-group last">
					<label class="col-lg-2 control-label">Penyelesaian :</label>
					<div class="col-lg-3">
						<input type="text" name="txtFinished" value="<?php echo $dataFinished; ?>" class="form-control" placeholder="Input Penyelesaian" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
		             </div>
				</div>		
			</div>
	    	<div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-2 col-md-10">
		                <button type="submit" name="btnSave" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-save"></i> Simpan Data</button>
		                <a href="?page=<?php echo base64_encode(notulentrxmeetsch) ?>&id=<?php echo base64_encode($dataID) ?>" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-undo"></i> Batalkan</a>
			        </div>
			    </div>
			</div>
		</form>
	</div>
</div>	