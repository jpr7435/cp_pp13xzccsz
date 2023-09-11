<?php
/* * To change this template, choose Tools | Templates * and open the template in the editor. */
$ci2 = &get_instance();
$ci2->load->model("vista");

$carteras = explode(";", $session['carteras']);
?>

<section class="main-container">
    <div class="header">
        <div class="header-content">
            <div class="page-title">
                <i class="icon-file-empty position-left"></i> Bloqueo de clientes - <?php echo $session['proyecto_activo']; ?>
            </div>
        </div>
    </div>
    <!-- /Page header -->

    <div class="container-fluid page-content">
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Documento:</label>
                            <input type="text" name="doc-bloqueo" id="doc-bloqueo" class="form-control"/>
                            <label>Accion:</label>
                            <select class="form-control" name="action-bloqueo" id="action-bloqueo">
                                <option value="0">Seleccione...</option>
                                <option value="1">Bloquear Cliente</option>
                                <option value="2">Desbloquear Cliente</option>
                            </select>
                            <button class="btn btn-success" name="block-Cliente" id="block-cliente">Aplicar</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body" id="resultado-bloqueo">
                    
                </div>
            </div>
        </div>

    </div>
</section>