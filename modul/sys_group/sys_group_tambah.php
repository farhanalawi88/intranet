<?php

if(isset($_POST['btnSave'])){
	$message = array();
	if (trim($_POST['txtNama'])=="") {
		$message[] = "<b>Nama group</b> tidak boleh kosong, silahkan isi terlebih dahulu !";		
	}
	if (trim($_POST['cmbStatus'])=="") {
		$message[] = "<b>Status group</b> tidak boleh kosong, silahkan isi terlebih dahulu !";		
	}
	if (trim($_POST['cmbLevel'])=="") {
		$message[] = "<b>Level group</b> tidak boleh kosong, silahkan isi terlebih dahulu !";		
	}

	$txtNama		= $_POST['txtNama'];
	$txtKeterangan	= $_POST['txtKeterangan'];
	$cmbStatus		= $_POST['cmbStatus'];
	$cmbLevel		= $_POST['cmbLevel'];
	$txtModul		= $_POST['txtModul'];
	

	
			
	if(count($message)==0){		
		$qrySave		= mysqli_query($koneksidb, "INSERT INTO sys_group (sys_group_nama,
																		sys_group_ket,
																		sys_group_sts,
																		sys_group_level)
																VALUES ('$txtNama',
																		'$txtKeterangan',
																		'$cmbStatus',
																		'$cmbLevel')") 
							  or die ("Gagal query".mysqli_errors());
		if($qrySave){	
			$sqlShow 	= "SELECT MAX(sys_group_id) as sys_group_id FROM sys_group";
			$qryShow	= mysqli_query($koneksidb, $sqlShow) or die ("Eror Query".mysqli_errors()); 
			$dataShow	= mysqli_fetch_array($qryShow);
			foreach ($txtModul as $id_key) {		
				$simpanModul=mysqli_query($koneksidb, "INSERT INTO sys_akses (sys_group_id,
																			sys_submenu_id,
																			sys_akses_created)
																	VALUES ('$dataShow[sys_group_id]',
																			'$id_key',
																			'".date('Y-m-d H:i:s')."')") 
					or die ("Gagal insert siswa".mysqli_errors());
					
			}	
			$_SESSION['info'] = 'success';
			$_SESSION['pesan'] = 'Group akses baru berhasil dibuat';
			echo '<script>window.location="?page='.base64_encode(dtgroup).'"</script>';
		}
		else{
			$message[] = "Gagal penyimpanan ke database";
		}
	}	
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

$dataNama		= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataKeteranngan= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
$dataStatus		= isset($_POST['cmbStatus']) ? $_POST['cmbStatus'] : '';
$dataLevel		= isset($_POST['cmbLevel']) ? $_POST['cmbLevel'] : '';
?>	
<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase">Form Penambahan Group</span></div>
		<div class="tools">
			<a href="javascript:;" class="collapse"></a>
			<a href="javascript:;" class="reload"></a>
			<a href="javascript:;" class="remove"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmadd">
			<div class="form-body">
		    	<div class="row">
		      		<div class="col-lg-4">
		        		<div class="form-group">
		          		<label class="form-control-label">Nama Group :</label>
		          		<input class="form-control" type="text" name="txtNama" value="<?php echo $dataNama ?>" placeholder="Masukkan Nama">
		          		</div>
		        	</div>
				    <div class="col-lg-4">
				    	<div class="form-group">
				        	<label class="form-control-label">Keterangan :</label>
				          	<input class="form-control" type="text" name="txtKeterangan" value="<?php echo $dataKeterangan ?>" placeholder="Masukkan Keterangan">
				        </div>
				    </div><!-- col-4 -->
				    <div class="col-lg-2">
				        <div class="form-group">
				    	    <label class="form-control-label">Level Group :</label>
				        	<select class="form-control select2" data-placeholder="Pilih Level" name="cmbLevel">
			                	<option value=""></option>
			               		<?php
								  $pilihan	= array("Admin", "User","Approver");
								  foreach ($pilihan as $nilai) {
									if ($dataLevel==$nilai) {
										$cek=" selected";
									} else { $cek = ""; }
									echo "<option value='$nilai' $cek>$nilai</option>";
								  }
								?>
			              	</select>
				        </div>
				    </div><!-- col-4 -->
				    <div class="col-lg-2">
				        <div class="form-group">
				    	    <label class="form-control-label">Status Group :</label>
				        	<select class="form-control select2" data-placeholder="Pilih Status" name="cmbStatus">
			                	<option value=""></option>
			               		<?php
								  $pilihan	= array("Active", "Non Active");
								  foreach ($pilihan as $nilai) {
									if ($dataStatus==$nilai) {
										$cek=" selected";
									} else { $cek = ""; }
									echo "<option value='$nilai' $cek>$nilai</option>";
								  }
								?>
			              	</select>
				        </div>
				    </div><!-- col-4 -->
				</div>
				<hr>
			    <div class="row">
			     	<div class="col-lg-12">    	
		            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_2">
						<thead>
		                    <tr>
		       	  	  	  	  	<th class="table-checkbox">
		                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
		                                <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" />
		                                <span></span>
		                            </label>
		                        </th>
							  	<th width="50%">NAMA MODUL</th>
								<th width="46%">MENU UTAMA</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$dataSql = "SELECT * FROM sys_submenu
											INNER JOIN sys_menu ON sys_submenu.sys_menu_id=sys_menu.sys_menu_id
											ORDER BY sys_submenu.sys_submenu_id DESC";
								$dataQry = mysqli_query($koneksidb, $dataSql)  or die ("Query salah : ".mysqli_errors());
								$nomor  = 0; 
								while ($data = mysqli_fetch_array($dataQry)) {
								$nomor++;
								$Kode = $data['sys_submenu_id'];
							?>
							<tr class="odd gradeX">
		                        <td>
		                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
		                                <input type="checkbox" class="checkboxes" value="<?php echo $Kode; ?>" name="txtModul[<?php echo $Kode; ?>]" />
		                                <span></span>
		                            </label>
		                        </td>
								<td><?php echo $data ['sys_submenu_nama']; ?></td>
								<td><?php echo $data ['sys_menu_nama']; ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					</div>
				</div>
			</div>
		    <div class="form-actions">
                <button type="submit" name="btnSave" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-save"></i> Simpan Data</button>
                <a href="?page=<?php echo base64_encode(dtgroup) ?>" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-undo"></i> Batalkan</a>
			</div>
		</form>
	</div>
</div>