
<?php
	require_once("../plugin/jasper/autoload.dist.php");
	require_once("../config/inc.library.php");
	use Jaspersoft\Client\Client;
	if(isset($_POST['btnPdf'])){


		$tglAwal 	= InggrisTgl($_POST['txtTglAwal']);
		$tglAkhir	= InggrisTgl($_POST['txtTglAkhir']);

		$control = array(
					    'tgl1' 		=> $tglAwal,
					    'tgl2'		=> $tglAkhir
						);

		$c = new Client(
		                "http://192.168.2.9:8080/jasperserver",
		                "jasperadmin",
		                "admin2018SKI"
		        );

		$report = $c->reportService()->runReport('/reports/Procurement/Outstanding_Purchase_Order_Report', 'pdf', null, null, $control);
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Description: File Transfer');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . strlen($report));
		header('Content-Type: application/pdf'); 
		echo $report;
	}
	if(isset($_POST['btnExcel'])){


		$tglAwal 	= InggrisTgl($_POST['txtTglAwal']);
		$tglAkhir	= InggrisTgl($_POST['txtTglAkhir']);

		$control = array(
					    'tgl1' 		=> $tglAwal,
					    'tgl2'		=> $tglAkhir
						);

		$c = new Client(
		                "http://192.168.2.9:8080/jasperserver",
		                "jasperadmin",
		                "admin2018SKI"
		        );

		$report = $c->reportService()->runReport('/reports/Procurement/Outstanding_Purchase_Order_Report', 'xls', null, null, $control);
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
        header('Content-Transfer-Encoding: binary');
        header('Content-Description: File Transfer');
        header('Content-Length: ' . strlen($report));
        header("Content-type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename="Outstanding_PO_Report.xls"');
		echo $report;
	}
?>