<?php
	
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtTanggal'])=="") {
			$message[] = "<b>Tanggal</b> tidak boleh kosong !";		
		}
		if (trim($_POST['cmbOrg'])=="") {
			$message[] = "<b>Organisasi</b> tidak boleh kosong !";		
		}
		if (trim($_POST['cmbBagian'])=="") {
			$message[] = "<b>Bagian</b> tidak boleh kosong !";		
		}
		if (trim($_POST['cmbJenis'])=="") {
			$message[] = "<b>Jenis</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtItem'])=="") {
			$message[] = "<b>Item pemeriksaan</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtDeskripsi'])=="") {
			$message[] = "<b>Deskripsi</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtAuditor'])=="") {
			$message[] = "<b>Nama auditor</b> tidak boleh kosong !";		
		}
		
		$txtTanggal		= InggrisTgl($_POST['txtTanggal']);
		$cmbOrg			= $_POST['cmbOrg'];
		$cmbBagian		= $_POST['cmbBagian'];
		$cmbJenis		= $_POST['cmbJenis'];
		$txtItem		= $_POST['txtItem'];
		$txtDeskripsi	= $_POST['txtDeskripsi'];
		$txtAuditor		= $_POST['txtAuditor'];
		$txtReferensi	= $_POST['txtReferensi'];
		$txtDokumen		= $_POST['txtDokumen'];

		if(count($message)==0){
		
			// INSERT PERIKSAAN
			$sqlSave="INSERT INTO as_trx_periksa (as_trx_periksa_tgl,
												as_trx_periksa_jenis,
												as_trx_periksa_uraian,
												sys_bagian_id,
												as_trx_periksa_created,
												as_trx_periksa_createdby,
												as_trx_periksa_sts,
												doc_ms_doc_id,
												sys_org_id,
												as_trx_periksa_item,
												as_trx_periksa_auditor)
										VALUES('$txtTanggal',
												'$cmbJenis', 
												'$txtDeskripsi',
												'$cmbBagian',
												'".date('Y-m-d H:i:s')."',
												'".$_SESSION['sys_role_id']."',
												'N',
												'$txtDokumen',
												'$cmbOrg',
												'$txtItem',
												'$txtAuditor')";
			$qrySave	= mysqli_query($koneksidb, $sqlSave) or die ("gagal insert ptkp ". mysqli_errors());
			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data pemeriksaan berhasil ditambahkan';
				echo '<script>window.location="?page='.base64_encode(dttrperiksa).'"</script>';
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
	
	$dataTanggal		= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : '';
	$dataOrg			= isset($_POST['cmbOrg']) ? $_POST['cmbOrg'] : '';
	$dataBagian			= isset($_POST['cmbBagian']) ? $_POST['cmbBagian'] : ''; 
	$dataJenis			= isset($_POST['cmbJenis']) ? $_POST['cmbJenis'] : ''; 
	$dataItem			= isset($_POST['txtItem']) ? $_POST['txtItem'] : ''; 
	$dataDeskripsi		= isset($_POST['txtDeskripsi']) ? $_POST['txtDeskripsi'] : ''; 
	$dataAuditor		= isset($_POST['txtAuditor']) ? $_POST['txtAuditor'] : ''; 
	$dataReferensi		= isset($_POST['txtReferensi']) ? $_POST['txtReferensi'] : ''; 
	$dataDokumen		= isset($_POST['txtDokumen']) ? $_POST['txtDokumen'] : ''; 
