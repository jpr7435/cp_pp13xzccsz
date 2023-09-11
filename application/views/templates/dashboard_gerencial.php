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

$carteras = explode(";", $session['carteras']);

$hoy = date("Y-m-d");
$mes = date("m");
$ini = date("Y-m-") . "01";
$fin = date("Y-m-") . "31";
echo $asesor_filtro . " ----- ";
$hoyHora = date("Y-m-d H:i:s");
?>

<section class="main-container">
  <!-- Page header -->
  <div class="header">
    <div class="header-content">
      <div class="page-title">
        <i class="icon-file-empty position-left"></i> Dashboard Gerencial
      </div>
    </div>
  </div>
  <!-- /Page header -->

  <div class="container-fluid page-content">

    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <div class="panel-title">Aplicar Filtros</div>
          </div>
          <div class="panel-body" style="text-align: center; overflow-x: auto;">
            <form method="post" name="aplica-filtros-dashboard" id="aplica-filtros-dashboard" action="http://<?php echo $this->config->item('host_cobranzas'); ?>/index.php/dashboard/<?php echo $session['proyecto_activo']; ?>">
              <div class="col-md-4 col-sm-4">
                <div class="form-group">

                  <label class="control-label col-lg-4">Cartera:</label>
                  <div class="col-lg-8">
                    <select class="form-control" multiple="multiple" name="cartera-filtro-dashboard[]" id="cartera-filtro-dashboard">
                      <option value="0">Sin Filtro</option>
                      <?php
                      foreach ($carteras as $key => $value) {
                        $pro2 = $this->vista->getProyectData($value);
                        ?>
                        <option value="<?php echo $pro2[0]['idProyecto']; ?>"><?php echo $pro2[0]['descripcion']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-sm-4">
                <div class="form-group">
                  <label class="control-label col-lg-4">Asesor:</label>
                  <div class="col-lg-8">
                    <select class="form-control" name="asesor-filtro-dashboard" id="asesor-filtro-dashboard">
                      <option value="0">Sin Filtro</option>
                      <?php foreach ($asesores as $as) { ?>
                        <option value="<?php echo $as['idUsuario']; ?>"><?php echo $as['nombre']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div style="clear: both; height: 30px;"></div>
                  <div class="col-lg-8">
                    <button type="submit" class="btn btn-success" name="filtro-dashboard-btn" id="filtro-dashboard-btn">Aplicar Filtros</button>
                  </div>
                </div>
              </div>
              <input type="hidden" name="generar" id="generar" value="1"/>
            </form>
          </div>
        </div><!-- panel -->
      </div><!-- col -->
    </div><!-- row -->


    <?php if (isset($generar)) { ?>
      <div class="row">
        <div class="col-md-12 col-sm-12">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <div class="panel-title">Estado de Cartera <?php
              if ($asesor_filtro != "" && $asesor_filtro != "0") {
                echo $asesor_filtro;
              }
              ?></div>
            </div>
            <div id="dashboard-result" class="panel-body" style="text-align: center; overflow-x: auto;">

              <table class="table bg-indigo table-striped table-hover table-bordered">
                <thead>
                  <tr class="bg-indigo-900">
                    <th>Gestor</th>
                    <th>Confirmacion</th>
                    <th>Proyeccion</th>
                    <th>Cierre Probable</th>
                    <th>Meta</th>
                    <th>Cumplimiento</th>
                    <th>Incumple</th>
                    <th>Productiva</th>
                    <th>No Productiva</th>
                    <th>Monto Promesas</th>
                    <th>Cobertura</th>
                    <th>Hoy</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $prId = $this->vista->getProyectAll();
                  //print_r($usuariosPr);
                  $confTot = 0;
                  $proyTot = 0;
                  $cierrTot = 0;
                  $metaTot = 0;
                  $cumpTot = 0;
                  $incumTot = 0;
                  $prodTot = 0;
                  $noproTot = 0;
                  $promTot = 0;
                  $coberTot = 0;
                  $hoyTot = 0;
                  $callGeneral = 0;
                  $proGeneral = 0;
                  $noproGeneral = 0;
                  $coberGeneral = 0;
                  $asigGeneral = 0;

                  foreach ($proyectos as $u) {

                    $confi = 0;
                    $proye = 0;
                    $incum = 0;
                    $cierr = 0;
                    $produ = 0;
                    $nopro = 0;
                    $totalcalls = 0;
                    $porcprodu = 0;
                    $porcnopro = 0;
                    $totasigna = 0;
                    $totcobert = 0;
                    $cobertura = 0;
                    $montoPr = 0;

                    if ($asesor_filtro != "" && $asesor_filtro != "0") {
                      $meta = $this->vista->getMetaUSer($asesor_filtro, $u['idProyecto']);
                    } else {
                      // $meta = $this->vista->getMetaTotalCampana($u['idProyecto']);
                      $prgest = $this->vista->getGestores($u['idProyecto']);

                      $meta[0]['valor'] = 0;
                      foreach ($prgest as $ppo) {
                        $userStatus = $this->vista->getusuario($ppo['idUsuario']);
                        if($userStatus[0]['idEstado'] < 3) {
                          $met = $this->vista->getMetas($ppo['idUsuario'], $u['idProyecto'], date('m'));
                          if (isset($met[0]['valor'])) {
                            $meta[0]['valor'] += $met[0]['valor'];
                          }
                        }
                      }
                    }




                    if (isset($meta[0]['valor'])) {

                      if ($meta[0]['valor'] > 0) {
                        if ($asesor_filtro != "" && $asesor_filtro != "0") {
                          $primera = $this->vista->getPromesasUsuario($asesor_filtro, $ini, $fin, $u['descripcion']);
                        } else {
                          $primera = $this->vista->getPromesasCampana($ini, $fin, $u['descripcion']);
                        }

                        foreach ($primera as $pr) {

                          if ($pr['idCumplido'] == 3) {
                            $confi += $pr['valorpromesa'];
                          } else if ($pr['idCumplido'] == 1 && $pr['activo'] == 1) {
                            $proye += $pr['valorpromesa'];
                          } else if ($pr['idCumplido'] == 2) {
                            $incum += $pr['valorpromesa'];
                          }
                          $montoPr += $pr['valorpromesa'];
                        }
                        $cierre = $confi + $proye;


                        if ($meta[0]['valor'] > 0) {
                          $cumpl = $cierre / $meta[0]['valor'];
                          $cumpl = $cumpl * 100;
                        } else {
                          $meta[0]['valor'] = 0;
                          $cumpl = 0;
                        }

                        $choy = 0;
                        if ($asesor_filtro != "" && $asesor_filtro != "0") {
                          $llamadas = $this->vista->getCallMes($asesor_filtro, $ini, $fin, $u['descripcion']);
                        } else {
                          $llamadas = $this->vista->getCallMesProyecto($ini, $fin, $u['descripcion']);
                        }


                        foreach ($llamadas as $cal) {
                          $totalcalls += 1;
                          $callGeneral += 1;

                          $cont = $this->vista->getContacto($cal['idContacto'], $u['descripcion']);
                          if (isset($cont[0]['idGrupo'])) {
                            if ($cont[0]['idGrupo'] == 1) {
                              $produ += 1;
                              $proGeneral += 1;
                            } else if ($cont[0]['idGrupo'] == 2) {
                              $nopro += 1;
                              $noproGeneral += 1;
                            }
                          }





                          if ($cal['fec'] == $hoy) {
                            $choy += 1;
                          }
                        }
                        if ($totalcalls == 0) {
                          $totalcalls = 1;
                        }
                        $porcprodu = $produ / $totalcalls;
                        $porcnopro = $nopro / $totalcalls;

                        $porcprodu = $porcprodu * 100;
                        $porcnopro = $porcnopro * 100;

                        if ($asesor_filtro != "" && $asesor_filtro != "0") {
                          $asig = $this->vista->getAsignacionAsesor($asesor_filtro, $u['descripcion']);
                        } else {
                          $asig = $this->vista->getAsignacionProyecto($u['descripcion']);
                        }


                        foreach ($asig as $as) {
                          $totasigna += 1;
                          $asigGeneral += 1;
                          if ($as['meses'] == $mes) {
                            $totcobert += 1;
                            $coberGeneral += 1;
                          }
                        }

                        if ($totasigna == 0) {
                          $totasigna = 1;
                        }

                        $cobertura = $totcobert / $totasigna;
                        $cobertura = $cobertura * 100;



                        $confTot = $confi + $confTot;
                        $proyTot = $proye + $proyTot;
                        $cierrTot = $cierre + $cierrTot;
                        $metaTot = $meta[0]['valor'] + $metaTot;
                        $cumpTot = $cumpl + $cumpTot;
                        $incumTot = $incum + $incumTot;
                        $prodTot = $porcprodu + $prodTot;
                        $noproTot = $porcnopro + $noproTot;
                        $promTot = $montoPr + $promTot;
                        $coberTot = $cobertura + $coberTot;
                        $hoyTot = $choy + $hoyTot;

                        ?>
                        <tr>
                          <td style="font-size: 10px;"><?php echo strtoupper($u['descripcion']); ?></td>
                          <td><?php echo number_format($confi, 2); ?></td>
                          <td><?php echo number_format($proye, 2); ?></td>
                          <td><?php echo number_format($cierre, 2); ?></td>
                          <td><?php echo number_format($meta[0]['valor'], 2); ?></td>
                          <td><?php echo number_format($cumpl, 2); ?>%</td>
                          <td><?php echo number_format($incum, 2); ?></td>
                          <td><?php echo number_format($porcprodu, 2); ?>%</td>
                          <td><?php echo number_format($porcnopro, 2); ?>%</td>
                          <td><?php echo number_format($montoPr, 2); ?></td>
                          <td><?php echo number_format($cobertura, 2); ?>%</td>
                          <td><?php echo number_format($choy, 0); ?></td>
                        </tr>
                        <?php
                      }


                    }

                  }

                  if ($metaTot > 0) {
                    $cumpTot = $cierrTot / $metaTot;
                    $cumpTot = $cumpTot * 100;
                  } else {
                    $metaTot = 0;
                    $cumpTot = 0;
                  }
                  if ($callGeneral == 0) {
                    $callGeneral = 1;
                  }

                  $proGeneral1 = $proGeneral / $callGeneral;
                  $noproGeneral1 = $noproGeneral / $callGeneral;

                  $proGeneral1 = $proGeneral1 * 100;
                  $noproGeneral1 = $noproGeneral1 * 100;

                  if ($asigGeneral == 0) {
                    $asigGeneral = 1;
                  }

                  $coberTot = $coberGeneral / $asigGeneral;
                  $coberTot = $coberTot * 100;
                  ?>
                  <tr class="bg-indigo-900">
                    <th style="font-size: 10px;">TOTALES:</th>
                    <th><?php echo number_format($confTot, 2); ?></th>
                    <th><?php echo number_format($proyTot, 2); ?></th>
                    <th><?php echo number_format($cierrTot, 2); ?></th>
                    <th><?php echo number_format($metaTot, 2); ?></th>
                    <th><?php echo number_format($cumpTot, 2); ?>%</th>
                    <th><?php echo number_format($incumTot, 2); ?></th>
                    <th><?php echo number_format($proGeneral1, 2); ?>%</th>
                    <th><?php echo number_format($noproGeneral1, 2); ?>%</th>
                    <th><?php echo number_format($promTot, 2); ?></th>
                    <th><?php echo number_format($coberTot, 2); ?>%</th>
                    <th><?php echo number_format($hoyTot, 0); ?></th>
                  </tr>
                </tbody>
              </table>

            </div>
          </div><!-- panel -->
        </div><!-- col -->
      </div><!-- row -->
    <?php } ?>
    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <div class="panel-title">Modulo de supervision</div>
          </div>
          <div class="panel-body" style="text-align: center; overflow-x: auto;">

            <table class="table bg-teal table-striped table-hover table-bordered">
              <thead>
                <tr class="bg-teal-500">
                  <th>Cartera</th>
                  <th>Gestor</th>
                  <th>Hora Logueo</th>
                  <th>Hora Deslogueo</th>
                  <th>Num Gestiones</th>
                  <th>Hora ultima gestion</th>
                  <th>Tiempo muerto</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($supervision as $sp){
                  $horaLog = explode(" ", $sp['fechaRegistro']);
                  if($sp['fechaCierre'] != null){
                    $horaDesLog = explode(" ", $sp['fechaCierre']);
                  }else{
                    $horaDesLog[1] = "";
                  }
                  $gest = $ci2->vista->getGestionesNumero($sp['idUsuario'], $sp['fechauno'], $session['proyecto_activo']);
                  $last = $ci2->vista->getUltimaGestion($sp['idUsuario'], $sp['fechauno'], $session['proyecto_activo']);
                  $predeslog = $ci2->vista->getDeslogueo($sp['idUsuario'], $sp['fechauno']);
                  $prelogeo = $ci2->vista->getLogueo($sp['idUsuario'], $sp['fechauno']);

                  $ultHora = explode(" ", $last[0]['ultima']);
                  if(!isset($ultHora[1])){
                    $ultHora[1] = "";
                  }

                  $muerto = "";

                  if(isset($last[0]['ultima'])){
                    $fecha1 = new DateTime($last[0]['ultima']);//fecha inicial
                    $fecha2 = new DateTime($hoyHora);//fecha de cierre

                    $intervalo = $fecha1->diff($fecha2);
                    $muerto = $intervalo->format('%H:%i:%s');
                  }else{
                    $muerto = "";
                  }

                  $logeo = explode(" ", $prelogeo[0]['fechaRegistro']);
                  if(isset($predeslog[0]['fechaCierre'])){
                    $deslog = explode(" ", $predeslog[0]['fechaCierre']);
                  }else{
                    $deslog[1] = "";
                  }



                  ?>
                  <tr>
                    <td><?php echo $session['proyecto_activo']; ?></td>
                    <td><?php echo $sp['usuario']; ?></td>
                    <td><?php echo $logeo[1]; ?></td>
                    <td><?php echo $deslog[1]; ?></td>
                    <td><?php echo $gest[0]['total']; ?></td>
                    <td><?php echo $ultHora[1]; ?></td>
                    <td><?php echo $muerto; ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>

          </div>
        </div><!-- panel -->
      </div><!-- col -->
    </div><!-- row -->
    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <div class="panel-title">Plan de trabajo</div>
          </div>
          <div class="panel-body" style="text-align: center; overflow-x: auto;">

            <table class="table bg-teal table-striped table-hover table-bordered">
              <thead>
                <tr class="bg-teal-900">
                  <th>Gestor</th>
                  <th>Confirmacion</th>
                  <th>Proyeccion</th>
                  <th>Cierre Probable</th>
                  <th>Meta</th>
                  <th>Cumplimiento</th>
                  <th>Incumple</th>
                  <th>Productiva</th>
                  <th>No Productiva</th>
                  <th>Monto Promesas</th>
                  <th>Cobertura</th>
                </tr>
              </thead>
              <?php
              $fechaI = date("Y-m-")."01";
              $fechaF = date("Y-m-")."31";
              $hoy = date("Y-m-d");

              $callMes = $ci2->vista->getCallMesProyecto($fechaI, $fechaF, $session['proyecto_activo']);

              $confTotalPlan = 0;
              $proyTotalPlan = 0;
              $promFutTotalPlan = 0;
              $cierTotalPlan = 0;
              $metTotalPlan = 0;
              $cumplTotalPlan = 0;
              $incumTotalPlan = 0;
              $prodTotalPlan = 0;
              $noprodTotalPlan = 0;
              $montoTotalPlan = 0;

              foreach ($estrategias as $estr) {
                $confEst = $ci2->vista->getConfEst($estr['descripcion'], $fechaI, $fechaF, $session['proyecto_activo']);
                $ProyEst = $ci2->vista->getProEst($estr['descripcion'], $fechaI, $fechaF, $session['proyecto_activo']);
                $PromFutEst = $ci2->vista->getPromFutEst($estr['descripcion'], $hoy, $hoy, $session['proyecto_activo']);
                $IncumptEst = $ci2->vista->getIncumpEst($estr['descripcion'], $fechaI, $fechaF, $session['proyecto_activo']);
                $metEstr = $ci2->vista->getMetaEst($estr['descripcion'], $session['proyecto_activo']);
                $cierr = $confEst[0]['tot'] + $PromFutEst[0]['tot'];
                $cumpl = $confEst[0]['tot'] /  $metEstr[0]['meta'];
                $cumpl = $cumpl * 100;
                $monPro = $ci2->vista->getMontoPromEst($estr['descripcion'], $fechaI, $fechaF, $session['proyecto_activo']);
                $prd = 0;
                $noprd = 0;
                foreach($callMes as $cm){
                  $ohs = explode(";", $cm['ohactivas']);
                  foreach($ohs as $key => $value){
                  /*  $estOh = $ci2->vista->getEstraOh($value, $session['proyecto_activo']);

                    if(isset($estOh[0]['estrategia'])){
                      if($estOh[0]['estrategia'] == $estr['descripcion']){
                        $contGr = $ci2->vista->getContacto($cm['idContacto'], $session['proyecto_activo']);
                        if($contGr[0]['idGrupo'] == 1){
                          $prd += 1;
                        }else if($contGr[0]['idGrupo'] == 2){
                          $noprd += 1;
                        }
                      }
                    }*/

                  }
                }

                $confTotalPlan += $confEst[0]['tot'];
                $proyTotalPlan += $ProyEst[0]['tot'];
                $promFutTotalPlan += $PromFutEst[0]['tot'];
                $metTotalPlan += $metEstr[0]['meta'];
                $incumTotalPlan += $IncumptEst[0]['tot'];
                $prodTotalPlan += $prd;
                $noprodTotalPlan += $noprd;
                $montoTotalPlan += $monPro[0]['tot'];
                  ?>
                  <tr>
                      <td style="font-size: 10px;"><?php echo $estr['descripcion']; ?></td>
                      <td><?php echo number_format($confEst[0]['tot'],2); ?></td>
                      <td><?php echo number_format($ProyEst[0]['tot'],2); ?></td>
                      <td><?php echo number_format($cierr,2); ?></td>
                      <td><?php echo number_format($metEstr[0]['meta'],2); ?></td>
                      <td><?php echo number_format($cumpl,2); ?> %</td>
                      <td><?php echo number_format($IncumptEst[0]['tot'],2); ?></td>
                      <td><?php echo number_format($prd,0); ?></td>
                      <td><?php echo number_format($noprd,0); ?></td>
                      <td><?php echo number_format($monPro[0]['tot'],2); ?></td>
                      <td>2</td>
                  </tr>
                  <?php
              }
              if($metTotalPlan == 0){
                $metTotalPlan = 1;
              }
              $cierTotalPlan = $confTotalPlan + $promFutTotalPlan;
              $cumplTotalPlan = ($confTotalPlan / $metTotalPlan) * 100;
              ?>

              <tr class="bg-teal-900">
                  <td style="font-size: 10px;">Totales:</td>
                  <td><?php echo number_format($confTotalPlan,2); ?></td>
                  <td><?php echo number_format($proyTotalPlan,2); ?></td>
                  <td><?php echo number_format($cierTotalPlan,2); ?></td>
                  <td><?php echo number_format($metTotalPlan,2); ?></td>
                  <td><?php echo number_format($cumplTotalPlan,2); ?> %</td>
                  <td><?php echo number_format($incumTotalPlan,2); ?></td>
                  <td><?php echo number_format($prodTotalPlan,0); ?></td>
                  <td><?php echo number_format($noprodTotalPlan,0); ?></td>
                  <td><?php echo number_format($montoTotalPlan,2); ?></td>
                  <td>2</td>
              </tr>
            </table>

          </div>
        </div><!-- panel -->
      </div><!-- col -->
    </div><!-- row -->

  </div><!-- container -->


</section>
