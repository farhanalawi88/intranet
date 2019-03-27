<?php
	
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtAgenda'])=="") {
			$message[] = "<b>Agenda</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtStartDate'])=="") {
			$message[] = "<b>Start Date</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtEndDate'])=="") {
			$message[] = "<b>End Date</b> tidak boleh kosong !";		
		}
		if (trim($_POST['cmbMeetingRoom'])=="") {
			$message[] = "<b>Meeting Room</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtPesertaMeeting'])=="") {
			$message[] = "<b>Peserta Meeting</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtNotulen'])=="") {
			$message[] = "<b>Notulen</b> tidak boleh kosong !";		
		}

		$txtAgenda			= $_POST['txtAgenda'];
		$txtStartDate		= $_POST['txtStartDate'];
		$txtEndDate			= $_POST['txtEndDate'];
		$cmbMeetingRoom		= $_POST['cmbMeetingRoom'];
		$txtPesertaMeeting	= $_POST['txtPesertaMeeting'];
		$txtNotulen			= $_POST['txtNotulen'];

		if(count($message)==0){
			$sqlSave="UPDATE book_meeting_room SET agenda='$txtAgenda',
												   start_date='$txtStartDate',
												   end_date='$txtEndDate',
												   id_room='$cmbMeetingRoom',
												   peserta_meeting='$txtPesertaMeeting',
												   notulen='$txtNotulen',
												   updated='".date('Y-m-d H:i:s')."'
												WHERE id_booking_meeting='$txtKode'";
			$qrySave	= mysqli_query($koneksidb, $sqlSave) or die ("gagal update ptkp ". mysqli_errors());
			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data pembuatan Booking Meeting Room berhasil diperbaharui';
				echo '<script>window.location="?page='.base64_encode(bookmeetingroomdata).'"</script>';
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
	$sqlShow			= "SELECT 
							a.id_booking_meeting,
							a.agenda,
							a.start_date,
							a.end_date,
							a.peserta_meeting,
							a.notulen,
							a.id_room,
							b.nama_ruang_meeting
							FROM book_meeting_room a
							LEFT JOIN book_master_room b ON a.id_room=b.id_room
							WHERE a.id_booking_meeting='$KodeEdit'";
							
	$qryShow 			= mysqli_query($koneksidb, $sqlShow)  or die ("Query ambil data department salah : ".mysqli_errors());
	$dataShow			= mysqli_fetch_array($qryShow);

	$dataKode 			= $dataShow['id_booking_meeting'];
	$dataAgenda			= isset($_POST['txtAgenda']) ? $_POST['txtAgenda'] : $dataShow['agenda'];
	$dataStartDate		= isset($_POST['txtStartDate']) ? $_POST['txtStartDate'] : $dataShow['start_date'];
	$dataEndDate		= isset($_POST['txtEndDate']) ? $_POST['txtEndDate'] : $dataShow['end_date'];
	$dataMeetingRoom	= isset($_POST['cmbMeetingRoom']) ? $_POST['cmbMeetingRoom'] : $dataShow['id_room'];
	$dataPesertaMeeting	= isset($_POST['txtPesertaMeeting']) ? $_POST['txtPesertaMeeting'] : $dataShow['peserta_meeting'];
	$dataNotulen		= isset($_POST['txtNotulen']) ? $_POST['txtNotulen'] : $dataShow['notulen'];

?>
<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
        <div class="caption">
            <span class="caption-subject uppercase bold">Form Booking Meeting Room</span>
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
					<label class="col-lg-2 control-label">Agenda :</label>
					<div class="col-lg-3">
						<input type="text" name="txtAgenda" value="<?php echo $dataAgenda; ?>" data-date-format="dd-mm-yyyy" class="form-control date-picker" placeholder="Input Agenda"/>
		             </div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Start Date :</label>
					<div class="col-lg-3">
						<input type="text" name="txtStartDate" value="<?php echo $dataStartDate; ?>" data-date-format="dd-mm-yyyy" class="form-control date-picker" placeholder="Pilih Tanggal"/>
		             </div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">End Date :</label>
					<div class="col-lg-3">
						<input type="text" name="txtEndDate" value="<?php echo $dataEndDate; ?>" data-date-format="dd-mm-yyyy" class="form-control date-picker" placeholder="Pilih Tanggal"/>
		             </div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Meeting Room :</label>
					<div class="col-md-4">
						<select name="cmbMeetingRoom" data-placeholder="Pilih Meeting Room" class="select2 form-control">
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM book_master_room WHERE status='Y' ORDER BY id_room ASC";
								  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
								  while ($dataRow = mysqli_fetch_array($dataQry)) {
									if ($dataMeetingRoom == $dataRow['id_room']) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$dataRow[id_room]' $cek>$dataRow[nama_ruang_meeting]</option>";
								  }
								  $sqlData ="";
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Peserta Meeting :</label>
					<div class="col-lg-3">
						<input type="text" name="txtPesertaMeeting" value="<?php echo $dataPesertaMeeting; ?>" data-date-format="dd-mm-yyyy" class="form-control date-picker" placeholder="Input Peserta Meeting"/>
		             </div>
				</div>			
		        <div class="form-group">
					<label class="col-lg-2 control-label">Notulen :</label>
					<div class="col-lg-10">
						<textarea type="text" name="txtNotulen" rows="4" onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control" placeholder="Input Notulen"><?php echo $dataNotulen; ?></textarea>
		             </div>
				</div>		
			</div>
	    	<div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-2 col-md-10">
		                <button type="submit" name="btnSave" class="btn blue"><i class="fa fa-save"></i> Simpan Data</button>
		                <a href="?page=<?php echo base64_encode(bookmeetingroomdata) ?>" class="btn blue"><i class="fa fa-undo"></i> Batalkan</a>
			        </div>
			    </div>
			</div>
		</form>
	</div>
</div>	