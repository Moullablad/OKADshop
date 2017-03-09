<?php
/**
 * 2016 OkadShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@okadshop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade OkadShop to newer
 * versions in the future. If you wish to customize OkadShop for your
 * needs please refer to http://www.okadshop.com for more information.
 *
 * @author    OkadShop <contact@okadshop.com>
 * @copyright 2016 OkadShop
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of OkadShop
 */

/*$files = $common->get_dir_contents("../cars/" );
foreach ($files as $key => $file_path) {
  $common->os_resize_images_in_folder($file_path);
}*/
//var_dump($files);


$common = new OS_Common();
global $user_info;
$total_customers = 0;
$total_products  = 0;
$total_quotes    = 0;
$total_orders    = 0;
$total_invoice   = 0;
$total_carriers  = 0;
$total_countries = 0;
$q_count = $i_count = 0;
$q_array = $i_array = $o_array = array();

//$module = new Hooks();
global $hooks;
$quote_active = $hooks->check_module_active("os-quotations");

try {
  //customers count
  $customers = $common->select('users', array('COUNT(id) as count'), "WHERE user_type IN ('user')");
  if( !empty($customers) ) $total_customers = $customers[0]['count'];

  //products count
  $products = $common->select('products', array('COUNT(id) as count'));
  if( !empty($products) ) $total_products = $products[0]['count'];

  if( $quote_active )
  {
    //products count
    $quotes = $common->select('quotations', array('COUNT(id) as count'));
    if( !empty($quotes) ) $total_quotes = $quotes[0]['count'];
  }
  
  //products count
  $orders = $common->select('orders', array('COUNT(id) as count'));
  if( !empty($orders) ) $total_orders = $orders[0]['count'];

  //products count
  $invoice = $common->select('invoices', array('COUNT(id) as count'));
  if( !empty($invoice) ) $total_invoice = $invoice[0]['count'];

  //products count
  $carrier = $common->select('carrier', array('COUNT(id) as count'));
  if( !empty($carrier) ) $total_carriers = $carrier[0]['count'];
} catch (Exception $e) {
  exit;
}

//products count
//$countries = $common->select('countries', array('COUNT(id) as count'));
//if( !empty($countries) ) $total_countries = $countries[0]['count'];



//quotation statistiques
global $DB;

if( $quote_active )
{
  $query ="SELECT DATE(cdate) as dates, count(id) as q_count FROM "._DB_PREFIX_."quotations WHERE MONTH(`cdate`)=MONTH(NOW()) group by DATE(cdate)";
  $res = $DB->pdo->query($query);
  $q_array = $res->fetchAll(PDO::FETCH_ASSOC);  
}

//orders statistiques
$query ="SELECT DATE(cdate) as dates, count(id) as o_count FROM "._DB_PREFIX_."orders WHERE MONTH(`cdate`)=MONTH(NOW()) group by DATE(cdate)";
$res = $DB->pdo->query($query);
$o_array = $res->fetchAll(PDO::FETCH_ASSOC);

//invoice statistiques
$query ="SELECT DATE(cdate) as dates, count(id) as i_count FROM "._DB_PREFIX_."invoices WHERE MONTH(`cdate`)=MONTH(NOW()) group by DATE(cdate)";
$res = $DB->pdo->query($query);
$i_array = $res->fetchAll(PDO::FETCH_ASSOC);


//merging two table
$output = array();
$merge = array_merge($q_array, $i_array, $o_array);
foreach ( $merge as $value ) {
$date = $value['dates'];
if ( !isset($output[$date]) ) {
  $output[$date] = array();
}
$output[$date] = array_merge($output[$date], $value);
}
$output = array_values($output);

//create JSon array
$data_month = $q_total =  $o_total = $i_total = '';
foreach ($output as $stat) {
  $date = $stat['dates'];
  $q_count = isset($stat['q_count']) ? $stat['q_count'] : 0;
  $o_count = isset($stat['o_count']) ? $stat['o_count'] : 0;
  $i_count = isset($stat['i_count']) ? $stat['i_count'] : 0;
  $data_month .= ('{date: "'. date("d-m-Y", strtotime($date)) .'", d: '. $q_count .', o: '. $o_count .', f: '. $i_count .'},');
  //count total invoices and quotations
  $q_total += $q_count;
  $o_total += $o_count;
  $i_total += $i_count;
}

