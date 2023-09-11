<?php
/* * To change this template, choose Tools | Templates * and open the template in the editor. */
$ci2 = &get_instance();
//$us = $ci3->load->model("usuarios");
//$ci2 = &get_instance();
$ci2->load->model("vista");

$carteras = explode(";", $session['carteras']);
$gruposC2 = $ci2->vista->getGruposContacto($session['proyecto_activo']);

$fila = 0;
$pr = 0;
?>

<section class="main-container">
    <!-- Page header -->
    <div class="header">
        <div class="header-content">
            <div class="page-title">
                <i class="icon-file-empty position-left"></i> Resumen de estrategias - <?php echo $session['proyecto_activo']; ?>
            </div>
        </div>
    </div>
    <!-- /Page header -->
    <div id="result"></div>
    <input type="hidden" name="proyect" id="proyect" value="<?php echo $session['proyecto_activo']; ?>"/>
    <div class="container-fluid page-content">
        <div class="col-md-12" style="margin-bottom: 25px; margin-top: 25px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">Estrategias</div>
                </div>
                <div class="panel-body" id="acciones-front">
                  <form name="metasForm" id="metasForm"  method="post" action="http://<?php echo $this->config->item('host_cobranzas'); ?>/index.php/savesestrategias">
                    <table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
                        <thead>
                            <tr>
                                <th>Estrategia</th>
                                <th># Clientes</th>
                                <th>Meta</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                             foreach ($estrategias as $est) {
                               $meta = 0;
                               $estDb = $ci2->vista->getEstrategiaUno($est['estrategia'], $session['proyecto_activo']);
                               if(isset($estDb[0]['meta'])){
                                 $meta = $estDb[0]['meta'];
                               }
                              ?>
                                <tr>
                                    <td><?php echo $est['estrategia']; ?></td>
                                    <td><?php echo $est['cuantos']; ?></td>
                                    <td><input type="text" class="form-control" style="width: 100px;" name="meta<?php echo $i; ?>" id="meta<?php echo $i; ?>" value="<?php echo $meta; ?>" /></td>
                                      <input type="hidden" name="estrategia<?php echo $i; ?>" id="estrategia<?php echo $i; ?>" value="<?php echo $est['estrategia']; ?>" />
                                      <input type="hidden" name="total" id="total" value="<?php echo $i; ?>" />
                                </tr>
                            <?php $i += 1; } ?>
                            <tr>
                              <td><button type="submit" name="metasBtn" class="btn btn-success">Guardar Metas</button></td>
                              <td></td>
                              <td></td>
                            </tr>
                        </tbody>
                    </table>
                  </form>
                </div>
            </div>
        </div>

    </div>
</section>
