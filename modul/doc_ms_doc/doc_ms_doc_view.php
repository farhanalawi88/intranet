<?php 

$KodeEdit           = isset($_GET['id']) ?  base64_decode($_GET['id']) : $_POST['txtKode']; 
$showSql            = "SELECT 
                        doc_ms_doc_id,
                        doc_ms_doc_createdby,
                        doc_ms_doc_pdf,
                        doc_ms_doc_word
                        FROM doc_ms_doc 
                        WHERE doc_ms_doc_id='$KodeEdit'";
$showQry            = mysqli_query($koneksidb, $showSql)  or die ("Query ambil data department salah : ".mysqli_errors());
$showRow            = mysqli_fetch_array($showQry);
$dataKode           = $showRow['doc_ms_doc_id'];
$dataPDF            = $showRow['doc_ms_doc_pdf'];
$dataWord           = $showRow['doc_ms_doc_word'];

?>
<div class="portlet box <?php echo $dataPanel; ?>">
    <div class="portlet-title">
        <div class="caption"><span class="caption-subject uppercase">Form View Document</span></div>
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
                        <li class="active"><a data-toggle="tab" href="#tab_1-1"><i class="fa fa-calendar"></i> View History </a></li>
                        <li><a data-toggle="tab" href="#tab_2-2"><i class="fa fa-file-pdf-o"></i> View Document </a><span class="after"> </span></li>
                    </ul>
                </div>
                <div class="col-md-8">
                    <div class="tab-content">
                        <div id="tab_2-2" class="tab-pane">
                            <?php
                                if(!empty($dataPDF)){
                            ?>
                            <embed src="./file/<?php echo $dataPDF; ?>#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" width="100%" height="500px" />
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
                                                $msgSql = "select 
                                                                a.doc_tr_usul_usulan,
                                                                a.doc_tr_usul_tgl as doc_tr_usul_tgl,
                                                                c.sys_bagian_nm,
                                                                (d.sys_role_nama) as dibuat_oleh
                                                                from doc_tr_usul a
                                                                inner join doc_ms_doc b on a.doc_ms_doc_id=b.doc_ms_doc_id
                                                                inner join sys_bagian c on a.sys_bagian_id=c.sys_bagian_id
                                                                inner join sys_role d on a.doc_tr_usul_createdby=d.sys_role_id
                                                            WHERE a.doc_ms_doc_id='$dataKode'";
                                                $msgQry = mysqli_query($koneksidb, $msgSql);
                                                $nomor  = 0; 
                                                while ($msgRow = mysqli_fetch_array($msgQry)) {
                                                $nomor++;
                                        ?>
                                        <li class="in">
                                            <div class="message">
                                                <span class="arrow"> </span>
                                                <a href="javascript:;" class="name"> <?php echo $msgRow['dibuat_oleh'] ?> </a>
                                                <span class="datetime"> at <?php echo IndonesiaTgl($msgRow['doc_tr_usul_tgl']) ?> </span>
                                                <span class="body"> <?php echo $msgRow['doc_tr_usul_usulan'] ?> </span>
                                            </div>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <a href="?page=<?php echo base64_encode(docdtmsdoc) ?>" class="btn <?php echo $dataPanel; ?>"><i class="fa fa-folder-open"></i> Data Dokumen</a>  
        </div>
    </div>
</div>



