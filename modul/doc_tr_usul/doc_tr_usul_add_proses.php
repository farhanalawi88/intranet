<?php
    if(isset($_POST['btnSave'])){
        $message = array();
        if (trim($_POST['cmbBagian'])=="") {
            $message[] = "<b>Bagian</b> tidak boleh kosong !";      
        }
        if (trim($_POST['txtNama'])=="") {
            $message[] = "<b>Judul</b> tidak boleh kosong !";       
        }
        if (trim($_POST['cmbKategori'])=="") {
            $message[] = "<b>Kategori</b> tidak boleh kosong !";        
        }
        if (trim($_POST['cmbJenis'])=="") {
            $message[] = "<b>Jenis</b> tidak boleh kosong !";       
        }
        if (trim($_POST['txtJnsUsul'])=="") {
            $message[] = "<b>Jenis Usulan</b> tidak boleh kosong !";       
        }
        if (trim($_POST['txtTanggal'])=="") {
            $message[] = "<b>Tgl. Pengesahan</b> tidak boleh kosong !";     
        }
        if (empty($_FILES['txtFileAsli']['tmp_name'])) {
            $message[] = "<b>File Asli</b> tidak boleh kosong !";     
        }
        if (empty($_FILES['txtFilePDF']['tmp_name'])) {
            $message[] = "<b>File PDF</b> tidak boleh kosong !";     
        }
        
        $txtRevisi      = $_POST['txtRevisi'];
        $txtNama        = $_POST['txtNama'];
        $cmbBagian      = $_POST['cmbBagian'];
        $cmbJenis       = $_POST['cmbJenis'];
        $cmbKategori    = $_POST['cmbKategori'];
        $txtIDDoc       = $_POST['txtIDDoc'];
        $txtTanggal     = InggrisTgl($_POST['txtTanggal']);
        $txtJnsUsul     = $_POST['txtJnsUsul'];
        $txtNoUsul      = $_POST['txtNoUsul'];
        $txtNomor       = $_POST['txtNomor'];
        $txtKode        = $_POST['txtKode'];


        if(count($message)==0){
            // CEK JENIS USULAN
            if($txtJnsUsul==2){
                // UBAH STATUS DOKUMEN
                $sqlupd     = "UPDATE doc_ms_file SET doc_ms_file_masa='A' WHERE doc_ms_doc_id='$txtIDDoc'";
                $qryupd     = mysqli_query($koneksidb, $sqlupd) or die ("gagal insert". mysqli_errors());

                if (! empty($_FILES['txtFileAsli']['tmp_name'])) {
                    $tgl            = date('ymdhis');
                    $file_asli      = $_FILES['txtFileAsli']['name'];
                    $file_asli      = stripslashes($file_asli);
                    $file_asli      = str_replace("'","",$file_asli);
                    $txtExtAsli     = pathinfo($file_asli, PATHINFO_EXTENSION);
                    $file_asli      = $tgl."_".$_POST['txtNomor']."_".$_POST['txtNama']."_"."".$_POST['txtRevisi'].".".$txtExtAsli;
                    copy($_FILES['txtFileAsli']['tmp_name'],"file/".$file_asli);


                    // INSERT FILE ASLI
                    $sqlAsli        = "INSERT INTO doc_ms_file (doc_ms_file_upload,
                                                                doc_ms_file_type,
                                                                doc_ms_doc_id,
                                                                doc_ms_file_created,
                                                                doc_ms_file_createdby,
                                                                doc_ms_file_sts,
                                                                doc_ms_file_masa)
                                                        VALUES('$file_asli',
                                                                '$txtExtAsli',
                                                                '$txtIDDoc',
                                                                '".date('Y-m-d H:i:s')."',
                                                                '".$_SESSION['sys_role_id']."',
                                                                'Y',
                                                                'B')";
                    $qryAsli        = mysqli_query($koneksidb, $sqlAsli) or die ("gagal insert file asli". mysqli_errors());
                }
                if (! empty($_FILES['txtFilePDF']['tmp_name'])) {
                    $tgl            = date('ymdhis');
                    $file_pdf       = $_FILES['txtFilePDF']['name'];
                    $file_pdf       = stripslashes($file_pdf);
                    $file_pdf       = str_replace("'","",$file_pdf);
                    $txtExtPDF      = pathinfo($file_pdf, PATHINFO_EXTENSION);
                    $file_pdf       = $tgl."_".$_POST['txtNomor']."_".$_POST['txtNama']."_"."".$_POST['txtRevisi'].".".$txtExtPDF;
                    copy($_FILES['txtFilePDF']['tmp_name'],"file/".$file_pdf);


                    // INSERT FILE ASLI
                    $sqlPDF         = "INSERT INTO doc_ms_file (doc_ms_file_upload,
                                                                doc_ms_file_type,
                                                                doc_ms_doc_id,
                                                                doc_ms_file_created,
                                                                doc_ms_file_createdby,
                                                                doc_ms_file_sts,
                                                                doc_ms_file_masa)
                                                        VALUES('$file_pdf',
                                                                '$txtExtPDF',
                                                                '$txtIDDoc',
                                                                '".date('Y-m-d H:i:s')."',
                                                                '".$_SESSION['sys_role_id']."',
                                                                'Y',
                                                                'B')";
                    $qryPDF         = mysqli_query($koneksidb, $sqlPDF) or die ("gagal insert file PDF". mysqli_errors());
                }

                $sqlSave="UPDATE doc_ms_doc SET doc_ms_doc_nm='$txtNama',
                                            doc_ms_doc_rev='$txtRevisi',
                                            doc_ms_jns_doc_id='$cmbJenis',
                                            sys_bagian_id='$cmbBagian',
                                            doc_ms_doc_tgl='$txtTanggal',
                                            doc_ms_kat_doc_id='$cmbKategori',
                                            doc_ms_doc_updated='".date('Y-m-d H:i:s')."',
                                            doc_ms_doc_updatedby='".$_SESSION['sys_role_id']."'
                                        WHERE doc_ms_doc_id='$txtIDDoc'";
                $qrySave    = mysqli_query($koneksidb, $sqlSave) or die ("gagal insert". mysqli_errors());
                if($qrySave){
                    $sqlupdate  ="UPDATE doc_tr_usul SET doc_tr_usul_sts='C',
                                                        doc_tr_usul_updated='".date('Y-m-d H:i:s')."',
                                                        doc_tr_usul_updatedby='".$_SESSION['sys_role_id']."'
                                                    WHERE doc_tr_usul_id='$txtKode'";
                    $qryupdate    = mysqli_query($koneksidb, $sqlupdate) or die ("gagal insert". mysqli_errors());
                    $_SESSION['info'] = 'success';
                    $_SESSION['pesan'] = 'Data usulan perubahan document berhasil diperbaharui dengan No. Usulan '.$txtNoUsul.'';
                    echo '<script>window.location="?page='.base64_encode(docdtprosestrusul).'"</script>';
                }
                exit;

            }elseif($txtJnsUsul==1){
                $sqlSave="INSERT INTO doc_ms_doc (doc_ms_doc_nm,
                                                    doc_ms_doc_kd,
                                                    doc_ms_doc_rev,
                                                    doc_ms_jns_doc_id,
                                                    sys_bagian_id,
                                                    doc_ms_doc_sts,
                                                    doc_ms_kat_doc_id,
                                                    doc_ms_doc_created,
                                                    doc_ms_doc_createdby,
                                                    doc_ms_doc_tgl)
                                            VALUES('$txtNama',
                                                    '$txtNomor',
                                                    '$txtRevisi',
                                                    '$cmbJenis',
                                                    '$cmbBagian',
                                                    'Y',
                                                    '$cmbKategori',
                                                    '".date('Y-m-d H:i:s')."',
                                                    '".$_SESSION['sys_role_id']."',
                                                    '$txtTanggal')";
                $qrySave    = mysqli_query($koneksidb, $sqlSave) or die ("gagal insert". mysqli_errors());
                if($qrySave){
                    $sqlCek         = "SELECT MAX(doc_ms_doc_id) as id_doc FROM doc_ms_doc WHERE doc_ms_doc_createdby='".$_SESSION['sys_role_id']."'";
                    $qryCek         = mysqli_query($koneksidb, $sqlCek) or die ("Gagal cek value".mysqli_errors()); 
                    $qryRow         = mysqli_fetch_array($qryCek);
                    $dataID         = $qryRow['id_doc'];

                    if (! empty($_FILES['txtFileAsli']['tmp_name'])) {
                        $tgl            = date('ymdhis');
                        $file_asli      = $_FILES['txtFileAsli']['name'];
                        $file_asli      = stripslashes($file_asli);
                        $file_asli      = str_replace("'","",$file_asli);
                        $txtExtAsli     = pathinfo($file_asli, PATHINFO_EXTENSION);
                        $file_asli      = $tgl."_".$_POST['txtNomor']."_".$_POST['txtNama']."_"."".$_POST['txtRevisi'].".".$txtExtAsli;
                        copy($_FILES['txtFileAsli']['tmp_name'],"file/".$file_asli);


                        // INSERT FILE ASLI
                        $sqlAsli        = "INSERT INTO doc_ms_file (doc_ms_file_upload,
                                                                    doc_ms_file_type,
                                                                    doc_ms_doc_id,
                                                                    doc_ms_file_created,
                                                                    doc_ms_file_createdby,
                                                                    doc_ms_file_sts,
                                                                    doc_ms_file_masa)
                                                            VALUES('$file_asli',
                                                                    '$txtExtAsli',
                                                                    '$dataID',
                                                                    '".date('Y-m-d H:i:s')."',
                                                                    '".$_SESSION['sys_role_id']."',
                                                                    'Y',
                                                                    'B')";
                        $qryAsli        = mysqli_query($koneksidb, $sqlAsli) or die ("gagal insert file asli". mysqli_errors());
                    }
                    if (! empty($_FILES['txtFilePDF']['tmp_name'])) {
                        $tgl            = date('ymdhis');
                        $file_pdf       = $_FILES['txtFilePDF']['name'];
                        $file_pdf       = stripslashes($file_pdf);
                        $file_pdf       = str_replace("'","",$file_pdf);
                        $txtExtPDF      = pathinfo($file_pdf, PATHINFO_EXTENSION);
                        $file_pdf       = $tgl."_".$_POST['txtNomor']."_".$_POST['txtNama']."_"."".$_POST['txtRevisi'].".".$txtExtPDF;
                        copy($_FILES['txtFilePDF']['tmp_name'],"file/".$file_pdf);


                        // INSERT FILE ASLI
                        $sqlPDF         = "INSERT INTO doc_ms_file (doc_ms_file_upload,
                                                                    doc_ms_file_type,
                                                                    doc_ms_doc_id,
                                                                    doc_ms_file_created,
                                                                    doc_ms_file_createdby,
                                                                    doc_ms_file_sts,
                                                                    doc_ms_file_masa)
                                                            VALUES('$file_pdf',
                                                                    '$txtExtPDF',
                                                                    '$dataID',
                                                                    '".date('Y-m-d H:i:s')."',
                                                                    '".$_SESSION['sys_role_id']."',
                                                                    'Y',
                                                                    'B')";
                        $qryPDF         = mysqli_query($koneksidb, $sqlPDF) or die ("gagal insert file PDF". mysqli_errors());
                    }

                    $sqlupdate  ="UPDATE doc_tr_usul SET doc_tr_usul_sts='C',
                                                        doc_tr_usul_updated='".date('Y-m-d H:i:s')."',
                                                        doc_tr_usul_updatedby='".$_SESSION['sys_role_id']."',
                                                        doc_ms_doc_id='$dataID'
                                                    WHERE doc_tr_usul_id='$txtKode'";
                    $qryupdate    = mysqli_query($koneksidb, $sqlupdate) or die ("gagal insert". mysqli_errors());

                    $_SESSION['info'] = 'success';
                    $_SESSION['pesan'] = 'Data usulan perubahan document berhasil diperbaharui dengan No. Usulan '.$txtNoUsul.'';
                    echo '<script>window.location="?page='.base64_encode(docdtprosestrusul).'"</script>';
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
                                

    $KodeEdit           = isset($_GET['id']) ?  base64_decode($_GET['id']) : $_POST['txtKode']; 
    $dataTglPengesahan  = isset($_POST['txtTglPengesahan']) ? $_POST['txtTglPengesahan'] : date('d-m-Y');
    $showSql            = "SELECT 
                            a.doc_tr_usul_id,
                            a.doc_tr_usul_createdby,
                            a.doc_tr_usul_no,
                            a.sys_bagian_id,
                            b.sys_bagian_nm,
                            a.doc_tr_usul_jns,
                            a.doc_ms_jns_doc_id,
                            c.doc_ms_jns_doc_nm,
                            a.doc_ms_kat_doc_id,
                            d.doc_ms_kat_doc_nm,
                            a.doc_tr_usul_isi,
                            a.doc_tr_usul_alasan,
                            a.doc_tr_usul_usulan,
                            a.doc_ms_doc_id,
                            e.doc_ms_doc_kd
                            FROM doc_tr_usul a
                            INNER JOIN sys_bagian b ON a.sys_bagian_id=a.sys_bagian_id
                            INNER JOIN doc_ms_jns_doc c ON a.doc_ms_jns_doc_id=c.doc_ms_jns_doc_id
                            INNER JOIN doc_ms_kat_doc d ON a.doc_ms_kat_doc_id=d.doc_ms_kat_doc_id
                            LEFT JOIN doc_ms_doc e ON a.doc_ms_doc_id=e.doc_ms_doc_id
                            WHERE a.doc_tr_usul_id='$KodeEdit'";
    $showQry            = mysqli_query($koneksidb, $showSql)  or die ("Query ambil data department salah : ".mysqli_errors());
    $showRow            = mysqli_fetch_array($showQry);
    $dataKode           = $showRow['doc_tr_usul_id'];
    $dataIDDoc          = $showRow['doc_ms_doc_id'];
    $dataNoUsul         = $showRow['doc_tr_usul_no'];

    if($showRow['doc_tr_usul_jns']==1){
    	$dataJnsUsul 	= 'BARU';
    }elseif($showRow['doc_tr_usul_jns']==2){
    	$dataJnsUsul 	= 'PERUBAHAN';
    }

    $dataTanggal        = isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : '';
    $dataKategori       = isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $showRow['doc_ms_kat_doc_id']; 
    $dataJenis          = isset($_POST['cmbJenis']) ? $_POST['cmbJenis'] : $showRow['doc_ms_jns_doc_id']; 
    $dataBagian         = isset($_POST['cmbBagian']) ? $_POST['cmbBagian'] : $showRow['sys_bagian_id']; 
    $dataNomor          = isset($_POST['txtNomor']) ? $_POST['txtNomor'] : $showRow['doc_ms_doc_kd']; 

    $revSql             = "SELECT ISNULL(SUM(doc_ms_doc_rev), 0) as doc_ms_doc_rev FROM doc_ms_doc WHERE doc_ms_doc_id='$txtIDDoc'";
    $revQry             = mysqli_query($koneksidb, $revSql) or die ("Gagal cek value".mysqli_errors()); 
    $revRow             = mysqli_fetch_array($revQry);
    // APABILA REVISI MENCAPAI 8 AKAN KEMBALI KE 0
    if($revRow['doc_ms_doc_rev']>=8 AND $dataJnsUsul=='PERUBAHAN'){
        $dataRevisi     = 0;
    }elseif($revRow['doc_ms_doc_rev']==0 AND $dataJnsUsul=='PERUBAHAN'){
        $dataRevisi     = $revRow['doc_ms_doc_rev']+1;
    }elseif($dataJnsUsul=='BARU'){
        $dataRevisi     = 0;
    }
    $dataNama           = isset($_POST['txtNama']) ? $_POST['txtNama'] : $showRow['doc_tr_usul_isi'];

