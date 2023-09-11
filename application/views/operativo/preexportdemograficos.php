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
                <i class="icon-file-empty position-left"></i> Exporte detalle de llamadas campaña - <?php echo $session['proyecto_activo']; ?>
            </div>
        </div>
    </div>
    <!-- /Page header -->

    <div class="container-fluid page-content">
        <div style="clear: both; height: 25px;"></div>
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <form name="exporta-demograficos" id="exporta-demograficos" method="post" action="http://<?php echo $this->config->item('host_cobranzas'); ?>/index.php/exportademograficos">
                        <div class="form-group">
                            <label>Demografico:</label>
                            <select name="demografico" id="demografico" class="form-control">
                                <option value="0">Seleccione...</option>
                                <option value="1">Telefonos</option>
                                <option value="2">Direcciones</option>
                                <option value="3">Mails</option>
                            </select>
                                    
                        </div>
                        <div class="form-group">
                            <label>Estado:</label>
                           <select name="estado-demo" id="estado-demo" class="form-control">
                                <option value="0">Seleccione...</option>
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success btn-labeled"  id="genera-demograficos" type="button"><b><i class="icon-floppy-disk"></i></b>Exportar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>