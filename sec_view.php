<?php 

$KodeEdit           = isset($_GET['id']) ?  base64_decode($_GET['id']) : $_POST['txtKode']; 
$showSql            = "SELECT * FROM as_sec 
                        WHERE as_sec_id='$KodeEdit'";
$showQry            = mysqli_query($koneksidb, $showSql)  or die ("Query ambil data department salah : ".mysqli_errors());
$showRow            = mysqli_fetch_array($showQry);
$dataVideo          = $showRow['as_sec_video'];
$dataPDF            = $showRow['as_sec_pdf'];

?>
<div class="portlet box blue-chambray">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject uppercase">Data Education Center Detail</span>
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse"></a>
            <a href="javascript:;" class="reload"></a>
            <a href="javascript:;" class="remove"></a>
        </div>
	</div>
	<div class="portlet-body">
        <ul class="nav nav-pills">
            <li class="active"><a href="#desc" data-toggle="tab"> Description </a></li>
            <li><a href="#video" data-toggle="tab"> Video Tutorial </a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade active in" id="desc">
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
            <div class="tab-pane fade" id="video">
                <?php
                    if(!empty($dataVideo)){
                ?>
                <video width="100%" height="100%" controls>
                    <source src="./file/<?php echo $dataVideo; ?>" type="video/mp4">
                </video>
                <?php }else{ ?>
                    <div class="note note-danger">
                        <span class="help-block">Tidak ada file video yang di upload</span>
                    </div>
                <?php } ?>
            </div>
           
        </div>
    </div>
</div>