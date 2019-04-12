<?php

// http://phpbego.wordpress.com

// Koneksi database
define("DB_HOST", "192.168.2.9");
define("DB_NAME", "intranet_db");
define("DB_USER", "root");
define("DB_PASS", "password");

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($mysqli->connect_errno) {
    echo "Failed to connect to Database: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

// Error report
mysqli_report(MYSQLI_REPORT_ERROR);
// Sungguh, gua Putus asa browsing kemana2 tak juga ketemu untuk timezone Indonesia
// Saya siasati untuk menambah 1 hari berikutnya. 
// DATE_ADD(end, INTERVAL 1 DAY) AS endD
// Jika tanpa script ini, maka event end day akan berkurang 1 hari... Blooooonn
// 8 Ramadhan 1435H
$rs = $mysqli->query("SELECT as_trx_meet_sch_id, as_trx_meet_sch_agenda, as_trx_meet_sch_start, DATE_ADD(as_trx_meet_sch_end, INTERVAL 1 DAY) AS endD FROM as_trx_meet_sch ORDER BY as_trx_meet_sch_start ASC");
// $arr = array();
// Kalau anda lihat tutorial lain di internet, mereka menggunakan ini
// Tapi karena saya ingin menyesuaikan dengan Program, saya mengabaikan ini.

while($obj = mysqli_fetch_assoc($rs)) {
$arr[] = array(
        'id' => $obj['as_trx_meet_sch_id'],
        'title' => $obj['as_trx_meet_sch_agenda'],
        'start' => $obj['as_trx_meet_sch_start'],
		'end' => $obj['endD']);
		}
echo json_encode($arr);
?>

