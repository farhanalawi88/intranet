<?php
	
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtAgenda'])=="") {
			$message[] = "<b>Agenda</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtStart'])=="") {
			$message[] = "<b>Start Date</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtEnd'])=="") {
			$message[] = "<b>End Date</b> tidak boleh kosong !";		
		}
		if (trim($_POST['cmbRoom'])=="") {
			$message[] = "<b>Meeting Room</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtPeserta'])=="") {
			$message[] = "<b>Peserta Meeting</b> tidak boleh kosong !";		
		}

		$txtAgenda		= $_POST['txtAgenda'];
		$txtStart		= $_POST['txtStart'];
		$txtEnd			= $_POST['txtEnd'];
		$cmbRoom		= $_POST['cmbRoom'];
		$txtPeserta		= $_POST['txtPeserta'];
		$txtKode 		= $_POST['txtKode'];

		if(count($message)==0){
			$sqlSave="UPDATE as_trx_meet_sch SET as_trx_meet_sch_agenda='$txtAgenda',
												   as_trx_meet_sch_start='$txtStart',
												   as_trx_meet_sch_end='$txtEnd',
												   as_ms_room_id='$cmbRoom',
												   as_trx_meet_sch_peserta='$txtPeserta',
												   as_trx_meet_sch_updatedby='".$_SESSION['sys_role_id']."',
												   as_trx_meet_sch_updated='".date('Y-m-d H:i:s')."'
												WHERE as_trx_meet_sch_id='$txtKode'";
			$qrySave	= mysqli_query($koneksidb, $sqlSave) or die ("gagal update meeting schedule ". mysqli_errors());
			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data meeting schedule berhasil diperbaharui';
				echo '<script>window.location="?page='.base64_encode(dttrxmeetsch).'"</script>';
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
	$sqlShow		= "SELECT * FROM as_trx_meet_sch a
						INNER JOIN as_ms_room b ON a.as_ms_room_id=b.as_ms_room_id
						WHERE a.as_trx_meet_sch_id='$KodeEdit'";
	$qryShow 		= mysqli_query($koneksidb, $sqlShow)  
						or die ("Query ambil data department salah : ".mysqli_errors());
	$dataShow		= mysqli_fetch_array($qryShow);

	$dataKode 		= $dataShow['as_trx_meet_sch_id'];
	$dataAgenda		= isset($_POST['txtAgenda']) ? $_POST['txtAgenda'] : $dataShow['as_trx_meet_sch_agenda'];
	$dataStart		= isset($_POST['txtStart']) ? $_POST['txtStartDate'] : $dataShow['as_trx_meet_sch_start'];
	$dataEnd		= isset($_POST['txtEnd']) ? $_POST['txtEndDate'] : $dataShow['as_trx_meet_sch_end'];
	$dataRoom		= isset($_POST['cmbRoom']) ? $_POST['cmbRoom'] : $dataShow['as_ms_room_id'];
	$dataPeserta	= isset($_POST['txtPeserta']) ? $_POST['txtPeserta'] : $dataShow['as_trx_meet_sch_peserta'];

?>
<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
        <div class="caption">
            <span class="caption-subject uppercase">Form Meeting Schedule</span>
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
					<label class="col-lg-2 control-label">Nama Agenda :</label>
					<div class="col-lg-10">
						<input type="text" name="txtAgenda" value="<?php echo $dataAgenda; ?>" class="form-control" placeholder="Input Agenda" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
						<input type="hidden" name="txtKode" value="<?php echo $dataKode ?>">
		             </div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Start Date :</label>
					<div class="col-lg-3">
						<input type="text" name="txtStart" value="<?php echo $dataStart; ?>" data-date-format="dd-mm-yyyy" class="form-control form_datetime" placeholder="Pilih Tanggal"/>
		             </div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">End Date :</label>
					<div class="col-lg-3">
						<input type="text" name="txtEnd" value="<?php echo $dataEnd; ?>" data-date-format="dd-mm-yyyy" class="form-control form_datetime" placeholder="Pilih Tanggal"/>
		             </div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Meeting Room :</label>
					<div class="col-md-4">
						<select name="cmbRoom" data-placeholder="Pilih Meeting Room" class="select2 form-control">
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM as_ms_room
								  			  WHERE as_ms_room_status='Y'
								  			  ORDER BY as_ms_room_id ASC";
								  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
								  while ($dataRow = mysqli_fetch_array($dataQry)) {
									if ($dataRoom == $dataRow['as_ms_room_id']) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$dataRow[as_ms_room_id]' $cek>$dataRow[as_ms_room_nama]</option>";
								  }
								  $sqlData ="";
							?>
						</select>
					</div>
				</div>
				<div class="form-group last">
					<label class="col-lg-2 control-label">Peserta Meeting :</label>
					<div class="col-lg-10">
						<input type="text" name="txtPeserta" value="<?php echo $dataPeserta; ?>" class="form-control" placeholder="Input Peserta Meeting" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
		             </div>
				</div>		
			</div>
	    	<div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-2 col-md-10">
		                <button type="submit" name="btnSave" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-save"></i> Simpan Data</button>
		                <a href="?page=<?php echo base64_encode(dttrxmeetsch) ?>" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-undo"></i> Batalkan</a>
			        </div>
			    </div>
			</div>
		</form>
	</div>
</div>	