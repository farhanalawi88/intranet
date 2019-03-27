<?php
date_default_timezone_set("Asia/Jakarta");

# Fungsi untuk membuat kode automatis
function kodeUnik($tabel, $field, $inisial, $panjang,$tanggal){

 	$qry	= mysql_query("SELECT MAX(".$field.") FROM $tabel WHERE date(".$tanggal.")='".date('Y-m-d')."'");
 	$row	= mysql_fetch_array($qry); 
 	if ($row[0]=="") {
 		$angka=0;
	}
 	else {
 		$angka		= substr($row[0], strlen($inisial));
 	}
	
 	$angka++;
 	$angka	=strval($angka); 
 	$tmp	="";
 	for($i=1; $i<=($panjang-strlen($inisial)-strlen($angka)); $i++) {
		$tmp=$tmp."0";	
	}
 	return $inisial.$tmp.$angka;
}
function buatKode($tabel, $inisial){
	$struktur	= pg_query("SELECT * FROM $tabel");
	$field		= pg_field_name($struktur,0);
	$panjang	= pg_field_prtlen($struktur,0);

 	$qry	= pg_query("SELECT MAX(".$field.") FROM ".$tabel);
 	$row	= pg_fetch_assoc($qry); 
 	if ($row[0]=="") {
 		$angka=0;
	}
 	else {
 		$angka		= substr($row[0], strlen($inisial));
 	}
	
 	$angka++;
 	$angka	=strval($angka); 
 	$tmp	="";
 	for($i=1; $i<=($panjang-strlen($inisial)-strlen($angka)); $i++) {
		$tmp=$tmp."0";	
	}
 	return $inisial.$tmp.$angka;
}

# Fungsi untuk membalik tanggal dari format Indo -> English
function InggrisTgl($tanggal){
	$tgl=substr($tanggal,0,2);
	$bln=substr($tanggal,3,2);
	$thn=substr($tanggal,6,4);
	$awal="$thn-$bln-$tgl";
	return $awal;
}

# Fungsi untuk membalik tanggal dari format English -> Indo
function IndonesiaTgl($tanggal){
	$tgl=substr($tanggal,8,2);
	$bln=substr($tanggal,5,2);
	$thn=substr($tanggal,0,4);
	$awal="$tgl-$bln-$thn";
	return $awal;
}
function IndonesiaTgl2($tanggal){
	$tgl=substr($tanggal,8,2);
	$bln=substr($tanggal,5,2);
	$thn=substr($tanggal,0,4);
	$awal="$tgl/$bln/$thn";
	return $awal;
}

# Fungsi untuk membuat format rupiah pada angka (uang)
function format_angka($angka) {
	$hasil =  number_format($angka,0, ".",".");
	return $hasil;
}

function format_angka2($angka) {
	$hasil =  number_format($angka,0, ",",",");
	return $hasil;
}

# Fungsi untuk menghitung umur
function umur($birthday){
	date_default_timezone_set("Asia/Jakarta");

	list($year,$month,$day) = explode("-",$birthday);
	$year_diff = date("Y") - $year;
	$month_diff = date("m") - $month;
	$day_diff = date("d") - $day;
	if ($month_diff < 0) $year_diff--;
	elseif (($month_diff==0) && ($day_diff < 0)) $year_diff--;
	return $year_diff;
}

class pageNavi_Home{
		// Fungsi untuk mencek halaman dan posisi data
		function cariPosisi($batas) {
			if(empty($_GET['page'])) {
				$posisi = 0;
				$_GET['page'] = 1;
			} else {
				$posisi = ($_GET['page'] - 1) * $batas;
			}
			return $posisi;
		}
		
		// Fungsi untuk menghitung total halaman
		function jumlahHalaman($jmldata, $batas) {
			$jmlhalaman = ceil($jmldata/$batas);
			return $jmlhalaman;
		}
		
