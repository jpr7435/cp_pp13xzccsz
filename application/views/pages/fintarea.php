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
                <i class="icon-file-empty position-left"></i> Fin de la tarea - <?php echo $session['proyecto_activo']; ?>
            </div>
        </div>
    </div>
    <!-- /Page header -->

    <div class="container-fluid page-content">
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <h4>Fin de la tarea!</h4>
                    <div class="alert alert-primary alert-styled-right">
                        No se encontraron más registros. <a style="text-decoration: underline;" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/dashboard" class="alert-link">Click aca para continuar.</a>
                    </div>
                </div>
            </div>
        </div>
        <div style="clear: both; height: 25px;"></div>
    </div>
</section>