<?php
			
	if(isset($_POST['btnHapus'])){
		$txtID 		= $_POST['txtID'];
		foreach ($txtID as $id_key) {
				
			mysqli_query($koneksidb, "DELETE FROM sys_role WHERE sys_role_id='$id_key'") 
				or die ("Gagal kosongkan tmp".mysqli_errors());
					
		}
	}
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
	<div class="portlet box <?php echo $dataPanel; ?>">
		<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase">Daftar Pengguna</span></div>
			<div class="actions">
				<a href="?page=<?php echo base64_encode(addrole) ?>" class="btn <?php echo $dataPanel; ?> active"><i class="icon-plus"></i> ADD DATA</a>	
				<button class="btn <?php echo $dataPanel; ?> active" name="btnHapus" type="submit" onclick="return confirm('Anda yakin ingin menghapus data penting ini !!')"><i class="icon-trash"></i> DELETE DATA</button>
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
						<th width="5%"><div align="center">NO</div></th>
                        <th width="20%">USERNAME</th>
                        <th width="40%">NAMA USER</th>
						<th width="20%">GROUP LEVEL</th>
						<th width="15%"><div align="center">STATUS</div></th>
				  	  	<th width="9%"><div align="center">ACTION</div></th>
                    </tr>
				</thead>
				<tbody>
               <?php
						$dataSql = "SELECT
										a.sys_role_id,
										a.sys_role_username,
										upper(a.sys_role_nama) as nama,
										upper(c.sys_group_nama) as sys_group_nama,
										a.sys_role_sts
									FROM
										sys_role a 
										INNER JOIN sys_group c ON a.sys_group_id= c.sys_group_id";
						$dataQry = mysqli_query($koneksidb, $dataSql)  or die ("Query petugas salah : ".mysqli_errors());
						$nomor  = 0; 
						while ($data = mysqli_fetch_array($dataQry)) {
						$nomor++;
						$Kode = $data['sys_role_id'];
				?>
                    <tr class="odd gradeX">
                        <td>
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="checkboxes" value="<?php echo $Kode; ?>" name="txtID[<?php echo $Kode; ?>]" />
                                <span></span>
                            </label>
                        </td>
						<td><div align="center"><?php echo $nomor ?></div></td>
						<td><?php echo $data ['sys_role_username']; ?></td>
						<td><?php echo $data ['nama']; ?></td>
						<td><?php echo $data ['sys_group_nama']; ?></td>
						<td>
						  <div align="center">
						    <?php 
							if($data ['sys_role_sts']=='Active'){
								echo "<span class='badge badge-success badge-roundless'>ACTIVE</span>";
							}else{
								echo "<span class='badge badge-danger badge-roundless'>NON ACTIVE</span>";
							}
							?>						
				        </div></td>
						<td><div align="center"><a href="?page=<?php echo base64_encode(edtrole) ?>&amp;id=<?php echo base64_encode($Kode); ?>" class="btn btn-xs <?php echo $dataPanel; ?>"><i class="fa fa-pencil"></i></a></div></td>
                    </tr>
                    <?php
                        
                    }
                    ?>
				</tbody>
            </table>
  		</div>
	</div>
</form>