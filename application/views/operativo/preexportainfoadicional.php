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
                <i class="icon-file-empty position-left"></i> Exporte informacion adicional campaña - <?php echo $session['proyecto_activo']; ?>
            </div>
        </div>
    </div>
    <!-- /Page header -->

    <div class="container-fluid page-content">
        <div style="clear: both; height: 25px;"></div>
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <form name="info-adicional" id="info-adicional" method="post" action="http://<?php echo $this->config->item('host_cobranzas'); ?>/index.php/exportainfoadicional/<?php echo $session['proyecto_activo']; ?>">
                        <ul style="list-style: none;">
                            <li><input type="radio" checked name="info" id="info" value="1"/>&nbsp;&nbsp;&nbsp;Referencias</li>
                            <li><input type="radio" name="info" id="info" value="2"/>&nbsp;&nbsp;&nbsp;Trabajo</li>
                            <li><input type="radio" name="info" id="info" value="3"/>&nbsp;&nbsp;&nbsp;Inmuebles</li>
                            <li><input type="radio" name="info" id="info" value="4"/>&nbsp;&nbsp;&nbsp;Vehiculos</li>
                        </ul>
                        <button type="submit" class="btn btn-success" name="infoexport-btn" id="infoexport-btn">Exportar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>