<?php
            
if(isset($_POST['btnSend'])){                        
    $txtPesan      = $_POST['txtPesan'];             
    $txtKode       = $_POST['txtKode'];
       
    $sqlSave="INSERT INTO doc_tr_usul_msg (doc_tr_usul_msg_pesan,
                                        doc_tr_usul_id,
                                        doc_tr_usul_msg_created,
                                        doc_tr_usul_msg_createdby)
                                VALUES('$txtPesan',
                                        '$txtKode',
                                        '".date('Y-m-d H:i:s')."',
                                        '".$_SESSION['sys_role_id']."')";
    $qrySave    = mysqli_query($koneksidb, $sqlSave) or die ("gagal insert". mysqli_errors());
    
} 
if(isset($_POST['btnApprove'])){                       
    $txtKode       = $_POST['txtKode'];            
    $txtNoDoc      = $_POST['txtNoDoc'];
       
    $hapus=mysqli_query($koneksidb,"UPDATE doc_tr_usul SET doc_tr_usul_sts='Y',
                                                                    doc_tr_usul_approvedby='".$_SESSION['sys_role_id']."',
                                                                    doc_tr_usul_approved='".date('Y-m-d H:i:s')."'
                                                                 WHERE doc_tr_usul_id='$txtKode'") 
        or die ("Gagal kosongkan tmp".mysqli_errors());
    if($hapus){
        $_SESSION['info'] = 'success';
        $_SESSION['pesan'] = 'Data usulan perubahan dokumen dengan No. '.$txtNoDoc.' berhasil diapprove';
        echo '<script>window.location="?page='.base64_encode(docdtapptrusul).'"</script>';
    }
    
} 
                                

$KodeEdit           = isset($_GET['id']) ?  base64_decode($_GET['id']) : $_POST['txtKode']; 
$showSql            = "SELECT 
                        a.doc_tr_usul_id,
                        a.doc_tr_usul_createdby,
                        a.doc_tr_usul_no,
                        a.doc_tr_usul_jns,
                        a.doc_tr_usul_isi,
                        b.sys_bagian_nm,
                        c.doc_ms_kat_doc_nm,
                        d.doc_ms_jns_doc_nm,
                        a.doc_tr_usul_usulan,
                        a.doc_tr_usul_alasan
                        FROM doc_tr_usul a
                        INNER JOIN sys_bagian b ON a.sys_bagian_id=b.sys_bagian_id
                        INNER JOIN doc_ms_kat_doc c ON a.doc_ms_kat_doc_id=c.doc_ms_kat_doc_id
                        INNER JOIN doc_ms_jns_doc d ON a.doc_ms_jns_doc_id=d.doc_ms_jns_doc_id
                        WHERE a.doc_tr_usul_id='$KodeEdit'";
$showQry            = mysqli_query($koneksidb, $showSql)  or die ("Query ambil data department salah : ".mysqli_errors());
$showRow            = mysqli_fetch_array($showQry);
$dataKode           = $showRow['doc_tr_usul_id'];

if($showRow['doc_tr_usul_jns']==1){
    $dataJnsUsul    = 'BARU';
}elseif($showRow['doc_tr_usul_jns']==2){
    $dataJnsUsul    = 'PERUBAHAN';
}


?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" autocomplete="off">
    <div class="portlet box <?php echo $dataPanel; ?>">
        <div class="portlet-title">
            <div class="caption"><span class="caption-subject uppercase">Form View Document & Comment </span></div>
            <div class="tools">
                <a href="javascript:;" class="collapse"> </a>
                <a href="javascript:;" class="reload"> </a>
                <a href="javascript:;" class="remove"> </a>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="form-body">
                <div class="row profile-account">
                    <div class="col-md-4">
                        <ul class="ver-inline-menu tabbable margin-bottom-10">
                            <li class="active"><a data-toggle="tab" href="#tab_1-1"><i class="fa fa-commenting-o"></i> Send Comment </a></li>
                            <li><a data-toggle="tab" href="#tab_2-2"><i class="fa fa-file-pdf-o"></i> View Document </a><span class="after"> </span></li>
                            <li><a data-toggle="tab" href="#tab_2-3"><i class="fa fa-check-square-o"></i> Approve Data </a><span class="after"> </span></li>
                        </ul>
                    </div>
                    <div class="col-md-8">
                        <div class="tab-content">
                            <div id="tab_2-2" class="tab-pane">
                                <?php
                                    $fileSql            = "SELECT 
                                                            doc_tr_usul_file_upload
                                                            FROM doc_tr_usul_file 
                                                            WHERE doc_tr_usul_id='$dataKode'
                                                            AND doc_tr_usul_file_type='pdf'";
                                    $fileQry            = mysqli_query($koneksidb, $fileSql)  or die ("Query ambil data department salah : ".mysqli_errors());
                                    $fileRow            = mysqli_fetch_array($fileQry);
                                    
                                    $dataUpload         = $fileRow['doc_tr_usul_file_upload'];
                                ?>
                                <?php
                                    if(!empty($dataUpload)){
                                ?>
                                <embed src="./file/<?php echo $dataUpload; ?>#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" width="100%" height="500px" />
                                <?php }else{ ?>
                                    <div class="note note-danger">
                                        <span class="help-block">Tidak ada file pdf yang di upload, silahkan upload file pdf terlebih dahulu </span>
                                    </div>
                                <?php } ?>
                            </div>
                            <div id="tab_1-1" class="tab-pane active">
                                
                                <div class="portlet-body" id="chats">
                        
                                    <div class="scroller" style="max-height: 325px;" data-always-visible="1" data-rail-visible1="1">
                                        <ul class="chats">
                                            <?php
                                                    $msgSql = "SELECT 
                                                                    a.doc_tr_usul_msg_pesan,
                                                                    CONVERT(CHAR(17),a.doc_tr_usul_msg_created,113) as doc_tr_usul_msg_created,
                                                                    b.sys_role_nama,
                                                                    a.doc_tr_usul_msg_createdby
                                                                FROM doc_tr_usul_msg a
                                                                INNER JOIN sys_role b ON a.doc_tr_usul_msg_createdby=b.sys_role_id
                                                                WHERE a.doc_tr_usul_id='$dataKode'
                                                                ORDER BY a.doc_tr_usul_msg_id ASC";
                                                    $msgQry = mysqli_query($koneksidb, $msgSql);
                                                    $nomor  = 0; 
                                                    while ($msgRow = mysqli_fetch_array($msgQry)) {
                                                    $nomor++;
                                                    if($msgRow['doc_tr_usul_msg_createdby']==$showRow['doc_tr_usul_createdby']){
                                                        $masukan= "in";
                                                    }else{
                                                        $masukan= "out";
                                                    }
                                            ?>
                                            <li class="<?php echo $masukan ?>">
                                                <div class="message">
                                                    <span class="arrow"> </span>
                                                    <a href="javascript:;" class="name"> <?php echo $msgRow['sys_role_nama'] ?> </a>
                                                    <span class="datetime"> at <?php echo $msgRow['doc_tr_usul_msg_created'] ?> </span>
                                                    <span class="body"> <?php echo $msgRow['doc_tr_usul_msg_pesan'] ?> </span>
                                                </div>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                    <div class="chat-form">
                                        <div class="input-cont">
                                            <input class="form-control" type="text" placeholder="Type a message here..." name="txtPesan" /> 
                                            <input class="form-control" type="hidden" name="txtKode"  value="<?php echo $KodeEdit ?>" /> 
                                        </div>
                                        <div class="btn-cont">
                                            <button type="submit" name="btnSend" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-check icon-white"></i></button>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                            <div id="tab_2-3" class="tab-pane">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">No. Pengajuan</label>
                                            <input type="text" class="form-control" name="txtNoDoc" value="<?php echo $showRow['doc_tr_usul_no'] ?>" readonly/> 
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Jenis Pengajuan</label>
                                            <input type="text" class="form-control" value="<?php echo $dataJnsUsul ?>" disabled/> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Nama Bagian</label>
                                            <input type="text" class="form-control" value="<?php echo $showRow['sys_bagian_nm'] ?>" readonly/> 
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Kategori</label>
                                            <input type="text" class="form-control" value="<?php echo $showRow['doc_ms_kat_doc_nm'] ?>" disabled/> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Subject</label>
                                            <input type="text" class="form-control" value="<?php echo $showRow['doc_ms_jns_doc_nm'] ?>" readonly/> 
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Isi Dokumen</label>
                                            <input type="text" class="form-control" value="<?php echo $showRow['doc_tr_usul_isi'] ?>" readonly/> 
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Usulan</label>
                                    <input type="text" class="form-control" value="<?php echo $showRow['doc_tr_usul_usulan'] ?>" readonly/> 
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Alasan</label>
                                    <input type="text" class="form-control" value="<?php echo $showRow['doc_tr_usul_alasan'] ?>" readonly/> 
                                </div>
                                <hr>                                
                                <div class="margin-top-10">
                                    <button type="submit" name="btnApprove" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-save"></i> Approve Data</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>



