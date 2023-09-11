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
                <i class="icon-file-empty position-left"></i> Crear Campa&ntilde;a
            </div>
        </div>
    </div>
    <!-- /Page header -->

    <div class="container-fluid page-content">
        <div style="clear: both; height: 25px;"></div>
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <form name="campana-form" id="campana-form" method="post" action="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/sms/savecampana">
                        <div class="form-group">
                            <label>Nombre de la Campa&ntilde;a</label>
                            <input type="text" name="nombre-campana" id="nombre-campana" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label>Descripcion de la Campa&ntilde;a</label>
                            <textarea name="desc-campana" id="desc-campana" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-success" name="create-campana-btn" id="create-campana-btn">Crear Campa&ntilde;a</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>