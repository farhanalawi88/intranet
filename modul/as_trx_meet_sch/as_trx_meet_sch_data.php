<?php
	// Menghapus Data
	if(isset($_POST['btnHapus'])){
		$txtID 		= $_POST['txtID'];
		foreach ($txtID as $id_key) {
				
			$hapus=mysqli_query($koneksidb,"DELETE FROM as_trx_meet_sch WHERE as_trx_meet_sch_id='$id_key'") 
				or die ("Gagal kosongkan tmp".mysqli_errors());
			if($hapus){
				$_SESSION['info'] = 'success';
	            $_SESSION['pesan'] = 'Data schedule meeting Berhasil Dihapus';
	            echo '<script>window.location="?page='.base64_encode(dttrxmeetsch).'"</script>';
          	}		
        }
	}	
	
	
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
	<div class="portlet box <?php echo $dataPanel; ?>">
	    <div class="portlet-title">
	        <div class="caption">
	            <span class="caption-subject uppercase">Data Meeting Schedule</span>
	        </div>
	        <div class="actions">
				<a href="?page=<?php echo base64_encode(addtrxmeetsch) ?>" class="btn <?php echo $dataPanel; ?> active"><i class="icon-plus"></i> ADD DATA </a>
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
                        <th width="30%">AGENDA MEETING</th>
						<th width="15%"><div align="center">START DATE</div></th>
                        <th width="15%"><div align="center">END DATE</div></th>
                        <th width="15%">MEETING ROOM</th>
                        <th width="20%">PESERTA MEETING</th>
				  	  	<th width="5%"><div align="center">ACTION</div></th>
                    </tr>
				</thead>
				<tbody>
               <?php
						$dataSql = "SELECT 
									a.as_trx_meet_sch_agenda,
									b.as_ms_room_nama,
									a.as_trx_meet_sch_peserta,
									DATE_FORMAT(a.as_trx_meet_sch_start,'%d/%m/%Y %H:%s') as as_trx_meet_sch_start,
									DATE_FORMAT(a.as_trx_meet_sch_end,'%d/%m/%Y %H:%s') as as_trx_meet_sch_end,
									a.as_trx_meet_sch_status,
									a.as_trx_meet_sch_id
									FROM as_trx_meet_sch a
									INNER JOIN as_ms_room b ON a.as_ms_room_id=b.as_ms_room_id
									ORDER BY a.as_trx_meet_sch_id DESC";
						$dataQry = mysqli_query($koneksidb, $dataSql);
						$nomor  = 0; 
						while ($data = mysqli_fetch_array($dataQry)) {
						$nomor++;
						$Kode = $data['as_trx_meet_sch_id'];
						if($data ['as_trx_meet_sch_status']=='Y'){
							$disabled 	= "disabled";
						}elseif($data ['as_trx_meet_sch_status']=='N'){
							$disabled 	= "";
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
						<td><?php echo $data['as_trx_meet_sch_agenda']; ?></td>
						<td><?php echo $data['as_trx_meet_sch_start']; ?></td>
						<td><?php echo $data['as_trx_meet_sch_end']; ?></td>
						<td><?php echo $data['as_ms_room_nama']; ?></td>
						<td><?php echo $data['as_trx_meet_sch_peserta']; ?></td>
						<td><div class="btn-group" align="center">
							<a data-original-title="Edit" href="?page=<?php echo base64_encode(edttrxmeetsch) ?>&amp;id=<?php echo base64_encode($Kode); ?>" class="btn btn-xs tooltips <?php echo $dataPanel; ?> <?php echo $disabled ?>"><i class="fa fa-pencil"></i></a>
							<a data-original-title="Notulen" href="?page=<?php echo base64_encode(notulentrxmeetsch) ?>&amp;id=<?php echo base64_encode($Kode); ?>" class="btn btn-xs tooltips <?php echo $dataPanel; ?> <?php echo $disabled ?>"><i class="fa fa-book"></i></a></div></td>
                    </tr>
                    <?php
                        
                    }
                    ?>
				</tbody>
            </table>
	    </div>
	</div>
</form>
    	