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
    <h1 style="display:none">Cargue de base inicial - <?php echo $session['proyecto_activo']; ?></h1>

    <!-- Page header -->
    <div class="header">
        <div class="header-content">
            <div class="page-title">
                <i class="icon-file-empty position-left"></i> Cargue de base inicial - <?php echo $session['proyecto_activo']; ?>
            </div>
        </div>
    </div>
    <!-- /Page header -->

    <div class="container-fluid page-content">
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="col-lg-7">
                        <form name="upload-file" id="upload-file" method="post" enctype="multipart/form-data" action="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/uploadbaseinicial/<?php echo $session['proyecto_activo']; ?>">
                            <div class="form-group">
                                <div class="input-group input-group-lg">
                                    <input class="form-control input-lg" name="file" id="file" type="file">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" id="cargar-btn" type="button">
                                            <i class="icon icon-upload"></i>
                                        </button> </span>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <div style="clear: both; height: 25px;"></div>
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div id="resultado-busqueda">

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>