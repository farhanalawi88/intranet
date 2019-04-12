<?php
	// Menghapus Data
	if(isset($_POST['btnHapus'])){
		$txtID 		= $_POST['txtID'];
		foreach ($txtID as $id_key) {
				
			$hapus=mysqli_query($koneksidb,"DELETE FROM ptkp_tr_ptkp WHERE ptkp_tr_ptkp_id='$id_key'") 
				or die ("Gagal kosongkan tmp".mysqli_errors());
			if($hapus){
				$_SESSION['info'] = 'success';
	            $_SESSION['pesan'] = 'Data pembuatan PTKP berhasil dihapus';
	            echo '<script>window.location="?page='.base64_encode(ptkpdttrptkp).'"</script>';
          	}
		
        }
	}	
	
	
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
	<div class="portlet box <?php echo $dataPanel; ?>">
	    <div class="portlet-title">
	        <div class="caption">
	            <span class="caption-subject uppercase">Data Penerimaan PTKP</span>
	        </div>
	        <div class="tools">
	            <a href="" class="collapse"> </a>
	            <a href="" class="reload"> </a>
	            <a href="" class="remove"> </a>
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
                        <th width="13%"><div align="center">NO. PTKP</div></th>
						<th width="5%"><div align="center">TGL. PTKP</div></th>
                        <th width="30%">SUMBER PTKP</th>
                        <th width="30%">KATEGORI</th>
                        <th width="15%">DIBUAT OLEH</th>
				  	  	<th width="10%"><div align="center">STATUS</div></th>
				  	  	<th width="10%"><div align="center">TINDAKAN</div></th>
                    </tr>
				</thead>
				<tbody>
               <?php
						$dataSql = "SELECT 
									a.ptkp_tr_ptkp_id,
									a.ptkp_tr_ptkp_no,
									a.ptkp_tr_ptkp_tgl,
									b.sys_role_nama,
									a.ptkp_tr_ptkp_sts,
									c.ptkp_ms_sumber_nm,
									d.sys_bagian_nm,
									f.ptkp_ms_kategori_nm
									FROM ptkp_tr_ptkp a
									INNER JOIN sys_role b ON a.ptkp_tr_ptkp_createdby=b.sys_role_id
									INNER JOIN ptkp_ms_sumber c ON a.ptkp_ms_sumber_id=c.ptkp_ms_sumber_id
									INNER JOIN sys_bagian d ON a.sys_bagian_id=d.sys_bagian_id
									INNER JOIN sys_bagian e ON b.sys_bagian_id=e.sys_bagian_id
									INNER JOIN ptkp_ms_kategori f ON a.ptkp_ms_kategori_id=f.ptkp_ms_kategori_id
									WHERE a.sys_bagian_id='".$userRow['sys_bagian_id']."'
									ORDER BY a.ptkp_tr_ptkp_id DESC";
						$dataQry = mysqli_query($koneksidb, $dataSql);
						$nomor  = 0; 
						while ($data = mysqli_fetch_array($dataQry)) {
						$nomor++;
						$Kode = $data['ptkp_tr_ptkp_id'];
						if($data ['ptkp_tr_ptkp_sts']=='Y'){
							$dataStatus= "<span class='badge badge-success badge-roundless'>CLOSE</span>";
						}elseif($data ['ptkp_tr_ptkp_sts']=='N'){
							$dataStatus= "<span class='badge badge-warning badge-roundless'>OPEN</span>";
						}elseif($data ['ptkp_tr_ptkp_sts']=='C'){
							$dataStatus= "<span class='badge badge-danger badge-roundless'>CANCEL</span>";
						}
				?>
                    <tr class="odd gradeX">
                        <td>
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="checkboxes" value="<?php echo $Kode; ?>" name="txtID[<?php echo $Kode; ?>]" />
                                <span></span>
                            </label>
                        </td>
						<td><div align="center"><?php echo $nomor ?></div></td>
						<td><div align="center"><div align="center"><?php echo $data['ptkp_tr_ptkp_no']; ?></div></td>
						<td><div align="center"><?php echo $data['ptkp_tr_ptkp_tgl']; ?></div></td>
						<td><?php echo $data['ptkp_ms_sumber_nm']; ?></td>
						<td><?php echo $data['ptkp_ms_kategori_nm']; ?></td>
						<td><?php echo strtoupper($data['sys_role_nama']); ?></td>
						<td><div align="center"><?php echo $dataStatus; ?></div></td>
						<td><div align="center"><a href="?page=<?php echo base64_encode(ptkpaddtrtrmptkp) ?>&amp;id=<?php echo base64_encode($Kode); ?>" class="btn btn-xs <?php echo $dataPanel; ?>"><i class="fa fa-edit"></i></a></div></td>
                    </tr>
                    <?php } ?>
				</tbody>
            </table>
	    </div>
	</div>
</form>
    	