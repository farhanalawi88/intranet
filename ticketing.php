<div class="portlet box blue-chambray">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject uppercase">Ticketing List</span>
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse"></a>
            <a href="javascript:;" class="reload"></a>
            <a href="javascript:;" class="remove"></a>
        </div>
	</div>
	<div class="portlet-body">
       <table class="table table-striped table-condensed table-hover" id="sample_1">
			<thead>
                <tr class="active">
			  	  	<th width="5%"><div align="center">LIHAT</div></th>
			  	  	<th width="5%"><div align="center">NO</div></th>
                    <th width="15%"><div align="center">TICKET NO</div></th>
                    <th width="15%"><div align="center">TICKET DATE</div></th>
					<th width="15%">REQUESTER</th>
					<th width="15%">CATEGORY</th>
					<th width="30%">TYPE</th>
		  	  	  	<th width="5%"><div align="center">STATUS</div></th>
                </tr>
			</thead>
			<tbody>
           <?php
				$dataSql = "SELECT 
							a.tic_tr_ticket_id,
							a.tic_tr_ticket_no,
							a.tic_tr_ticket_diminta,
							b.tic_ms_kat_nm,
							d.tic_ms_modul_nm,
							a.tic_tr_ticket_sts,
							DATE_FORMAT(a.tic_tr_ticket_tgl_start, '%d/%m/%Y %H:%s') as tic_tr_ticket_tgl_start
							FROM tic_tr_ticket a
							LEFT JOIN tic_ms_kat b ON a.tic_ms_kat_id=b.tic_ms_kat_id
							LEFT JOIN tic_ms_modul d ON a.tic_ms_modul_id=d.tic_ms_modul_id
							ORDER BY a.tic_tr_ticket_id DESC";
				$dataQry = mysqli_query($koneksidb, $dataSql);
				$nomor  = 0; 
				while ($data = mysqli_fetch_array($dataQry)) {
				$nomor++;
				$Kode = $data['tic_tr_ticket_id'];
				if($data ['tic_tr_ticket_sts']=='N'){
					$dataStatus= "<label class='badge badge-warning badge-roundless'>PENDING</label>";
				}elseif($data ['tic_tr_ticket_sts']=='Y'){
					$dataStatus= "<label class='badge badge-success badge-roundless'>SOLVED</label>";
				}elseif($data ['tic_tr_ticket_sts']=='C'){
					$dataStatus= "<label class='badge badge-danger badge-roundless'>CANCEL</label>";
				}
			?>
                <tr class="odd gradeX">
					<td>
						<div align="center">
							<div class="btn-group clearfix">
								<a data-original-title="View" href="?page=<?php echo base64_encode(ticketingview) ?>&amp;id=<?php echo base64_encode($Kode); ?>" class="btn btn-xs grey-cascade tooltips"><i class="fa fa-eye"></i></a>
							</div>
						</div>
					</td>
					<td><div align="center"><?php echo $nomor; ?></div></td>
					<td><div align="center"><?php echo $data ['tic_tr_ticket_no']; ?></div></td>
					<td><div align="center"><?php echo ($data ['tic_tr_ticket_tgl_start']); ?></div></td>
					<td><?php echo $data ['tic_tr_ticket_diminta']; ?></td>
					<td><?php echo $data ['tic_ms_kat_nm']; ?></td>
					<td><?php echo $data ['tic_ms_modul_nm']; ?></td>
					<td><div align="center"><?php echo $dataStatus; ?></div></td>
                </tr>
                <?php } ?>
			</tbody>
        </table>
    </div>
</div>
    		