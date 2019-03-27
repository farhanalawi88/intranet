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
	$txtNamaLm		= $_POST['txtNamaLm'];
	$txtModul		= $_POST['txtModul'];
	$txtKeterangan	= $_POST['txtKeterangan'];
	$cmbStatus		= $_POST['cmbStatus'];
	$txtKode		= $_POST['txtKode'];
	$txtID 			= encrypt(date('Y-m-d H:i:s'));
	$cmbLevel		= $_POST['cmbLevel'];
	
			
	if(count($message)==0){		

		$delete=mysqli_query($koneksidb, "DELETE FROM sys_akses WHERE sys_group_id='$txtKode'") 
								or die ("Gagal kosongkan tmp".mysqli_errors());		
		foreach ($txtModul as $id_key) {
			$simpanModul=mysqli_query($koneksidb, "INSERT INTO sys_akses (sys_group_id, 
																		sys_submenu_id,
																		sys_akses_created)
																VALUES('$txtKode',
																		'$id_key',
																		'".date('Y-m-d')."')")
				or die ("Gagal insert sys_akses".mysqli_errors());
				
		}
		
		$qrySave		= mysqli_query($koneksidb, "UPDATE sys_group SET sys_group_nama='$txtNama', 
																sys_group_ket='$txtKeterangan', 
																sys_group_sts='$cmbStatus',
																sys_group_level='$cmbLevel'
														WHERE sys_group_id='".$_POST['txtKode']."'") 
							  or die ("Gagal update sys_group".mysqli_errors());
		if($qrySave){
		$_SESSION['info'] = 'success';						
			$_SESSION['pesan'] = 'Data group akses berhasil diperbaharui';
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

			
$kodeTransaksi 		= base64_decode($_GET['id']);
$beliSql 			= "SELECT * FROM sys_group WHERE sys_group_id='$kodeTransaksi'";
$beliQry 			= mysqli_query($koneksidb, $beliSql)  or die ("Query pendaftaran salah : ".mysqli_errors());
$beliRow 			= mysqli_fetch_array($beliQry);

$dataKode			= $beliRow['sys_group_id'];
$dataNamaLm			= $beliRow['sys_group_nama'];
$dataNama			= isset($_POST['txtNama']) ? $_POST['txtNama'] : $beliRow['sys_group_nama'];
$dataKeterangan		= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : $beliRow['sys_group_ket'];
$dataStatus			= isset($_POST['cmbStatus']) ? $_POST['cmbStatus'] : $beliRow['sys_group_sts'];
$dataLevel			= isset($_POST['cmbLevel']) ? $_POST['cmbLevel'] : $beliRow['sys_group_level'];
?>
<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase bold">Form Perubahan Group</span></div>
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
			          	<input class="form-control" type="hidden" name="txtNamaLm" value="<?php echo $dataNamaLm ?>">
			          	<input class="form-control" type="hidden" name="txtKode" value="<?php echo $dataKode ?>">
		        		</div>
		      		</div><!-- col-4 -->
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
		     	<div class="batas"></div>
			    <div class="row">
			     	<div class="col-lg-12">    	
		            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_2">
						<thead>
		                    <tr class="active">
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
								$dataSql	= "SELECT * FROM sys_submenu 
												INNER JOIN sys_menu ON sys_submenu.sys_menu_id=sys_menu.sys_menu_id";
								$dataQry 	= mysqli_query($koneksidb, $dataSql)  
												or die ("Query sys_akses salah : ".mysqli_errors());
								$nomor 		= 0; 
								while ($data= mysqli_fetch_array($dataQry)) {
								$nomor++;
								$Kode 		= $data['sys_group_id'];
								$QryCari	= mysqli_query($koneksidb, "SELECT count(*) as total FROM sys_akses
												WHERE sys_group_id='$dataKode' 
												AND sys_submenu_id='$data[sys_submenu_id]'") 
												or die ("gagal ambil ".mysqli_errors());
								$dataCari	= mysqli_fetch_array($QryCari);
								$dataCari2	= $dataCari['total'];
								if($dataCari2>=1){
									$kondisi= "checked";
								}else{
									$kondisi= "";
								}
							?>
							<tr class="odd gradeX">
		                        <td>
		                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
		                                <input type="checkbox" class="checkboxes" <?php echo $kondisi ?> value="<?php echo $data['sys_submenu_id']; ?>" name="txtModul[<?php echo $data['sys_submenu_id']; ?>]"/>
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