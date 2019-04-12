<?php
if(isset($_POST['btnSave'])){
	$message = array();
	if (trim($_POST['txtKode'])=="") {
		$message[] = "<b>Notulen</b> tidak boleh kosong, silahkan isi terlebih dahulu !";		
	}

	$txtKode		= $_POST['txtKode'];

	if(count($message)==0){		
		$qrySave		= mysqli_query($koneksidb, "UPDATE as_trx_meet_sch SET as_trx_meet_sch_status='Y' 
															WHERE as_trx_meet_sch_id='$txtKode'") 
							  or die ("Gagal query".mysqli_errors());
		if($qrySave){	
			
			$_SESSION['info'] = 'success';
			$_SESSION['pesan'] = 'Data meeting schedule berhasil ditutup / closing';
			echo '<script>window.location="?page='.base64_encode(dttrxmeetsch).'"</script>';
		}
		else{
			$message[] = "Gagal penyimpanan ke database";
		}
	}	

}
if(isset($_POST['btnHapus'])){
	$hapus=mysqli_query($koneksidb,"DELETE FROM as_trx_notulen WHERE as_trx_notulen_id='".$_POST['btnHapus']."'") 
				or die ("Gagal kosongkan tmp".mysqli_errors());

}
if(isset($_POST['btnInput'])){
	$message = array();
	if (trim($_POST['txtNotulen'])=="") {
		$message[] = "<b>Notulen</b> tidak boleh kosong, silahkan isi terlebih dahulu !";		
	}

	$txtNotulen		= $_POST['txtNotulen'];
	$txtAction		= $_POST['txtAction'];
	$txtUser		= $_POST['txtUser'];
	$txtFinished	= $_POST['txtFinished'];
	$txtKode		= $_POST['txtKode'];	
			
	if(count($message)==0){		
		$qrySave		= mysqli_query($koneksidb, "INSERT INTO as_trx_notulen (as_trx_notulen_point,
																				as_trx_meet_sch_id,
																				as_trx_notulen_action,
																				as_trx_notulen_user,
																				as_trx_notulen_finished,
																				as_trx_notulen_created,
																				as_trx_notulen_createdby)
																		VALUES ('$txtNotulen',
																				'$txtKode',
																				'$txtAction',
																				'$txtUser',
																				'$txtFinished',
																				'".date('Y-m-d H:i:s')."',
																				'".$_SESSION['sys_role_id']."')") 
							  or die ("Gagal query".mysqli_errors());
		if($qrySave){	
			
			$_SESSION['info'] = 'success';
			$_SESSION['pesan'] = ''.$txtNotulen.' berhasil ditambahkan';
			echo '<script>window.location="?page='.base64_encode(notulentrxmeetsch).'&id='.base64_encode($txtKode).'"</script>';
		}
		else{
			$message[] = "Gagal penyimpanan ke database";
		}
	}	
} 

if (! count($message)==0 ){
	echo "<div class='alert alert-danger alert-dismissable'>
                      <button type='button' class='close' data-dismiss='alert' aria-hidden='true'></button>";
		$Num=0;
		foreach ($message as $indeks=>$pesan_tampil) { 
		$Num++;
			echo "&nbsp;&nbsp;$Num. $pesan_tampil<br>";	
		} 
	echo "</div>"; 
}

$KodeEdit		= isset($_GET['id']) ?  base64_decode($_GET['id']) : $_POST['txtKode']; 
$sqlShow		= "SELECT * FROM as_trx_meet_sch a
					INNER JOIN as_ms_room b ON a.as_ms_room_id=b.as_ms_room_id
					WHERE a.as_trx_meet_sch_id='$KodeEdit'";
$qryShow 		= mysqli_query($koneksidb, $sqlShow)  
					or die ("Query ambil data department salah : ".mysqli_errors());
$dataShow		= mysqli_fetch_array($qryShow);
$dataKode 		= $dataShow['as_trx_meet_sch_id'];

$dataAgenda		= $dataShow['as_trx_meet_sch_agenda'];
$dataAction		= isset($_POST['txtAction']) ? $_POST['txtAction'] : $dataShow['as_trx_notulen_action'];
$dataUser		= isset($_POST['txtUser']) ? $_POST['txtUser'] : $dataShow['as_trx_notulen_user'];
$dataFinished	= isset($_POST['txtFinished']) ? $_POST['txtFinished'] : $dataShow['as_trx_notulen_finished'];
?>	
<div class="portlet box <?php echo $dataPanel; ?>">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase">Notulen <?php echo $dataAgenda ?></span></div>
		<div class="tools">
			<a href="javascript:;" class="collapse"></a>
			<a href="javascript:;" class="reload"></a>
			<a href="javascript:;" class="remove"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmadd" autocomplete='off'>
			<div class="form-body">
		    	<div class="row">
		      		<div class="col-lg-4">
		        		<div class="form-group">
		          		<label class="form-control-label">Uraian Pembahasan & Point Meeting :</label>
		          		<input class="form-control" type="text" name="txtNotulen" placeholder="Masukkan Notulen" onkeyup="javascript:this.value=this.value.toUpperCase();">
		          		<input type="hidden" name="txtKode" value="<?php echo $dataKode ?>">
		          		</div>
		        	</div>
		        	<div class="col-lg-4">
		        		<div class="form-group">
		          		<label class="form-control-label">Action Plan :</label>
		          		<input class="form-control" type="text" name="txtAction" placeholder="Masukkan Action Plan" onkeyup="javascript:this.value=this.value.toUpperCase();">
		          		</div>
		        	</div>
		        	<div class="col-lg-2">
		        		<div class="form-group">
		          		<label class="form-control-label">Penanggung Jawab :</label>
		          		<input class="form-control" type="text" name="txtUser" placeholder="Masukkan Penanggung Jawab" onkeyup="javascript:this.value=this.value.toUpperCase();">
		          		</div>
		        	</div>
		        	<div class="col-lg-2">
		        		<div class="form-group">
		          		<label class="form-control-label">Penyelesaian :</label>
		          		<input class="form-control" type="text" name="txtFinished" placeholder="Masukkan Penyelesaian" onkeyup="javascript:this.value=this.value.toUpperCase();">
		          		</div>
		        	</div>	

				</div>

		        <button type="submit" name="btnInput" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-save"></i> Input Data</button>
				<div class="batas"></div>
			    <div class="row">
			     	<div class="col-lg-12">    	
		            <table class="table table-striped table-condensed table-hover" id="sample_1">
						<thead>
		                    <tr class="active">
		       	  	  	  	  	<th width="10%"><div align="center">ACTION</div></th>
							  	<th width="5%"><div align="center">NO</div></th>
								<th width="35%">NOTULEN & POINT MEETING</th>
								<th width="35%">ACTION PLAN</th>
								<th width="10%">PENANGGUNG JAWAB</th>
								<th width="5%">PENYELESAIAN</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$dataSql = "SELECT * FROM as_trx_notulen
											WHERE as_trx_meet_sch_id='$dataKode'
											ORDER BY as_trx_notulen_id DESC";
								$dataQry = mysqli_query($koneksidb, $dataSql)  or die ("Query salah : ".mysqli_errors());
								$nomor  = 0; 
								while ($data = mysqli_fetch_array($dataQry)) {
								$nomor++;
								$Kode = $data['as_trx_notulen_id'];
							?>
							<tr class="odd gradeX">
		                        <td>
		                        	<div align="center">
		                        		<div class="btn-group">
		                        			<button type="submit" value="<?php echo $Kode ?>" name="btnHapus" class="btn btn-xs <?php echo $dataPanel; ?>"><i class="fa fa-trash"></i></button>
		                        			<a href="?page=<?php echo base64_encode(edtnotulentrxmeetsch) ?>&amp;id=<?php echo base64_encode($Kode); ?>" value="<?php echo $Kode ?>" class="btn btn-xs <?php echo $dataPanel; ?>"><i class="fa fa-edit"></i></a>
		                        		</div>
		                        	</div>
		                        </td>
								<td><div align="center"><?php echo $nomor; ?></div></td>
								<td><?php echo $data ['as_trx_notulen_point']; ?></td>
								<td><?php echo $data ['as_trx_notulen_action']; ?></td>
								<td><?php echo $data ['as_trx_notulen_user']; ?></td>
								<td><?php echo $data ['as_trx_notulen_finished']; ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					</div>
				</div>
			</div>
		    <div class="form-actions">
                <button type="submit" name="btnSave" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-calendar"></i> Close Schedule</button>
                <a href="?page=<?php echo base64_encode(dttrxmeetsch) ?>" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-undo"></i> Kembali</a>
			</div>
		</form>
	</div>
</div>