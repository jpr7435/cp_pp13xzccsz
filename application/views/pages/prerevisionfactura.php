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
        <i class="icon-file-empty position-left"></i> Revision de factura
      </div>
    </div>
  </div>
  <!-- /Page header -->

  <div class="container-fluid page-content">
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">
          <div class="col-lg-7">
            <form name="upload-file" id="upload-file" method="post" enctype="multipart/form-data" action="https://<?php echo $this->config->item("host_cobranzas"); ?>/index.php/resumen-factrura/<?php echo $session['proyecto_activo']; ?>">
              <div class="form-group">
                <div class="input-group input-group-lg">
                  <label>Mes de Factura:</label>
                  <select class="form-control" name="codigo" id="codigo">
                    <option val="0">Seleccione...</option>
                    <?php foreach($codigos as $co){ ?>
                      <option value="<?php echo $co['codigo']; ?>"><?php echo $co['mes']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group input-group-lg">
                  <button type="submit" class="btn btn-success">Revisar</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
