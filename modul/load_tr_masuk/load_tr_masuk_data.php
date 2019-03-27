<?php
			
	if(isset($_POST['btnHapus'])){
		$txtID 		= $_POST['txtID'];
		foreach ($txtID as $id_key) {
				
			$hapus=mysqli_query($koneksidb, "DELETE FROM load_tr_inout WHERE load_tr_inout_id='$id_key'");
				
			if($hapus){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data masuk kendaraan berhasil dihapus';
				echo '<script>window.location="?page='.base64_encode(loaddttrmasuk).'"</script>';
			}	
					
		}
	}
 ?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
	<div class="portlet box <?php echo $dataPanel; ?>">
		<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase bold">Data Masuk Kendaraan</span></div>
			<div class="actions">
				<a href="?page=<?php echo base64_encode(loadaddtrmasuk) ?>" class="btn <?php echo $dataPanel; ?> active"><i class="icon-plus"></i> ADD DATA</a>	
				<button class="btn <?php echo $dataPanel; ?> active" name="btnHapus" type="submit" onclick="return confirm('Anda yakin ingin menghapus data penting ini !!')"><i class="icon-trash"></i> DELETE DATA</button>
			</div>
		</div>
		<div class="portlet-body">
			<table class="table table-bordered table-hover table-checkable order-column" id="sample_2">
				<thead>
                    <tr class="active">
       	  	  	  	  	<th class="table-checkbox" width="3%">
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" />
                                <span></span>
                            </label>
                        </th>
                        <th width="5%"><div align="center">NO</div></th>
                        <th width="15%"><div align="center">NO. REG</div></th>
                        <th width="10%"><div align="center">NO. KARTU</div></th>
                        <th width="15%"><div align="center">TGL. MASUK</div></th>
                        <th width="20%">JENIS KENDARAAN</th>
                        <th width="15%">NO. KENDARAAN</th>
						<th width="10%"><div align="center">STATUS</div></th>
			  	  	  	<th width="10%"><div align="center">AKSI</div></th>
                    </tr>
				</thead>
				<tbody>
                    <?php
						$dataSql = "SELECT 
									convert(char(10),a.load_tr_inout_tgl_masuk,103) as load_tr_inout_tgl_masuk,
									convert(char(10),a.load_tr_inout_tgl_masuk,108) as load_tr_inout_jam_masuk,
									b.load_ms_jns_kend_nm,
									c.load_ms_petugas_nm,
									a.load_tr_inout_reg,
									a.load_tr_inout_nopol,
									a.load_tr_inout_sts,
									a.load_tr_inout_id,
									a.load_tr_inout_card
									FROM load_tr_inout a 
									INNER JOIN load_ms_jns_kend b ON a.load_ms_jns_kend_id=b.load_ms_jns_kend_id
									LEFT JOIN load_ms_petugas c ON a.load_ms_petugas_id=c.load_ms_petugas_id
									ORDER BY a.load_tr_inout_id DESC";
						$dataQry = mysqli_query($koneksidb, $dataSql);
						$nomor  = 0; 
						while ($data = mysqli_fetch_array($dataQry)) {
						$nomor++;
						$Kode = $data['load_tr_inout_id'];
						if($data['load_tr_inout_sts']=='Y'){
							$dataStatus		= '<label class="badge badge-success badge-roundless">CLOSE</label>';
						}else{
							$dataStatus		= '<label class="badge badge-warning badge-roundless">OPEN</label>';
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
						<td><div align="center"><?php echo $data['load_tr_inout_reg']; ?></div></td>
						<td><div align="center"><?php echo $data['load_tr_inout_card']; ?></div></td>
						<td><div align="center"><?php echo $data['load_tr_inout_tgl_masuk']; ?> <?php echo $data['load_tr_inout_jam_masuk']; ?></div></td>
						<td><?php echo $data ['load_ms_jns_kend_nm']; ?></td>
						<td><?php echo $data ['load_tr_inout_nopol']; ?></td>
						<td><div align="center"><?php echo $dataStatus; ?></div></td>
                        <td><div align="center"><a href="?page=<?php echo base64_encode(loadedttrmasuk) ?>&amp;id=<?php echo $Kode; ?>" class="btn <?php echo $dataPanel; ?> btn-xs"><i class="icon-book-open"></i></a></div></td>
                    </tr>
                    <?php } ?>
				</tbody>
            </table>
		</div>
	</div>
</form>