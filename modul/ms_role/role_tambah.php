<?php
		
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['cmbGroup'])=="") {
			$message[] = "Nama group user tidak boleh kosong!";		
		}
		if (trim($_POST['txtNama'])=="") {
			$message[] = "Nama user tidak boleh kosong!";		
		}
		if (trim($_POST['txtUsername'])=="") {
			$message[] = "Username user tidak boleh kosong!";		
		}
		if (trim($_POST['txtPassword'])=="") {
			$message[] = "Password user tidak boleh kosong!";		
		}
		if (trim($_POST['txtHome'])=="") {
			$message[] = "Home page user tidak boleh kosong!";		
		}
		if (trim($_POST['cmbOrg'])=="") {
			$message[] = "Organisasi tidak boleh kosong!";		
		}
		if (trim($_POST['cmbBagian'])=="") {
			$message[] = "Bagian tidak boleh kosong!";		
		}
		
		if (trim($_POST['cmbJab'])=="") {
			$message[] = "Jabatan tidak boleh kosong!";		
		}
		
		
		$cmbGroup		= $_POST['cmbGroup'];
		$cmbStatus		= $_POST['cmbStatus'];
		$cmbID			= $_POST['cmbID'];
		$txtUsername	= $_POST['txtUsername'];
		$txtPassword	= $_POST['txtPassword'];
		$txtNama		= $_POST['txtNama'];
		$txtHome		= $_POST['txtHome'];
		$cmbOrg			= $_POST['cmbOrg'];
		$cmbBagian		= $_POST['cmbBagian'];
		$cmbJab			= $_POST['cmbJab'];

		
		if(count($message)==0){					
			$sqlSave="INSERT INTO sys_role (ad_user_id,
											sys_group_id,
											sys_role_sts,
											sys_role_nama,
											sys_role_username,
											sys_role_template,
											sys_role_template_color,
											sys_role_panel_color,
											sys_role_created,
											sys_role_home,
											sys_jab_id,
											sys_bagian_id,
											sys_org_id,
											sys_role_password)
									VALUES('$cmbID', 
											'$cmbGroup',
											'$cmbStatus',
											'$txtNama',
											'$txtUsername',
											'O',
											'darkblue',
											'green',
											'".date('Y-m-d H:i:s')."',
											'$txtHome',
											'$cmbJab',
											'$cmbBagian',
											'$cmbOrg',
											'$txtPassword')";
			$qrySave=mysqli_query($koneksidb, $sqlSave) or die ("Gagal query".mysqli_errors());
			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data role user berhasil ditambahkan';
			echo '<script>window.location="?page='.base64_encode(dtrole).'"</script>';

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
	} 
	$dataNama		= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
	$dataUsername	= isset($_POST['txtUsername']) ? $_POST['txtUsername'] : '';
	$dataID			= isset($_POST['cmbID']) ? $_POST['cmbID'] : '';
	$dataPassword	= isset($_POST['txtPassword']) ? $_POST['txtPassword'] : '';
	$dataGroup		= isset($_POST['cmbGroup']) ? $_POST['cmbGroup'] : '';
	$dataStatus		= isset($_POST['cmbStatus']) ? $_POST['cmbStatus'] : '';
	$datahome		= isset($_POST['txtHome']) ? $_POST['txtHome'] : '';
	$dataOrg		= isset($_POST['cmbOrg']) ? $_POST['cmbOrg'] : '';
	$dataBagian		= isset($_POST['cmbBagian']) ? $_POST['cmbBagian'] : '';
	$dataJab		= isset($_POST['cmbJab']) ? $_POST['cmbJab'] : '';
