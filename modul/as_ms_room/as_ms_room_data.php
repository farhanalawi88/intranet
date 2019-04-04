<?php
	// Menghapus Data
	if(isset($_POST['btnHapus'])){
		$txtID 		= $_POST['txtID'];
		foreach ($txtID as $id_key) {
				
			$hapus=mysqli_query($koneksidb,"DELETE FROM as_ms_room WHERE as_ms_room_id='$id_key'") 
				or die ("Gagal kosongkan tmp".mysqli_errors());
			if($hapus){
				$_SESSION['info'] = 'success';
	            $_SESSION['pesan'] = 'Data Meeting Room Berhasil Dihapus';
	            echo '<script>window.location="?page='.base64_encode(masterroomdata).'"</script>';
          	}		
        }
	}	
	
	
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
	<div class="portlet box <?php echo $dataPanel; ?>">
	    <div class="portlet-title">
	        <div class="caption">
	            <span class="caption-subject uppercase">Data Meeting Room</span>
	        </div>
	        <div class="actions">
				<a href="?page=<?php echo base64_encode(masterroomadd) ?>" class="btn <?php echo $dataPanel; ?> active"><i class="icon-plus"></i> ADD DATA </a>
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
                        <th width="30%">NAMA RUANG MEETING</th>
                        <th width="30%">KETERANGAN</th>
                        <th width="20%">DIBUAT OLEH</th>
				  	  	<th width="10%"><div align="center">STATUS</div></th>
				  	  	<th width="10%"><div align="center">ACTION</div></th>
                    </tr>
				</thead>
				<tbody>
               <?php
						$dataSql = "SELECT * FROM as_ms_room a
									INNER JOIN sys_role b ON a.as_ms_room_createdby=b.sys_role_id
									ORDER BY a.as_ms_room_id DESC";
						$dataQry = mysqli_query($koneksidb, $dataSql);
						$nomor  = 0; 
						while ($data = mysqli_fetch_array($dataQry)) {
						$nomor++;
						$Kode = $data['as_ms_room_id'];
						if($data ['as_ms_room_status']=='Y'){
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
						<td><div align="center"><?php echo $nomor; ?></div></td>
						<td><?php echo $data['as_ms_room_nama']; ?></td>
						<td><?php echo $data['as_ms_room_keterangan']; ?></td>
						<td><?php echo strtoupper($data['sys_role_nama']); ?></td>
						<td><div align="center"><?php echo $dataStatus; ?></div></td>
						<td><div align="center"><a href="?page=<?php echo base64_encode(masterroomedit) ?>&amp;id=<?php echo base64_encode($Kode); ?>" class="btn btn-xs <?php echo $dataPanel; ?>"><i class="fa fa-pencil"></i></a></div></td>
                    </tr>
                    <?php
                        
                    }
                    ?>
				</tbody>
            </table>
	    </div>
	</div>
</form>
    	