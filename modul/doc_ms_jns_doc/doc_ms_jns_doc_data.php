<?php
	// Menghapus Data
	if(isset($_POST['btnHapus'])){
		$txtID 		= $_POST['txtID'];
		foreach ($txtID as $id_key) {
				
			$hapus=mysqli_query($koneksidb,"DELETE FROM doc_ms_jns_doc WHERE doc_ms_jns_doc_id='$id_key'") 
				or die ("Gagal kosongkan tmp".mysqli_errors());
			if($hapus){
				$_SESSION['info'] = 'success';
	            $_SESSION['pesan'] = 'Data jenis dokumen berhasil dihapus';
	            echo '<script>window.location="?page='.base64_encode(docdtmsjnsdoc).'"</script>';
          	}
		
        }
	}	
	
	
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
	<div class="portlet box <?php echo $dataPanel; ?>">
	    <div class="portlet-title">
	        <div class="caption">
	            <span class="caption-subject uppercase bold">Data Jenis Dokumen</span>
	        </div>
	        <div class="actions">
				<a href="?page=<?php echo base64_encode(docaddmsjnsdoc) ?>" class="btn <?php echo $dataPanel; ?> active"><i class="icon-plus"></i> ADD DATA </a>
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
						<th width="5%">KODE</th>
                        <th width="30%">JENIS DOKUMEN</th>
                        <th width="30%">TINGKATAN DOKUMEN</th>
                        <th width="30%">DIBUAT OLEH</th>
				  	  	<th width="10%"><div align="center">STATUS</div></th>
				  	  	<th width="10%"><div align="center">ACTION</div></th>
                    </tr>
				</thead>
				<tbody>
               <?php
						$dataSql = "SELECT * FROM doc_ms_jns_doc a
									INNER JOIN sys_role b ON a.doc_ms_jns_doc_createdby=b.sys_role_id
									ORDER BY a.doc_ms_jns_doc_id DESC";
						$dataQry = mysqli_query($koneksidb, $dataSql);
						$nomor  = 0; 
						while ($data = mysqli_fetch_array($dataQry)) {
						$nomor++;
						$Kode = $data['doc_ms_jns_doc_id'];
						if($data ['doc_ms_jns_doc_sts']=='Y'){
							$dataStatus= "<span class='badge badge-success badge-roundless'>ACTIVE</span>";
						}else{
							$dataStatus= "<span class='badge badge-danger badge-roundless'>NON ACTIVE</span>";
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
						<td><?php echo $data ['doc_ms_jns_doc_kd']; ?></td>
						<td><?php echo $data['doc_ms_jns_doc_nm']; ?></td>
						<td>DOKUMEN TINGKAT <?php echo $data['doc_ms_jns_doc_tingkat']; ?></td>
						<td><?php echo strtoupper($data['sys_role_nama']); ?></td>
						<td><div align="center"><?php echo $dataStatus; ?></div></td>
						<td><div align="center"><a href="?page=<?php echo base64_encode(docedtmsjnsdoc) ?>&amp;id=<?php echo base64_encode($Kode); ?>" class="btn btn-xs <?php echo $dataPanel; ?>"><i class="fa fa-pencil"></i></a></div></td>
                    </tr>
                    <?php
                        
                    }
                    ?>
				</tbody>
            </table>
	    </div>
	</div>
</form>
    	