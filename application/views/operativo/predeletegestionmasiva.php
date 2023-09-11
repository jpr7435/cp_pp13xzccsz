<?php
/* * To change this template, choose Tools | Templates * and open the template in the editor. */
$ci2 = &get_instance();
//$us = $ci3->load->model("usuarios");
//$ci2 = &get_instance();
$ci2->load->model("vista");

$carteras = explode(";", $session['carteras']);

$fila = 0;
$pr = 0;

//print_r($campos);
//print_r($creditos);
?>

<section class="main-container">

    <!-- Page header -->
    <div class="header">
        <div class="header-content">
            <div class="page-title">
                <i class="icon-file-empty position-left"></i> Elimina cargue de gestiones masivas - <?php echo $session['proyecto_activo']; ?>
            </div>
        </div>
    </div>
    <!-- /Page header -->

    <div class="container-fluid page-content">
        <div style="clear: both; height: 25px;"></div>
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                  <?php if(isset($mensaje)){
                    echo $mensaje;
                  } ?>
                    <form name="fechas-bbva" id="fechas-bbva" method="post" action="http://<?php echo $this->config->item("host_cobranzas"); ?>/index.php/deletegestionmasiva">
                        <div class="form-group">
                            <label>Fecha:</label>
                            <input type="text" name="fechaIni" id="fechaIni" class="form-control datepicker-here" data-language='en' />
                        </div>
                        <div class="form-group">
                            <label>Usuario:</label>
                            <select name="usuarioCargue" id="usuarioCargue" class="form-control">
                              <option value="0">Seleccione...</option>
                              <?php foreach($usuarios as $us){ ?>
                                <option value="<?php echo $us['idUsuario']; ?>"><?php echo $us['nombre']; ?></option>
                              <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success btn-labeled"  id="genera-informe-llamadas" type="button"><b><i class="icon-floppy-disk"></i></b>Eliminar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
