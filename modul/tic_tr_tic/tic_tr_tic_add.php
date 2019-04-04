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
			$message[] = "Tunjuab ticket tidak boleh kosong!";		
		}
				
		$cmbModul		= $_POST['cmbModul'];
		$txtProblem		= $_POST['txtProblem'];
		$txtDeskripsi	= $_POST['txtDeskripsi'];
		$txtDiminta		= $_POST['txtDiminta'];
		$cmbKategori	= $_POST['cmbKategori'];
		$txtNoref		= $_POST['txtNoref'];
		$txtTanggal		= date('Y-m-d H:i:s');
		$cmbUntuk		= $_POST['cmbUntuk'];
				
		
		if(count($message)==0){		
			// INISIAL KODE ORG
			$orgSql 		= "SELECT sys_org_kd FROM sys_org WHERE sys_org_id='".$userRow['sys_org_id']."'";
			$orgQry			= mysqli_query($koneksidb, $orgSql) or die ("gagal select org".mysqli_errors());
			$orgRow 		= mysqli_fetch_array($orgQry);	
			// INISIAL KODE BAGIAN
			$depSql 		= "SELECT sys_bagian_kd FROM sys_bagian WHERE sys_bagian_id='".$userRow['sys_bagian_id']."'";
			$depQry			= mysqli_query($koneksidb, $depSql) or die ("gagal select bagian".mysqli_errors());
			$depRow 		= mysqli_fetch_array($depQry);	

			$bulan			= substr($txtTanggal,5,2);
			$romawi 		= getRomawi($bulan);
			$tahun			= substr($txtTanggal,2,2);
			$tahun2			= substr($txtTanggal,0,4);
			$nomorTrans		= "/".$orgRow['sys_org_kd']."/".$depRow['sys_bagian_kd']."/".$romawi."/".$tahun;
			$queryTrans		= "SELECT 
									max(tic_tr_ticket_no) as maxKode 
								FROM tic_tr_ticket 
								WHERE YEAR(tic_tr_ticket_tgl_start)='$tahun2' 
								AND sys_bagian_id='".$userRow['sys_bagian_id']."' 
								AND sys_org_id='".$userRow['sys_org_id']."'";
			$hasilTrans		= mysqli_query($koneksidb, $queryTrans);
			$dataTrans		= mysqli_fetch_array($hasilTrans);
			$noTrans		= $dataTrans['maxKode'];
			$noUrutTrans	= $noTrans + 1;
			$IDTrans		=  sprintf("%03s", $noUrutTrans);
			$kodeTrans		= $IDTrans.$nomorTrans;
			$tgl 		 = date('ymdhis');
			if (! empty($_FILES['txtFilePDF']['tmp_name'])) {
				$file_upload_pdf 	= $_FILES['txtFilePDF']['name'];
				$file_upload_pdf 	= stripslashes($file_upload_pdf);
				$file_upload_pdf 	= str_replace("'","",$file_upload_pdf);
				$txtExtPDF			= pathinfo($file_upload_pdf, PATHINFO_EXTENSION);
				$file_upload_pdf	= $tgl."_".$_POST['txtProblem'].".".$txtExtPDF;
				copy($_FILES['txtFilePDF']['tmp_name'],"file/".$file_upload_pdf);
			}
			else {
				$file_upload_pdf 	= "";
			}	

			$sqlSave	= "INSERT INTO tic_tr_ticket (tic_tr_ticket_no,
													tic_tr_ticket_tgl_start,
													tic_tr_ticket_createdby,
													tic_tr_ticket_problem,
													tic_ms_kat_id,
													sys_bagian_id,
													tic_tr_ticket_sts,
													tic_tr_ticket_ref,
													tic_ms_modul_id,
													tic_tr_ticket_app,
													tic_tr_ticket_description,
													sys_org_id,
													tic_tr_ticket_diminta,
													tic_file_ticket,
													tic_tr_ticket_to) 
											VALUES ('$kodeTrans',
													'$txtTanggal',
													'".$userRow['sys_role_id']."',
													'$txtProblem',
													'$cmbKategori',
													'".$userRow['sys_bagian_id']."',
													'N',
													'$txtNoref',
													'$cmbModul',
													'N',
													'$txtDeskripsi',
													'".$userRow['sys_org_id']."',
													'$txtDiminta',
													'$file_upload_pdf',
													'$cmbUntuk')";
			$qrySave	= mysqli_query($koneksidb, $sqlSave) or die ("gagal insert". mysqli_errors());

			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data ticket berhasil ditambahkan dengan No. '.$kodeTrans.'';
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
	
	$dataModul		= isset($_POST['cmbModul']) ? $_POST['cmbModul'] : '';		
	$dataDiminta	= isset($_POST['txtDiminta']) ? $_POST['txtDiminta'] : strtoupper($userRow['sys_role_nama']);
	$dataProblem	= isset($_POST['txtProblem']) ? $_POST['txtProblem'] : '';
	$dataUntuk		= isset($_POST['cmbUntuk']) ? $_POST['cmbUntuk'] : '';
	$dataNoref		= isset($_POST['txtNoref']) ? $_POST['txtNoref'] : '';
	$dataDeskripsi	= isset($_POST['txtDeskripsi']) ? $_POST['txtDeskripsi'] : '';
