
<?php
	require_once("../plugin/jasper/autoload.dist.php");
	require_once("../config/inc.library.php");
	use Jaspersoft\Client\Client;

	$dataOrg		= $_POST['cmbOrg'];
	$dataBarang		= $_POST['cmbBarang'];
	$dataDoc		= $_POST['cmbDoc'];
	$dataSupplier	= $_POST['cmbSupplier'];
	$dataAct		= $_POST['cmbAct'];
	$tglAwal 		= InggrisTgl($_POST['txtTglAwal']);
	$tglAkhir		= InggrisTgl($_POST['txtTglAkhir']);
	$control 		= array(
						    'tgl1' 			=> $tglAwal,
						    'tgl2'			=> $tglAkhir,
						    'ad_org_id'		=> $dataOrg,
						    'c_bpartner_id'	=> $dataSupplier,
						    'documentno'	=> $dataDoc,
						    'm_product_id'	=> $dataBarang
							);

	$c = new Client(
	                "http://192.168.2.9:8080/jasperserver",
	                "jasperadmin",
	                "admin2018SKI"
    );

	if($dataAct=='PDF'){
		$report = $c->reportService()->runReport('/reports/Procurement/Purchase_Order_Report', 'pdf', null, null, $control);
		header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Description: File Transfer');
        //header('Content-Disposition: attachment; filename=report.pdf');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . strlen($report));
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="Purchase_Order_Report_'.date('ymdhis').'.pdf"');
        echo $report;
	}elseif($dataAct=='EXCEL'){
		$report = $c->reportService()->runReport('/reports/Procurement/Purchase_Order_Report', 'xls', null, null, $control);
        header('Cache-Control: must-revalidate');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . strlen($report));
        header("Content-type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename="Purchase_Order_Report_'.date(dmyhis).'.xls"');
        ob_clean();
        flush();
        echo $report;

	}
	
?>