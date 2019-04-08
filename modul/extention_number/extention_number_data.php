<?php
	// Menghapus Data
	if(isset($_POST['btnHapus'])){
		$txtID 		= $_POST['txtID'];
		foreach ($txtID as $id_key) {
				
			$hapus=mysqli_query($koneksidb,"DELETE FROM ext_number WHERE id_ext_number='$id_key'") 
				or die ("Gagal kosongkan tmp".mysqli_errors());
			if($hapus){
				$_SESSION['info'] = 'success';
	            $_SESSION['pesan'] = 'Data Pembuatan Ext Telepon Berhasil Dihapus';
	            echo '<script>window.location="?page='.base64_encode(extentionnumberdata).'"</script>';
          	}		
        }
	}	
	
	
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
	<div class="portlet box <?php echo $dataPanel; ?>">
	    <div class="portlet-title">
	        <div class="caption">
	            <span class="caption-subject uppercase">Data Pembuatan Ext Telepon</span>
	        </div>
	        <div class="actions">
				<a href="?page=<?php echo base64_encode(extentionnumberadd) ?>" class="btn <?php echo $dataPanel; ?> active"><i class="icon-plus"></i> ADD DATA </a>
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
                        <th width="40%">NAMA</th>
                        <th width="30%">DEPARTEMEN</th>
                        <th width="20%">LINE TELEPON</th>
				  	  	<th width="10%"><div align="center">ACTION</div></th>
                    </tr>
				</thead>
				<tbody>
               <?php
						$dataSql = "SELECT 
									a.id_ext_number,
									a.line_telepon,
									b.nama_karyawan,
									c.sys_bagian_nm
									FROM ext_number a
									INNER JOIN sys_employee b ON a.id_employee=b.id_employee
									INNER JOIN sys_bagian c ON a.sys_bagian_id=c.sys_bagian_id
									ORDER BY a.id_ext_number DESC";
						$dataQry = mysqli_query($koneksidb, $dataSql);
						$nomor  = 0; 
						while ($data = mysqli_fetch_array($dataQry)) {
						$nomor++;
						$Kode = $data['id_ext_number'];
						//if($data ['ptkp_tr_ptkp_sts']=='Y'){
							//$dataStatus= "<span class='badge badge-success badge-roundless'>CLOSE</span>";
						//}elseif($data ['ptkp_tr_ptkp_sts']=='N'){
							//$dataStatus= "<span class='badge badge-warning badge-roundless'>OPEN</span>";
						//}elseif($data ['ptkp_tr_ptkp_sts']=='C'){
							//$dataStatus= "<span class='badge badge-danger badge-roundless'>CANCEL</span>";
						//}
				?>
                    <tr class="odd gradeX">
                        <td>
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="checkboxes" value="<?php echo $Kode; ?>" name="txtID[<?php echo $Kode; ?>]" />
                                <span></span>
                            </label>
                        </td>
                        <td><?php echo $data['nama_karyawan']; ?></td>
						<td><?php echo $data['sys_bagian_nm']; ?></td>
						<td><?php echo $data['line_telepon']; ?></td>
						<td><div align="center"><a href="?page=<?php echo base64_encode(extentionnumberedit) ?>&amp;id=<?php echo base64_encode($Kode); ?>" class="btn btn-xs <?php echo $dataPanel; ?>"><i class="fa fa-pencil"></i></a></div></td>
                    </tr>
                    <?php
                        
                    }
                    ?>
				</tbody>
            </table>
	    </div>
	</div>
</form>
    	