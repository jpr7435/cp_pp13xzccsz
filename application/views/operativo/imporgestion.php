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
    <h1 style="display:none">Importe de Gestion - <?php echo $session['proyecto_activo']; ?></h1>

    <!-- Page header -->
    <div class="header">
        <div class="header-content">
            <div class="page-title">
                <i class="icon-file-empty position-left"></i> Cargue de gestion adicional
            </div>
        </div>
    </div>
    <!-- /Page header -->

    <div class="container-fluid page-content">
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="col-lg-7">
                        <form name="upload-file" id="upload-file" method="post" enctype="multipart/form-data" action="http://<?php echo $this->config->item("host_cobranzas"); ?>/index.php/uploadgestion/<?php echo $session['proyecto_activo']; ?>">
                            <div class="form-group">
                              <p>Para el cargue de gestion adicional se debe subir un archivo, CSV delimitado por punto y coma (;). El archivo debera llevar la siguiente estructura:</br>
                                - <strong>documento:</strong> El numero de documento del clientes al cual se le va a cargar la gestion.</br>
                                - <strong>telefono:</strong> El numero de telefono donde serealizo la gestion, si no aplica este campo se debe poner cero (0).</br>
                                - <strong>idAccion:</strong> El codigo de accion que corresponden las gestiones.</br>
                                - <strong>idStatus:</strong> El codigo de status de las gestiones a cargar.</br>
                                - <strong>idLogro:</strong>  El codigo del logro de las gestiones a cargar.</br>
                                - <strong>Fecha Gestion:</strong> La fecha en la que se realizo la gestion a cargar, en el formato dd/mm/yyyy.</br>
                                - <strong>Texto Gestion:</strong> El texto de la gestion que se va a cargar.
                              </p>
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