?>
<div class="portlet box <?php echo $dataPanel; ?>">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject uppercase">Form Proses Perubahan Document</span>
        </div>
        <div class="tools">
            <a href="" class="collapse"> </a>
            <a href="#portlet-config" data-toggle="modal" class="config"> </a>
            <a href="" class="reload"> </a>
            <a href="" class="remove"> </a>
        </div>
    </div>
    <div class="portlet-body form">
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal form-bordered" autocomplete="off" enctype="multipart/form-data">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-lg-2 control-label">No. Usulan :</label>
                    <div class="col-lg-3">
                        <input type="text" name="txtNoUsul" value="<?php echo $dataNoUsul; ?>" class="form-control" readonly/>
                        <input type="hidden" name="txtJnsUsul" value="<?php echo $showRow['doc_tr_usul_jns']; ?>" />
                        <input type="hidden" name="txtKode" value="<?php echo $dataKode; ?>" />
                     </div>
                </div>
                <?php if($showRow['doc_tr_usul_jns']==1){ ?>
                <div class="form-group">
                    <label class="col-lg-2 control-label">Jenis Usulan :</label>
                    <div class="col-lg-3">
                        <input type="text" value="<?php echo $dataJnsUsul; ?>" class="form-control" disabled/>
                     </div>
                </div>
                <?php } ?>
                <div class="form-group">
                    <label class="col-lg-2 control-label">No. Dokumen :</label>
                    <div class="col-lg-3">
                        <input type="text" name="txtNomor" value="<?php echo $dataNomor; ?>" class="form-control" placeholder="Enter Number" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
                        <input type="hidden" name="txtIDDoc" value="<?php echo $dataIDDoc; ?>"/>
                     </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Kategori :</label>
                    <div class="col-md-3">
                        <select name="cmbKategori" data-placeholder="Select Category" class="select2 form-control">
                            <option value=""></option> 
                            <?php
                                  $dataSql = "SELECT * FROM doc_ms_kat_doc WHERE doc_ms_kat_doc_sts='Y' ORDER BY doc_ms_kat_doc_id DESC";
                                  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
                                  while ($dataRow = mysqli_fetch_array($dataQry)) {
                                    if ($dataKategori == $dataRow['doc_ms_kat_doc_id']) {
                                        $cek = " selected";
                                    } else { $cek=""; }
                                    echo "<option value='$dataRow[doc_ms_kat_doc_id]' $cek>$dataRow[doc_ms_kat_doc_nm]</option>";
                                  }
                                  $sqlData ="";
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Jenis Dokumen :</label>
                    <div class="col-md-4">
                        <select name="cmbJenis" data-placeholder="Select Type" class="select2 form-control">
                            <option value=""></option> 
                            <?php
                                  $dataSql = "SELECT * FROM doc_ms_jns_doc WHERE doc_ms_jns_doc_sts='Y' ORDER BY doc_ms_jns_doc_id DESC";
                                  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
                                  while ($dataRow = mysqli_fetch_array($dataQry)) {
                                    if ($dataJenis == $dataRow['doc_ms_jns_doc_id']) {
                                        $cek = " selected";
                                    } else { $cek=""; }
                                    echo "<option value='$dataRow[doc_ms_jns_doc_id]' $cek>$dataRow[doc_ms_jns_doc_kd] - $dataRow[doc_ms_jns_doc_nm]</option>";
                                  }
                                  $sqlData ="";
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Nama Bagian :</label>
                    <div class="col-md-4">
                        <select name="cmbBagian" data-placeholder="Select Departemen" class="select2 form-control">
                            <option value=""></option> 
                            <?php
                                  $dataSql = "SELECT * FROM sys_bagian WHERE sys_bagian_sts='Y' ORDER BY sys_bagian_id DESC";
                                  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errors());
                                  while ($dataRow = mysqli_fetch_array($dataQry)) {
                                    if ($dataBagian == $dataRow['sys_bagian_id']) {
                                        $cek = " selected";
                                    } else { $cek=""; }
                                    echo "<option value='$dataRow[sys_bagian_id]' $cek>$dataRow[sys_bagian_kd] - $dataRow[sys_bagian_nm]</option>";
                                  }
                                  $sqlData ="";
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">Judul Dokumen :</label>
                    <div class="col-lg-9">
                        <input type="text" name="txtNama" value="<?php echo $dataNama; ?>" class="form-control" placeholder="Enter Title" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
                     </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">Revisi :</label>
                    <div class="col-lg-2">
                        <input type="text" name="txtRevisi" value="<?php echo $dataRevisi; ?>" class="form-control" placeholder="Enter Revision" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
                     </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">Tgl. Pengesahan :</label>
                    <div class="col-lg-3">
                        <input type="text" name="txtTanggal" value="<?php echo $dataTanggal; ?>" class="form-control date-picker" placeholder="Enter Date" data-date-format="dd-mm-yyyy"/>
                     </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">Dokumen Asli :</label>
                    <div class="col-md-9">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <span class="btn default btn-file">
                                <span class="fileinput-new">
                                     Select file
                                </span>
                                <span class="fileinput-exists">
                                     Change
                                </span>
                                <input type="file" name="txtFileAsli">
                            </span>
                            <span class="fileinput-filename">
                            </span>
                             &nbsp;
                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"></a>

                            
                        </div>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">Dokumen PDF :</label>
                    <div class="col-md-9">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <span class="btn default btn-file">
                                <span class="fileinput-new">
                                     Select file
                                </span>
                                <span class="fileinput-exists">
                                     Change
                                </span>
                                <input type="file" name="txtFilePDF">
                            </span>
                            <span class="fileinput-filename">
                            </span>
                             &nbsp;
                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"></a>

                            
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-2 col-md-10">
                        <button type="submit" name="btnSave" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-save"></i> Simpan Data</button>
                        <a href="?page=<?php echo base64_encode(docdtprosestrusul) ?>" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-undo"></i> Kembali</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>



