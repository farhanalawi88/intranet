<?php
			
	if(isset($_POST['btnUpdate'])){
		$txtID 		= $_POST['txtID'];
		foreach ($txtID as $id_key) {
				
			pg_query($koneksipg, "UPDATE ad_session SET session_active='N' WHERE ad_session_id='$id_key'") 
				or die ("Gagal kosongkan tmp".pg_last_error());
					
		}
	}
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
	<div class="portlet box <?php echo $dataPanel; ?>">
	    <div class="portlet-title">
	        <div class="caption">
	            <span class="caption-subject uppercase">Session Pengguna</span>
	        </div>
	        <div class="actions">
	        	<a href="?page=<?php echo base64_encode(dtlog) ?>" class="btn <?php echo $dataPanel; ?> active"><i class="icon-refresh"></i> RELOAD SESSION </a>
				<button class="btn <?php echo $dataPanel; ?> active" name="btnUpdate" type="submit" onclick="return confirm('Anda yakin ingin menghapus data penting ini !!')"><i class="icon-shield"></i> KILL SESSION</button>
			</div>
		</div>
    <div class="portlet-body">
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
                        <th width="15%">USERNAME</th>
                        <th width="25%">NAMA USER</th>
                        <th width="15%">REMOTE ADDRESS</th>
						<th width="20%">LOGIN TIME</th>
						<th width="20%">LAST PING</th>
                    </tr>
				</thead>
				<tbody>
               <?php
               			$dataTanggal	= date('Y-m-d');
						$dataSql 		= "SELECT
											a.username,
											b.name,
											a.remote_addr,
											a.remote_host,
											to_char(a.created,'dd/mm/yyyy HH24:MI') as created,
											to_char(a.last_session_ping,'dd/mm/yyyy HH24:MI') as last_session_ping,
											a.ad_session_id
											FROM ad_session a
											INNER JOIN ad_user b ON a.createdby=b.ad_user_id
											WHERE a.session_active='Y'
											ORDER BY a.created ASC";
						$dataQry 		= pg_query($koneksipg, $dataSql)  or die ("Query petugas salah : ".pg_last_error());
						$nomor  		= 0; 
						while ($data 	= pg_fetch_array($dataQry)) {
						$nomor++;
						$Kode 			= $data['ad_session_id'];
				?>
                    <tr class="odd gradeX">
                        <td>
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="checkboxes" value="<?php echo $Kode; ?>" name="txtID[<?php echo $Kode; ?>]" />
                                <span></span>
                            </label>
                        </td>
						<td><div align="center"><?php echo $nomor; ?></div></td>
						<td><?php echo $data ['username']; ?></td>
						<td><?php echo $data ['name']; ?></td>
						<td><?php echo $data ['remote_addr']; ?></td>
						<td><?php echo $data ['created']; ?></td>
						<td><?php echo $data ['last_session_ping']; ?></td>
                    </tr>
                    <?php
                        
                    }
                    ?>
				</tbody>
            </table>
  		</div>
	</div>
</form>