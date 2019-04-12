<?php
			
	if(isset($_POST['btnHapus'])){
		$txtID 		= $_POST['txtID'];
		foreach ($txtID as $id_key) {
				
			$hapus=mysqli_query($koneksidb, "DELETE FROM load_ms_identitas WHERE load_ms_identitas_id='$id_key'");
				
			if($hapus){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data petugas berhasil dihapus';
				echo '<script>window.location="?page='.base64_encod(loaddtmspetugas).'"</script>';
			}	
					
		}
	}
 ?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
	<div class="portlet box <?php echo $dataPanel; ?>">
		<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase">Data Identitas</span></div>
			<div class="actions">
				<a href="?page=<?php echo base64_encode(loadaddmspetugas) ?>" class="btn <?php echo $dataPanel; ?> active"><i class="icon-plus"></i> ADD DATA</a>	
				<button class="btn <?php echo $dataPanel; ?> active" name="btnHapus" type="submit" onclick="return confirm('Anda yakin ingin menghapus data penting ini !!')"><i class="icon-trash"></i> DELETE DATA</button>
			</div>
		</div>
		<div class="portlet-body">
			<table class="table table-hover table-checkable order-column" id="sample_2">
				<thead>
                    <tr class="active">
       	  	  	  	  	<th class="table-checkbox" width="3%">
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" />
                                <span></span>
                            </label>
                        </th>
                        <th width="5%"><div align="center">NO</div></th>
                        <th width="60%">NAMA IDENTITAS</th>
						<th width="10%"><div align="center">STATUS</div></th>
			  	  	  	<th width="10%"><div align="center">AKSI</div></th>
                    </tr>
				</thead>
				<tbody>
                    <?php
						$dataSql = "SELECT * FROM load_ms_identitas ORDER BY load_ms_identitas_id DESC";
						$dataQry = mysqli_query($koneksidb, $dataSql);
						$nomor  = 0; 
						while ($data = mysqli_fetch_array($dataQry)) {
						$nomor++;
						$Kode = $data['load_ms_identitas_id'];
						if($data['load_ms_identitas_sts']=='Y'){
							$dataStatus		= '<label class="badge badge-success badge-roundless">ACTIVE</label>';
						}else{
							$dataStatus		= '<label class="badge badge-danger badge-roundless">NON ACTIVE</label>';
						}
					?>
                   <tr>
                        <td>
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="checkboxes" value="<?php echo $Kode; ?>" name="txtID[<?php echo $Kode; ?>]" />
                                <span></span>
                            </label>
                        </td>
						<td><div align="center"><?php echo $nomor; ?></div></td>
						<td><?php echo $data ['load_ms_identitas_nm']; ?></td>
						<td><div align="center"><?php echo $dataStatus; ?></div></td>
                        <td><div align="center"><a href="?page=<?php echo base64_encode(loadedtmspetugas) ?>&amp;id=<?php echo $Kode; ?>" class="btn <?php echo $dataPanel; ?> btn-xs"><i class="icon-book-open"></i></a></div></td>
                    </tr>
                    <?php } ?>
				</tbody>
            </table>
		</div>
	</div>
</form>