?>
<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT>
<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
        <div class="caption">
            <span class="caption-subject uppercase">Form Pembuatan Pemerikaan</span>
        </div>
        <div class="tools">
            <a href="" class="collapse"> </a>
            <a href="#portlet-config" data-toggle="modal" class="config"> </a>
            <a href="" class="reload"> </a>
            <a href="" class="remove"> </a>
        </div>
    </div>
	<div class="portlet-body form">
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" autocomplete="off" name="form1">
        	<div class="form-body">
		       <div class="row">
	        		<div class="col-lg-3">
	        			<div class="form-group">
							<label class="control-label">Tgl. Pemeriksaan : :</label>
							<input type="text" name="txtTanggal" value="<?php echo $dataTanggal; ?>" data-date-format="dd-mm-yyyy" class="form-control date-picker" placeholder="Pilih Tanggal"/>
						</div>
	        		</div>
	        		<div class="col-lg-3">
	        			<div class="form-group">
							<label class="control-label">Nama Organisasi :</label>
							<select name="cmbOrg" data-placeholder="Pilih Organisasi" class="select2 form-control">
								<option value=""></option> 
								<?php
									  $dataSql = "SELECT * FROM sys_org WHERE sys_org_sts='Y' ORDER BY sys_org_id ASC";
									  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
									  while ($dataRow = mysqli_fetch_array($dataQry)) {
										if ($dataOrg == $dataRow['sys_org_id']) {
											$cek = " selected";
										} else { $cek=""; }
										echo "<option value='$dataRow[sys_org_id]' $cek>$dataRow[sys_org_nm]</option>";
									  }
									  $sqlData ="";
								?>
							</select>
						</div>
	        		</div>
	        		<div class="col-lg-3">
	        			<div class="form-group">
							<label class="control-label">Departemen :</label>
							<select name="cmbBagian" data-placeholder="Pilih Departemen" class="select2 form-control" onChange="javascript:submitform();">
								<option value=""></option> 
								<?php
									  $dataSql = "SELECT * FROM sys_bagian 
									  				WHERE sys_bagian_sts='Y' 
									  				AND NOT sys_bagian_id='".$userRow['sys_bagian_id']."'
									  				ORDER BY sys_bagian_id ASC";
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
	        		<div class="col-lg-3">
	        			<div class="form-group">
							<label class="control-label">Jenis Pemeriksaan :</label>
							<select class="form-control select2" data-placeholder="Pilih Jenis" name="cmbJenis">
			                	<option value=""></option>
			               		<?php
								  $pilihan	= array("AUDIT INTERNAL HARIAN", "AUDIT INTERNAL BULANAN");
								  foreach ($pilihan as $nilai) {
									if ($dataJenis==$nilai) {
										$cek=" selected";
									} else { $cek = ""; }
									echo "<option value='$nilai' $cek>$nilai</option>";
								  }
								?>
			              	</select>
						</div>	
	        		</div>
	        	</div> 
				<div class="row">
	        		<div class="col-lg-6">
	        			<div class="form-group">
							<label class="control-label">Item Pemeriksaan :</label>
							<input type="text" name="txtItem" value="<?php echo $dataItem; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control" placeholder="Input Item Pemeriksaan" id="doc_ms_doc_kd"/>
						</div>	
	        		</div>
	        		<div class="col-lg-6">
	        			<div class="form-group last">
							<label class="control-label">Auditor / Inisiator :</label>
							<input type="text" name="txtAuditor" value="<?php echo $dataAuditor; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control" placeholder="Input Auditor"/>
						</div>	
	        		</div>
	        	</div>
				<div class="row">
	        		<div class="col-lg-12">
	        			<div class="form-group">
							<label class="control-label">Uraian Temuan & Bukti Audit :</label>
							<textarea type="text" name="txtDeskripsi" rows="4" onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control ckeditor" placeholder="Input Deskripsi Temuan"><?php echo $dataDeskripsi; ?></textarea>
						</div>
	        		</div>
	        	</div>
		        <div class="row last">
		        	<div class="col-lg-12">
		        		<div class="form-group last">
							<label class="control-label">Referensi :</label>
							<div class="input-group">
								<input type="text" name="txtReferensi" value="<?php echo $dataReferensi; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control" placeholder="Input Referensi" id="nomor_doc"/>
		                        <input class="form-control" type="hidden" name="txtDokumen" id="doc_ms_doc_id" value="<?php echo $dataDokumen ?>" />
		                        <span class="input-group-btn">
		                            <a class="btn <?php echo $dataPanel; ?> btn-block" data-toggle="modal" data-target="#barang"><i class="icon-magnifier-add"></i></a>
		                        </span>
		                    </div>
						</div>	
		        	</div>
		        </div>
			</div>
	    	<div class="form-actions">
                <button type="submit" name="btnSave" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-save"></i> Simpan Data</button>
                <a href="?page=<?php echo base64_encode(ptkpdttrptkp) ?>" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-undo"></i> Batalkan</a>
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
            	<table class="table table-hover table-condensed table-striped table-condensed" width="100%" id="sample_2">
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
								data-kd="<?php echo $data['doc_ms_doc_kd']; ?>">
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
                <button type="button" class="btn <?php echo $dataPanel; ?>" data-dismiss="modal">Close</button>
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
		document.getElementById("nomor_doc").value = $(this).attr('data-kd');
    });
</script>