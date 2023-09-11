<?php
/* * To change this template, choose Tools | Templates * and open the template in the editor. */
$ci2 = &get_instance();
//$us = $ci3->load->model("usuarios");
//$ci2 = &get_instance();
$ci2->load->model("vista");

$carteras = explode(";", $session['carteras']);

$fila = 0;
$pr = 0;


?>

<section class="main-container">
  <h1 style="display:none">Cargue de factura - <?php echo $session['proyecto_activo']; ?></h1>

  <!-- Page header -->
  <div class="header">
    <div class="header-content">
      <div class="page-title">
        <i class="icon-file-empty position-left"></i> Cargue de factura
      </div>
    </div>
  </div>
  <!-- /Page header -->

  <div class="container-fluid page-content">
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">
          <div class="col-lg-7">
            <form name="upload-file" id="upload-file" method="post" enctype="multipart/form-data" action="http://<?php echo $this->config->item("host_cobranzas"); ?>/index.php/uploadfactura/<?php echo $session['proyecto_activo']; ?>">
              <div class="form-group">
                <div class="input-group input-group-lg">
                  <label>Mes:</label>
                  <select class="form-control" name="mes" id="mes">
                    <option val="0">Seleccione...</option>
                    <option val="Enero">Enero</option>
                    <option val="Febrero">Febrero</option>
                    <option val="Marzo">Marzo</option>
                    <option val="Abril">Abril</option>
                    <option val="Mayo">Mayo</option>
                    <option val="Junio">Junio</option>
                    <option val="Julio">Julio</option>
                    <option val="Agosto">Agosto</option>
                    <option val="Septiembre">Septiembre</option>
                    <option val="Octubre">Octubre</option>
                    <option val="Noviembre">Noviembre</option>
                    <option val="Diciembre">Diciembre</option>
                  </select>
                  </div>
                </div>
              <div class="form-group">
                <div class="input-group input-group-lg">
                  <input class="form-control input-lg" name="file" id="file" type="file">
                  <span class="input-group-btn">
                    <button class="btn btn-default" id="cargar-fact-btn" type="button">
                      <i class="icon icon-upload"></i>
                    </button> </span>
                  </div>
                </div>
              </form>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>
