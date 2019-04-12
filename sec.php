<?php 
	$dataBagian		= isset($_POST['cmbBagian']) ? $_POST['cmbBagian'] : '';
?>
<div class="portlet box blue-chambray">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject uppercase">Data Education Center</span>
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse"></a>
            <a href="javascript:;" class="reload"></a>
            <a href="javascript:;" class="remove"></a>
        </div>
	</div>
	<div class="portlet-body">
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal form-bordered" autocomplete="off" name="form1">
        	<div class="form-body">
				<div class="form-group">
					<label class="col-lg-2 control-label">Nama Bagian :</label>
					<div class="col-lg-4">
						<select name="cmbBagian" data-placeholder="- Pilih Bagian -" class="select2 form-control">
							<option value=""></option> 
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
		             <div class="col-lg-4">
		             	<button type="submit" name="btnCari" class="btn blue-chambray"><i class="fa fa-search"></i> Tampilkan</button>
		             	<?php
		             	if(isset($_POST['btnCari'])){

		             	?>
		             	<a href="?page=<?php echo base64_encode(sec) ?>" class="btn blue-chambray"><i class="fa fa-undo"></i> Reset </a>
		             	<?php } ?>
		             </div>
				</div>
			</div>
		</form>
		<div class="batas2"></div>
       	<table class="table table-striped table-hover table-checkable order-column" id="sample_1">
			<thead>
                <tr class="active">
			  	  	<th width="5%"><div align="center">LIHAT</div></th>
					<th width="5%"><div align="center">NO</div></th>
					<th width="10%">TGL. DIBUAT</th>
					<th width="20%">NAMA BAGIAN</th>
                    <th width="50%">NAMA & JUDUL</th>
                </tr>
			</thead>
			<tbody>
           <?php
       			if(isset($_POST['btnCari'])){
					$dataSql = "SELECT * FROM as_sec a
								INNER JOIN sys_bagian b ON a.sys_bagian_id=b.sys_bagian_id
								WHERE as_sec_sts='Y'
								AND a.sys_bagian_id='$dataBagian'
								ORDER BY a.as_sec_id DESC";
				}else{
					$dataSql = "SELECT * FROM as_sec a
								INNER JOIN sys_bagian b ON a.sys_bagian_id=b.sys_bagian_id
								WHERE as_sec_sts='Y'
								ORDER BY a.as_sec_id DESC";
				}
				$dataQry = mysqli_query($koneksidb, $dataSql);
				$nomor  = 0; 
				while ($data = mysqli_fetch_array($dataQry)) {
				$nomor++;
				$Kode = $data['as_sec_id'];
				if($data ['as_sec_sts']=='Y'){
					$dataStatus= "<span class='badge badge-success badge-roundless'>ACTIVE</span>";
				}else{
					$dataStatus= "<span class='badge badge-danger badge-roundless'>NON ACTIVE</span>";
				}
			?>
                <tr class="odd gradeX">
					<td><div align="center"><a href="?page=<?php echo base64_encode(secview) ?>&amp;id=<?php echo base64_encode($Kode); ?>" class="btn btn-xs grey-cascade"><i class="fa fa-eye"></i></a></div></td>
					<td><div align="center"><?php echo $nomor ?></div></td>
					<td><?php echo IndonesiaTgl2($data ['as_sec_tgl']); ?></td>
					<td><?php echo $data['sys_bagian_nm']; ?></td>
					<td><?php echo $data['as_sec_name']; ?></td>
                </tr>
                <?php  }  ?>
			</tbody>
        </table>
    </div>
</div>
    	