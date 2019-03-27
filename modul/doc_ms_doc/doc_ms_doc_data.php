<?php
	// Menghapus Data
	if(isset($_POST['btnHapus'])){
		$txtID 		= $_POST['txtID'];
		foreach ($txtID as $id_key) {
			$sqlShow			= "SELECT * FROM doc_ms_file WHERE doc_ms_doc_id='$id_key'";
			$qryShow 			= mysqli_query($koneksidb, $sqlShow)  or die ("Query ambil data department salah : ".mysqli_errors());
			while ($dataShow	= mysqli_fetch_array($qryShow)) {
				$hapus 	= mysqli_query($koneksidb,"DELETE FROM doc_ms_file WHERE doc_ms_doc_id='$id_key'") 
							or die ("Gagal kosongkan tmp".mysqli_errors());
				$file 	= $dataShow['doc_ms_file_upload'];
				$target = "file/".$file."";
				if(file_exists($target)){
					unlink($target);
				}
			}
				
			$hapus=mysqli_query($koneksidb,"UPDATE doc_ms_doc SET doc_ms_doc_sts='D' WHERE doc_ms_doc_id='$id_key'") 
				or die ("Gagal kosongkan tmp".mysqli_errors());
			if($hapus){
				$_SESSION['info'] = 'success';
	            $_SESSION['pesan'] = 'Data master document berhasil dihapus';
	            echo '<script>window.location="?page='.base64_encode(docdtmsdoc).'"</script>';
          	}
		
        }
	}	
	
	
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
	
	<div class="portlet box <?php echo $dataPanel; ?>">
	    <div class="portlet-title">
	        <div class="caption">
	            <span class="caption-subject uppercase bold">Data Master Document</span>
	        </div>
	        <div class="actions">
				<a href="?page=<?php echo base64_encode(docaddmsdoc) ?>" class="btn <?php echo $dataPanel; ?> active"><i class="icon-plus"></i> ADD DATA </a>
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
						<th width="50"><div align="center">NO</div></th>
						<th width="100"><div align="center">NO. DOCUMENT</div></th>
                        <th width="150">BAGIAN</th>
                        <th width="150">JENIS</th>
                        <th width="400">JUDUL DOCUMENT</th>
				  	  	<th width="100"><div align="center">ACTION</div></th>
                    </tr>
				</thead>
				<tbody>
               <?php
						$dataSql = "SELECT 
										a.doc_ms_doc_kd,
										a.doc_ms_doc_id,
										a.doc_ms_doc_nm,
										a.doc_ms_doc_sts,
										b.doc_ms_kat_doc_nm,
										a.doc_ms_doc_type,
										d.sys_bagian_nm
									FROM doc_ms_doc a
									INNER JOIN doc_ms_kat_doc b ON a.doc_ms_kat_doc_id=b.doc_ms_kat_doc_id
									INNER JOIN sys_bagian d ON a.sys_bagian_id=d.sys_bagian_id
									WHERE NOT a.doc_ms_doc_sts='D'
									ORDER BY a.doc_ms_doc_id ASC";
						$dataQry = mysqli_query($koneksidb, $dataSql);
						$nomor  = 0; 
						while ($data = mysqli_fetch_array($dataQry)) {
						$nomor++;
						$ID = $data['doc_ms_doc_id'];
						if($data ['doc_ms_doc_sts']=='Y'){
							$dataStatus= "<span class='badge badge-success badge-roundless'>APPROVED</span>";
						}else{
							$dataStatus= "<span class='badge badge-warning badge-roundless'>DRAFT</span>";
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
						<td><div align="center"><?php echo $data ['doc_ms_doc_kd']; ?></div></td>
						<td><?php echo $data['sys_bagian_nm']; ?></td>
						<td><?php echo $data['doc_ms_doc_type']; ?></td>
						<td><?php echo $data['doc_ms_doc_nm']; ?></td>
						<td>
							<div align="center">
								<div class="btn-group clearfix">
									<a data-original-title="Edit" href="?page=<?php echo base64_encode(docedtmsdoc) ?>&amp;id=<?php echo base64_encode($ID); ?>" class="btn btn-xs blue tooltips"><i class="fa fa-pencil"></i></a>
									<a data-original-title="View" href="?page=<?php echo base64_encode(docviewmsdoc) ?>&amp;id=<?php echo base64_encode($ID); ?>" class="btn btn-xs green tooltips"><i class="fa fa-eye"></i></a>
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
    		