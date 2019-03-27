<?php 

$KodeEdit           = isset($_GET['id']) ?  base64_decode($_GET['id']) : $_POST['txtKode']; 
$showSql            = "SELECT 
                        doc_tr_usul_id,
                        doc_tr_usul_createdby
                        FROM doc_tr_usul 
                        WHERE doc_tr_usul_id='$KodeEdit'";
$showQry            = mysqli_query($koneksidb, $showSql)  or die ("Query ambil data department salah : ".mysqli_errors());
$showRow            = mysqli_fetch_array($showQry);
$dataKode           = $showRow['doc_tr_usul_id'];

?>
<div class="portlet box <?php echo $dataPanel; ?>">
    <div class="portlet-title">
        <div class="caption"><span class="caption-subject uppercase bold">Form View Document & Comment </span></div>
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
                            <?php
        
                                if(isset($_POST['txtPesan'])){                        
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
                            ?>
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
                                    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" autocomplete="off">
                                        <div class="input-cont">
                                            <input class="form-control" type="text" placeholder="Type a message here..." name="txtPesan" /> 
                                            <input class="form-control" type="hidden" name="txtKode"  value="<?php echo $KodeEdit ?>" /> 
                                        </div>
                                        <div class="btn-cont">
                                            <button type="submit" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-check icon-white"></i></button>
                                        </div>
                                    </form>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>



