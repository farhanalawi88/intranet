<?php
	// Menghapus Data
	if(isset($_POST['btnHapus'])){
		$message = array();
		if (empty($_POST['txtID'])) {
			$message[] = "<b>Menu</b> belum ada yang dipilih !";		
		}

		$txtID 		= $_POST['txtID'];

		if(count($message)==0){
			foreach ($txtID as $id_key) {
					
				$hapus=mysqli_query($koneksidb,"DELETE FROM sys_menu WHERE sys_menu_id='$id_key'") 
					or die ("Gagal kosongkan tmp".mysqli_errors());
				if($hapus){
					$_SESSION['info'] = 'success';
		            $_SESSION['pesan'] = 'Data menu utama berhasil dihapus';
		            echo '<script>window.location="?page='.base64_encode(dtmenu).'"</script>';
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
	}	
	
	
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
	<div class="portlet box <?php echo $dataPanel; ?>">
	    <div class="portlet-title">
	        <div class="caption">
	            <span class="caption-subject uppercase">Data Main Menu</span>
	        </div>
	        <div class="actions">
				<a href="?page=<?php echo base64_encode(addmenu) ?>" class="btn <?php echo $dataPanel; ?> active"><i class="icon-plus"></i> ADD DATA </a>
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
                        <th width="50%">NAMA MENU</th>
                        <th width="30%">MENU ICON</th>
						<th width="10%"><div align="center">URUTAN</div></th>
				  	  	<th width="5%"><div align="center">ACTION</div></th>
                    </tr>
				</thead>
				<tbody>
               <?php
						$dataSql = "SELECT * FROM sys_menu a
									ORDER BY a.sys_menu_id ASC";
						$dataQry = mysqli_query($koneksidb, $dataSql);
						$nomor  = 0; 
						while ($data = mysqli_fetch_array($dataQry)) {
						$nomor++;
						$Kode = $data['sys_menu_id'];
				?>
                    <tr class="odd gradeX">
                        <td>
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="checkboxes" value="<?php echo $Kode; ?>" name="txtID[<?php echo $Kode; ?>]" />
                                <span></span>
                            </label>
                        </td>
						<td><div align="center"><?php echo $nomor ?></div></td>
						<td><?php echo $data ['sys_menu_nama']; ?></td>
						<td><?php echo $data['sys_menu_icon']; ?></td>
						<td>
						  <div align="center">
						    <?php echo $data ['sys_menu_urutan'] ?>						
				        </div></td>
						<td><div align="center"><a href="?page=<?php echo base64_encode(edtmenu) ?>&amp;id=<?php echo base64_encode($Kode); ?>" class="btn btn-xs <?php echo $dataPanel; ?>"><i class="fa fa-pencil"></i></a></div></td>
                    </tr>
                    <?php
                        
                    }
                    ?>
				</tbody>
            </table>
	    </div>
	</div>
</form>
    	