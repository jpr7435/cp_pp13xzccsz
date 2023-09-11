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
                <i class="icon-file-empty position-left"></i> Campos del proyecto - <?php echo $slug; ?>
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
                      <div class="col-md-3">
                        <label>Nombre Campo:</label>
                        <input type="text" name="name-field" id="name-field" class="form-control"/>
                      </div>

                      <div class="col-md-3">
                        <label>Tipo:</label>
                        <select name="tipo-field" id="tipo-field" class="form-control">
                          <option value="0">Seleccione....</option>
                          <option value="varchar">Texto</option>
                          <option value="float">Moneda</option>
                          <option value="longtext">Texto Largo</option>
                        </select>
                      </div>
                      <div class="col-md-3">
                        <label>Ubicacion:</label>
                        <select name="location-field" id="location-field" class="form-control">
                          <option value="0">Seleccione....</option>
                          <option value="valores">Valores</option>
                          <option value="fechas">Fechas</option>
                          <option value="otros">Otros</option>
                        </select>
                      </div>
                      <input type="hidden" name="proyect" id="proyect" value="<?php echo $slug; ?>" />
                      <div class="col-md-2">
                        <div style="clear: both; height: 30px;"></div>
                        <button type="button" id="savefield-btn" class="btn btn-success">Guardar</button>
                      </div>
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
                                <th>Tipo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($campos as $camp) { ?>
                                <tr>
                                    <td><?php echo $camp['Field']; ?></td>
                                    <td><?php echo $camp['Type']; ?></td>
                                    <?php if($camp['Field'] != "idCreditos" && $camp['Field'] != "documento" && $camp['Field'] != "obligacion" && $camp['Field'] != "fechacargue" && $camp['Field'] != "activo" && $camp['Field'] != "fechaActualizacion" && $camp['Field'] != "nuip" && $camp['Field'] != "radicado"){ ?>
                                    <td><img src="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/img/delete.png" flag="<?php echo $camp['Field']; ?>" style="cursor: pointer;" class="drop-field-btn" alt="Borrar" title="Borrar Campo"/></td>
                                  <?php }else{ ?>
                                    <td></td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
      </div>
    </div>
</section>
