
<?php
	require_once("../plugin/jasper/autoload.dist.php");
	require_once("../config/inc.library.php");
	use Jaspersoft\Client\Client;

	$dataKategori		= $_GET['kat'];
	$dataModul			= $_GET['mdl'];
	$dataAct			= $_GET['act'];
	$tglAwal 			= $_GET['tgl1'];
	$tglAkhir			= $_GET['tgl2'];
	$control 			= array(
							    'tgl1' 					=> $tglAwal,
							    'tgl2'					=> $tglAkhir,
							    'tic_ms_modul_id'		=> $dataModul,
							    'tic_ms_kat_id'			=> $dataKategori
								);

	$c = new Client(
	                "http://192.168.2.9:8080/jasperserver",
	                "jasperadmin",
	                "admin2018SKI"
    );

	if($dataAct=='PDF'){
		$report = $c->reportService()->runReport('/reports/Ticket/Report_Ticketing', 'pdf', null, null, $control);
		header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Description: File Transfer');
        //header('Content-Disposition: attachment; filename=report.pdf');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . strlen($report));
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="Report_Ticketing_'.date('ymdhis').'.pdf"');
        echo $report;
	}elseif($dataAct=='EXCEL'){
		$report = $c->reportService()->runReport('/reports/Ticket/Report_Ticketing', 'xls', null, null, $control);
        header('Cache-Control: must-revalidate');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . strlen($report));
        header("Content-type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename="Report_Ticketing_'.date(dmyhis).'.xls"');
        ob_clean();
        flush();
        echo $report;

	}
	
?>