?>
<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase">Form Add Ticket</span></div>
		<div class="tools">
			<a href="javascript:;" class="collapse"></a>
			<a href="javascript:;" class="reload"></a>
			<a href="javascript:;" class="remove"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmadd" class="form-horizontal form-bordered" autocomplete="off" enctype="multipart/form-data">
			<div class="form-body">
				<div class="form-group">
					<label class="col-md-2 control-label">Ticket Untuk :</label>
					<div class="col-md-4">
						<select name="cmbUntuk" data-placeholder="- Pilih Bagian -" class="select2 form-control">
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
				<div class="form-group">
					<label class="col-md-2 control-label">Kategori :</label>
					<div class="col-md-3">
						<select name="cmbKategori" data-placeholder="- Pilih Kategori -" class="select2 form-control">
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
	            <input class="form-control" type="hidden" value="<?php echo $dataDiminta ?>" name="txtDiminta" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
				<div class="form-group">
					<label class="col-md-2 control-label">Type :</label>
					<div class="col-md-4">
						<select name="cmbModul" data-placeholder="- Pilih Modul -" class="select2 form-control">
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
				<div class="form-group">
					<label class="col-md-2 control-label">Data Referensi :</label>
					<div class="col-md-3">
	                    <input class="form-control" type="text" value="<?php echo $dataNoref ?>" name="txtNoref" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Subject :</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="txtProblem" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $dataProblem ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Deskripsi :</label>
					<div class="col-md-10">
						<textarea class="form-control ckeditor" name="txtDeskripsi"><?php echo $dataDeskripsi ?></textarea>
					</div>
				</div>
				<div class="form-group last">
					<label class="control-label col-md-2">Upload File :</label>
					<div class="col-md-9">
						<div class="fileinput fileinput-new" data-provides="fileinput">
							<span class="btn default btn-file">
								<span class="fileinput-new">Select file</span>
								<span class="fileinput-exists">Change</span>
								<input type="file" name="txtFilePDF">
							</span>
							<span class="fileinput-filename"></span>&nbsp;
							<a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"></a>
						</div>
					</div>
				</div>
			</div>
			<div class="form-actions">
			    <div class="row">
		            <div class="col-lg-offset-2 col-lg-10">
		                <button type="submit" name="btnSave" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-save"></i> Simpan Data</button>
		                <a href="?page=<?php echo base64_encode(ticdttic) ?>" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-undo"></i> Batalkan</a>
		            </div>
			    </div>
			</div>
		</form>
	</div>
</div>
