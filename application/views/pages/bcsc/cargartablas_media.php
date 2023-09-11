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
                <i class="icon-file-empty position-left"></i> Cargar Tablas Diarias BCS
            </div>
        </div>
    </div>
    <!-- /Page header -->

    <div class="container-fluid page-content">

        <div style="clear: both; height: 25px;"></div>
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">

                    <form name ="cargartablas" id="cargartablas" method="post" enctype="multipart/form-data" action="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/uploadtablas_media">

                        <lable>Seleccionar Tablas:</lable>
                        <input type="file" name="tablas[]" id="tablas" multiple="multiple"/>
                        <div style="clear:both; height: 8px;"></div>
                        <button class="btn btn-default" id="dotablas" type="button">
                                            <i class="icon icon-upload"></i>Cargar
                                        </button>


                    </form>



                </div>
            </div>
        </div>
    </div>
</section>
