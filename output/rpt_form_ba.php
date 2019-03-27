
<?php
require_once("../plugin/jasper/autoload.dist.php");
use Jaspersoft\Client\Client;
$dataTransaksi = $_GET['id'];

$control = array(
    'tic_tr_ticket_id' => $dataTransaksi
);

$c = new Client(
                "http://192.168.2.9:8080/jasperserver",
                "jasperadmin",
                "admin2018SKI"
        );

$report = $c->reportService()->runReport('/reports/Ticket/Form_BA', 'pdf', null, null, $control);
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Description: File Transfer');
//header('Content-Disposition: attachment; filename=report.pdf');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . strlen($report));
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="BA_'.$dataTransaksi.'.pdf"');

echo $report;
?>