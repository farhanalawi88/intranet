<?php
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtSolve'])=="") {
			$message[] = "Deskripsi penyelesaian tidak boleh kosong!";		
		}
				
		$txtKode		= $_POST['txtKode'];
		$txtSolve		= $_POST['txtSolve'];
		
		if(count($message)==0){		

			$sqlSave	= "UPDATE tic_tr_ticket SET tic_tr_ticket_sts='Y',
													tic_tr_ticket_tgl_finish='".date('Y-m-d H:i:s')."',
													tic_tr_ticket_solvedby='".$_SESSION['sys_role_id']."',
													tic_tr_ticket_solved='$txtSolve'
												WHERE tic_tr_ticket_id='$txtKode'";
			$qrySave	= mysqli_query($koneksidb, $sqlSave) or die ("gagal edit". mysqli_errors());

			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data ticket berhasil diperbaharui dengan No. '.$_POST['txtNomor'].'';
				echo '<script>window.location="?page='.base64_encode(ticmanagtic).'"</script>';
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
	$KodeEdit		= isset($_GET['id']) ?  $_GET['id'] : $_POST['txtTglLibur']; 
	$sqlShow 		= "SELECT * FROM tic_tr_ticket WHERE tic_tr_ticket_id='$KodeEdit'";
	$qryShow 		= mysqli_query($koneksidb, $sqlShow)  or die ("Query ambil data libur salah : ".mysqli_errors());
	$dataShow 		= mysqli_fetch_array($qryShow);		
	
	$dataKode		= $dataShow['tic_tr_ticket_id'];
	$dataNomor		= $dataShow['tic_tr_ticket_no'];
	$dataModul		= isset($_POST['cmbModul']) ? $_POST['cmbModul'] : $dataShow['tic_ms_modul_id'];		
	$dataDiminta	= isset($_POST['txtDiminta']) ? $_POST['txtDiminta'] : $dataShow['tic_tr_ticket_diminta'];
	$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $dataShow['tic_ms_kat_id'];
	$dataProblem	= isset($_POST['txtProblem']) ? $_POST['txtProblem'] : $dataShow['tic_tr_ticket_problem'];
	$dataDeskripsi	= isset($_POST['txtDeskripsi']) ? $_POST['txtDeskripsi'] : $dataShow['tic_tr_ticket_description'];
	$dataSolve		= isset($_POST['txtSolve']) ? $_POST['txtSolve'] : $dataShow['tic_tr_ticket_solved'];
?>
<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase">Form Proses Ticket</span></div>
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
					<label class="col-md-2 control-label">No. Ticket :</label>
					<div class="col-md-2">
	                    <input class="form-control" type="text" value="<?php echo $dataNomor ?>" name="txtNomor" readonly/>
	                    <input class="form-control" type="hidden" value="<?php echo $dataKode ?>" name="txtKode"/>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-2 control-label">Subject :</label>
					<div class="col-md-10">
						<input type="text" class="form-control" disabled value="<?php echo $dataProblem ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Subject Detail :</label>
					<div class="col-md-10">
						<textarea class="form-control ckeditor" name="txtDeskripsi"  onkeyup="javascript:this.value=this.value.toUpperCase();"><?php echo $dataDeskripsi ?></textarea>
					</div>
				</div>
				<div class="form-group last">
					<label class="col-md-2 control-label">Penyelesaian :</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="txtSolve" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $dataSolve ?>">
					</div>
				</div>
			</div>
			<div class="form-actions">
			    <div class="row">
		            <div class="col-lg-offset-2 col-lg-10">
		                <button type="submit" name="btnSave" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-save"></i> Simpan Data</button>
		                <a href="?page=<?php echo base64_encode(ticmanagtic) ?>" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-undo"></i> Batalkan</a>
		            </div>
			    </div>
			</div>
		</form>
	</div>
</div>
