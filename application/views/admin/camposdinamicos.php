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
                <i class="icon-file-empty position-left"></i> Campos dinamicos del proyecto - <?php echo $session['proyecto_activo']; ?>
            </div>
        </div>
    </div>
    <!-- /Page header -->

    <div class="container-fluid page-content">

      <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">Agregar Campo</div>
                </div>
                <div class="panel-body">
                  <form name="savedinamic" id="savedinamic" method="post" action="http://<?php echo $this->config->item('host_cobranzas'); ?>/index.php/admin/savefielddinamic">
                      <div class="col-md-3">
                        <label>Nombre Campo:</label>
                        <input type="text" name="name-field" id="name-field" class="form-control"/>
                      </div>
                      <div class="col-md-2">
                        <div style="clear: both; height: 30px;"></div>
                        <button type="button" id="savefielddinamic-btn" class="btn btn-success">Guardar</button>
                      </div>
                  </form>
                </div>
            </div>
        </div>
      </div>


      <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">Campos</div>
                </div>
                <div id="field-list" class="panel-body">
                    <table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
                        <thead>
                            <tr>
                                <th>Campo</th>
                                <th>Opciones</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $flag = 0;
                              foreach ($campos as $camp) { ?>
                                <tr>
                                    <td><?php echo $camp['nombreCampo']; ?></td>
                                    <td>
                                      <small>Se deben separa las opciones con ; - Ejemplo: opcion1;opcion2;opcion3;opcion4</small></br>
                                      <textarea name="options-field<?php echo $flag; ?>" class="form-control" id="options-field<?php echo $flag; ?>"><?php echo $camp['contenido']; ?></textarea></td>
                                      <td><button type="button" class="btn btn-success guardar-campo" idcam="<?php echo $camp['idCampos']; ?>" flag="<?php echo $flag; ?>">Guardar</button>&nbsp;&nbsp;&nbsp;<button type="button" idcam="<?php echo $camp['idCampos']; ?>"
                                         flag="<?php echo $flag; ?>" class="btn btn-danger borrar-campo" >Borrar</button></td>
                                </tr>
                            <?php $flag += 1; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
      </div>
    </div>
</section>
