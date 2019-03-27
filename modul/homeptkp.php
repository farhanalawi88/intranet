<div class="row">
	<div class="col-md-6">
		<div class="portlet box <?php echo $dataPanel; ?>">
			<div class="portlet-title">
				<div class="caption">
                    <span class="caption-subject uppercase bold">Grafik PTKP</span>
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
                    <span class="caption-subject uppercase bold">Grafik Pembuatan PTKP</span>
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
        text: 'Total Data PTKP',
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
        pointFormat: 'PTKP pada <?php echo date('Y') ?>: <b>{point.y:.1f} ticket</b>'
    },
    series: [{
        name: 'Data PTKP',


        data: [
            <?php 
                $dataTahun      = date('Y');
                $pilihan        = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
                foreach ($pilihan as $nilai) {
                $tahunSql       = "SELECT
                                       COUNT(*) AS total_masuk
                                    FROM
                                        ptkp_tr_ptkp
                                    WHERE YEAR(ptkp_tr_ptkp_tgl)='$dataTahun'
                                    AND MONTH(ptkp_tr_ptkp_tgl)='$nilai'";        
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
            text: 'Grafik Data PTKP',
            style: {
                fontSize: '14px',
                fontFamily: 'Abel'
            }
        },
        subtitle: {
            text: 'Setiap Sumber PTKP',
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
            name: 'TOTAL PTKP',
            data: [

                <?php
                    $tmp2Sql ="SELECT
                                    a.ptkp_ms_sumber_nm,
                                    COUNT( b.ptkp_ms_sumber_id ) AS jml 
                                FROM
                                    ptkp_ms_sumber a
                                    LEFT JOIN ptkp_tr_ptkp b ON b.ptkp_ms_sumber_id= a.ptkp_ms_sumber_id 
                                GROUP BY
                                    a.ptkp_ms_sumber_nm";
                    $tmp2Qry = mysqli_query($koneksidb, $tmp2Sql) or die ("Gagal Query Tmp".mysqli_errors()); 
                    while($tmp2Row = mysqli_fetch_array($tmp2Qry)) {    
                ?>
                    ['<?php echo $tmp2Row['ptkp_ms_sumber_nm'] ?>',<?php echo $tmp2Row['jml'] ?>],
               
                <?php } ?>
                
            ]
        }]
    });
</script>
