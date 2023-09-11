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
<script src="https://<?php echo $this->config->item("host_cobranzas"); ?>/front/lib/js/core/tiempos.js"></script>
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
        <div class="alert alert-primary alert-styled-left">
          Tiempo de espera actual:
          <span style="font-weight: bold;">
              <span id="hour3">00</span>
              <span class="divider">:</span>
              <span id="minute3">00</span>
              <span class="divider">:</span>
              <span id="second3">00</span>

          </span>
        </div>
        <a href="https://<?php echo $this->config->item("host_cobranzas"); ?>/index.php/dashboard/<?php echo $session['proyecto_activo']; ?>" style="cursor: pointer; float: right; font-weight: bold; text-decoration: underline;">Terminar campa&ntilde;a entrantes</a>
        </div>
      </div>
    </div><!-- row -->
  </div><!-- container fluid -->
</section>
