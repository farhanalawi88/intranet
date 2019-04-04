<div class="portlet box blue-chambray">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject uppercase">Meeting Schedule List</span>
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
					<th width="15%">ROOM</th>
					<th width="40%">AGENDA MEETING</th>
                    <th width="30%"><div align="center">WAKTU MEETING</div></th>
                </tr>
			</thead>
			<tbody>
           <?php
           		$dataTgl 	= date('Y-m-d');
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
							WHERE NOT date( as_trx_meet_sch_start ) < ".$dataTgl."
							ORDER BY a.as_trx_meet_sch_start ASC";
				$dataQry = mysqli_query($koneksidb, $dataSql);
				$nomor  = 0; 
				while ($data = mysqli_fetch_array($dataQry)) {
				$nomor++;
				$ID = $data['as_trx_meet_sch_id'];
			?>
                <tr class="odd gradeX">
					<td>
						<div align="center">
							<div class="btn-group clearfix">
								<a data-original-title="View" href="?page=<?php echo base64_encode(meetingscheduleview) ?>&amp;id=<?php echo base64_encode($ID); ?>" class="btn btn-xs grey-cascade tooltips"><i class="fa fa-eye"></i></a>
							</div>
						</div>
					</td>
					<td><div align="center"><?php echo $nomor ?></div></td>
					<td><?php echo $data ['as_ms_room_nama']; ?></td>
					<td><?php echo $data ['as_trx_meet_sch_agenda']; ?></td>
					<td><div align="center"><?php echo $data['as_trx_meet_sch_start']; ?> s/d <?php echo $data['as_trx_meet_sch_end']; ?></div></td>
                </tr>
                <?php } ?>
			</tbody>
        </table>
    </div>
</div>
    		