//calculate percentage
$total = $q_total+$o_total+$i_total;
if( $total > 0 ){
  $q_rate = ($q_total/$total)*100;
  $o_rate = ($o_total/$total)*100;
  $i_rate = ($i_total/$total)*100;
  $donut_data = '[
                  {value: '. $q_rate .', label: "'. l("Devis", "core") .'", formatted: "'. l("Au moins", "core") .' '. number_format($q_rate, 2, '.', '') .' %" },
                  {value: '. $o_rate .', label: "'. l("Commandes", "core") .'", formatted: "'. l("Au moins", "core") .' '. number_format($o_rate, 2, '.', '') .' %" },
                  {value: '. $i_rate .', label: "'. l("Factures", "core") .'", formatted: "'. l("Environ", "core") .' '. number_format($i_rate, 2, '.', '') .' %" }
                ]';

}else{
  $q_rate = $o_rate = $i_rate = 0;
  $donut_data = '[{value: 0, label: "'. l("Vide", "core") .'", formatted: "'. l("Pas de données disponibles", "core") .'" }]';
  $data_month = '{date: "'. date("d-m-Y") .'", d: 0, o: 0, f: 0}';
}


// $select = $common->select('modules_sections', array('hook_function'));
// echo '<pre>';
// print_r($select);
// echo '</pre>';
?>

<style>
.panel .panel-heading {
  background-color: #dedede;
  border-radius: 0px;
  color: #A5245E;
  font-size: 14px;
  font-weight: bold;
  letter-spacing: 2px;
}

#admin-home .center-block .jumbotron {
  height: 250px;
}

.jumbotron h2{
  color: rebeccapurple;
  margin:0px;
}
    
.jumbotron p {
  color: #1ABD93;
}


#dashaddons {
  background-color: #fff;
  border: 1px dashed silver;
  -webkit-border-radius: 3px;
  border-radius: 3px;
  padding: 10px 20px;
  font-size: 1.3em;
  text-align: center;
}

.home-block1 .panel {
  margin-bottom: 8px;
}
</style>


<!-- <input type="text" value="ga:102405413" id="table_id">
<input type="text" value="745407840055-vnuj5n6vr78bbsvd6qe0h2201q48m7a7.apps.googleusercontent.com" id="client_id"> -->





