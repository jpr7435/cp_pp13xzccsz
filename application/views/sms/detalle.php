<?php
/* * To change this template, choose Tools | Templates * and open the template in the editor. */
$ci2 = &get_instance();
//$us = $ci3->load->model("usuarios");
//$ci2 = &get_instance();
$ci2->load->model("vista");

//$carteras = explode(";", $session['carteras']);
$registros = $this->vista->getRegistrosCampanaSMS($campana[0]['idCampana']);
?>

<section class="main-container">

  <!-- Page header -->
  <div class="header">
    <div class="header-content">
      <div class="page-title">
        <i class="icon-file-empty position-left"></i> Detalle Campa&ntilde;a
      </div>
    </div>
  </div>
  <!-- /Page header -->

  <div class="container-fluid page-content">
    <div style="clear: both; height: 25px;"></div>
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">
          <label>Registros Cargados:&nbsp;&nbsp;&nbsp;<?php if(isset($registros[0]['total'])){echo $registros[0]['total']; }else{echo "0";} ?></label>
          <form name="upload-file" id="upload-file" method="post" enctype="multipart/form-data" action="https://<?php echo $this->config->item("host_cobranzas"); ?>/index.php/sms/uploadsms">
            <label for="msg-envio">Registros para envio:</label>
            <input type="file" id="file-envio" name="file-envio" class="form-control"/>
            <input type="hidden" name="campana-activa-base" id="campana-activa-base" value="<?php echo $campana[0]['idCampana']; ?>"/>
            <button type="submit" name="cargar-sms-btn" class="btn btn-success" style="margin-top: 20px;" id="cargar-sms-btn">Cargar Archivo</button>
          </form>
        </div>
      </div>
    </div>


    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">
          <input type="hidden" name="campana-activa" id="campana-activa" value="<?php echo $campana[0]['idCampana']; ?>"/>
          <h1><?php echo $campana[0]['campana']; ?></h1>
          <p><?php echo $campana[0]['concepto']; ?></p>
          <label for="msg-envio">Mensaje a enviar:</label>
          <textarea id="msg-envio" name="msg-envio" class="form-control"><?php echo $campana[0]['mensaje']; ?></textarea>
          <p class="text-info" style="margin-top: 10px; font-size: 14px;"><?php echo $preview; ?></p>
          <button type="button" name="detalle-sms-btn" class="btn btn-success" style="margin-top: 20px;" id="detalle-sms-btn">Guardar Mensaje</button>
        </div>
      </div>
    </div>


    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">
          <div class="panel panel-flat">
            <div class="panel-body">
              <button style="margin-bottom: 15px;" type="button" name="new-respuesta-sms-btn" class="btn btn-danger" id="new-respuesta-sms-btn">Agregar respuesta</button>
              <table class="table table-bordered">
                <thead>
                  <th>Codigo</th>
                  <th>Mensaje Respuesta</th>
                </thead>
                <tbody>
                  <?php foreach($respuestas as $r){ ?>
                    <tr>
                      <td><?php echo $r['codigo']; ?></td>
                      <td><?php echo $r['mensaje']; ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">
          <button type="button" name="enviar-sms-btn" class="btn btn-warning" id="enviar-sms-btn">Enviar</button>
        </div>
      </div>
    </div>
  </div>
</section>
<div id="modal-respuesta-sms">
  <form name="new-respuesta-form" id="new-respuesta-form" method="post" action="https://<?php echo $this->config->item("host_cobranzas"); ?>/index.php/sms/saverespuesta">
    <div class="sms-respuesta-box">
      <div class="form-group">
        <label>Codigo</label>
        <input type="text" class="form-control" name="codigo-new-sms" id="codigo-new-sms"/>
      </div>
      <div class="form-group">
        <label>Respuesta</label>
        <textarea class="form-control" name="respuesta-new-sms" id="respuesta-new-sms"></textarea>
      </div>
      <input type="hidden" name="campana-activa-respuesta" id="campana-activa-respuesta" value="<?php echo $campana[0]['idCampana']; ?>"/>
      <div class="form-group">
        <button type="button" id="btn-guardar-respuesta-sms" class="btn btn-success">Guardar</button>&nbsp;&nbsp;<button type="button" id="cancel-new-respuesta" class="btn btn-danger">Cancelar</button>
      </div>
    </div>
  </form>
</div>
