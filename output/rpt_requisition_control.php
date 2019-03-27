
<?php
	require_once("../plugin/jasper/autoload.dist.php");
	require_once("../config/inc.library.php");
	use Jaspersoft\Client\Client;
	
		$tglAwal 		= InggrisTgl($_POST['txtTglAwal']);
		$tglAkhir		= InggrisTgl($_POST['txtTglAkhir']);
		$dataOrganisasi	= $_POST['cmbOrganisasi'];
		$dataAct		= $_POST['cmbAct'];

		$control = array(
						'FDATE' 			=> $tglAwal,
					    'EDATE'				=> $tglAkhir,
					    'AD_Org_ID' 		=> $dataOrganisasi
						);

		$c = new Client(
		                "http://192.168.2.9:8080/jasperserver",
		                "jasperadmin",
		                "admin2018SKI"
		        );


		if($dataAct=='PDF'){
			$report = $c->reportService()->runReport('/reports/Procurement/Requsition_Control_Report', 'pdf', null, null, $control);
			header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Description: File Transfer');
            //header('Content-Disposition: attachment; filename=report.pdf');
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . strlen($report));
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="Requsition_Control_Report_'.date('ymdhis').'.pdf"');
            echo $report;

		}elseif($dataAct=='EXCEL'){
			$report = $c->reportService()->runReport('/reports/Procurement/Requsition_Control_Report', 'xls', null, null, $control);
	        header('Cache-Control: must-revalidate');
	        header('Content-Transfer-Encoding: binary');
	        header('Content-Length: ' . strlen($report));
	        header("Content-type: application/vnd.ms-excel");
	        header('Content-Disposition: attachment; filename="Requsition_Control_Report_'.date(dmyhis).'.xls"');
	        ob_clean();
	        flush();
	        echo $report;

		}


		
?>