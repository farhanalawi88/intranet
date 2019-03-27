
<?php
	require_once("../plugin/jasper/autoload.dist.php");
	require_once("../config/inc.library.php");
	use Jaspersoft\Client\Client;

	$dataJenis			= $_GET['jns'];
	$dataPetugas		= $_GET['ptgs'];
	$dataKlasifikasi	= $_GET['kls'];
	$dataAct			= $_GET['act'];
	$tglAwal 			= $_GET['tgl1'];
	$tglAkhir			= $_GET['tgl2'];
	$control 			= array(
							    'tgl1' 					=> $tglAwal,
							    'tgl2'					=> $tglAkhir,
							    'load_ms_jns_kend_id'	=> $dataJenis,
							    'load_ms_petugas_id'	=> $dataPetugas,
							    'load_ms_klasifikasi_id'=> $dataKlasifikasi
								);

	$c = new Client(
	                "http://192.168.2.9:8080/jasperserver",
	                "jasperadmin",
	                "admin2018SKI"
    );

	if($dataAct=='PDF'){
		$report = $c->reportService()->runReport('/reports/Loading/Report_Inout_Masuk', 'pdf', null, null, $control);
		header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Description: File Transfer');
        //header('Content-Disposition: attachment; filename=report.pdf');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . strlen($report));
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="Report_Inout_Masuk_'.date('ymdhis').'.pdf"');
        echo $report;
	}elseif($dataAct=='EXCEL'){
		$report = $c->reportService()->runReport('/reports/Loading/Report_Inout_Masuk', 'xls', null, null, $control);
        header('Cache-Control: must-revalidate');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . strlen($report));
        header("Content-type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename="Report_Inout_Masuk_'.date(dmyhis).'.xls"');
        ob_clean();
        flush();
        echo $report;

	}
	
?>