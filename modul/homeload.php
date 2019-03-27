<div class="row">
	<div class="col-md-6">
		<div class="portlet box <?php echo $dataPanel; ?>">
			<div class="portlet-title">
				<div class="caption">
                    <span class="caption-subject uppercase bold">Grafik Jenis Kendaraan</span>
                </div>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
					<a href="javascript:;" class="reload"></a>
					<a href="javascript:;" class="remove"></a>
				</div>
			</div>
			<div class="portlet-body">
				<div id='container_1'></div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="portlet box <?php echo $dataPanel; ?>">
			<div class="portlet-title">
				<div class="caption">
                    <span class="caption-subject uppercase bold">Grafik Masuk Kendaraan</span>
                </div>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
					<a href="javascript:;" class="reload"></a>
					<a href="javascript:;" class="remove"></a>
				</div>
			</div>
			<div class="portlet-body">
				<div id='order_2'></div>
			</div>
		</div>
	</div>
</div>

<script src="./assets/scripts/jquery.min.js" type="text/javascript"></script>
<script src="./assets/scripts/highcharts.js" type="text/javascript"></script>
<script src="./assets/scripts/highcharts-3d.js" type="text/javascript"></script>
<script src="./assets/scripts/exporting.js"></script>

<script type="text/javascript">

Highcharts.chart('order_2', {
    chart: {
        type: 'area'
    },
    title: {
        text: 'Total Masuk Kendaran',
        style: {
            fontSize: '14px',
            fontFamily: 'Abel'
        }
    },
    subtitle: {
        text: 'Tahun <?php echo date('Y') ?>',
        style: {
            fontSize: '14px',
            fontFamily: 'Abel'
        }
    },
    xAxis: {
        type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total Masuk'
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'Kendaraan masuk <?php echo date('Y') ?>: <b>{point.y:.1f} kendaraan</b>'
    },
    series: [{
        name: 'Masuk Kendaraan',


        data: [
            <?php 
                $dataTahun      = date('Y');
                $pilihan        = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
                foreach ($pilihan as $nilai) {
                $tahunSql       = "SELECT
                                       COUNT(*) AS total_masuk
                                    FROM
                                        load_tr_inout
                                    WHERE YEAR(load_tr_inout_tgl_masuk)='$dataTahun'
                                    AND MONTH(load_tr_inout_tgl_masuk)='$nilai'";        
                $tahunQry       = mysqli_query($koneksidb, $tahunSql) or die(mysqli_errors());
                while($dataRow = mysqli_fetch_array($tahunQry)){
                   $jml_pegawai = $dataRow['total_masuk'];                 
                }             
            ?>
                  
               ['<?php echo $nilai; ?>', <?php echo $jml_pegawai ?>],
            
            <?php } ?>
        ],
        dataLabels: {
            enabled: true,
            color: '#FFFFFF',
            align: 'right',
            format: '{point.y:.1f}', // one decimal
            y: 10, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Abel'
            }
        }
    }]
});
		</script>
<script type="text/javascript">

    Highcharts.chart('container_1', {
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45
            }
        },
        title: {
            text: 'Grafik Data Kendaraan',
            style: {
                fontSize: '14px',
                fontFamily: 'Abel'
            }
        },
        subtitle: {
            text: 'Setiap Jenis Kendaraan',
            style: {
                fontSize: '14px',
                fontFamily: 'Abel'
            }
        },
        plotOptions: {
            pie: {
                innerSize: 100,
                depth: 45
            }
        },
        series: [{
            name: 'Total Kendaraan',
            data: [

                <?php
                    $tmp2Sql ="SELECT
                                    a.load_ms_jns_kend_nm,
                                    COUNT( b.load_ms_jns_kend_id ) AS jml 
                                FROM
                                    load_ms_jns_kend a
                                    LEFT JOIN load_tr_inout b ON b.load_ms_jns_kend_id= a.load_ms_jns_kend_id 
                                GROUP BY
                                    a.load_ms_jns_kend_nm";
                    $tmp2Qry = mysqli_query($koneksidb, $tmp2Sql) or die ("Gagal Query Tmp".mysqli_errors()); 
                    while($tmp2Row = mysqli_fetch_array($tmp2Qry)) {    
                ?>
                    ['<?php echo $tmp2Row['load_ms_jns_kend_nm'] ?>',<?php echo $tmp2Row['jml'] ?>],
               
                <?php } ?>
                
            ]
        }]
    });
</script>