<div><!--style="margin-right:25%"-->
  <div class="row" id="admin-home">
  	<div class="col-sm-12 padding0">
  		<div class="center-block">
  			<div class="jumbotron">
  			  <h2><?=l("Bonjour", "core");?>, <?php echo $user_info->first_name. " ". $user_info->last_name; ?>.</h2>
  			  <p><?=l("Voici ce qui se passe avec votre magasin dès maintenant.", "core");?></p>
  			</div>
  			<div class="home-blocks">
  				<div class="home-block1">
  					<div class="row">
  						<div class="col-xs-4 col-sm-2">
  							<div class="panel panel-default">
  							  <div class="panel-body">
  							    <label><?=l("Produits", "core");?></label>
  							  	<p class="value"><?php echo $total_products; ?></p>
  							    <p class="icon"><i class="fa fa-shopping-basket fa-3x"></i></p>
  							  </div>
  							</div>
  						</div>
  						<div class="col-xs-4 col-sm-2">
  							<div class="panel panel-default">
  							  <div class="panel-body">
  							  	<label><?=l("Clients", "core");?></label>
  							  	<p class="value"><?php echo $total_customers; ?></p>
  							    <p class="icon"><i class="fa fa-users fa-3x"></i></p>
  							  </div>
  							</div>
  						</div>
              <div class="col-xs-4 col-sm-2">
                <div class="panel panel-default">
                  <div class="panel-body">
                    <label><?=l("Devis", "core");?></label>
                    <p class="value"><?php echo $total_quotes; ?></p>
                    <p class="icon"><i class="fa fa fa-pencil-square-o fa-3x"></i></p>
                  </div>
                </div>
              </div>
              <div class="col-xs-4 col-sm-2">
                <div class="panel panel-default">
                  <div class="panel-body">
                    <label><?=l("Commandes", "core");?></label>
                    <p class="value"><?php echo $total_orders; ?></p>
                    <p class="icon"><i class="fa fa-credit-card fa-3x"></i></p>
                  </div>
                </div>
              </div>
              <div class="col-xs-4 col-sm-2">
                <div class="panel panel-default">
                  <div class="panel-body">
                    <label><?=l("Factures", "core");?></label>
                    <p class="value"><?php echo $total_invoice; ?></p>
                    <p class="icon"><i class="fa fa-list-alt fa-3x"></i></p>
                  </div>
                </div>
              </div>
              <div class="col-xs-4 col-sm-2">
                <div class="panel panel-default">
                  <div class="panel-body">
                    <label><?=l("Transporteurs", "core");?></label>
                    <p class="value"><?php echo $total_carriers; ?></p>
                    <p class="icon"><i class="fa fa fa-truck fa-3x"></i></p>
                  </div>
                </div>
              </div>
  					</div>
            <div id="update_alert"></div>
  				</div>
  			</div>
  		</div>
  	</div>
  </div><!--/ .row  -->
  <br>


  <div class="row">
    <div class="col-sm-9 right0 left0">
      <div class="sortable list">
        <?=execute_section_hooks( 'sec_dashboard' );?>
      </div>
      <br>
      <div class="col-sm-12">
        <div id="dashaddons">
          <a href="?module=modules&page=positions">
            <i class="fa fa-plus"></i> <?=l("Ajoutez des modules à votre tableau de bord", "core");?>
          </a>
        </div>
      </div>
    </div><!-- /.col-sm-9 -->
    <div class="col-sm-3">
      <div class="panel panel-default">
        <div class="panel-heading">
          <i class="fa fa-rss"></i> <?=l("ACTUALITÉS OKADSHOP", "core");?></div>
        <div class="panel-body">
          <div id="os_news"></div>
          <center><a href="#" class="btn more_news"><?=l("Trouver plus d'actualités", "core");?></a></center>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading">
          <i class="fa fa-refresh"></i> <?=l("MISES À JOUR", "core");?></div>
        <div class="panel-body">
          <center>
            <p><?=l("Vous pouvez mettre à jour OkadShop", "core");?> <span class="os_version"><?=_OS_VERSION_;?></span></p>
            <a href="?module=modules&slug=os-updates&page=update-core" class="btn btn-default" style="margin-top: -4px;"><?=l("Mettre à jour", "core");?></a>
          </center>
        </div>
      </div>
      <div id="embed-api-auth"></div>
    </div>
  </div><!--/ .row  -->


  <script>
  $(document).ready(function(){

    //run webservices
    os_get_news();
    os_check_updates();

    //sortable
    $('.sortable').bind('sortupdate', function() {
      var childrens = $('div.sortable').children();
      os_update_positions(childrens);

         /*console.log( children )
     $('.sortable div').each(function(){
        console.log( $(this).index() )
      });*/
    });

    //data_month
    if( $("#data_month").length ){
      Morris.Bar({
        element: 'data_month',
        data: [ <?= $data_month; ?> ],
        xkey: 'date',
        ykeys: ['d','o', 'f'],
        labels: [ '<?=l("Devis", "core");?>','<?=l("Commandes", "core");?>', '<?=l("Factures", "core");?>'],
      });
    }

    //Donut
    if( $("#totals").length ){
      Morris.Donut({
        element: 'totals',
        data: <?=$donut_data;?>,
        labelColor: '#d9534f',
        colors: [
          '#27C24C',
          '#F05050',
          '#7266ba'
        ],
        formatter: function (x, data) { return data.formatted; }
      });
    } 

  });

  //os_update_positions
  function os_update_positions(childrens) {
    var json = {items: []};
    $.each(childrens, function(p, f) {
      json.items.push(
        {func: f.className}
      );
    });
    $.ajax({
      type: "POST",
      url: 'ajax/dashboard/sortable.php',
      data: {hook_pos:JSON.stringify(json)},
      success: function(data){
        os_message_notif("<?=l('Les positions ont été mise a jour.','admin');?>");
      }
    });
  }

  //os_get_news
  function os_get_news() {
    $.getJSON( "http://updates.okadshop.com/os-news.php", function( data ) {
      var news = "";
      $.each( data, function( key, val ) {
        news += '<article><h4><a target="_blank" href="'+val.link+'">'+val.title+'</a></h4><span class="text-muted">'+val.date+'</span><p>'+val.description+' <a target="_blank" href="'+val.link+'">En savoir plus</a></p></article>';
      });
      if( news != "" ){
        $('#os_news').html(news);
      }else{
        $('#os_news').html("<center><?=l('Pas d\'actualités pour le moment.', 'admin');?></center>");
        $('.more_news').hide();
      }
    });
  }

  //os_check_updates
  function os_check_updates() {
    $.getJSON( "http://updates.okadshop.com/index.php", function( data ) {
      var current_ver = "<?=_OS_VERSION_;?>";
      if( current_ver != data.version )
      {
        var alert = '<div class="alert alert-success"><a href="?module=modules&slug=os-updates&page=update-core" class="btn btn-default pull-right" style="margin-top: 4px;"><?=l("Mettre à jour.", "core");?></a><h4><?=l("OKADSHOP MISES À JOUR.", "core");?></h4><p><?=l("Vous pouvez mettre à jour OkadShop", "core");?> '+data.version+'</p></div>';
        $("#update_alert").html(alert);
        $(".os_version").text(data.version);
      }
    });
  }
  </script>


  <!--div class="row">
    <div class="col-md-6">
      <section class="panel">
        <header class="panel-heading">
          Statistiques
        </header>
        <div class="panel-body" style="padding-left: 5px;padding-right: 0px;">
          <canvas height="250" width="600" id="linechart"></canvas>
        </div>
      </section>
    </div>
    <div class="col-md-6">
      <section class="panel">
        <header class="panel-heading">
          Orders in Progress
        </header>
        <div class="panel-body table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Project</th>
                <th>Manager</th>
                <th>Deadline</th>
                <th>Status</th>
                <th>Progress</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Facebook</td>
                <td>Mark</td>
                <td>10/10/2014</td>
                <td><span class="label label-danger">in progress</span></td>
                <td><span class="badge badge-info">50%</span></td>
              </tr>
              <tr>
                <td>2</td>
                <td>Twitter</td>
                <td>Evan</td>
                <td>10/8/2014</td>
                <td><span class="label label-success">completed</span></td>
                <td><span class="badge badge-success">100%</span></td>
              </tr>
              <tr>
                <td>3</td>
                <td>Google</td>
                <td>Larry</td>
                <td>10/12/2014</td>
                <td><span class="label label-warning">in progress</span></td>
                <td><span class="badge badge-warning">75%</span></td>
              </tr>
              <tr>
                <td>4</td>
                <td>LinkedIn</td>
                <td>Allen</td>
                <td>10/01/2015</td>
                <td><span class="label label-info">in progress</span></td>
                <td><span class="badge badge-info">65%</span></td>
              </tr>
              <tr>
                <td>3</td>
                <td>Google</td>
                <td>Larry</td>
                <td>10/12/2014</td>
                <td><span class="label label-warning">in progress</span></td>
                <td><span class="badge badge-warning">75%</span></td>
              </tr>
              <tr>
                <td>3</td>
                <td>Google</td>
                <td>Larry</td>
                <td>10/12/2014</td>
                <td><span class="label label-warning">in progress</span></td>
                <td><span class="badge badge-warning">75%</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>
    </div>
  </div>
</div-->

<script>
/*$(document).ready(function(){
  //BAR CHART
  "use strict";
  var data = {
  labels: ["January", "February", "March", "April", "May", "June", "July"],
  datasets: [
      {
        label: "My First dataset",
        fillColor: "rgba(220,220,220,0.2)",
        strokeColor: "rgba(220,220,220,1)",
        pointColor: "rgba(220,220,220,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(220,220,220,1)",
        data: [65, 59, 80, 81, 56, 55, 40]
      },
      {
        label: "My Second dataset",
        fillColor: "rgba(151,187,205,0.2)",
        strokeColor: "rgba(151,187,205,1)",
        pointColor: "rgba(151,187,205,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(151,187,205,1)",
        data: [28, 48, 40, 19, 86, 27, 90]
      }
  ]
  };
  new Chart(document.getElementById("linechart").getContext("2d")).Line(data,{
    responsive : true,
    maintainAspectRatio: false,
  });

});*/
</script>