<?php
			
	if(isset($_POST['btnHapus'])){
		$txtID 		= $_POST['txtID'];
		foreach ($txtID as $id_key) {
				
			$hapus=mysqli_query($koneksidb, "UPDATE as_trx_periksa SET as_trx_periksa_sts='C' WHERE as_trx_periksa_id='$id_key' AND as_trx_periksa_sts='N'") 
				or die ("Gagal kosongkan tmp".mysqli_error());
				
			if($hapus){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data pemeriksaan berhasil dibatalkan';
				echo '<script>window.location="?page='.base64_encode(dttrperiksa).'"</script>';
			}	
					
		}
	}
 ?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
	<div class="portlet box <?php echo $dataPanel; ?>">
		<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase">Data Item Pemeriksaan</span></div>
			<div class="actions">
				<a href="?page=<?php echo base64_encode(addtrperiksa) ?>" class="btn <?php echo $dataPanel; ?> active"><i class="icon-plus"></i> ADD DATA</a>	
				<button class="btn <?php echo $dataPanel; ?> active" name="btnHapus" type="submit" onclick="return confirm('Anda yakin ingin membatalkan data penting ini !!')"><i class="icon-trash"></i> BATALKAN</button>
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
                        <th width="15%">NAMA BAGIAN</th>
                        <th width="10%"><div align="center">TANGGAL</div></th>
						<th width="15%">AUDITOR</th>
						<th width="40%">ITEM PEMERIKSAAN</th>
			  	  	  	<th width="10%"><div align="center">STATUS</div></th>
			  	  	  	<th width="5%"><div align="center">ACTION</div></th>
                    </tr>
				</thead>
				<tbody>
                    <?php
						$dataSql = "SELECT * FROM as_trx_periksa a
									LEFT JOIN sys_org b ON a.sys_org_id=b.sys_org_id
									LEFT JOIN sys_bagian c ON a.sys_bagian_id=c.sys_bagian_id
									INNER JOIN sys_role d ON a.as_trx_periksa_createdby=d.sys_role_id
									ORDER BY a.as_trx_periksa_id DESC";
						$dataQry = mysqli_query($koneksidb, $dataSql)  or die ("Query petugas salah : ".mysqli_error());
						$nomor  = 0; 
						while ($data = mysqli_fetch_array($dataQry)) {
						$nomor++;
						$Kode = $data['as_trx_periksa_id'];
						if($data ['as_trx_periksa_sts']=='N'){
							$dataStatus	= "<label class='badge badge-info badge-roundless'>PEMERIKSAAN</label>";
							$disabled 	= "";
						}elseif($data ['as_trx_periksa_sts']=='Y'){
							$dataStatus= "<label class='badge badge-warning badge-roundless'>PTKP</label>";
							$disabled 	= "";
						}elseif($data ['as_trx_periksa_sts']=='C'){
							$dataStatus= "<label class='badge badge-danger badge-roundless'>CANCEL</label>";
							$disabled 	= "disabled";
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
						<td><?php echo $data ['sys_bagian_nm']; ?></td>
						<td><div align="center"><?php echo IndonesiaTgl2($data ['as_trx_periksa_tgl']); ?></div></td>
						<td><?php echo $data ['as_trx_periksa_auditor']; ?></td>
						<td><?php echo $data ['as_trx_periksa_item']; ?></td>
						<td><div align="center"><?php echo $dataStatus; ?></div></td>
						<td><div align="center">
							<div class="btn-group">
								<a href="?page=<?php echo base64_encode(edttrperiksa) ?>&amp;id=<?php echo base64_encode($Kode); ?>" class="btn <?php echo $dataPanel; ?> btn-xs <?php echo $disabled ?>"><i class="fa fa-pencil"></i></a>
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