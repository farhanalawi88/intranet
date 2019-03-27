
<?php
	require_once("../plugin/jasper/autoload.dist.php");
	require_once("../config/inc.library.php");
	use Jaspersoft\Client\Client;

	$dataSumber			= $_GET['sumber'];
	$dataKategori		= $_GET['kategori'];
	$dataBagian			= $_GET['bagian'];
	$dataTindak			= $_GET['tindak'];
	$dataMonitor		= $_GET['monitor'];
	$dataAct			= $_GET['act'];
	$tglAwal 			= $_GET['tgl1'];
	$tglAkhir			= $_GET['tgl2'];
	$control 			= array(
							    'tgl1' 					=> $tglAwal,
							    'tgl2'					=> $tglAkhir,
							    'ptkp_ms_sumber_id'		=> $dataSumber,
							    'sys_bagian_id'			=> $dataBagian,
							    'ptkp_ms_kategori_id'	=> $dataKategori,
							    'ptkp_tr_ptkp_tindakan'	=> $dataTindak,
							    'ptkp_tr_ptkp_sts'		=> $dataMonitor
								);

	$c = new Client(
	                "http://192.168.2.9:8080/jasperserver",
	                "jasperadmin",
	                "admin2018SKI"
    );

	if($dataAct=='PDF'){
		$report = $c->reportService()->runReport('/reports/MR/PTKP_Report', 'pdf', null, null, $control);
		header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Description: File Transfer');
        //header('Content-Disposition: attachment; filename=report.pdf');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . strlen($report));
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="Report_PTKP'.date('ymdhis').'.pdf"');
        echo $report;
	}elseif($dataAct=='EXCEL'){
		$report = $c->reportService()->runReport('/reports/MR/PTKP_Report', 'xls', null, null, $control);
        header('Cache-Control: must-revalidate');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . strlen($report));
        header("Content-type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename="Report_PTKP'.date(dmyhis).'.xls"');
        ob_clean();
        flush();
        echo $report;

	}
	
?>