		// Fungsi untuk link halaman 1,2,3 
		function navHalaman($halaman_aktif, $jmlhalaman) {
			global $link;
			
			$link_halaman = "";
		
			// Link ke halaman pertama (first) dan sebelumnya (prev)
			if($halaman_aktif > 1) {
				$prev = $halaman_aktif - 1;
	
				if($prev > 1) { 
					$link_halaman .= "<a class=\"first\" href=\"page-1.html\"></a>";
				}			
				$link_halaman .= "<a class=\"previouspostslink\" href=\"page-".$prev.".html\"></a>";
			}
		
			$angka = ($halaman_aktif > 3 ? "<span>...</span>" : " "); 
			for($i = $halaman_aktif-2;$i < $halaman_aktif;$i++) {
				if ($i < 1) continue;
				$angka .= "<a href=\"page-".$i.".html\">".$i."</a>";
			}
			$angka .= "<span class=\"current\">".$halaman_aktif."</span>";
			  
			for($i=$halaman_aktif+1; $i<($halaman_aktif+3); $i++) {
				if($i > $jmlhalaman) break;
				$angka .= "<a href=\"page-".$i.".html\">".$i."</a>";
			}
			$angka .= ($halaman_aktif+2 < $jmlhalaman ? "<span>...</span><a href=\"page-".$jmlhalaman.".html\">".$jmlhalaman."</a>" : " ");
		
			$link_halaman .= $angka;
			 
			if($halaman_aktif < $jmlhalaman) {
				$next = $halaman_aktif + 1;
				$link_halaman .= "<a class=\"nextpostslink\" href=\"page-".$next.".html\"></a>";
				
				if($halaman_aktif != $jmlhalaman - 1) {
					$link_halaman .= "<a class=\"last\" href=\"page-".$jmlhalaman.".html\"></a>";
				}
			}
			
			return $link_halaman;
		}
	}	
  date_default_timezone_set("UTC");

  function dateDiff($time1, $time2, $precision = 6) {
    if (!is_int($time1)) {
      $time1 = strtotime($time1);
    }
    if (!is_int($time2)) {
      $time2 = strtotime($time2);
    }

    if ($time1 > $time2) {
      $ttime = $time1;
      $time1 = $time2;
      $time2 = $ttime;
    }

    $intervals = array('year','month','day','hour','minute','second');
    $diffs = array();

    foreach ($intervals as $interval) {
      $diffs[$interval] = 0;
      $ttime = strtotime("+1 " . $interval, $time1);
      while ($time2 >= $ttime) {
$time1 = $ttime;
$diffs[$interval]++;
$ttime = strtotime("+1 " . $interval, $time1);
      }
    }

    $count = 0;
    $times = array();
    foreach ($diffs as $interval => $value) {
      if ($count >= $precision) {
break;
      }
      if ($value > 0) {
if ($value != 1) {
 $interval .= "s";
}
$times[] = $value . " " . $interval;
$count++;
      }
    }

    return implode(", ", $times);
  }

function get_age($birth_date){
date_default_timezone_set("Asia/Jakarta");
return floor((time() - strtotime($birth_date))/31556926);
}
function sekianLama($format, $wkt) {
    $sekarang = date("Y-m-d");
    return date($format, strtotime(date("Y-m-d", strtotime($sekarang)) . " " . $wkt));
}
function restore($file) {
	global $rest_dir;
	$koneksi=mysql_connect("localhost","root","root");
	mysql_select_db("artikel",$koneksi);
	
	$nama_file	= $file['name'];
	$ukrn_file	= $file['size'];
	$tmp_file	= $file['tmp_name'];
	
	if ($nama_file == "")
	{
		echo "Fatal Error";
	}
	else
	{
		$alamatfile	= $rest_dir.$nama_file;
		$templine	= array();
		
		if (move_uploaded_file($tmp_file , $alamatfile))
		{
			
			$templine	= '';
			$lines		= file($alamatfile);

			foreach ($lines as $line)
			{
				if (substr($line, 0, 2) == '--' || $line == '')
					continue;
			 
				$templine .= $line;

				if (substr(trim($line), -1, 1) == ';'){
					mysql_query($templine); 
					$templine = '';
				}
			}
			echo "<div class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					<i class='icon-ok'></i> &nbsp;Berhasil Restore Database</div>";
		
		}else{
			echo "Proses upload gagal, kode error = " . $file['error'];
		}	
	}
	
}

