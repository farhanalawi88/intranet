
<?php
	require_once("../plugin/jasper/autoload.dist.php");
	require_once("../config/inc.library.php");
	use Jaspersoft\Client\Client;

		$dataTanggal 	= InggrisTgl($_POST['txtTanggal']);
		$dataWarehouse	= $_POST['cmbWarehouse'];
		$dataOrganisasi	= $_POST['cmbOrganisasi'];
		$dataNama		= $_POST['txtNama'];
		$dataKeterangan	= $_POST['txtKeterangan'];
		$dataAct		= $_POST['cmbAct'];

		$control = array(
						'movement_date' 		=> $dataTanggal,
					    'm_locator_id'			=> $dataWarehouse,
					    'ad_org_id'				=> $dataOrganisasi,
					    'name'					=> $dataNama,
					    'description'			=> $dataKeterangan
						);

		$c = new Client(
		                "http://192.168.2.9:8080/jasperserver",
		                "jasperadmin",
		                "admin2018SKI"
		        );

		if($dataAct=='PDF'){
			$report = $c->reportService()->runReport('/reports/Procurement/Form_Upload_Stock_Barang', 'pdf', null, null, $control);
			header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Description: File Transfer');
            //header('Content-Disposition: attachment; filename=report.pdf');
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . strlen($report));
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="Form_Upload_Stock_Barang_'.date('ymdhis').'.pdf"');
            echo $report;
		}elseif($dataAct=='EXCEL'){
			$report = $c->reportService()->runReport('/reports/Procurement/Form_Upload_Stock_Barang', 'xls', null, null, $control);
	        header('Cache-Control: must-revalidate');
	        header('Content-Transfer-Encoding: binary');
	        header('Content-Length: ' . strlen($report));
	        header("Content-type: application/vnd.ms-excel");
	        header('Content-Disposition: attachment; filename="Form_Upload_Stock_Barang_'.date(dmyhis).'.xls"');
	        ob_clean();
	        flush();
	        echo $report;

		}elseif($dataAct=='CSV'){
			$report = $c->reportService()->runReport('/reports/Procurement/Form_Upload_Stock_Barang', 'csv', null, null, $control);
	        header('Cache-Control: must-revalidate');
	        header('Content-Transfer-Encoding: binary');
	        header('Content-Length: ' . strlen($report));
	        header('Content-Type: text/csv');
	        header('Content-Disposition: attachment; filename="Form_Upload_Stock_Barang_'.date(dmyhis).'.csv"');
	        ob_clean();
	        flush();
	        echo $report;

		}

?>