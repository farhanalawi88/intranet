<?php
	// Menghapus Data
	if(isset($_POST['btnHapus'])){
		$txtID 		= $_POST['txtID'];
		foreach ($txtID as $id_key) {
				
			$hapus=mysqli_query($koneksidb,"DELETE FROM sys_bagian WHERE sys_bagian_id='$id_key'") 
				or die ("Gagal kosongkan tmp".mysqli_errors());
			if($hapus){
				$_SESSION['info'] = 'success';
	            $_SESSION['pesan'] = 'Data bagian berhasil dihapus';
	            echo '<script>window.location="?page='.base64_encode(dtbagian).'"</script>';
          	}
		
        }
	}	
	
	
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
	<div class="portlet box <?php echo $dataPanel; ?>">
	    <div class="portlet-title">
	        <div class="caption">
	            <span class="caption-subject uppercase bold">Data Bagian & Department</span>
	        </div>
	        <div class="actions">
				<a href="?page=<?php echo base64_encode(addbagian) ?>" class="btn <?php echo $dataPanel; ?> active"><i class="icon-plus"></i> ADD DATA </a>
				<button class="btn <?php echo $dataPanel; ?> active" name="btnHapus" type="submit" onclick="return confirm('Anda yakin ingin menghapus data penting ini !!')"><i class="icon-trash"></i> DELETE DATA</button>
			</div>
		</div>
    	<div class="portlet-body">
           <table class="table table-striped table-hover table-checkable order-column" id="sample_2">
				<thead>
                    <tr class="active">
       	  	  	  	  	<th class="table-checkbox">
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" />
                                <span></span>
                            </label>
                        </th>
						<th width="5%"><div align="center">NO</div></th>
						<th width="5%"><div align="center">KODE</div></th>
                        <th width="30%">NAMA BAGIAN</th>
                        <th width="30%">KETERANGAN</th>
                        <th width="30%">DIBUAT OLEH</th>
				  	  	<th width="10%"><div align="center">STATUS</div></th>
				  	  	<th width="10%"><div align="center">ACTION</div></th>
                    </tr>
				</thead>
				<tbody>
               <?php
						$dataSql = "SELECT 
										a.sys_bagian_id,
										a.sys_bagian_nm,
										a.sys_bagian_ket,
										a.sys_bagian_sts,
										a.sys_bagian_kd,
										b.sys_role_nama
									FROM sys_bagian a
									INNER JOIN sys_role b ON a.sys_bagian_createdby=b.sys_role_id
									ORDER BY a.sys_bagian_id DESC";
						$dataQry = mysqli_query($koneksidb, $dataSql);
						$nomor  = 0; 
						while ($data = mysqli_fetch_array($dataQry)) {
						$nomor++;
						$ID = $data['sys_bagian_id'];
						if($data ['sys_bagian_sts']=='Y'){
							$dataStatus= "<span class='badge badge-success badge-roundless'>ACTIVE</span>";
						}else{
							$dataStatus= "<span class='badge badge-danger badge-roundless'>NON ACTIVE</span>";
						}
				?>
                    <tr class="odd gradeX">
                        <td>
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="checkboxes" value="<?php echo $ID; ?>" name="txtID[<?php echo $ID; ?>]" />
                                <span></span>
                            </label>
                        </td>
						<td><div align="center"><?php echo $nomor ?></div></td>
						<td><div align="center"><?php echo $data ['sys_bagian_kd']; ?></div></td>
						<td><?php echo $data['sys_bagian_nm']; ?></td>
						<td><?php echo $data['sys_bagian_ket']; ?></td>
						<td><?php echo strtoupper($data['sys_role_nama']); ?></td>
						<td><div align="center"><?php echo $dataStatus; ?></div></td>
						<td><div align="center"><a href="?page=<?php echo base64_encode(edtbagian) ?>&amp;id=<?php echo base64_encode($ID); ?>" class="btn btn-xs <?php echo $dataPanel; ?>"><i class="fa fa-pencil"></i></a></div></td>
                    </tr>
                    <?php } ?>
				</tbody>
            </table>
	    </div>
	</div>
</form>
    	