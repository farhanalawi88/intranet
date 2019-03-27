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

?>
<div class="portlet box grey-cascade">
    <div class="portlet-title">
        <div class="caption"><span class="caption-subject">Standard Depertemen Detail</span></div>
        <div class="tools">
            <a href="javascript:;" class="collapse"></a>
            <a href="javascript:;" class="reload"></a>
            <a href="javascript:;" class="remove"></a>
        </div>
    </div>
    <div class="portlet-body">
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
</div>