<?php
			
	if(isset($_POST['btnHapus'])){
		$txtID 		= $_POST['txtID'];
		foreach ($txtID as $id_key) {
				
			$hapus=mysqli_query($koneksidb, "UPDATE tic_tr_ticket SET tic_tr_ticket_sts='C' WHERE tic_tr_ticket_id='$id_key' AND tic_tr_ticket_sts='N'") 
				or die ("Gagal kosongkan tmp".mysqli_error());
				
			if($hapus){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data ticket berhasil dibatalkan';
				echo '<script>window.location="?page='.base64_encode(ticdttic).'"</script>';
			}	
					
		}
	}
 ?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
	<div class="portlet box <?php echo $dataPanel; ?>">
		<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase">Data Ticket</span></div>
			<div class="actions">
				<a href="?page=<?php echo base64_encode(ticaddtic) ?>" class="btn <?php echo $dataPanel; ?> active"><i class="icon-plus"></i> ADD DATA</a>	
				<button class="btn <?php echo $dataPanel; ?> active" name="btnHapus" type="submit" onclick="return confirm('Anda yakin ingin membatalkan data penting ini !!')"><i class="icon-trash"></i> DELETE DATA</button>
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
                        <th width="2%"><div align="center">NO</div></th>
                        <th width="10%"><div align="center">NOMOR TICKET</div></th>
                        <th width="15%"><div align="center">TICKET DATE</div></th>
						<th width="15%">REQUESTER</th>
						<th width="20%">CATEGORY</th>
						<th width="20%">TYPE</th>
			  	  	  	<th width="5%"><div align="center">STATUS</div></th>
			  	  	  	<th width="5%"><div align="center">ACTION</div></th>
                    </tr>
				</thead>
				<tbody>
                    <?php
						$dataSql = "SELECT * FROM tic_tr_ticket a
									LEFT JOIN tic_ms_kat b ON a.tic_ms_kat_id=b.tic_ms_kat_id
									LEFT JOIN tic_ms_modul d ON a.tic_ms_modul_id=d.tic_ms_modul_id
									WHERE a.sys_bagian_id='".$userRow['sys_bagian_id']."'
									ORDER BY a.tic_tr_ticket_id DESC";
						$dataQry = mysqli_query($koneksidb, $dataSql)  or die ("Query petugas salah : ".mysqli_error());
						$nomor  = 0; 
						while ($data = mysqli_fetch_array($dataQry)) {
						$nomor++;
						$Kode = $data['tic_tr_ticket_id'];
						if($data ['tic_tr_ticket_sts']=='N'){
							$dataStatus= "<label class='badge badge-warning badge-roundless'>PENDING</label>";
						}elseif($data ['tic_tr_ticket_sts']=='Y'){
							$dataStatus= "<label class='badge badge-success badge-roundless'>SOLVED</label>";
						}elseif($data ['tic_tr_ticket_sts']=='C'){
							$dataStatus= "<label class='badge badge-danger badge-roundless'>CANCEL</label>";
						}

						if($data ['tic_tr_ticket_sts']=='N'){
							$disabled ="";
						}else{
							$disabled ="disabled";
						}
					?>
                   <tr class="odd gradeX">
                        <td>
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="checkboxes" value="<?php echo $Kode; ?>" name="txtID[<?php echo $Kode; ?>]" />
                                <span></span>
                            </label>
                        </td>
						<td><div align="center"><?php echo $nomor; ?></div></td>
						<td><div align="center"><?php echo $data ['tic_tr_ticket_no']; ?></div></td>

						<td><div align="center"><?php echo date('d/m/Y H:i',strtotime($data ['tic_tr_ticket_tgl_start'])); ?></div></td>
						<td><?php echo $data ['tic_tr_ticket_diminta']; ?></td>
						<td><?php echo $data ['tic_ms_kat_nm']; ?></td>
						<td><?php echo $data ['tic_ms_modul_nm']; ?></td>
						<td><div align="center"><?php echo $dataStatus; ?></div></td>
						<td><div align="center">
							<div class="btn-group">
								<a href="?page=<?php echo base64_encode(ticedttic) ?>&amp;id=<?php echo base64_encode($Kode); ?>" class="btn <?php echo $dataPanel; ?> btn-xs <?php echo $disabled ?>"><i class="fa fa-pencil"></i></a>
							</div>
							</div>
						</td>
                    </tr>
                    <?php } ?>
				</tbody>
            </table>
		</div>
	</div>
</form>
<style>
    .disabled {
        pointer-events: none;
        cursor: default;
    }
</style>