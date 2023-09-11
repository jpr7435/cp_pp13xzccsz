<?php
/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

$ci2 = &get_instance();
//$us = $ci3->load->model("usuarios");
//$ci2 = &get_instance();
$ci2->load->model("vista");

$hoy = date("Y-m-d");
$mes = date("m");
$ini = date("Y-m-") . "01";
$fin = date("Y-m-") . "31";
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">

google.charts.load('current', {'packages':['bar']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  var data = google.visualization.arrayToDataTable([
    ['Proyeccion', 'Mes anterior', 'Mes actual'],
    ['Confirmaciones', <?php echo $recu_anterior[0]['confirmaciones']; ?>, <?php echo $recu_actual[0]['confirmaciones']; ?>]
  ]);

  var options = {
    chart: {
      title: 'Mes anterior Vs Mes actual',
      subtitle: 'Grafico de recuperacion',
    },
    bars: 'vertical',
    vAxis: {format: 'decimal'}
  };

  var chart = new google.charts.Bar(document.getElementById('recuperacion_div'));

  chart.draw(data, google.charts.Bar.convertOptions(options));
}

</script>

<script type="text/javascript">
google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
  var data = google.visualization.arrayToDataTable([
    ['Indicador', 'Hoy'],
    ['Proyeccion', <?php echo $proy_hoy[0]['proyeccion']; ?>],
    ['Confirmacion', <?php echo $conf_hoy[0]['confirmaciones']; ?>]
  ]);

  var options = {
    title: 'Proyeccion',
    pieHole: 0.4,
    is3D: true
  };

  var chart = new google.visualization.PieChart(document.getElementById('proyeccion_div'));
  chart.draw(data, options);
}
</script>

<script type="text/javascript">
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);
<?php $dia = intval(date("d"));
      $mes = date("m");
      $ano = date("Y");
?>
function drawChart() {
  var data = google.visualization.arrayToDataTable([

    ['Dia', 'Confirmaciones', 'Promesas'],
    <?php
     $totalPro = 0;
     $totalProm = 0;
     $totalCierre = 0;
     for($i = 1; $i <= 31; $i++){

      if($i < 10){
        $diaHoy = "0".$i;
      }else{
        $diaHoy = $i;
      }

      $valor = $this->vista->getConfirmacionesDia($diaHoy, $mes, $ano, $session['proyecto_activo']);
      $prom = $this->vista->getProyeccionesDia($diaHoy, $mes, $ano, $session['proyecto_activo']);


      if(isset($valor[0]['valor'])){
          $totalPro = $valor[0]['valor'];
      }else{
            $totalPro = 0;
      }

      if(isset($prom[0]['valor'])){
          $totalProm = $prom[0]['valor'];
      }else{
            $totalProm = 0;
      }

      if($i <= $dia){
        $totalCierre += $totalPro;
      }else{
        $totalCierre += $totalProm;
      }

      ?>

        ['<?php echo $i; ?>',  <?php echo $totalPro; ?>,  <?php echo $totalProm; ?>],
    <?php } ?>
  ]);

  var options = {
    title: 'Cierre Probable: <?php echo number_format($totalCierre, 2); ?>',
    curveType: 'function',
    legend: { position: 'bottom' }
  };

  var chart = new google.visualization.LineChart(document.getElementById('cierre_div'));

  chart.draw(data, options);
}
</script>


<?php
$prH = 0;
$prAy = 0;

$noprH = 0;
$noprAy = 0;

$sinprH = 0;
$sinprAy = 0;

foreach($prod_hoy as $h){

  $con = $this->vista->getContacto($h['idContacto'], $session['proyecto_activo']);
  $gr = $this->vista->getGruposContactoUno($con[0]['idGrupo'], $session['proyecto_activo']);

  if($gr[0]['idGrupo'] == 1){
    $prH += 1;
  }else if($gr[0]['idGrupo'] == 2){
    $noprH += 1;
  }else if($gr[0]['idGrupo'] == 3){
    $sinprH += 1;
  }

}

foreach($prod_ayer as $ay){
  $conay = $this->vista->getContacto($ay['idContacto'], $session['proyecto_activo']);
  $gray = $this->vista->getGruposContactoUno($conay[0]['idGrupo'], $session['proyecto_activo']);

  if($gray[0]['idGrupo'] == 1){
    $prAy += 1;
  }else if($gray[0]['idGrupo'] == 2){
    $noprAy += 1;
  }else if($gray[0]['idGrupo'] == 3){
    $sinprAy += 1;
  }
}

?>

<script type="text/javascript">
google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
  var data = google.visualization.arrayToDataTable([
    ['Productividad', 'Productiva', 'No productiva', 'Sin Contacto'],
    ['Hoy', <?php echo $prH; ?>, <?php echo $noprH; ?>, <?php echo $sinprH; ?> ],
    ['Ayer', <?php echo $prAy; ?>, <?php echo $noprAy; ?>, <?php echo $sinprAy; ?> ]
  ]);

  var options = {
    height: 500,
    legend: { position: 'top', maxLines: 3 },
    bar: { groupWidth: '75%' },
    isStacked: true
  };

  var chart = new google.visualization.BarChart(document.getElementById("gestiones_div"));
  chart.draw(data, options);
}
</script>



<script type="text/javascript">
google.charts.load('current', {'packages':['gauge']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {

  var data = google.visualization.arrayToDataTable([
    ['Label', 'Value'],
    ['Cobertura', 80]
  ]);

  var options = {
    height: 400,
    redFrom: 90, redTo: 100,
    yellowFrom:75, yellowTo: 90,
    minorTicks: 5
  };

  var chart = new google.visualization.Gauge(document.getElementById('cobertura_div'));

  chart.draw(data, options);

  setInterval(function() {
    data.setValue(0, 1, 40 + Math.round(60 * Math.random()));
    chart.draw(data, options);
  }, 13000);

}
</script>


<section class="main-container">
  <!-- Page header -->
  <div class="header">
    <div class="header-content">
      <div class="page-title">
        <i class="icon-file-empty position-left"></i> Dashboard campaña <?php echo $session['proyecto_activo']; ?>
      </div>
    </div>
  </div>
  <!-- /Page header -->

  <div class="container-fluid page-content">

    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <div class="panel-title">Recuperaci&oacute;n Actual</div>
          </div>
          <div class="panel-body">
            <div id="recuperacion_div" style="margin: 0 auto; width: 60%; height: 500px;">
            </div>
          </div>
        </div><!-- panel -->
      </div><!-- col -->
    </div><!-- row -->


    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <div class="panel-title">Proyecci&oacute;n / Cierre</div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-3" id="proyeccion_div" style="margin: 0 auto; height: 500px;">

              </div>
              <div class="col-md-9" id="cierre_div" style="margin: 0 auto; height: 500px;">

              </div>
            </div>
          </div>
        </div><!-- panel -->
      </div><!-- col -->
    </div><!-- row -->

    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <div class="panel-title">Gestiones</div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div id="gestiones_div" style="margin: 0 auto; height: 500px;">

              </div>
            </div>
          </div>
        </div><!-- panel -->
      </div><!-- col -->
    </div><!-- row -->

    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <div class="panel-title">Cobertura</div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div id="cobertura_div" style="margin: 0 auto; height: 500px;">

              </div>
            </div>
          </div>
        </div><!-- panel -->
      </div><!-- col -->
    </div><!-- row -->

  </div><!-- container -->


</section>
