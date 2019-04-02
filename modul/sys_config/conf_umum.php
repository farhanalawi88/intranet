<?php		
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['cmbMenu'])=="") {
			$message[] = "Menu setting tidak boleh kosong !";		
		}
		if (trim($_POST['cmbColor'])=="") {
			$message[] = "Theme color tidak boleh kosong !";		
		}
		if (trim($_POST['cmbPanel'])=="") {
			$message[] = "Panel color tidak boleh kosong !";		
		}
				
		$txtKode	= $_POST['txtKode'];
		$cmbMenu	= $_POST['cmbMenu'];
		$cmbColor	= $_POST['cmbColor'];
		$cmbPanel	= $_POST['cmbPanel'];
							
		if(count($message)==0){			
			$sqlSave= "UPDATE sys_role SET sys_role_template_color='$cmbColor',
											sys_role_template='$cmbMenu',
											sys_role_panel_color='$cmbPanel',
											sys_role_updated='".date('Y-m-d H:i:s')."'
									WHERE sys_role_id='$txtKode'";
			$qrySave=mysqli_query($koneksidb, $sqlSave) or die ("SQL ERROR".mysqli_errors());
			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'pengaturan umum berhasil diperbaharui';
				echo '<script>window.location="?page='.base64_encode(cnfset).'"</script>';
			}
		}		
		if (! count($message)==0 ){
			echo "<div class='alert note note-warning'>
			  		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'></button>";
				$Num=0;
				foreach ($message as $indeks=>$pesan_tampil) { 
				$Num++;
				echo "&nbsp;&nbsp;$Num. $pesan_tampil<br>";	
			} 
				echo "</div>"; 
		}
	} 
	$sqlShow 		= "SELECT * FROM sys_role WHERE sys_role_id='".$_SESSION['sys_role_id']."'";
	$qryShow 		= mysqli_query($koneksidb, $sqlShow)  or die ("Query ambil data user salah : ".mysqli_errors());
	$dataShow 		= mysqli_fetch_array($qryShow);
	
	$dataKode		= $dataShow['sys_role_id'];
	$dataColor		= isset($dataShow['sys_role_template_color']) ?  $dataShow['sys_role_template_color'] : $_POST['cmbColor'];
	$dataMenu		= isset($dataShow['sys_role_template']) ?  $dataShow['sys_role_template'] : $_POST['cmbMenu'];
	$dataPan		= isset($dataShow['sys_role_panel_color']) ?  $dataShow['sys_role_panel_color'] : $_POST['cmbPanel'];
			
?>
<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase bold">Pengaturan Umum</span></div>
		<div class="tools">
			<a href="javascript:;" class="collapse"></a>
			<a href="javascript:;" class="reload"></a>
			<a href="javascript:;" class="remove"></a>
		</div>
	</div>	
	<div class="portlet-body form">	
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
	        <input type="hidden" name="txtKode" value="<?php echo $dataKode; ?>" class="form-control" readonly="readonly"/>
			<div class="form-body">
				<div class="form-group last">
					<label class="col-lg-2 control-label">Theme Color :</label>
					<div class="col-lg-3">
						<select name="cmbColor" class="form-control select2">
							<?php
								$namaBulan = array("darkblue" => "Darkblue", "blue" => "Blue", "grey" => "Grey","light" => "Light", "light2" => "Light 2");
								foreach($namaBulan as $bulanKe => $bulanNM) {
									if ($bulanKe == $dataColor) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$bulanKe' $cek>$bulanNM</option>";
							  	}
							?>
						</select>
					</div>
				</div>
				<div class="form-group last">
					<label class="col-lg-2 control-label">Menu Setting :</label>
					<div class="col-lg-3">
						<select name="cmbMenu" class="form-control select2">
							<?php
								$namaBulan = array("O" => "Sidebar Open", "C" => "Sidebar Closed");
								foreach($namaBulan as $bulanKe => $bulanNM) {
									if ($bulanKe == $dataMenu) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$bulanKe' $cek>$bulanNM</option>";
							  	}
							?>
						</select>
					</div>
				</div>
				<div class="form-group last">
					<label class="col-lg-2 control-label">Panel Color :</label>
					<div class="col-lg-3">
						<select name="cmbPanel" class="form-control select2">
							<?php
								$namaBulan = array("green" => "Green", "yellow" => "Yellow", "red" => "Red", "blue" => "blue", "grey" => "Grey", "dark" => "Dark", "purple" => "Purple", "blue-ebonyclay" => "Blue Ebonyclay", "green-jungle" => "Green Jungle", "blue-steel" => "Blue Steel", "blue-hoki" => "Blue Hoki", "grey-cascade" => "Grey Cascade", "blue-chambray" => "Blue Chambray");
								foreach($namaBulan as $bulanKe => $bulanNM) {
									if ($bulanKe == $dataPan) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$bulanKe' $cek>$bulanNM</option>";
							  	}
							?>
						</select>
					</div>
				</div>
			</div>
			<div class="form-actions">
	            <div class="row">
	                <div class="col-md-offset-2 col-md-9">
	                    <button type="submit" class="btn <?php echo $dataPanel; ?>" name="btnSave"><i class="fa fa-save"></i> Simpan Perubahan</button>
	                </div>
	            </div>
	        </div>
	    </form>
	</div>
</div>
		