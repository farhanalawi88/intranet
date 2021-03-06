<?php     
  if(isset($_POST['btnHapus'])){
    $txtID    = $_POST['txtID'];
    foreach ($txtID as $id_key) {
        
      $hapus=mysqli_query($koneksidb, "DELETE FROM sys_group WHERE sys_group_id='$id_key'") 
        or die ("Gagal kosongkan tmp".mysqli_errors());
        
      if($hapus){
        $_SESSION['info'] = 'success';
        $_SESSION['pesan'] = 'Data group berhasil dihapus';
        echo '<script>window.location="?page='.base64_encode(dtgroup).'"</script>';
      } 
    }
  }
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
  <div class="portlet box <?php echo $dataPanel; ?>">
    <div class="portlet-title">
    <div class="caption"><span class="caption-subject uppercase bold">Data Group & Level</span></div>
      <div class="actions">
        <a href="?page=<?php echo base64_encode(addgroup) ?>" class="btn <?php echo $dataPanel; ?> active"><i class="icon-plus"></i> ADD DATA</a> 
        <button class="btn <?php echo $dataPanel; ?> active" name="btnHapus" type="submit" onclick="return confirm('Anda yakin ingin menghapus data penting ini !!')"><i class="icon-trash"></i> DELETE DATA</button>
      </div>
    </div>
    <div class="portlet-body">
      <table class="table table-bordered" id="sample_2">
        <thead>
          <tr class="active">
            <th class="table-checkbox" width="3%">
                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                    <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" />
                    <span></span>
                </label>
            </th>
            <th width="5%"><div align="center">NO</div></th>
            <th width="30%">NAMA GROUP</th>
            <th width="40%">KETERANGAN</th>
            <th width="10%"><div align="center">LEVEL</div></th>
            <th width="10%"><div align="center">STATUS</div></th>
            <th width="9%"><div align="center">ACTION</div></th>
          </tr>
        </thead>
        <tbody>
          <?php
            $dataSql = "SELECT * FROM sys_group ORDER BY sys_group_id DESC";
            $dataQry = mysqli_query($koneksidb, $dataSql)  or die ("Query supplier salah : ".mysqli_errors());
            $nomor  = 0; 
            while ($data = mysqli_fetch_array($dataQry)) {
            $nomor++;
            $Kode = $data['sys_group_id'];
          ?>
        <tr class="odd gradeX">
            <td>
                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                    <input type="checkbox" class="checkboxes" value="<?php echo $Kode; ?>" name="txtID[<?php echo $Kode; ?>]" />
                    <span></span>
                </label>
            </td>
            <td><div align="center"><?php echo $nomor; ?></div></td>
            <td><?php echo $data['sys_group_nama']; ?></td>
            <td><?php echo $data ['sys_group_ket']; ?></td>
            <td><div align="center"><?php echo $data ['sys_group_level']; ?></div></td>
            <td>
              <div align="center">
                <?php 
                if($data ['sys_group_sts']=='Active'){
                  echo "<label class='badge badge-success badge-roundless'>ACTIVE</label>";
                }else{
                  echo "<label class='badge badge-danger badge-roundless'>NON ACTIVE</label>";
                }
                ?>            
              </div></td>
              <td><div align="center"><a href="?page=<?php echo base64_encode(edtgroup) ?>&amp;id=<?php echo base64_encode($Kode); ?>" class="btn btn-xs <?php echo $dataPanel; ?>"><i class="fa fa-pencil"></i></a></div></td>
            </tr>
            <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</form>