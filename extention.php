<div class="portlet box blue-chambray">
	    <div class="portlet-title">
	        <div class="caption">
	            <span class="caption-subject uppercase bold">User Extention</span>
	        </div>
	        <div class="tools">
	            <a href="javascript:;" class="collapse"></a>
	            <a href="javascript:;" class="reload"></a>
	            <a href="javascript:;" class="remove"></a>
	        </div>
		</div>
    	<div class="portlet-body">
           <table class="table table-striped table-hover table-checkable order-column" id="sample_2">
				<thead>
                    <tr class="active">
                        <th width="40%">NAMA</th>
                        <th width="30%">DEPARTEMEN</th>
                        <th width="20%">LINE TELEPON</th>
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
									LEFT JOIN sys_employee b ON a.id_employee=b.id_employee
									LEFT JOIN sys_bagian c ON a.sys_bagian_id=c.sys_bagian_id";
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
                        <td><?php echo $data['nama_karyawan']; ?></td>
						<td><?php echo $data['sys_bagian_nm']; ?></td>
						<td><?php echo $data['line_telepon']; ?></td>
                    </tr>
                    <?php
                        
                    }
                    ?>
				</tbody>
            </table>
	    </div>
	</div>