<?php
/* * To change this template, choose Tools | Templates * and open the template in the editor. */
$ci2 = &get_instance();
//$us = $ci3->load->model("usuarios");
//$ci2 = &get_instance();
$ci2->load->model("vista");

$carteras = explode(";", $session['carteras']);
?>
<section class="main-container">
  <!-- Page header -->
  <div class="header">
    <div class="header-content">
      <div class="page-title">
        <i class="icon-file-empty position-left"></i> Cargar catalogo - <?php echo $slug; ?>
      </div>
    </div>
  </div>
  <!-- /Page header -->

  <div class="container-fluid page-content">

    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <div class="panel-title">Status</div>
          </div>
          <div class="panel-body">
            <div class="col-md-12">
              <form name="upload-status" id="upload-status" method="post" enctype="multipart/form-data" action="http://<?php echo $this->config->item('host_cobranzas'); ?>/index.php/admin/uploadstatus/<?php echo $slug; ?>">
                <label>Para el cargue de los status, se debe subir un archivo .csv de limitado por punto y coma (;). El archivo debe llevar las soguientes columnas:</br>
                  - status</br>
                  - grupo</br>
                  - predictiva</br>
                </br>
                Status: El nombre del status que se va a crear.</br>
                Grupo: El grupo hace referencia al codigo del grupo al cual pertenece el status a crear: 1 = Productiva, 2 = No Productiva, 3 = Sin Contacto.</br>
                Predictiva: El campo predictiva hace referencia al codigo de predictiva al cual pertenece el status que se va a crear: 1 = Proyeccion, 2 = Confirmacion, 3 = Comentario General.</br>

                </label>
                <input type="file" name="status" id="status" class="form-control"/>
                <div style="clear: both; height: 20px;"></div>
                <button type="button" id="upload-satus-btn" class="btn btn-success">Cargar</button>
              </form>
            </div>
          </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading">
            <div class="panel-title">Logros</div>
          </div>
          <div class="panel-body">
            <div class="col-md-12">
              <form name="upload-logros" id="upload-logros" method="post" enctype="multipart/form-data" action="http://<?php echo $this->config->item('host_cobranzas'); ?>/index.php/admin/uploadlogros/<?php echo $slug; ?>">
                <label>Para el cargue de los logros, se debe subir un archivo .csv de limitado por punto y coma (;). El archivo debe llevar las soguientes columnas:</br>
                  - Logro</br>
                  - Nivel</br>
                  - Clase</br>
                  - Dias entre gestion</br>
                </br>
                Logro: El nombre del logro que se va a crear.</br>
                Nivel: El nivel es un valor numerico para calcular la mejor gestion.</br>
                Clase: El campo clase hace referencia al codigo de clase al cual pertenece el logro que se va a crear: 1 = CR, 2 = Contactado, 3 = Incumple, 4 = Tramite, 5 = SC, 6 = FG.</br>
                Dias entre Gestion: Este es un valor numero para las colas automaticas para los dias entre gestion.</br>

                </label>
                <input type="file" name="logros" id="logros" class="form-control"/>
                <div style="clear: both; height: 20px;"></div>
                <button type="button" id="upload-logros-btn" class="btn btn-success">Cargar</button>
              </form>
            </div>
          </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading">
            <div class="panel-title">Relaciones</div>
          </div>
          <div class="panel-body">
            <div class="col-md-12">
              <form name="upload-relaciones" id="upload-relaciones" method="post" enctype="multipart/form-data" action="http://<?php echo $this->config->item('host_cobranzas'); ?>/index.php/admin/uploadrelaciones/<?php echo $slug; ?>">
                <label>Para el cargue de las relaciones, se debe subir un archivo .csv de limitado por punto y coma (;). El archivo debe llevar las soguientes columnas:</br>
                  - Accion</br>
                  - Status</br>
                  - Logro</br>
                </br>
                Accion: El codigo de accion correspondiente a la base de datos.</br>
                Status: El codigo de status creado en la base de datos.</br>
                Logro: El codigo de logro creado en la base de datos.</br>
                </label>
                <input type="file" name="relaciones" id="relaciones" class="form-control"/>
                <div style="clear: both; height: 20px;"></div>
                <button type="button" id="upload-relaciones-btn" class="btn btn-success">Cargar</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
