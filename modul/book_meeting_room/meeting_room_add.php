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
			$message[] = "<b>Deskripsi</b> tidak boleh kosong !";		
		}
		
		$txtAgenda			= $_POST['txtAgenda'];
		$txtStartDate		= $_POST['txtStartDate'];
		$txtEndDate			= $_POST['txtEndDate'];
		$cmbMeetingRoom		= $_POST['cmbMeetingRoom'];
		$txtPesertaMeeting	= $_POST['txtPesertaMeeting'];
		$txtNotulen			= $_POST['txtNotulen'];

		if(count($message)==0){

			// INSERT DATA BOOKING MEETING ROOM
			$sqlSave="INSERT INTO book_meeting_room (agenda,
												     start_date,
												     end_date,
												     id_room,
												     peserta_meeting,
												     notulen,
													 created)
										VALUES ('$txtAgenda',
												'$txtStartDate',
												'$txtEndDate', 
												'$cmbMeetingRoom',
												'$txtPesertaMeeting',
												'$txtNotulen',											
												'".date('Y-m-d H:i:s')."')";
			$qrySave	= mysqli_query($koneksidb, $sqlSave) or die ("Gagal Insert Meeting Room ". mysqli_errors());
			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data Pembuatan Meeting Room Berhasil Ditambahkan';
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
	
	$dataAgenda				= isset($_POST['txtAgenda']) ? $_POST['txtAgenda'] : '';
	$dataStartDate			= isset($_POST['txtStartDate']) ? $_POST['txtStartDate'] : '';
	$dataEndDate			= isset($_POST['txtEndDate']) ? $_POST['txtEndDate'] : '';
	$dataMeetingRoom		= isset($_POST['cmbMeetingRoom']) ? $_POST['cmbMeetingRoom'] : '';
	$dataPesertaMeeting		= isset($_POST['txtPesertaMeeting']) ? $_POST['txtPesertaMeeting'] : '';
	$dataNotulen			= isset($_POST['txtNotulen']) ? $_POST['txtNotulen'] : ''; 
?>
<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT>
<div class="portlet box blue">
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
						<input type="text" name="txtAgenda" value="<?php echo $dataAgenda; ?>" class="form-control" placeholder="Input Agenda"/>
		             </div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Start Date :</label>
					<div class="col-lg-3">
						<input type="text" name="txtStartDate" value="<?php echo $dataStartDate; ?>" data-date-format="dd-mm-yyyy" class="form-control form_datetime" placeholder="Pilih Tanggal"/>
		             </div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">End Date :</label>
					<div class="col-lg-3">
						<input type="text" name="txtEndDate" value="<?php echo $dataEndDate; ?>" data-date-format="dd-mm-yyyy" class="form-control form_datetime" placeholder="Pilih Tanggal"/>
		             </div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Meeting Room :</label>
					<div class="col-md-4">
						<select name="cmbMeetingRoom" data-placeholder="Pilih Meeting Room" class="select2 form-control">
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM book_master_room
								  			  WHERE status='Y'
								  			  ORDER BY id_room ASC";
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
						<input type="text" name="txtPesertaMeeting" value="<?php echo $dataPesertaMeeting; ?>" class="form-control" placeholder="Input Peserta Meeting"/>
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