?>
<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase bold">Penambahan Role User</span></div>
		<div class="tools">
			<a href="javascript:;" class="collapse"></a>
			<a href="javascript:;" class="reload"></a>
			<a href="javascript:;" class="remove"></a>
		</div>
	</div>	
	<div class="portlet-body form">		
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
			<div class="form-body">
				<div class="form-group">
					<label class="col-lg-2 control-label">ID Openbravo :</label>
					<div class="col-lg-4">
						<div class="input-group">
	                        <input class="form-control" type="text" name="cmbID" id="ad_user_id" value="<?php echo $dataID ?>" readonly/>
	                        <span class="input-group-btn">
	                            <a class="btn green btn-block" data-toggle="modal" data-target="#user"><i class="icon-magnifier-add"></i></a>
	                        </span>
	                    </div>
	                    <span class="help-block"> Masukkan ID openbravo apabila user dari OB </span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Nama User :</label>
					<div class="col-lg-3">
	                	<input class="form-control" type="text" id="nama_user" value="<?php echo $dataNama ?>" name="txtNama" value="<?php echo $dataNama ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Username :</label>
					<div class="col-lg-3">
	                    <input class="form-control" type="text" name="txtUsername" id="username" value="<?php echo $dataUsername ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Password :</label>
					<div class="col-lg-3">
	                    <input class="form-control" type="password" name="txtPassword" value="<?php echo $dataPassword ?>" id="password"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Organisasi :</label>
					<div class="col-lg-4">
						<select name="cmbOrg" class="select2 form-control" data-placeholder="Pilih Organisasi">
							<option value=""> </option>
							<?php
							  $dataSql = "SELECT * FROM sys_org ORDER BY sys_org_id DESC";
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
				<div class="form-group">
					<label class="col-lg-2 control-label">Bagian :</label>
					<div class="col-lg-3">
						<select name="cmbBagian" class="select2 form-control" data-placeholder="Pilih Bagian">
							<option value=""> </option>
							<?php
							  $dataSql = "SELECT * FROM sys_bagian ORDER BY sys_bagian_id DESC";
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
					<label class="col-lg-2 control-label">Jabatan :</label>
					<div class="col-lg-3">
						<select name="cmbJab" class="select2 form-control" data-placeholder="- Select Jabatan -">
							<option value=""> </option>
							<?php
							  $dataSql = "SELECT * FROM sys_jab ORDER BY sys_jab_id DESC";
							  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
							  while ($dataRow = mysqli_fetch_array($dataQry)) {
								if ($dataJab == $dataRow['sys_jab_id']) {
									$cek = " selected";
								} else { $cek=""; }
								echo "<option value='$dataRow[sys_jab_id]' $cek>$dataRow[sys_jab_nm]</option>";
							  }
							  $sqlData ="";
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Dasboard :</label>
					<div class="col-lg-3">
						<select name="txtHome" class="form-control select2">
							<?php
								$namaBulan = array("home" => "Home Administrator", 
													"homeload" => "Home Aplikasi Loading", 
													"homeptkp" => "Home Aplikasi PTKP", 
													"hometicket" => "Home Aplikasi Ticket");
								foreach($namaBulan as $bulanKe => $bulanNM) {
									if ($bulanKe == $dataHome) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$bulanKe' $cek>$bulanNM</option>";
							  	}
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Level Group :</label>
					<div class="col-lg-3">
						<select name="cmbGroup" class="select2 form-control" data-placeholder="Pilih Group">
							<option value=""> </option>
							<?php
							  $dataSql = "SELECT * FROM sys_group ORDER BY sys_group_id DESC";
							  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
							  while ($dataRow = mysqli_fetch_array($dataQry)) {
								if ($dataGroup == $dataRow['sys_group_id']) {
									$cek = " selected";
								} else { $cek=""; }
								echo "<option value='$dataRow[sys_group_id]' $cek>$dataRow[sys_group_nama]</option>";
							  }
							  $sqlData ="";
							?>
						</select>
					</div>
				</div>
				<div class="form-group last">
	                <label class="col-md-2 control-label">Status User :</label>
	                <div class="col-md-10">
	                    <div class="md-radio-list">
	                    	<?php
								if($dataStatus=='Active'){
				                    echo " 	<div class='md-radio'>
				                    			<input type='radio' id='radio53' name='cmbStatus' value='Active' class='md-radiobtn' checked>
				                            	<label for='radio53'><span></span><span class='check'></span><span class='box'></span> Active </label>
				                            </div>
				                        	<div class='md-radio'>
				                            	<input type='radio' id='radio54' name='cmbStatus' value='Non Active' class='md-radiobtn'>
				                            	<label for='radio54'><span></span><span class='check'></span><span class='box'></span> Non Active </label>
				                        	</div>";
				                }elseif($dataStatus=='Non Active'){
				                	echo "	<div class='md-radio'>
				                            	<input type='radio' id='radio53' name='cmbStatus' value='Active' class='md-radiobtn'>
				                            	<label for='radio53'><span></span><span class='check'></span><span class='box'></span> Active </label>
				                        	</div>
				                        	<div class='md-radio'>
				                            	<input type='radio' id='radio54' name='cmbStatus' value='Non Active' class='md-radiobtn' checked>
				                            	<label for='radio54'><span></span><span class='check'></span><span class='box'></span> Non Active </label>
				                            </div>";
				                }else{
				                	echo "	<div class='md-radio'>
				                            	<input type='radio' id='radio53' name='cmbStatus' value='Active' class='md-radiobtn'>
				                            	<label for='radio53'><span></span><span class='check'></span><span class='box'></span> Active </label>
				                        	</div>
				                        	<div class='md-radio'>
				                            	<input type='radio' id='radio54' name='cmbStatus' value='Non Active' class='md-radiobtn'>
				                            	<label for='radio54'><span></span><span class='check'></span><span class='box'></span> Non Active </label>
				                            </div>";
				                }
				            ?>
	                    </div>
	                </div>
	            </div>
	         </div>
			<div class="form-actions">
			    <div class="row">
			        <div class="form-group">
			            <div class="col-lg-offset-2 col-lg-10">
			                <button type="submit" name="btnSave" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-save"></i> Simpan Data</button>
			                <a href="?page=<?php echo base64_encode(dtrole) ?>" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-undo"></i> Batalkan</a>
			            </div>
			        </div>
			    </div>
			</div>
		</form>
	</div>
