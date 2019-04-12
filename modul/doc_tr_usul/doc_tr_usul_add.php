<?php
	
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtIsi'])=="") {
			$message[] = "<b>Isi</b> tidak boleh kosong !";		
		}
		if (trim($_POST['cmbKategori'])=="") {
			$message[] = "<b>Kategori</b> tidak boleh kosong !";		
		}
		if (trim($_POST['cmbSubject'])=="") {
			$message[] = "<b>Jenis</b> tidak boleh kosong !";		
		}
		if (trim($_POST['cmbJenis'])=="") {
			$message[] = "<b>Jenis</b> tidak boleh kosong !";		
		}
		if (empty($userRow['sys_bagian_id'])) {
			$message[] = "<b>Nama Bagian</b> tidak terdeteksi, silahkan hubungi IT support !";		
		}
		if (trim($_POST['txtDokumen'])=="" AND trim($_POST['cmbJenis'])==2) {
			$message[] = "<b>Nomor dokumen</b> tidak boleh kosong !";		
		}
		
		$txtAlasan		= $_POST['txtAlasan'];
		$txtIsi			= $_POST['txtIsi'];
		$cmbSubject		= $_POST['cmbSubject'];
		$cmbJenis		= $_POST['cmbJenis'];
		$cmbKategori	= $_POST['cmbKategori'];
		$txtUsulan		= $_POST['txtUsulan'];
		$txtDokumen		= $_POST['txtDokumen'];
		$txtTanggal		= InggrisTgl($_POST['txtTanggal']);


		if(count($message)==0){
			// GET KODE JENIS
			$initSql			= "SELECT sys_bagian_ket FROM sys_bagian WHERE sys_bagian_id='".$userRow['sys_bagian_id']."'";
			$initQry			= mysqli_query($koneksidb, $initSql) or die ("Gagal cek value".mysqli_errors()); 
			$initRow			= mysqli_fetch_array($initQry);
			$dataInit 			= $initRow['sys_bagian_ket'];
			//
			$bulan			= substr($txtTanggal,5,2);
			$romawi 		= getRomawi($bulan);
			$tahun			= substr($txtTanggal,0,4);
			$nomorTrans		= "/".$dataInit."/".$romawi."/".$tahun;
			$queryTrans		= "SELECT max(doc_tr_usul_no) as maxKode FROM doc_tr_usul WHERE CONVERT(CHAR(4),doc_tr_usul_tgl,112)='$tahun' AND sys_bagian_id='".$userRow['sys_bagian_id']."'";
			$hasilTrans		= mysqli_query($koneksidb, $queryTrans);
			$dataTrans		= mysqli_fetch_array($hasilTrans);
			$noTrans		= $dataTrans['maxKode'];
			$noUrutTrans	= $noTrans + 1;
			$IDTrans		=  sprintf("%02s", $noUrutTrans);
			$kodeTrans		= $IDTrans.$nomorTrans;
			$sqlSave="INSERT INTO doc_tr_usul (doc_tr_usul_no,
												doc_tr_usul_tgl,
												doc_tr_usul_subject,
												doc_ms_kat_doc_id,
												doc_ms_doc_id,
												sys_org_id,
												sys_bagian_id,
												doc_tr_usul_jns,
												doc_tr_usul_isi,
												doc_tr_usul_usulan,
												doc_tr_usul_alasan,
												doc_tr_usul_sts,
												doc_tr_usul_created,
												doc_tr_usul_createdby)
										VALUES('$kodeTrans',
												'$txtTanggal',
												'$cmbSubject',
												'$cmbKategori',
												'$txtDokumen',
												'".$userRow['sys_org_id']."',
												'".$userRow['sys_bagian_id']."',
												'$cmbJenis',
												'$txtIsi',
												'$txtUsulan',
												'$txtAlasan',
												'N',
												'".date('Y-m-d H:i:s')."',
												'".$_SESSION['sys_role_id']."')";
			$qrySave	= mysqli_query($koneksidb, $sqlSave) or die ("gagal insert". mysqli_errors());
			if($qrySave){
				$sqlCek			= "SELECT MAX(doc_tr_usul_id) as id_doc FROM doc_tr_usul WHERE doc_tr_usul_createdby='".$_SESSION['sys_role_id']."'";
				$qryCek			= mysqli_query($koneksidb, $sqlCek) or die ("Gagal cek value".mysqli_errors()); 
				$qryRow			= mysqli_fetch_array($qryCek);
				$dataID 		= $qryRow['id_doc'];
				
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data usulan perubahan dokumen dengan No. '.$kodeTrans.' berhasil ditambahkan';
				echo '<script>window.location="?page='.base64_encode(docupdtrusul).'&id='.base64_encode($dataID).'"</script>';
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
	
	$dataTanggal	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
	$dataJenis		= isset($_POST['cmbJenis']) ? $_POST['cmbJenis'] : '';
	$dataNama		= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
	$dataNomor		= isset($_POST['txtNomor']) ? $_POST['txtNomor'] : ''; 
	$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : ''; 
	$dataSubject	= isset($_POST['cmbSubject']) ? $_POST['cmbSubject'] : ''; 
	$dataAlasan		= isset($_POST['txtAlasan']) ? $_POST['txtAlasan'] : ''; 
	$dataDokumen	= isset($_POST['txtDokumen']) ? $_POST['txtDokumen'] : ''; 
	$dataUsulan		= isset($_POST['txtUsulan']) ? $_POST['txtUsulan'] : ''; 
	$dataIsi		= isset($_POST['txtIsi']) ? $_POST['txtIsi'] : ''; 
?>

<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT>
<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
        <div class="caption">
            <span class="caption-subject uppercase">Form Data Usulan Perubahan</span>
        </div>
        <div class="tools">
            <a href="" class="collapse"> </a>
            <a href="" class="reload"> </a>
            <a href="" class="remove"> </a>
        </div>
    </div>
	<div class="portlet-body form">
        <form action="<?php $_SERVER['PHP_SELF']; ?>" name="form1" method="post" class="form-horizontal form-bordered" autocomplete="off">
        	<div class="form-body">
        		<div class="form-group">
					<label class="col-md-2 control-label">Tgl. Pengajuan :</label>
					<div class="col-md-3">
						<div class="input-group">
                            <input type="text" name="txtTanggal" class="form-control date-picker" data-date-format="dd-mm-yyyy" value="<?php echo $dataTanggal ?>" readonly>
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
					</div>
				</div>
		        <div class="form-group">
					<label class="col-md-2 control-label">Kategori :</label>
					<div class="col-md-3">
						<select name="cmbKategori" data-placeholder="Select Category" class="select2 form-control">
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM doc_ms_kat_doc WHERE doc_ms_kat_doc_sts='Y' ORDER BY doc_ms_kat_doc_id DESC";
								  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
								  while ($dataRow = mysqli_fetch_array($dataQry)) {
									if ($dataKategori == $dataRow['doc_ms_kat_doc_id']) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$dataRow[doc_ms_kat_doc_id]' $cek>$dataRow[doc_ms_kat_doc_nm]</option>";
								  }
								  $sqlData ="";
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Subjek Dokumen :</label>
					<div class="col-md-4">
						<select class="form-control select2" data-placeholder="Select Subject" name="cmbSubject">
		                	<option value=""></option>
		               		<?php
							  $pilihan	= array("PEDOMAN MUTU", "PROSEDUR","INSTRUKSI KERJA","RENCANA MUTU","STANDAR MUTU","FORMAT STANDAR");
							  foreach ($pilihan as $nilai) {
								if ($dataSubject==$nilai) {
									$cek=" selected";
								} else { $cek = ""; }
								echo "<option value='$nilai' $cek>$nilai</option>";
							  }
							?>
		              	</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Jenis Usulan :</label>
					<div class="col-lg-3">
						<select name="cmbJenis" class="form-control select2" data-placeholder="Select Type" onChange="javascript:submitform();">
							<option value=""></option> 
							<?php
								$namaBulan = array("1" => "BARU", "2" => "PERUBAHAN");
								foreach($namaBulan as $bulanKe => $bulanNM) {
									if ($bulanKe == $dataJenis) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$bulanKe' $cek>$bulanNM</option>";
							  	}
							?>
						</select>
					</div>
				</div>
				<?php 
					if($dataJenis==2){
				?>
		        <div class="form-group">
					<label class="col-md-2 control-label">No. Dokumen :</label>
					<div class="col-md-3">
						<div class="input-group last">
                            <input type="text" name="txtNomor" value="<?php echo $dataNomor ?>" id="doc_ms_doc_kd" class="form-control" readonly>
                            <input type="hidden" name="txtDokumen" id="doc_ms_doc_id" class="form-control" value="<?php echo $dataDokumen ?>">
                            <span class="input-group-btn">
                                <button data-toggle="modal" data-target="#barang" class="btn <?php echo $dataPanel; ?>" type="button"><i class="fa fa-search" /></i></button>
                            </span>
                        </div>
					</div>
				</div>
				<?php } ?>
				<div class="form-group">
					<label class="col-lg-2 control-label">Isi Dokumen :</label>
					<div class="col-lg-8">
						<input type="text" name="txtIsi" placeholder="Enter Document Name" class="form-control" id="doc_ms_doc_nm" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $dataIsi; ?>">
		             </div>
				</div>
		        <div class="form-group">
					<label class="col-lg-2 control-label">Usulan :</label>
					<div class="col-lg-10">
						<textarea type="text" name="txtUsulan" placeholder="Enter Request" class="form-control"  onkeyup="javascript:this.value=this.value.toUpperCase();"><?php echo $dataUsulan; ?></textarea>
		             </div>
				</div>
				<div class="form-group last">
					<label class="col-lg-2 control-label">Alasan :</label>
					<div class="col-lg-10">
						<textarea type="text" name="txtAlasan" placeholder="Enter Description" class="form-control"  onkeyup="javascript:this.value=this.value.toUpperCase();"><?php echo $dataAlasan; ?></textarea>
		             </div>
				</div>
			</div>
			<div class="modal fade bs-modal-lg" id="barang" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title"><b>Daftar Distribusi Dokumen</b></h4>
                        </div>
                        <div class="modal-body"> 
                            <table class="table table-striped table-condensed table-hover" id="sample_2">
								<thead>
				                    <tr class="active">
										<th width="100"><div align="center">NO. DOCUMENT</div></th>
				                        <th width="200">BAGIAN</th>
				                        <th width="600">JUDUL DOCUMENT</th>
				                    </tr>
								</thead>
								<tbody>
				               <?php
										$dataSql = "SELECT 
														a.doc_ms_doc_kd,
														a.doc_ms_doc_id,
														a.doc_ms_doc_nm,
														a.doc_ms_doc_sts,
														b.doc_ms_kat_doc_nm,
														a.doc_ms_doc_type,
														d.sys_bagian_nm
													FROM doc_ms_doc a
													INNER JOIN doc_ms_kat_doc b ON a.doc_ms_kat_doc_id=b.doc_ms_kat_doc_id
													INNER JOIN sys_bagian d ON a.sys_bagian_id=d.sys_bagian_id
													WHERE NOT a.doc_ms_doc_sts='D'
													AND a.doc_ms_doc_type='$dataSubject'
													AND a.doc_ms_kat_doc_id='$dataKategori'
													AND a.sys_bagian_id='".$userRow['sys_bagian_id']."'
													ORDER BY a.doc_ms_doc_id DESC";
										$dataQry = mysqli_query($koneksidb, $dataSql);
										$nomor  = 0; 
										while ($data = mysqli_fetch_array($dataQry)) {
										$nomor++;
										$ID = $data['doc_ms_doc_id'];
										if($data ['doc_ms_doc_sts']=='Y'){
											$dataStatus= "<span class='badge badge-success badge-roundless'>APPROVED</span>";
										}else{
											$dataStatus= "<span class='badge badge-warning badge-roundless'>DRAFT</span>";
										}
								?>
				                    <tr class="pilihDokumen" data-dismiss="modal" aria-hidden="true" 
                                        data-dokumen="<?php echo $data['doc_ms_doc_id']; ?>"
                                        data-isi="<?php echo $data['doc_ms_doc_nm']; ?>"
                                        data-nomor="<?php echo $data['doc_ms_doc_kd']; ?>">
										<td><div align="center"><?php echo $data ['doc_ms_doc_kd']; ?></div></td>
										<td><?php echo $data['sys_bagian_nm']; ?></td>
										<td><?php echo $data['doc_ms_doc_nm']; ?></td>
				                    </tr>
				                    <?php } ?>
								</tbody>
				            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn <?php echo $dataPanel; ?>" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
	    	<div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-2 col-md-10">
		                <button type="submit" name="btnSave" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-save"></i> Simpan Data</button>
		                <a href="?page=<?php echo base64_encode(docdttrusul) ?>" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-undo"></i> Batalkan</a>
			        </div>
			    </div>
			</div>
		</form>
	</div>
</div>
<script src="./assets/scripts/jquery-1.11.2.min.js"></script>
<script type="text/javascript">
    $(document).on('click', '.pilihDokumen', function (e) {
        document.getElementById("doc_ms_doc_kd").value = $(this).attr('data-nomor');
        document.getElementById("doc_ms_doc_id").value = $(this).attr('data-dokumen');
        document.getElementById("doc_ms_doc_nm").value = $(this).attr('data-isi');
    });
</script>   
		