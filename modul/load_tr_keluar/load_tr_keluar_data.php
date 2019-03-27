<?php
			
	if(isset($_POST['btnHapus'])){
		$txtID 		= $_POST['txtID'];
		foreach ($txtID as $id_key) {
				
			$hapus=mysqli_query($koneksidb, "UPDATE load_tr_inout SET load_tr_inout_sts='N' WHERE load_tr_inout_id='$id_key'");
				
			if($hapus){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data keluar kendaraan berhasil dihapus';
				echo '<script>window.location="?page='.base64_encode(loaddttrkeluar).'"</script>';
			}	
					
		}
	}
 ?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
	<div class="portlet box <?php echo $dataPanel; ?>">
		<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase bold">Data Keluar Kendaraan</span></div>
			<div class="actions">
				<a href="?page=<?php echo base64_encode(loadcardtrkeluar) ?>" class="btn <?php echo $dataPanel; ?> active"><i class="icon-plus"></i> ADD DATA</a>	
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
                        <th width="15%"><div align="center">TGL. KELUAR</div></th>
                        <th width="20%">KENDARAAN</th>
                        <th width="10%">NO. KENDARAAN</th>
                        <th width="15%">WAKTU</th>
						<th width="10%"><div align="center">STATUS</div></th>
			  	  	  	<th width="10%"><div align="center">AKSI</div></th>
                    </tr>
				</thead>
				<tbody>
                    <?php
						$dataSql = "SELECT 
									convert(char(10),a.load_tr_inout_tgl_keluar,103) as load_tr_inout_tgl_keluar,
									convert(char(10),a.load_tr_inout_tgl_keluar,108) as load_tr_inout_jam_keluar,
									b.load_ms_jns_kend_nm,
									c.load_ms_petugas_nm,
									a.load_tr_inout_reg,
									a.load_tr_inout_nopol,
									a.load_tr_inout_sts,
									a.load_tr_inout_id,
									a.load_tr_inout_card,
									convert(char(15),a.load_tr_inout_tgl_load,120) as load_tr_inout_tgl_load,
									convert(char(15),a.load_tr_inout_tgl_unload,120) as load_tr_inout_tgl_unload
									FROM load_tr_inout a 
									INNER JOIN load_ms_jns_kend b ON a.load_ms_jns_kend_id=b.load_ms_jns_kend_id
									LEFT JOIN load_ms_petugas c ON a.load_ms_petugas_id=c.load_ms_petugas_id
									WHERE load_tr_inout_sts='Y'
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

						$awal  = strtotime($data['load_tr_inout_tgl_load']);
						$akhir = strtotime($data['load_tr_inout_tgl_unload']);
						$diff  = $akhir - $awal;

						$jam   = floor($diff / (60 * 60));
						$menit = $diff - $jam * (60 * 60);
						$dataSelisih =  $jam .  ' JAM, ' . floor( $menit / 60 ) . ' MENIT';
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
						<td><div align="center"><?php echo $data['load_tr_inout_tgl_keluar']; ?> <?php echo $data['load_tr_inout_jam_keluar']; ?></div></td>
						<td><?php echo $data ['load_ms_jns_kend_nm']; ?></td>
						<td><?php echo $data ['load_tr_inout_nopol']; ?></td>
						<td><?php echo $dataSelisih; ?></td>
						<td><div align="center"><?php echo $dataStatus; ?></div></td>
                        <td><div align="center"><a href="?page=<?php echo base64_encode(loadedttrkeluar) ?>&amp;id=<?php echo $Kode; ?>" class="btn <?php echo $dataPanel; ?> btn-xs"><i class="icon-book-open"></i></a></div></td>
                    </tr>
                    <?php } ?>
				</tbody>
            </table>
		</div>
	</div>
</form>