</div>
<div class="modal fade bs-modal-lg" id="user" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Data User</h4>
            </div>
            <div class="modal-body"> 
            	<table class="table table-hover table-bordered table-striped table-condensed" width="100%" id="sample_2">
		            <thead>
		                <tr class="active">
		                    <th width="50"><div align="center">PILIH</div></th>
		                    <th width="50"><div align="center">NO</div></th>
		                    <th width="300">NAMA USER</th>
		                    <th width="200">USERNAME</th>
		                    <th width="200">BAGIAN</th>
		                    <th width="200">KETERANGAN</th>
		                </tr>
		            </thead>
		            <tbody>
		                <?php
		                //Data mentah yang ditampilkan ke tabel    
		                $query = pg_query($koneksipg, "SELECT 
															a.ad_user_id,
															a.name,
															a.username,
															b.name as bagian,
															a.description,
															a.password
															FROM
																ad_user a
																LEFT JOIN gmm_departement b ON a.em_gmm_departement_id= b.gmm_departement_id 
															WHERE
																NOT a.username= '' 
															ORDER BY
																a.ad_user_id DESC");
		               	$nomor = 0;
		                while ($data = pg_fetch_array($query)) {
		                	$nomor ++;
		                    ?>
		                    <tr class="pilihUser" data-dismiss="modal" aria-hidden="true" 
								data-id="<?php echo $data['ad_user_id']; ?>"
								data-nama="<?php echo $data['name']; ?>"
								data-password="<?php echo $data['password']; ?>"
								data-username="<?php echo $data['username']; ?>">
		                        <td><div align="center"><button class="btn btn-xs red"><i class="icon-eye"></i></button></div></td>
		                        <td><div align="center"><?php echo $nomor; ?></div></td>
		                        <td><?php echo $data['name']; ?></td>
		                        <td><?php echo $data['username']; ?></td>
		                        <td><?php echo $data['bagian']; ?></td>
		                        <td><?php echo $data['description']; ?></td>
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
    $(document).on('click', '.pilihUser', function (e) {
        document.getElementById("ad_user_id").value = $(this).attr('data-id');
		document.getElementById("nama_user").value = $(this).attr('data-nama');
		document.getElementById("username").value = $(this).attr('data-username');
		document.getElementById("password").value = $(this).attr('data-password');
    });
</script>	