<?php
			
	if(isset($_POST['btnHapus'])){
		$txtID 		= $_POST['txtID'];
		foreach ($txtID as $id_key) {
				
			$hapus=mysqli_query($koneksidb, "DELETE FROM tic_ms_kat WHERE tic_ms_kat_id='$id_key'");
				
			if($hapus){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data kategori ticket berhasil dihapus';
				echo '<script>window.location="?page='.base64_encod(ticdtktgr).'"</script>';
			}	
					
		}
	}
 ?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
	<div class="portlet box <?php echo $dataPanel; ?>">
		<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase bold">Data Kategori Ticket</span></div>
			<div class="actions">
				<a href="?page=<?php echo base64_encode(ticaddktgr) ?>" class="btn <?php echo $dataPanel; ?> active"><i class="icon-plus"></i> ADD DATA</a>	
				<button class="btn <?php echo $dataPanel; ?> active" name="btnHapus" type="submit" onclick="return confirm('Anda yakin ingin menghapus data penting ini !!')"><i class="icon-trash"></i> DELETE DATA</button>
			</div>
		</div>
		<div class="portlet-body">
			<table class="table table-striped table-hover table-checkable order-column" id="sample_2">
				<thead>
                    <tr class="active">
       	  	  	  	  	<th class="table-checkbox" width="3%">
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" />
                                <span></span>
                            </label>
                        </th>
                        <th width="5%"><div align="center">NO</div></th>
                        <th width="60%">NAMA KATEGORI</th>
						<th width="10%"><div align="center">STATUS</div></th>
			  	  	  	<th width="10%"><div align="center">AKSI</div></th>
                    </tr>
				</thead>
				<tbody>
                    <?php
						$dataSql = "SELECT * FROM tic_ms_kat ORDER BY tic_ms_kat_id DESC";
						$dataQry = mysqli_query($koneksidb, $dataSql);
						$nomor  = 0; 
						while ($data = mysqli_fetch_array($dataQry)) {
						$nomor++;
						$Kode = $data['tic_ms_kat_id'];
					?>
                   <tr>
                        <td>
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="checkboxes" value="<?php echo $Kode; ?>" name="txtID[<?php echo $Kode; ?>]" />
                                <span></span>
                            </label>
                        </td>
						<td><div align="center"><?php echo $nomor; ?></div></td>
						<td><?php echo $data ['tic_ms_kat_nm']; ?></td>
						<td><div align="center"><?php echo $data ['tic_ms_kat_sts']; ?></div></td>
                        <td><div align="center"><a href="?page=<?php echo base64_encode(ticedtktgr) ?>&amp;id=<?php echo $Kode; ?>" class="btn <?php echo $dataPanel; ?> btn-xs"><i class="fa fa-pencil"></i></a></div></td>
                    </tr>
                    <?php } ?>
				</tbody>
            </table>
		</div>
	</div>
</form>