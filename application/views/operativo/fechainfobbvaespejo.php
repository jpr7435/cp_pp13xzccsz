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
                <i class="icon-file-empty position-left"></i> Exporte de infome para campaña - <?php echo $session['proyecto_activo']; ?>
            </div>
        </div>
    </div>
    <!-- /Page header -->

    <div class="container-fluid page-content">
        <div style="clear: both; height: 25px;"></div>
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <form name="fechas-bbva" id="fechas-bbva" method="post" action="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/generainformebbvaespejo">
                        <div class="form-group">
                            <label>Fecha Incial:</label>
                            <input type="text" name="fechaIni" id="fechaIni" class="form-control datepicker-here" data-language='en' />
                        </div>
                        <div class="form-group">
                            <label>Fecha Final:</label>
                            <input type="text" name="fechaFin" id="fechaFin" class="form-control datepicker-here" data-language='en' />
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success btn-labeled"  id="genera-informe-bbva" type="button"><b><i class="icon-floppy-disk"></i></b>Exportar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