function paginate_one($reload, $hal, $tpages) {
	
	$firstlabel = "&laquo;&nbsp;";
	$prevlabel  = "&lsaquo;&nbsp;";
	$nextlabel  = "&nbsp;&rsaquo;";
	$lastlabel  = "&nbsp;&raquo;";
	
	$out = "<ul>";
	
	// first
	if($hal>1) {
		$out.= "<li><a href=\"" . $reload . "\">" . $firstlabel . "</a></li>";
	}
	else {
		$out.= "<li><span>" . $firstlabel . "</span></li>";
	}
	
	// previous
	if($hal==1) {
		$out.= "<li><span>" . $prevlabel . "</span></li>";
	}
	elseif($hal==2) {
		$out.= "<li><a href=\"" . $reload . "\">" . $prevlabel . "</a></li>";
	}
	else {
		$out.= "<li><a href=\"" . $reload . "&amp;hal=" . ($hal-1) . "\">" . $prevlabel . "</a></li>";
	}
	
	// current
	$out.= "<li><span class=\"current\">Halaman " . $hal . " dari " . $tpages ."</span></li>";
	
	// next
	if($hal<$tpages) {
		$out.= "<li><a href=\"" . $reload . "&amp;hal=" .($hal+1) . "\">" . $nextlabel . "</a></li>";
	}
	else {
		$out.= "<li><span>" . $nextlabel . "</span></li>";
	}
	
	// last
	if($hal<$tpages) {
		$out.= "<li><a href=\"" . $reload . "&amp;hal=" . $tpages . "\">" . $lastlabel . "</a></li>";
	}
	else {
		$out.= "<li><span>" . $lastlabel . "</span></li>";
	}
	
	$out.= "</ul>";
	
	return $out;
}
function encrypt($str) {
    $kunci = '979a218e0632df2935317f98d47956c7';
    for ($i = 0; $i < strlen($str); $i++) {
        $karakter = substr($str, $i, 1);
        $kuncikarakter = substr($kunci, ($i % strlen($kunci))-1, 1);
        $karakter = chr(ord($karakter)+ord($kuncikarakter));
        $hasil .= $karakter;
        
    }
    return urlencode(base64_encode($hasil));
}

function decrypt($str) {
    $str = base64_decode(urldecode($str));
    $hasil = '';
    $kunci = '979a218e0632df2935317f98d47956c7';
    for ($i = 0; $i < strlen($str); $i++) {
        $karakter = substr($str, $i, 1);
        $kuncikarakter = substr($kunci, ($i % strlen($kunci))-1, 1);
        $karakter = chr(ord($karakter)-ord($kuncikarakter));
        $hasil .= $karakter;
        
    }
    return $hasil;
}

function randid($length){
//    karakter yang bisa dipakai sebagai password
    $string = "ABCDEFGHIJKLMNOPQRSTU1234567890";
    $len = strlen($string);
    
//    mengenerate password
    for($i=1;$i<=$length; $i++){
        $start = rand(0, $len);
        $pass .= substr($string, $start, 1);
    }
    
    return $pass;
}
function getRomawi($bln){
    switch ($bln){
        case 1: 
            return "I";
            break;
        case 2:
            return "II";
            break;
        case 3:
            return "III";
            break;
        case 4:
            return "IV";
            break;
        case 5:
            return "V";
            break;
        case 6:
            return "VI";
            break;
        case 7:
            return "VII";
            break;
        case 8:
            return "VIII";
            break;
        case 9:
            return "IX";
            break;
        case 10:
            return "X";
            break;
        case 11:
            return "XI";
            break;
        case 12:
            return "XII";
            break;
    }
}

?>