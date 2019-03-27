<div class="portlet box grey-cascade">
    <div class="portlet-title">
        <div class="caption"><span class="caption-subject uppercase">Standard Global Detail</span></div>
        <div class="tools">
            <a href="javascript:;" class="collapse"></a>
            <a href="javascript:;" class="reload"></a>
            <a href="javascript:;" class="remove"></a>
        </div>
    </div>
    <div class="portlet-body">
    	<div class="panel-group accordion" id="accordion3">
            <div class="panel panel-default">
            	<?php
						$dataSql = "SELECT * FROM doc_ms_doc a
									INNER JOIN doc_ms_kat_doc b ON a.doc_ms_kat_doc_id=b.doc_ms_kat_doc_id
									INNER JOIN sys_bagian d ON a.sys_bagian_id=d.sys_bagian_id
									WHERE a.doc_ms_doc_link='".$_GET['id']."'";
						$dataQry = mysqli_query($koneksidb, $dataSql);
						$nomor  = 0; 
						while ($data = mysqli_fetch_array($dataQry)) {
						$nomor++;
						$ID = $data['doc_ms_doc_id'];
				?>

                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#<?php echo $ID ?>"> <?php echo $data['doc_ms_doc_type'].' - '.$data['doc_ms_doc_nm'] ?> </a>
                    </h4>
                </div>
                <div id="<?php echo $ID ?>" class="panel-collapse collapse">
                    <div class="panel-body">
                        <?php
                            if(!empty($data['doc_ms_doc_pdf'])){
                        ?>
                        <embed src="./file/<?php echo $data['doc_ms_doc_pdf']; ?>#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" width="100%" height="500px" />
                        <?php }else{ ?>
                            <div class="note note-danger">
                                <span class="help-block">Tidak ada file pdf yang di upload, silahkan upload file pdf terlebih dahulu </span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
            </div>
        </div>
    </div>
</div>