<?php
    if(isset($_POST['btnSave'])){
        $message = array();
        if (trim($_POST['cmbModul'])=="") {
            $message[] = "Data type tidak boleh kosong!";      
        }
        if (trim($_POST['cmbOrg'])=="") {
            $message[] = "Data organisasi tidak boleh kosong!";       
        }
        if (trim($_POST['cmbBagian'])=="") {
            $message[] = "Data bagian tidak boleh kosong!";       
        }
        if (trim($_POST['cmbKategori'])=="") {
            $message[] = "Data kategori tidak boleh kosong!";        
        }
        if (trim($_POST['txtSubject'])=="") {
            $message[] = "Data subject tidak boleh kosong!";      
        }
                
        $cmbModul       = $_POST['cmbModul'];
        $txtSubject     = $_POST['txtSubject'];
        $txtDetail      = $_POST['txtDetail'];
        $cmbOrg         = $_POST['cmbOrg'];
        $txtDiminta     = $_POST['txtDiminta'];
        $cmbKategori    = $_POST['cmbKategori'];
        $cmbBagian       = $_POST['cmbBagian'];
        $txtTanggal     = date('Y-m-d H:i:s');
                
        
        if(count($message)==0){     
            $bulan          = substr($txtTanggal,5,2);
            $romawi         = getRomawi($bulan);
            $tahun          = substr($txtTanggal,2,2);
            $tahun2         = substr($txtTanggal,0,4);
            $nomorTrans     = "/".$romawi."/".$tahun;
            $queryTrans     = "SELECT max(tic_tr_ticket_no) as maxKode FROM tic_tr_ticket WHERE CONVERT(CHAR(4),tic_tr_ticket_tgl_start,112)='$tahun2''";
            $hasilTrans     = mysqli_query($koneksidb, $queryTrans);
            $dataTrans      = mysqli_fetch_array($hasilTrans);
            $noTrans        = $dataTrans['maxKode'];
            $noUrutTrans    = $noTrans + 1;
            $IDTrans        =  sprintf("%04s", $noUrutTrans);
            $kodeTrans      = $IDTrans.$nomorTrans;

            $tgl         = date('ymdhis');
            if (! empty($_FILES['txtFile']['tmp_name'])) {
                $file_upload_pdf    = $_FILES['txtFile']['name'];
                $file_upload_pdf    = stripslashes($file_upload_pdf);
                $file_upload_pdf    = str_replace("'","",$file_upload_pdf);
                $txtExtPDF          = pathinfo($file_upload_pdf, PATHINFO_EXTENSION);
                $file_upload_pdf    = $tgl.".".$txtExtPDF;
                copy($_FILES['txtFile']['tmp_name'],"file/".$file_upload_pdf);
            }
            else {
                $file_upload_pdf    = "";
            }   

            $sqlSave    = "INSERT INTO tic_tr_ticket (tic_tr_ticket_no,
                                                    tic_tr_ticket_tgl_start,
                                                    tic_tr_ticket_problem,
                                                    tic_ms_kat_id,
                                                    sys_org_id,
                                                    tic_tr_ticket_sts,
                                                    tic_ms_modul_id,
                                                    tic_tr_ticket_app,
                                                    tic_tr_ticket_description,
                                                    sys_bagian_id,
                                                    tic_tr_ticket_diminta,
                                                    tic_file_ticket) 
                                            VALUES ('$kodeTrans',
                                                    '$txtTanggal',
                                                    '$txtSubject',
                                                    '$cmbKategori',
                                                    '$cmbOrg',
                                                    'N',
                                                    '$cmbModul',
                                                    'N',
                                                    '$txtDetail',
                                                    '$cmbBagian',
                                                    '$txtDiminta',
                                                    '$file_upload_pdf')";
            $qrySave    = mysqli_query($koneksidb, $sqlSave) or die ("gagal insert". mysqli_errors());

            if($qrySave){
                $_SESSION['info'] = 'success';
                $_SESSION['pesan'] = 'Data ticket berhasil ditambahkan dengan No. '.$kodeTrans.'';
                echo '<script>window.location="?page='.base64_encode(ithelpdesk).'"</script>';
            }
            exit;
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
    
    $dataModul      = isset($_POST['cmbModul']) ? $_POST['cmbModul'] : '';      
    $dataDiminta    = isset($_POST['txtDiminta']) ? $_POST['txtDiminta'] : '';
    $dataOrg        = isset($_POST['cmbOrg']) ? $_POST['cmbOrg'] : '';
    $dataBagian     = isset($_POST['cmbBagian']) ? $_POST['cmbBagian'] : '';
    $dataKategori   = isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : '';
    $dataSubject    = isset($_POST['txtSubject']) ? $_POST['txtSubject'] : '';
    $dataDetail     = isset($_POST['txtDetail']) ? $_POST['txtDetail'] : '';
?>
<div class="portlet box blue">
    <div class="portlet-title">
        <div class="caption"><span class="caption-subject uppercase bold">Form Add Ticket</span></div>
        <div class="tools">
            <a href="javascript:;" class="collapse"></a>
            <a href="javascript:;" class="reload"></a>
            <a href="javascript:;" class="remove"></a>
        </div>
    </div>
    <div class="portlet-body form">
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmadd" class="form-horizontal form-bordered" enctype="multipart/form-data" autocomplete="off">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-2 control-label">Organisasi :</label>
                    <div class="col-md-3">
                        <select name="cmbOrg" data-placeholder="Pilih Organisasi" class="select2 form-control">
                            <option value=""></option> 
                            <?php
                                  $dataSql = "SELECT * FROM sys_org ORDER BY sys_org_id DESC";
                                  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
                                  while ($dataRow = mysqli_fetch_array($dataQry)) {
                                    if ($dataOrg == $dataRow['sys_org_id']) {
                                        $cek = " selected";
                                    } else { $cek=""; }
                                    echo "<option value='$dataRow[sys_org_id]' $cek>$dataRow[sys_org_nm]</option>";
                                  }
                                  $sqlData ="";
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Nama Bagian :</label>
                    <div class="col-md-3">
                        <select name="cmbBagian" data-placeholder="Pilih Bagian" class="select2 form-control">
                            <option value=""></option> 
                            <?php
                                  $dataSql = "SELECT * FROM sys_bagian ORDER BY sys_bagian_id DESC";
                                  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
                                  while ($dataRow = mysqli_fetch_array($dataQry)) {
                                    if ($dataBagian == $dataRow['sys_bagian_id']) {
                                        $cek = " selected";
                                    } else { $cek=""; }
                                    echo "<option value='$dataRow[sys_bagian_id]' $cek>$dataRow[sys_bagian_nm]</option>";
                                  }
                                  $sqlData ="";
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Kategori :</label>
                    <div class="col-md-3">
                        <select name="cmbKategori" data-placeholder="Pilih Kategori" class="select2 form-control">
                            <option value=""></option> 
                            <?php
                                  $dataSql = "SELECT * FROM tic_ms_kat ORDER BY tic_ms_kat_id DESC";
                                  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
                                  while ($dataRow = mysqli_fetch_array($dataQry)) {
                                    if ($dataKategori == $dataRow['tic_ms_kat_id']) {
                                        $cek = " selected";
                                    } else { $cek=""; }
                                    echo "<option value='$dataRow[tic_ms_kat_id]' $cek>$dataRow[tic_ms_kat_nm]</option>";
                                  }
                                  $sqlData ="";
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Type :</label>
                    <div class="col-md-4">
                        <select name="cmbModul" data-placeholder="Pilih Modul" class="select2 form-control">
                            <option value=""></option> 
                            <?php
                                  $dataSql = "SELECT * FROM tic_ms_modul ORDER BY tic_ms_modul_id DESC";
                                  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
                                  while ($dataRow = mysqli_fetch_array($dataQry)) {
                                    if ($dataModul == $dataRow['tic_ms_modul_id']) {
                                        $cek = " selected";
                                    } else { $cek=""; }
                                    echo "<option value='$dataRow[tic_ms_modul_id]' $cek>$dataRow[tic_ms_modul_nm]</option>";
                                  }
                                  $sqlData ="";
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Diminta Oleh :</label>
                    <div class="col-md-3">
                        <input class="form-control" type="text" value="<?php echo $dataDiminta ?>" name="txtDiminta" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Subject :</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="txtSubject" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $dataSubject ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Subject Detail :</label>
                    <div class="col-md-10">
                        <textarea class="form-control ckeditor" name="txtDetail" onkeyup="javascript:this.value=this.value.toUpperCase();"><?php echo $dataDetail ?></textarea>
                    </div>
                </div>
                <div class="form-group last">
                    <label class="control-label col-md-2">Upload File</label>
                    <div class="col-md-3">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="input-group">
                                <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                    <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                    <span class="fileinput-filename"> </span>
                                </div>
                                <span class="input-group-addon btn default btn-file">
                                    <span class="fileinput-new"><i class="fa fa-folder-open"></i></span>
                                    <span class="fileinput-exists"><i class="fa fa-folder"></i></span>
                                    <input type="file" name="txtFile"> </span>
                                    <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> <i class="fa fa-close"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-lg-offset-2 col-lg-10">
                        <button type="submit" name="btnSave" class="btn blue"><i class="fa fa-save"></i> Simpan Data</button>
                        <a href="?page=<?php echo base64_encode(ithelpdesk) ?>" class="btn blue"><i class="fa fa-undo"></i> Batalkan</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
