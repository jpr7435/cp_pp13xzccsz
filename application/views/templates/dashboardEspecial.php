<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$ci2 = &get_instance();
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
                    <th style="background: #F2F2F2;">Hora Logueo</th>
                    <th style="background: #F2F2F2;">Hora Ultima Accion</th>
                    <th style="background: #F2F2F2;">Clientes Gestionados</th>
                    <th style="background: #F2F2F2;">Contactos</th>
                    <th style="background: #F2F2F2;">% Efectividad</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($usuariosPr as $Upr) {
                    $us = $this->vista->getusuario($Upr['idUsuario']);
                    $cls = $this->vista->getClientesHoy($hoy, $Upr['idUsuario'], $session['proyecto_activo']);
                    $clientes = 0;
                    $contacto = 0;
                    $porce = 0;
                    $fechaLog = "";
                    $fechaUltima = "";
                    foreach($cls as $clU){
                      $clientes += 1;
                      $fechaUltima = $clU['fechaGestion'];
                      if($clU['idContacto'] == 1){
                        $contacto += 1;
                      }
                    }
                    if($clientes > 0){
                    $fechaLog = $cls[0]['fechaGestion'];
                    $porce = $contacto / $clientes;
                    $porce = $porce * 100;
                    ?>
                  <tr>
                    <td><?php echo $us[0]['usuario']; ?></td>
                    <td><?php echo $fechaLog; ?></td>
                    <td><?php echo $fechaUltima; ?></td>
                    <td><?php echo $clientes; ?></td>
                    <td><?php echo $contacto; ?></td>
                    <td><?php echo number_format($porce, 2)." %"; ?></td>
                  </tr>
                <?php } } ?>
                </tbody>
              </table>
            </div>
          </div><!-- panel -->
        </div><!-- col -->
      </div><!-- row -->
    </div><!-- container -->
</section>
