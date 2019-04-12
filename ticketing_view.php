<?php
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['cmbModul'])=="") {
			$message[] = "Nama type tidak boleh kosong!";		
		}
		if (trim($_POST['cmbKategori'])=="") {
			$message[] = "Kategori tidak boleh kosong!";		
		}
		if (trim($_POST['txtProblem'])=="") {
			$message[] = "Data perubahan tidak boleh kosong!";		
		}
		if (trim($_POST['txtDeskripsi'])=="") {
			$message[] = "Data alasan perubahan tidak boleh kosong!";		
		}
		if (trim($_POST['cmbUntuk'])=="") {
			$message[] = "Tunjuan ticket tidak boleh kosong!";		
		}
				
		$cmbModul		= $_POST['cmbModul'];
		$txtProblem		= $_POST['txtProblem'];
		$cmbKategori	= $_POST['cmbKategori'];
		$txtNoref		= $_POST['txtNoref'];
		$txtKode		= $_POST['txtKode'];
		$txtDeskripsi	= $_POST['txtDeskripsi'];
		$cmbUntuk		= $_POST['cmbUntuk'];
				
		
		if(count($message)==0){		
			$tgl 		 = date('ymdhis');
			// UPLOAD FILE PDF
			if (empty($_FILES['txtPDF']['tmp_name'])) {
				$file_pdf = $_POST['txtPDFLama'];
			}
			else  {
				if(! $_POST['txtPDFLama']=="") {
					if(file_exists("file/".$_POST['txtPDFLama'])) {
						unlink("file/".$_POST['txtPDFLama']);	
					}
				}

				$file_pdf = $_FILES['txtPDF']['name'];
				$file_pdf = stripslashes($file_pdf);
				$file_pdf = str_replace("'","",$file_pdf);
				
				$file_pdf = $tgl.".".$file_pdf;
				copy($_FILES['txtPDF']['tmp_name'],"file/".$file_pdf);					
			}
			$sqlSave	= "UPDATE tic_tr_ticket SET tic_tr_ticket_problem='$txtProblem',
													tic_ms_kat_id='$cmbKategori',
													tic_tr_ticket_ref='$txtNoref',
													tic_ms_modul_id='$cmbModul',
													tic_tr_ticket_description='$txtDeskripsi',
													tic_tr_ticket_to='$cmbUntuk',
													tic_file_ticket='$file_pdf'
												WHERE tic_tr_ticket_id='$txtKode'";
			$qrySave	= mysqli_query($koneksidb, $sqlSave) or die ("gagal edit". mysqli_errors());

			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data ticket berhasil diperbaharui dengan No. '.$_POST['txtNomor'].'';
				echo '<script>window.location="?page='.base64_encode(ticdttic).'"</script>';
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
	$sqlShow 		= "SELECT * FROM tic_tr_ticket a
						LEFT JOIN sys_role b ON a.tic_tr_ticket_solvedby=b.sys_role_id
						WHERE a.tic_tr_ticket_id='".base64_decode($KodeEdit)."'";
	$qryShow 		= mysqli_query($koneksidb, $sqlShow)  or die ("Query ambil data libur salah : ".mysqli_errors());
	$dataShow 		= mysqli_fetch_array($qryShow);		
	
	$dataKode		= $dataShow['tic_tr_ticket_id'];
	$dataTgl		= $dataShow['tic_tr_ticket_tgl_start'];
	$dataNomor		= $dataShow['tic_tr_ticket_no'];
	$dataDiminta	= $dataShow['tic_tr_ticket_diminta'];
	$dataModul		= $dataShow['tic_ms_modul_id'];		
	$dataKategori	= $dataShow['tic_ms_kat_id'];
	$dataProblem	= $dataShow['tic_tr_ticket_problem'];
	$dataUntuk		= $dataShow['tic_tr_ticket_to'];
	$dataNoref		= $dataShow['tic_tr_ticket_ref'];
	$dataDeskripsi	= $dataShow['tic_tr_ticket_description'];
?>
<div class="portlet box blue-chambray">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase">Ticket Detail No. <?php echo $dataNomor ?></span></div>
		<div class="tools">
			<a href="javascript:;" class="collapse"></a>
			<a href="javascript:;" class="reload"></a>
			<a href="javascript:;" class="remove"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<div class="form-body">
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label class="control-label">Tgl. Ticket :</label>
		                <input class="form-control" type="text" value="<?php echo date('d F Y H:i', strtotime($dataShow['tic_tr_ticket_tgl_start'])) ?>" disabled/>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label class="control-label">Ticket Untuk :</label>
						<select name="cmbUntuk" data-placeholder="- Pilih Bagian -" class="form-control" disabled>
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM sys_bagian WHERE NOT sys_bagian_id='".$userRow['sys_bagian_id']."' 
								  				ORDER BY sys_bagian_id DESC";
								  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
								  while ($dataRow = mysqli_fetch_array($dataQry)) {
									if ($dataUntuk == $dataRow['sys_bagian_id']) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$dataRow[sys_bagian_id]' $cek>$dataRow[sys_bagian_nm]</option>";
								  }
								  $sqlData ="";
							?>
						</select>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label class="control-label">Kategori :</label>
						<select name="cmbKategori" data-placeholder="- Pilih Kategori -" class="form-control" disabled>
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM tic_ms_kat ORDER BY tic_ms_kat_id DESC";
								  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
								  while ($dataRow = mysqli_fetch_array($dataQry)) {
									if ($dataKategori == $dataRow['tic_ms_kat_id']) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$dataRow[tic_ms_kat_id]' $cek>$dataRow[tic_ms_kat_nm]</option>";
								  }
								  $sqlData ="";
							?>
						</select>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label class="control-label">Type :</label>
						<select name="cmbModul" data-placeholder="- Pilih Modul -" class="form-control" disabled>
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM tic_ms_modul ORDER BY tic_ms_modul_id DESC";
								  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
								  while ($dataRow = mysqli_fetch_array($dataQry)) {
									if ($dataModul == $dataRow['tic_ms_modul_id']) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$dataRow[tic_ms_modul_id]' $cek>$dataRow[tic_ms_modul_nm]</option>";
								  }
								  $sqlData ="";
							?>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label class="control-label">Data Referensi :</label>
		                <input class="form-control" type="text" value="<?php echo $dataNoref ?>" disabled/>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label class="control-label">Diminta Oleh :</label>
		                <input class="form-control" type="text" value="<?php echo $dataDiminta ?>" disabled/>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label">Subject :</label>
						<input type="text" class="form-control" name="txtProblem" value="<?php echo $dataProblem ?>" disabled>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label">Deskripsi :</label>
						<textarea class="form-control ckeditor" name="txtDeskripsi" disabled><?php echo $dataDeskripsi ?></textarea>
					</div>
				</div>	
			</div>
			
		</div>
	</div>
</div>
<?php if($dataShow['tic_tr_ticket_sts']=='Y'){ ?>
<div class="portlet box blue-chambray">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase">Diselesaikan Pada <?php echo date('d F Y H:i', strtotime($dataShow['tic_tr_ticket_tgl_finished'])) ?> Oleh : <?php echo $dataShow['sys_role_nama'] ?></span></div>
		<div class="tools">
			<a href="javascript:;" class="collapse"></a>
			<a href="javascript:;" class="reload"></a>
			<a href="javascript:;" class="remove"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<div class="form-body">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label">Informasi Penyelesaian :</label>
						<textarea class="form-control ckeditor" name="txtDeskripsi" disabled><?php echo $dataShow['tic_tr_ticket_solved'] ?></textarea>
					</div>
				</div>	
			</div>
			
		</div>
	</div>
</div>
<?php } ?>