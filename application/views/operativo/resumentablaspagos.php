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

    <!-- Page header -->
    <div class="header">
        <div class="header-content">
            <div class="page-title">
                <i class="icon-file-empty position-left"></i> Resumen de cargue pagos - <?php echo $session['proyecto_activo']; ?>
            </div>
        </div>
    </div>
    <!-- /Page header -->

    <div class="container-fluid page-content">
        <div style="clear: both; height: 25px;"></div>
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <h2>Pagos Cargados: <?php echo number_format($cuantos,0); ?></h2>
                    <h2>Valor de pagos: <?php echo number_format($valores,0); ?></h2>
                    <h2>Pagos No Reconocidos: <?php echo number_format($noreconoce,0); ?></h2>
                </div>
            </div>
        </div>
    </div>
</section>
