<?php
	
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['cmbSumber'])=="") {
			$message[] = "<b>Sumber</b> tidak boleh kosong !";		
		}
		if (trim($_POST['cmbKategori'])=="") {
			$message[] = "<b>Kategori</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtKegiatan'])=="") {
			$message[] = "<b>Kegiatan/proses</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtDeskripsi'])=="") {
			$message[] = "<b>Deskripsi</b> tidak boleh kosong !";		
		}
		if (trim($_POST['cmbDampak'])=="") {
			$message[] = "<b>Dampak</b> tidak boleh kosong !";		
		}
		if (trim($_POST['cmbTerkait'])=="") {
			$message[] = "<b>Keterkaitan Temuan</b> tidak boleh kosong !";		
		}
		
		$cmbSumber		= $_POST['cmbSumber'];
		$cmbKategori	= $_POST['cmbKategori'];
		$txtKegiatan	= $_POST['txtKegiatan'];
		$txtDeskripsi	= $_POST['txtDeskripsi'];
		$cmbDampak		= $_POST['cmbDampak'];
		$cmbTerkait		= $_POST['cmbTerkait'];
		$txtReferensi	= $_POST['txtReferensi'];
		$txtDokumen		= $_POST['txtDokumen'];
		$txtKode		= $_POST['txtKode'];
		$txtMasalah		= $_POST['txtMasalah'];

		if(count($message)==0){
			$sqlSave="UPDATE ptkp_tr_ptkp SET ptkp_ms_sumber_id='$cmbSumber', 
													ptkp_ms_dampak_id='$cmbDampak',
													ptkp_ms_kategori_id='$cmbKategori',
													ptkp_ms_terkait_id='$cmbTerkait',
													ptkp_tr_ptkp_kegiatan='$txtKegiatan',
													ptkp_tr_ptkp_deskripsi='$txtDeskripsi',
													ptkp_tr_ptkp_referensi='$txtReferensi',
													doc_ms_doc_id='$txtDokumen',
													ptkp_tr_ptkp_masalah='$txtMasalah',
													ptkp_tr_ptkp_updated='".date('Y-m-d H:i:s')."',
													ptkp_tr_ptkp_updatedby='".$_SESSION['sys_role_id']."'
												WHERE ptkp_tr_ptkp_id='$txtKode'";
			$qrySave	= mysqli_query($koneksidb, $sqlSave) or die ("gagal update ptkp ". mysqli_errors());
			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data pembuatan ptkp berhasil diperbaharui';
				echo '<script>window.location="?page='.base64_encode(ptkpdttrptkp).'"</script>';
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
							a.ptkp_tr_ptkp_tgl,
							a.ptkp_tr_ptkp_no,
							a.ptkp_ms_sumber_id,
							a.sys_bagian_id,
							a.ptkp_ms_dampak_id,
							a.ptkp_ms_kategori_id,
							a.ptkp_ms_terkait_id,
							a.ptkp_tr_ptkp_kegiatan,
							a.ptkp_tr_ptkp_deskripsi,
							a.ptkp_tr_ptkp_referensi,
							a.doc_ms_doc_id,
							b.doc_ms_doc_kd,
							a.ptkp_tr_ptkp_id,
							a.ptkp_tr_ptkp_masalah
							FROM ptkp_tr_ptkp a
							LEFT JOIN doc_ms_doc b ON a.doc_ms_doc_id=b.doc_ms_doc_id
							WHERE a.ptkp_tr_ptkp_id='$KodeEdit'";
	$qryShow 			= mysqli_query($koneksidb, $sqlShow)  or die ("Query ambil data department salah : ".mysqli_errors());
	$dataShow			= mysqli_fetch_array($qryShow);

	$dataKode 			= $dataShow['ptkp_tr_ptkp_id'];
	$dataNomor 			= $dataShow['ptkp_tr_ptkp_no'];
	$dataTanggal		= $dataShow['ptkp_tr_ptkp_tgl'];
	$dataSumber			= isset($_POST['cmbSumber']) ? $_POST['cmbSumber'] : $dataShow['ptkp_ms_sumber_id'];
	$dataBagian			= $dataShow['sys_bagian_id']; 
	$dataKegiatan		= isset($_POST['txtKegiatan']) ? $_POST['txtKegiatan'] : $dataShow['ptkp_tr_ptkp_kegiatan'];  
	$dataKategori		= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $dataShow['ptkp_ms_kategori_id'];  
	$dataDeskripsi		= isset($_POST['txtDeskripsi']) ? $_POST['txtDeskripsi'] : $dataShow['ptkp_tr_ptkp_deskripsi']; 
	$dataDampak			= isset($_POST['cmbDampak']) ? $_POST['cmbDampak'] : $dataShow['ptkp_ms_dampak_id']; 
	$dataTerkait		= isset($_POST['cmbTerkait']) ? $_POST['cmbTerkait'] : $dataShow['ptkp_ms_terkait_id']; 
	$dataReferensi		= isset($_POST['txtReferensi']) ? $_POST['txtReferensi'] : $dataShow['doc_ms_doc_kd'];
	$dataDokumen		= isset($_POST['txtDokumen']) ? $_POST['txtDokumen'] : $dataShow['doc_ms_doc_id'];
	$dataMasalah		= isset($_POST['txtMasalah']) ? $_POST['txtMasalah'] : $dataShow['ptkp_tr_ptkp_masalah'];
?>
<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
        <div class="caption">
            <span class="caption-subject uppercase bold">Form Pembuatan PTKP</span>
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
					<label class="col-lg-2 control-label">No. PTKP :</label>
					<div class="col-lg-2">
						<input type="text" value="<?php echo $dataNomor; ?>" class="form-control" disabled/>
						<input type="hidden" value="<?php echo $dataKode; ?>" name="txtKode"/>
		             </div>
				</div>
		        <div class="form-group">
					<label class="col-lg-2 control-label">Tanggal :</label>
					<div class="col-lg-3">
						<input type="text" value="<?php echo $dataTanggal; ?>" class="form-control date-picker" disabled/>
		             </div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Sumber :</label>
					<div class="col-md-4">
						<select name="cmbSumber" data-placeholder="Pilih Sumber" class="select2 form-control">
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM ptkp_ms_sumber WHERE ptkp_ms_sumber_sts='Y' ORDER BY ptkp_ms_sumber_id ASC";
								  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
								  while ($dataRow = mysqli_fetch_array($dataQry)) {
									if ($dataSumber == $dataRow['ptkp_ms_sumber_id']) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$dataRow[ptkp_ms_sumber_id]' $cek>$dataRow[ptkp_ms_sumber_nm]</option>";
								  }
								  $sqlData ="";
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Departemen :</label>
					<div class="col-md-3">
						<select name="cmbBagian" data-placeholder="Pilih Departemen" class="select2 form-control" disabled>
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM sys_bagian WHERE sys_bagian_sts='Y' ORDER BY sys_bagian_id ASC";
								  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
								  while ($dataRow = mysqli_fetch_array($dataQry)) {
									if ($dataBagian == $dataRow['sys_bagian_id']) {
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
					<label class="col-lg-2 control-label">Kegiatan :</label>
					<div class="col-lg-8">
						<input type="text" name="txtKegiatan" value="<?php echo $dataKegiatan; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control" placeholder="Input Kegiatan"/>
		             </div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Kategori :</label>
					<div class="col-md-4">
						<select name="cmbKategori" data-placeholder="Pilih Kategori" class="select2 form-control">
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM ptkp_ms_kategori WHERE ptkp_ms_kategori_sts='Y' ORDER BY ptkp_ms_kategori_id ASC";
								  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
								  while ($dataRow = mysqli_fetch_array($dataQry)) {
									if ($dataKategori == $dataRow['ptkp_ms_kategori_id']) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$dataRow[ptkp_ms_kategori_id]' $cek>$dataRow[ptkp_ms_kategori_nm]</option>";
								  }
								  $sqlData ="";
							?>
						</select>
					</div>
				</div>				
		        <div class="form-group">
					<label class="col-lg-2 control-label">Deskripsi :</label>
					<div class="col-lg-10">
						<textarea type="text" name="txtDeskripsi" rows="4" onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control" placeholder="Input Deskripsi Temuan"><?php echo $dataDeskripsi; ?></textarea>
		             </div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Dampak Temuan :</label>
					<div class="col-md-4">
						<select name="cmbDampak" data-placeholder="Pilih Dampak" class="select2 form-control">
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM ptkp_ms_dampak WHERE ptkp_ms_dampak_sts='Y' ORDER BY ptkp_ms_dampak_id ASC";
								  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
								  while ($dataRow = mysqli_fetch_array($dataQry)) {
									if ($dataDampak == $dataRow['ptkp_ms_dampak_id']) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$dataRow[ptkp_ms_dampak_id]' $cek>$dataRow[ptkp_ms_dampak_nm]</option>";
								  }
								  $sqlData ="";
							?>
						</select>
					</div>
				</div>	
				<div class="form-group">
					<label class="col-md-2 control-label">Keterkaitan :</label>
					<div class="col-md-4">
						<select name="cmbTerkait" data-placeholder="Pilih Keterkaitan" class="select2 form-control">
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM ptkp_ms_terkait WHERE ptkp_ms_terkait_sts='Y' ORDER BY ptkp_ms_terkait_id ASC";
								  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
								  while ($dataRow = mysqli_fetch_array($dataQry)) {
									if ($dataTerkait == $dataRow['ptkp_ms_terkait_id']) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$dataRow[ptkp_ms_terkait_id]' $cek>$dataRow[ptkp_ms_terkait_nm]</option>";
								  }
								  $sqlData ="";
							?>
						</select>
					</div>
				</div>	
		        <div class="form-group last">
					<label class="col-lg-2 control-label">Referensi :</label>
					<div class="col-lg-3">

						<div class="input-group">
							<input type="text" name="txtReferensi" value="<?php echo $dataReferensi; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control" placeholder="Input Referensi" id="doc_ms_doc_kd"/>
	                        <input class="form-control" type="hidden" name="txtDokumen" id="doc_ms_doc_id" value="<?php echo $dataDokumen ?>" />
	                        <span class="input-group-btn">
	                            <a class="btn <?php echo $dataPanel; ?> btn-block" data-toggle="modal" data-target="#barang"><i class="icon-magnifier-add"></i></a>
	                        </span>
	                    </div>
		             </div>
				</div>		
			</div>
	    	<div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-2 col-md-10">
		                <button type="submit" name="btnSave" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-save"></i> Simpan Data</button>
		                <a href="?page=<?php echo base64_encode(ptkpdttrptkp) ?>" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-undo"></i> Batalkan</a>
			        </div>
			    </div>
			</div>
		</form>
	</div>
</div>
		
<div class="modal fade bs-modal-lg" id="barang" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">DAFTAR DOKUMEN</h4>
            </div>
            <div class="modal-body"> 
            	<table class="table table-hover table-bordered table-striped table-condensed" width="100%" id="sample_2">
		            <thead>
		                <tr class="active">
		                  	<th width="5%"><div align="center">NO</div></th>
							<th width="10%"><div align="center">NO. DOCUMENT</div></th>
	                        <th width="15%">BAGIAN</th>
	                        <th width="15%">KATEGORI</th>
	                        <th width="15%">JENIS</th>
	                        <th width="30%">JUDUL DOCUMENT</th>
		                </tr>
		            </thead>
		            <tbody>
		                <?php
		                //Data mentah yang ditampilkan ke tabel    
		                $query = mysqli_query($koneksidb, "SELECT 
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
															AND d.sys_bagian_id='$dataBagian'
															ORDER BY a.doc_ms_doc_kd ASC") or die ("gagal tampil dokumen".mysqli_errors());
		                $nomor =0;
		                while ($data = mysqli_fetch_array($query)) {
		                	$nomor ++ ;
		                    ?>
		                    <tr class="pilihBarang" data-dismiss="modal" aria-hidden="true" 
								data-kode="<?php echo $data['doc_ms_doc_id']; ?>"
								data-nomor="<?php echo $data['doc_ms_doc_kd']; ?>">
		                        <td><div align="center"><?php echo $nomor ?></div></td>
								<td><div align="center"><?php echo $data ['doc_ms_doc_kd']; ?></div></td>
								<td><?php echo $data['sys_bagian_nm']; ?></td>
								<td><?php echo $data['doc_ms_kat_doc_nm']; ?></td>
								<td><?php echo $data['doc_ms_doc_type']; ?></td>
								<td><?php echo $data['doc_ms_doc_nm']; ?></td>
		                    </tr>
		                    <?php
		                }
		                ?>
		            </tbody>
		        </table> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn green" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script src="./assets/scripts/jquery-1.11.2.min.js"></script>
<script src="./assets/scripts/bootstrap.js"></script>
<script type="text/javascript">
    $(document).on('click', '.pilihBarang', function (e) {
        document.getElementById("doc_ms_doc_id").value = $(this).attr('data-kode');
		document.getElementById("doc_ms_doc_kd").value = $(this).attr('data-nomor');
    });
</script>	