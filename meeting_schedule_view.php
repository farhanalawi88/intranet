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
	$sqlShow 		= "SELECT * FROM as_trx_meet_sch a
						INNER JOIN as_ms_room b ON a.as_ms_room_id=b.as_ms_room_id
						WHERE a.as_trx_meet_sch_id='".base64_decode($KodeEdit)."'";
	$qryShow 		= mysqli_query($koneksidb, $sqlShow)  or die ("Query ambil data libur salah : ".mysqli_errors());
	$dataShow 		= mysqli_fetch_array($qryShow);		
	
	
?>
<div class="portlet box blue-chambray">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase">Agenda : <?php echo $dataShow['as_trx_meet_sch_agenda'] ?></span></div>
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
						<label class="control-label">Tgl. Mulai :</label>
		                <input class="form-control" type="text" value="<?php echo date('d F Y H:i', strtotime($dataShow['as_trx_meet_sch_start'])) ?>" disabled/>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label class="control-label">Tgl. Selesai :</label>
		                <input class="form-control" type="text" value="<?php echo date('d F Y H:i', strtotime($dataShow['as_trx_meet_sch_end'])) ?>" disabled/>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label class="control-label">Nama Ruangan :</label>
		                <input class="form-control" type="text" value="<?php echo $dataShow['as_ms_room_nama'] ?>" disabled/>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label class="control-label">Informasi Peserta :</label>
		                <input class="form-control" type="text" value="<?php echo $dataShow['as_trx_meet_sch_peserta'] ?>" disabled/>
					</div>
				</div>
			</div>
			<hr>
			<div class="row">
		     	<div class="col-lg-12">    	
		            <table class="table table-striped table-condensed table-hover" id="sample_1">
						<thead>
		                    <tr class="active">
		       	  	  	  	  	<th class="table-checkbox">
		                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
		                                <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />
		                                <span></span>
		                            </label>
		                        </th>
							  	<th width="5%"><div align="center">NO</div></th>
								<th width="90%">NOTULEN & POINT MEETING</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$dataSql = "SELECT * FROM as_trx_notulen
											WHERE as_trx_meet_sch_id='".$dataShow['as_trx_meet_sch_id']."'
											ORDER BY as_trx_notulen_id DESC";
								$dataQry = mysqli_query($koneksidb, $dataSql)  or die ("Query salah : ".mysqli_errors());
								$nomor  = 0; 
								while ($data = mysqli_fetch_array($dataQry)) {
								$nomor++;
								$Kode = $data['as_trx_notulen_id'];
							?>
							<tr class="odd gradeX">
		                        <td>
		                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
		                                <input type="checkbox" class="checkboxes" value="<?php echo $Kode; ?>" name="txtID[<?php echo $Kode; ?>]" />
		                                <span></span>
		                            </label>
		                        </td>
								<td><div align="center"><?php echo $nomor; ?></div></td>
								<td><?php echo $data ['as_trx_notulen_point']; ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
