<div class="row">
	<div class="col-md-6">
		<div class="portlet box <?php echo $dataPanel; ?>">
			<div class="portlet-title">
				<div class="caption">
                    <span class="caption-subject uppercase bold">Grafik Ticketing</span>
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
                    <span class="caption-subject uppercase bold">Grafik Ticketing Modul</span>
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
        text: 'Total Ticket',
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
        pointFormat: 'Ticket in <?php echo date('Y') ?>: <b>{point.y:.1f} ticket</b>'
    },
    series: [{
        name: 'Data Ticket',


        data: [
            <?php 
                $dataTahun      = date('Y');
                $pilihan        = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
                foreach ($pilihan as $nilai) {
                $tahunSql       = "SELECT
                                       COUNT(*) AS total_masuk
                                    FROM
                                        tic_tr_ticket
                                    WHERE YEAR(tic_tr_ticket_tgl_start)='$dataTahun'
                                    AND MONTH(tic_tr_ticket_tgl_start)='$nilai'";        
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
            text: 'Grafik Data Ticket',
            style: {
                fontSize: '14px',
                fontFamily: 'Abel'
            }
        },
        subtitle: {
            text: 'Setiap Jenis Modul',
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
            name: 'Total Ticket',
            data: [

                <?php
                    $tmp2Sql ="SELECT
                                    a.tic_ms_modul_nm,
                                    COUNT( b.tic_ms_modul_id ) AS jml 
                                FROM
                                    tic_ms_modul a
                                    LEFT JOIN tic_tr_ticket b ON b.tic_ms_modul_id= a.tic_ms_modul_id 
                                GROUP BY
                                    a.tic_ms_modul_nm";
                    $tmp2Qry = mysqli_query($koneksidb, $tmp2Sql) or die ("Gagal Query Tmp".mysqli_errors()); 
                    while($tmp2Row = mysqli_fetch_array($tmp2Qry)) {    
                ?>
                    ['<?php echo $tmp2Row['tic_ms_modul_nm'] ?>',<?php echo $tmp2Row['jml'] ?>],
               
                <?php } ?>
                
            ]
        }]
    });
</script>
