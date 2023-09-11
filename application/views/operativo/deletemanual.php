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
                <i class="icon-file-empty position-left"></i> Eliminacion Manual - <?php echo $session['proyecto_activo']; ?>
            </div>
        </div>
    </div>
    <!-- /Page header -->

    <div class="container-fluid page-content">
        <div style="clear: both; height: 25px;"></div>
        <div class="row">
            <div class="col col-md-6">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h5>Borrar Promesas</h5>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label>Numero de Obligacion:</label>
                            <input type="text" name="ohprom" id="ohprom" class="form-control" />
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success btn-labeled"  id="bucsa-promesas-btn" type="button"><b><i class="icon-floppy-disk"></i></b>Buscar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-md-6">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h5>Borrar Confirmaciones</h5>
                        </div>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label>Numero de Obligacion:</label>
                            <input type="text" name="ohconf" id="ohconf" class="form-control" />
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success btn-labeled"  id="busca-confirmaciones-btn" type="button"><b><i class="icon-floppy-disk"></i></b>Buscar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col col-md-6">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h5>Borrar Pagos</h5>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label>Numero de Obligacion:</label>
                            <input type="text" name="ohpago" id="ohpago" class="form-control" />
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success btn-labeled"  id="busca-pagos-btn" type="button"><b><i class="icon-floppy-disk"></i></b>Buscar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-md-6">
                
            </div>
        </div>

        <div style="clear: both; height: 25px;"></div>
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div id="resultado-busqueda-eliminacion">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>