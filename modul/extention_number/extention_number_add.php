<?php

	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['cmbNama'])=="") {
			$message[] = "<b>Nama</b> tidak boleh kosong !";		
		}
		if (trim($_POST['cmbDepartemen'])=="") {
			$message[] = "<b>Departemen</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtLineTelepon'])=="") {
			$message[] = "<b>Line Telepon</b> tidak boleh kosong !";		
		}
		
		$cmbNama			= $_POST['cmbNama'];
		$cmbDepartemen		= $_POST['cmbDepartemen'];
		$txtLineTelepon		= $_POST['txtLineTelepon'];

		if(count($message)==0){

			// INSERT DATA EXTENTION TELEPON
			$sqlSave="INSERT INTO ext_number (id_employee,
												sys_bagian_id,
												line_telepon,
												created)
										VALUES ('$cmbNama',
												'$cmbDepartemen',
												'$txtLineTelepon',											
												'".date('Y-m-d H:i:s')."')";
			$qrySave	= mysqli_query($koneksidb, $sqlSave) or die ("Gagal Insert Ext Telepon ". mysqli_errors());
			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data Pembuatan Ext Telepon Berhasil Ditambahkan';
				echo '<script>window.location="?page='.base64_encode(extentionnumberdata).'"</script>';
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
	
	$dataNama				= isset($_POST['cmbNama']) ? $_POST['cmbNama'] : '';
	$dataDepartemen			= isset($_POST['cmbDepartemen']) ? $_POST['cmbDepartemen'] : '';
	$dataLineTelepon		= isset($_POST['txtLineTelepon']) ? $_POST['txtLineTelepon'] : ''; 
?>

<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT>
<div class="portlet box blue">
	<div class="portlet-title">
        <div class="caption">
            <span class="caption-subject uppercase bold">Form Ext Telepon</span>
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
					<label class="col-md-2 control-label">Nama :</label>
					<div class="col-md-4">
						<select name="cmbNama" data-placeholder="Pilih Nama" class="select2 form-control">
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM sys_employee
								  			  WHERE status='Y'
								  			  ORDER BY id_employee ASC";
								  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
								  while ($dataRow = mysqli_fetch_array($dataQry)) {
									if ($dataNama == $dataRow['id_employee']) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$dataRow[id_employee]' $cek>$dataRow[nama_karyawan]</option>";
								  }
								  $sqlData ="";
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Departemen :</label>
					<div class="col-md-4">
						<select name="cmbDepartemen" data-placeholder="Pilih Departemen" class="select2 form-control">
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM sys_bagian
								  			  WHERE sys_bagian_sts='Y'
								  			  ORDER BY sys_bagian_id ASC";
								  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
								  while ($dataRow = mysqli_fetch_array($dataQry)) {
									if ($dataDepartemen == $dataRow['sys_bagian_id']) {
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
					<label class="col-lg-2 control-label">Line Telepon :</label>
					<div class="col-lg-3">
						<input type="text" name="txtLineTelepon" value="<?php echo $dataLineTelepon; ?>" class="form-control" placeholder="Input Line Telepon"/>
		             </div>
				</div>		
			</div>
	    	<div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-2 col-md-10">
		                <button type="submit" name="btnSave" class="btn blue"><i class="fa fa-save"></i> Simpan Data</button>
		                <a href="?page=<?php echo base64_encode(extentionnumberdata) ?>" class="btn blue"><i class="fa fa-undo"></i> Batalkan</a>
			        </div>
			    </div>
			</div>
		</form>
	</div>
</div>	