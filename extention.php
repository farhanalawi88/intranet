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
                        <th width="30%">KETERANGAN</th>
                        <th width="20%">LINE TELEPON</th>
                    </tr>
				</thead>
				<tbody>
               <?php
						$dataSql = "SELECT * FROM as_ms_ext a";
						$dataQry = mysqli_query($koneksidb, $dataSql);
						$nomor  = 0; 
						while ($data = mysqli_fetch_array($dataQry)) {
						$nomor++;
				?>
                    <tr class="odd gradeX">
                        <td><?php echo $data['as_ms_ext_nama']; ?></td>
						<td><?php echo $data['as_ms_ext_ket']; ?></td>
						<td><?php echo $data['as_ms_ext_line']; ?></td>
                    </tr>
                    <?php
                        
                    }
                    ?>
				</tbody>
            </table>
	    </div>
	</div>