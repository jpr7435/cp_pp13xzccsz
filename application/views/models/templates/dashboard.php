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



?>

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
        <div class="col-md-4 col-sm-4">
          <div class="panel panel-success panel-border border-success">
            <div class="panel-heading">
              <h5 class="panel-title">Detalle Pagos <a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/detalle-pagos" style="font-size: 9px;">Ver Detalle</a></h5>
            </div>
            <div class="panel-body" style="text-align: center;">
              <p style="font-size: 15px;">$<?php echo number_format($totalPagos[0]['total'],0); ?></p>
            </div>
          </div>
        </div>

        <div class="col-md-4 col-sm-4">
          <div class="panel panel-warning panel-border border-warning">
            <div class="panel-heading">
              <h5 class="panel-title">Meta Pagos</h5>
            </div>
            <div class="panel-body" style="text-align: center;">
              <p style="font-size: 15px;">$<?php echo number_format($session['meta'],0); ?></p>
            </div>
          </div>

        </div>

        <div class="col-md-4 col-sm-4">
          <div class="panel panel-info panel-border border-info">
            <div class="panel-heading">
              <h5 class="panel-title">Ejecucion Meta</h5>
            </div>
            <div class="panel-body" style="text-align: center;">
              <p style="font-size: 15px;"><?php if($session['meta'] != 0){$ejemet1 = $totalPagos[0]['total'] / $session['meta'];}else{$ejemet1 = 0;} $ejemet = $ejemet1 * 100; echo number_format($ejemet, 2)." %"; ?></p>
            </div>
          </div>

        </div>
      </div>






      <div class="row">
        <div class="col-md-12 col-sm-12">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <div class="panel-title">Productividad</div>
            </div>
            <div class="panel-body" style="text-align: center; overflow-x: auto;">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th style="background: #F2F2F2;">Asesor</th>
                    <th style="background: #F2F2F2;">Hora de logueo</th>
                    <th style="background: #F2F2F2;">Hora de deslogueo</th>
                    <th style="background: #F2F2F2;">Hora ultima accion</th>
                    <th style="background: #F2F2F2;">Gestiones</th>
                    <th style="background: #F2F2F2;">Clientes</th>
                    <th style="background: #F2F2F2;">Contactos</th>
                    <th style="background: #F2F2F2;">Acuerdos</th>
                    <th style="background: #F2F2F2;">Meta gestiones</th>
                    <th style="background: #F2F2F2;">Meta clientes</th>
                    <th style="background: #F2F2F2;">Meta contactos</th>
                    <th style="background: #F2F2F2;">Meta acuerdos</th>
                    <th style="background: #F2F2F2;">Cumplimientos dia</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($usuariosPr as $Upr) {

                    $gestUser = 0;
                    $contactos = 0;
                    $acuerdos = 0;
                    unset($cliT);
                    $cliT = array();
                     foreach($productividad as $prT){

                        if($Upr['idUsuario'] == $prT['idAsesor']){
                          $gestUser += 1;
                          $cliT[$prT['documento']] = $prT['documento'];
                          $precont = $this->vista->getContacto($prT['idContacto'], $session['proyecto_activo']);
                          if($precont[0]['idGrupo'] == 1){
                            $contactos += 1;
                          }

                          $preacue = $this->vista->getResultado($prT['idResultado'], $session['proyecto_activo']);
                          
                        }



                     }

                    $us = $this->vista->getusuario($Upr['idUsuario']);

                    $logEve = $this->vista->getEventoLogeo($Upr['idUsuario'], $hoy);

                    if(isset($logEve[0]['evento'])){
                      $logeo = $this->vista->getEvento($logEve[0]['evento']);
                      $horaLog = explode(" ", $logeo[0]['fecha']);
                    }else{
                      $horaLog[1] = "";
                    }

                    $deslogEve = $this->vista->getDeslogeo($Upr['idUsuario'], $hoy);

                    if(isset($deslogEve[0]['evento'])){
                      $deslogeo = $this->vista->getEvento($deslogEve[0]['evento']);
                      $horaDeslog = explode(" ", $deslogeo[0]['fecha']);
                    }else{
                      $horaDeslog[1] = "";
                    }


                    $lastEvent = $this->vista->getLastevent($Upr['idUsuario'], $hoy, $session['proyecto_activo']);

                    if(isset($lastEvent[0]['evento'])){
                      $ultimoEve = $this->vista->getCobranzasEvent($lastEvent[0]['evento'], $session['proyecto_activo']);
                    }else{
                      $ultimoEve[0]['hora'] = "";
                    }

                    $metas = $this->vista->getMetas($Upr['idUsuario']);

                    $mtaGest1 =  $gestUser / $metas[0]['metaproductividad'];
                    if($mtaGest1 > 1.05){
                      $mtaGest1 = 1.05;
                    }
                    $mtaGest = $mtaGest1 * 100;

                    $cli = sizeof($cliT);

                    $mtaCli1 =  $cli / $metas[0]['metaClientes'];

                    if($mtaCli1 > 1.05){
                      $mtaCli1 = 1.05;
                    }
                    $mtaCli = $mtaCli1 * 100;

                    $mtaCont1 =  $contactos / $metas[0]['metaContactos'];

                    if($mtaCont1 > 1.03){
                      $mtaCont1 = 1.03;
                    }
                    $mtaCont = $mtaCont1 * 100;

                    $mtaAcu1 =  $acuerdos / $metas[0]['metaAcuerdos'];

                    if($mtaAcu1 > 1.5){
                      $mtaAcu1 = 1.5;
                    }
                    $mtaAcu = $mtaAcu1 * 100;

                    $preGest = $mtaGest1 * 0.15;
                    $preCli = $mtaCli1 * 0.15;
                    $preCont = $mtaCont1 * 0.4;
                    $preAcu = $mtaAcu1 * 0.3;


                    $totalCuadro1 = $preGest + $preCli + $preCont + $preAcu;
                    $totalCuadro = $totalCuadro1 * 100;
                    if($totalCuadro > 79){
                      $claseRow = 'style="background-color: #D0F5A9;"';
                    }else if($totalCuadro > 49 && $totalCuadro < 80){
                      $claseRow = 'style="background-color: #F2F5A9;"';
                    }else{
                      $claseRow = 'style="background-color: #F5A9A9;"';
                    }

                    ?>
                  <tr>
                    <td <?php echo $claseRow; ?>><?php echo $us[0]['usuario']; ?></td>
                    <td <?php echo $claseRow; ?>><?php echo $horaLog[1]; ?></td>
                    <td <?php echo $claseRow; ?>><?php echo $horaDeslog[1]; ?></td>
                    <td <?php echo $claseRow; ?>><?php echo $ultimoEve[0]['hora']; ?></td>
                    <td <?php echo $claseRow; ?>><?php echo $gestUser; ?></td>
                    <td <?php echo $claseRow; ?>><?php echo sizeof($cliT); ?></td>
                    <td <?php echo $claseRow; ?>><?php echo $contactos; ?></td>
                    <td <?php echo $claseRow; ?>><?php echo $acuerdos; ?></td>
                    <td <?php echo $claseRow; ?>><?php echo number_format($mtaGest,2)." %"; ?></td>
                    <td <?php echo $claseRow; ?>><?php echo number_format($mtaCli,2)." %"; ?></td>
                    <td <?php echo $claseRow; ?>><?php echo number_format($mtaCont,2)." %"; ?></td>
                    <td <?php echo $claseRow; ?>><?php echo number_format($mtaAcu,2)." %"; ?></td>
                    <td <?php echo $claseRow; ?>><?php echo number_format($totalCuadro,2)." %"; ?></td>
                  </tr>
                <?php } ?>
                </tbody>
              </table>
            </div>
          </div><!-- panel -->
        </div><!-- col -->
      </div><!-- row -->
    </div><!-- container -->


</section>
