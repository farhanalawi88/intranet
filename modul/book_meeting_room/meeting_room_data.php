<?php
	// Menghapus Data
	if(isset($_POST['btnHapus'])){
		$txtID 		= $_POST['txtID'];
		foreach ($txtID as $id_key) {
				
			$hapus=mysqli_query($koneksidb,"DELETE FROM book_meeting_room WHERE id_booking_meeting='$id_key'") 
				or die ("Gagal kosongkan tmp".mysqli_errors());
			if($hapus){
				$_SESSION['info'] = 'success';
	            $_SESSION['pesan'] = 'Data Pembuatan Booking Meeting Room Berhasil Dihapus';
	            echo '<script>window.location="?page='.base64_encode(bookmeetingroomdata).'"</script>';
          	}		
        }
	}	
	
	
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
	<div class="portlet box blue">
	    <div class="portlet-title">
	        <div class="caption">
	            <span class="caption-subject uppercase bold">Data Pembuatan Booking Meeting Room</span>
	        </div>
	        <div class="actions">
				<a href="?page=<?php echo base64_encode(bookmeetingroomadd) ?>" class="btn blue active"><i class="icon-plus"></i> ADD DATA </a>
				<button class="btn blue active" name="btnHapus" type="submit" onclick="return confirm('Anda yakin ingin menghapus data penting ini !!')"><i class="icon-trash"></i> DELETE DATA</button>
			</div>
		</div>
    	<div class="portlet-body">
           <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_2">
				<thead>
                    <tr class="active">
       	  	  	  	  	<th class="table-checkbox">
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" />
                                <span></span>
                            </label>
                        </th>
                        <th width="13%"><div align="center">AGENDA</div></th>
						<th width="5%"><div align="center">START DATE</div></th>
                        <th width="15%">END DATE</th>
                        <th width="20%">MEETING ROOM</th>
                        <th width="30%">PESERTA MEETING</th>
                        <th width="30%">NOTULEN</th>
				  	  	<th width="10%"><div align="center">ACTION</div></th>
                    </tr>
				</thead>
				<tbody>
               <?php
						$dataSql = "SELECT 
									a.id_booking_meeting,
									a.agenda,
									a.start_date,
									a.end_date,
									a.peserta_meeting,
									a.notulen,
									b.nama_ruang_meeting
									FROM book_meeting_room a
									INNER JOIN book_master_room b ON a.id_room=b.id_room
									ORDER BY a.id_booking_meeting DESC";
						$dataQry = mysqli_query($koneksidb, $dataSql);
						$nomor  = 0; 
						while ($data = mysqli_fetch_array($dataQry)) {
						$nomor++;
						$Kode = $data['id_booking_meeting'];
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
						<td><div align="center"><?php echo $data['agenda']; ?></div></td>
						<td><?php echo $data['start_date']; ?></td>
						<td><?php echo $data['end_date']; ?></td>
						<td><?php echo $data['nama_ruang_meeting']; ?></td>
						<td><?php echo $data['peserta_meeting']; ?></td>
						<td><?php echo $data['notulen']; ?></td>
						<td><div align="center"><a href="?page=<?php echo base64_encode(bookmeetingroomedit) ?>&amp;id=<?php echo base64_encode($Kode); ?>" class="btn btn-xs <?php echo $dataPanel; ?>"><i class="fa fa-pencil"></i></a></div></td>
                    </tr>
                    <?php
                        
                    }
                    ?>
				</tbody>
            </table>
	    </div>
	</div>
</form>
    	