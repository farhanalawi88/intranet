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
		$txtKode		= $_POST['txtKode'];

		if(count($message)==0){
		
			// INSERT PERIKSAAN
			$sqlSave="UPDATE as_trx_periksa SET as_trx_periksa_tgl='$txtTanggal',
												as_trx_periksa_jenis='$cmbJenis',
												as_trx_periksa_uraian='$txtDeskripsi',
												sys_bagian_id='$cmbBagian',
												as_trx_periksa_updated='".date('Y-m-d H:i:s')."',
												as_trx_periksa_updatedby='".$_SESSION['sys_role_id']."',
												doc_ms_doc_id='$txtDokumen',
												sys_org_id='$cmbOrg',
												as_trx_periksa_item='$txtItem',
												as_trx_periksa_auditor='$txtAuditor'
											WHERE as_trx_periksa_id='$txtKode'";
			$qrySave	= mysqli_query($koneksidb, $sqlSave) or die ("gagal insert ptkp ". mysqli_errors());
			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data pemeriksaan berhasil diperbahrui';
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
	$KodeEdit			= isset($_GET['id']) ?  $_GET['id'] : $_POST['txtKode']; 
	$sqlShow 			= "SELECT 
							a.as_trx_periksa_id,
							a.as_trx_periksa_tgl,
							a.sys_org_id,
							a.sys_bagian_id,
							a.as_trx_periksa_jenis,
							a.as_trx_periksa_item,
							a.as_trx_periksa_uraian,
							a.as_trx_periksa_auditor,
							b.doc_ms_doc_kd,
							a.doc_ms_doc_id
							FROM as_trx_periksa a
							LEFT JOIN doc_ms_doc b ON a.doc_ms_doc_id=b.doc_ms_doc_id
							WHERE a.as_trx_periksa_id='".base64_decode($KodeEdit)."'";
	$qryShow 			= mysqli_query($koneksidb, $sqlShow)  or die ("Query ambil data libur salah : ".mysqli_errors());
	$dataShow 			= mysqli_fetch_array($qryShow);		
	
	$dataKode			= $dataShow['as_trx_periksa_id'];
	
	$dataTanggal		= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : IndonesiaTgl($dataShow['as_trx_periksa_tgl']);
	$dataOrg			= isset($_POST['cmbOrg']) ? $_POST['cmbOrg'] : $dataShow['sys_org_id'];
	$dataBagian			= isset($_POST['cmbBagian']) ? $_POST['cmbBagian'] : $dataShow['sys_bagian_id']; 
	$dataJenis			= isset($_POST['cmbJenis']) ? $_POST['cmbJenis'] : $dataShow['as_trx_periksa_jenis']; 
	$dataItem			= isset($_POST['txtItem']) ? $_POST['txtItem'] : $dataShow['as_trx_periksa_item']; 
	$dataDeskripsi		= isset($_POST['txtDeskripsi']) ? $_POST['txtDeskripsi'] : $dataShow['as_trx_periksa_uraian']; 
	$dataAuditor		= isset($_POST['txtAuditor']) ? $_POST['txtAuditor'] : $dataShow['as_trx_periksa_auditor']; 
	$dataReferensi		= isset($_POST['txtReferensi']) ? $_POST['txtReferensi'] : $dataShow['doc_ms_doc_kd']; 
	$dataDokumen		= isset($_POST['txtDokumen']) ? $_POST['txtDokumen'] : $dataShow['doc_ms_doc_id']; 
?>
<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" autocomplete="off" name="form1">
	<div class="portlet light portlet-fit portlet-datatable bordered">
		<div class="portlet-title">
	        <div class="caption">
	            <span class="caption-subject uppercase bold">Form Perubahan Pemerikaan</span>
	        </div>
	        <div class="actions">
				<button type="submit" name="btnSave" class="btn btn-default btn-sm"><i class="fa fa-save"></i></button>
				<a href="?page=<?php echo base64_encode(dttrperiksa) ?>" class="btn btn-default btn-sm"><i class="fa fa-close"></i></a>
			</div>
	    </div>
		<div class="portlet-body">
        	<div class="form-body">
		       <div class="row">
	        		<div class="col-lg-3">
	        			<div class="form-group">
							<label class="control-label">Tgl. Pemeriksaan : :</label>
							<input type="text" name="txtTanggal" value="<?php echo $dataTanggal; ?>" data-date-format="dd-mm-yyyy" class="form-control date-picker" placeholder="Pilih Tanggal"/>
							<input type="hidden" name="txtKode" value="<?php echo $dataKode ?>">
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
							<input type="text" name="txtItem" value="<?php echo $dataItem; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control" placeholder="Input Item Pemeriksaan"/>
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
								<input type="text" name="txtReferensi" value="<?php echo $dataReferensi; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control" placeholder="Input Referensi" id="doc_ms_doc_kd"/>
		                        <input class="form-control" type="hidden" name="txtDokumen" id="doc_ms_doc_id" value="<?php echo $dataDokumen ?>" />
		                        <span class="input-group-btn">
		                            <a class="btn <?php echo $dataPanel; ?> btn-block" data-toggle="modal" data-target="#barang"><i class="icon-magnifier-add"></i></a>
		                        </span>
		                    </div>
						</div>	
		        	</div>
		        </div>
			</div>
		</div>
	</div>
</form>
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
								data-no="<?php echo $data['doc_ms_doc_kd']; ?>">
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
		document.getElementById("doc_ms_doc_kd").value = $(this).attr('data-no');
    });
</script>