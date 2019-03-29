
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
	
	<div class="portlet box <?php echo $dataPanel; ?>">
	    <div class="portlet-title">
	        <div class="caption">
	            <span class="caption-subject uppercase">Data Process Document Registration</span>
	        </div>
	        <div class="tools">
	            <a href="" class="collapse"> </a>
	            <a href="" class="reload"> </a>
	            <a href="" class="remove"> </a>
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
						<th width="20%"><div align="center">NO. USULAN</div></th>
						<th width="5%"><div align="center">TANGGAL</div></th>
                        <th width="20%">BAGIAN</th>
                        <th width="15%">KATEGORI</th>
                        <th width="15%">SUBJEK</th>
                        <th width="5%"><div align="center">STATUS</div></th>
				  	  	<th width="5%"><div align="center">ACTION</div></th>
                    </tr>
				</thead>
				<tbody>
               <?php
						$dataSql = "SELECT 
										a.doc_tr_usul_no,
										a.doc_tr_usul_tgl as doc_tr_usul_tgl,
										a.doc_tr_usul_jns,
										a.doc_tr_usul_sts,
										b.doc_ms_kat_doc_nm,
										a.doc_tr_usul_subject,
										d.sys_bagian_nm,
										e.doc_ms_doc_nm,
										a.doc_tr_usul_id
									FROM doc_tr_usul a
									INNER JOIN doc_ms_kat_doc b ON a.doc_ms_kat_doc_id=b.doc_ms_kat_doc_id
									INNER JOIN sys_bagian d ON a.sys_bagian_id=d.sys_bagian_id
									LEFT JOIN doc_ms_doc e ON a.doc_ms_doc_id=e.doc_ms_doc_id
									WHERE NOT a.doc_tr_usul_sts IN ('D','N')
									ORDER BY a.doc_tr_usul_id DESC";
						$dataQry = mysqli_query($koneksidb, $dataSql);
						$nomor  = 0; 
						while ($data = mysqli_fetch_array($dataQry)) {
						$nomor++;
						$ID = $data['doc_tr_usul_id'];
						if($data ['doc_tr_usul_sts']=='Y'){
							$dataStatus= "<span class='badge badge-success badge-roundless'>APPROVED</span>";
							$disabled 	= "";
						}elseif($data ['doc_tr_usul_sts']=='D'){
							$dataStatus= "<span class='badge badge-warning badge-roundless'>DRAFT</span>";
							$disabled 	= "";
						}elseif($data ['doc_tr_usul_sts']=='C'){
							$dataStatus= "<span class='badge badge-danger badge-roundless'>CLOSE</span>";
							$disabled 	= "disabled";
						}elseif($data ['doc_tr_usul_sts']=='N'){
							$dataStatus= "<span class='badge badge-warning badge-roundless'>DRAFT</span>";
							$disabled 	= "";
						}

				?>
                    <tr class="odd gradeX">
                        <td>
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="checkboxes" value="<?php echo $ID; ?>" name="txtID[<?php echo $ID; ?>]" />
                                <span></span>
                            </label>
                        </td>
						<td><div align="center"><?php echo $nomor ?></div></td>
						<td><div align="center"><?php echo $data ['doc_tr_usul_no']; ?></div></td>
						<td><div align="center"><?php echo IndonesiaTgl($data ['doc_tr_usul_tgl']); ?></div></td>
						<td><?php echo $data['sys_bagian_nm']; ?></td>
						<td><?php echo $data['doc_ms_kat_doc_nm']; ?></td>
						<td><?php echo $data['doc_tr_usul_subject']; ?></td>
						<td><div align="center"><?php echo $dataStatus; ?></div></td>
						<td>
							<div align="center">
								<div class="btn-group clearfix">
									<a data-original-title="Proses" href="?page=<?php echo base64_encode(docaddprosestrusul) ?>&amp;id=<?php echo base64_encode($ID); ?>" class="btn btn-xs blue tooltips <?php echo $disabled ?>"><i class="fa fa-edit"></i></a>
								</div>
							</div>
						</td>
                    </tr>
                    <?php } ?>
				</tbody>
            </table>
	    </div>
	</div>
</form>
    		