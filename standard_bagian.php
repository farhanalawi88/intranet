<div class="portlet box blue-chambray">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject uppercase">Standard Departemen</span>
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse"></a>
            <a href="javascript:;" class="reload"></a>
            <a href="javascript:;" class="remove"></a>
        </div>
	</div>
	<div class="portlet-body">
       <table class="table table-striped table-condensed table-hover" id="sample_2">
			<thead>
                <tr class="active">
			  	  	<th width="5%"><div align="center">LIHAT</div></th>
					<th width="5%"><div align="center">NO</div></th>
					<th width="10%"><div align="center">NO. DOKUMEN</div></th>
                    <th width="20%">BAGIAN</th>
                    <th width="15%">JENIS</th>
                    <th width="40%">JUDUL DOCUMENT</th>
                </tr>
			</thead>
			<tbody>
           <?php

           	if(isset($_GET['id'])){
           		$filter	= "AND a.sys_bagian_id='".base64_decode($_GET['id'])."'";
           	}else{
           		$filter = "";
           	}

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
								$filter
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
						<div align="center">
							<div class="btn-group clearfix">
								<a data-original-title="View" href="?page=<?php echo base64_encode(standarddepartemenview) ?>&amp;id=<?php echo base64_encode($ID); ?>" class="btn btn-xs grey-cascade tooltips"><i class="fa fa-eye"></i></a>
							</div>
						</div>
					</td>
					<td><div align="center"><?php echo $nomor ?></div></td>
					<td><div align="center"><?php echo $data ['doc_ms_doc_kd']; ?></div></td>
					<td><?php echo $data['sys_bagian_nm']; ?></td>
					<td><?php echo $data['doc_ms_doc_type']; ?></td>
					<td><?php echo $data['doc_ms_doc_nm']; ?></td>
                </tr>
                <?php } ?>
			</tbody>
        </table>
    </div>
</div>
    		