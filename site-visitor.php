/*
*Site visitor with Graph on WP Dashboard
*
CREATE TABLE IF NOT EXISTS wp_vcp_log
  (
      `LogID` int(11) NOT NULL AUTO_INCREMENT,
      `IP` varchar(20) NOT NULL,
      `Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
       PRIMARY KEY (`LogID`)
  );
*/
<?php
function vcp_log_user() {

    if(!vcp_check_ip_exist($_SERVER['REMOTE_ADDR'])){

        global $wpdb;

        $table_name = $wpdb->prefix . 'vcp_log';

        $sqlQuery = "INSERT INTO $table_name VALUES (NULL,'".$_SERVER['REMOTE_ADDR']."',NULL)";
        $sqlQueryResult = $wpdb -> get_results($sqlQuery);
    }
}


function vcp_get_visit_count($interval='D')
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'vcp_log';

    if($interval == 'C')
        $condition = "`Time` > DATE_SUB(NOW(), INTERVAL 5 HOUR)";
    else if($interval == 'T')
        $condition = "1";
    elseif($interval == 'D')
        $condition = "DATE(`Time`)=DATE(NOW())";
    else if($interval == 'W')
        $condition = "WEEKOFYEAR(`Time`)=WEEKOFYEAR(NOW())";
    else if($interval == 'M')
        $condition = "MONTH(`Time`)=MONTH(NOW())";
    else if($interval == 'Y')
        $condition = "DATE(`Time`)=DATE(NOW() - INTERVAL 1 DAY)";
    else if($interval == 'D2')
        $condition = "DATE(`Time`)=DATE(NOW() - INTERVAL 2 DAY)";
    else if($interval == 'D3')
        $condition = "DATE(`Time`)=DATE(NOW() - INTERVAL 3 DAY)";
    else if($interval == 'D4')
        $condition = "DATE(`Time`)=DATE(NOW() - INTERVAL 4 DAY)";
    else if($interval == 'D5')
        $condition = "DATE(`Time`)=DATE(NOW() - INTERVAL 5 DAY)";
    else if($interval == 'D6')
        $condition = "DATE(`Time`)=DATE(NOW() - INTERVAL 6 DAY)";

    $sql = "SELECT COUNT(*) FROM $table_name WHERE ".$condition;

    $count = $wpdb -> get_var($sql);

    return $count;
}

function vcp_check_ip_exist($ip)
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'vcp_log';

    $sql = "SELECT COUNT(*) FROM $table_name WHERE IP='".$ip."' AND DATE(Time)='".date('Y-m-d')."'";

    $count = $wpdb -> get_var($sql);

    return $count;
}
//Log user
add_action( 'init', 'vcp_log_user' );

/*
*DashBoard Widget code
*
*/
add_action('wp_dashboard_setup', 'site_visitor_dashboard_widgets');

function site_visitor_dashboard_widgets() {
    global $wp_meta_boxes;

    wp_add_dashboard_widget('site_visitor_help_widget', 'Site Vistor', 'site_visitor_dashboard_help');
}

function site_visitor_dashboard_help() { ?>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.js"></script>
    <?php
        $td =date('d-M');
        $dd1 =date('d-M',strtotime("-1 days"));
        $dd2 =date('d-M',strtotime("-2 days"));
        $dd3 =date('d-M',strtotime("-3 days"));
        $dd4 =date('d-M',strtotime("-4 days"));
        $dd5 =date('d-M',strtotime("-5 days"));
        $dd6 =date('d-M',strtotime("-6 days"));
    ?>

    <div class="site-visit">
        <canvas id="myChart" ></canvas>
    </div>
    <script type="text/javascript">
        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["<?php echo $dd6; ?> ","<?php echo $dd5; ?>","<?php echo $dd4; ?>","<?php echo $dd3; ?>","<?php echo $dd2; ?>","<?php echo $dd1; ?>","<?php echo $td; ?>" ],
                datasets: [{
                    label: '# Visitor in <?php echo date('F, Y'); ?>',
                    data: [<?php echo vcp_get_visit_count('D6') ?>,
                        <?php echo vcp_get_visit_count('D5') ?>,
                        <?php echo vcp_get_visit_count('D4') ?>,
                        <?php echo vcp_get_visit_count('D3') ?>,
                        <?php echo vcp_get_visit_count('D2') ?>,
                        <?php echo vcp_get_visit_count('Y') ?>,
                        <?php echo vcp_get_visit_count('D') ?> ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(266, 134, 244, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(266, 134, 244, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    </script>
    <p>Today: <?php echo vcp_get_visit_count('D') ?></p>
    <p>Yesterday: <?php echo vcp_get_visit_count('Y') ?></p>
    <p>This Week: <?php echo vcp_get_visit_count('W') ?></p>
    <p>This Month: <?php echo vcp_get_visit_count('M') ?></p>
    <p>Total: <?php echo vcp_get_visit_count('T') ?></p>
<!--    <p>Currently Online: --><?php //echo vcp_get_visit_count('C') ?><!--</p>-->
<?php
}

