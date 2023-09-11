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
    <h1 style="display:none">Resumen de tareas - <?php echo $session['proyecto_activo']; ?></h1>

    <!-- Page header -->
    <div class="header">
        <div class="header-content">
            <div class="page-title">
                <i class="icon-file-empty position-left"></i> Resumen tareas - <?php echo $session['proyecto_activo']; ?>
            </div>
        </div>
    </div>
    <!-- /Page header -->

    <div class="container-fluid page-content">
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="col-md-6">
                        <div class="box box-success">
                            <div class="box-body">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Asesor</th>
                                            <th>Cuentas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($asignacion as $asig) {

                                            $user = $ci2->vista->getusuario($asig['idAsesor'], $session['proyecto_activo']);
                                            ?>
                                            <tr>
                                                <td><?php echo $user[0]['usuario']; ?></td>
                                                <td style="text-align: center;"><?php echo $asig['cuantos']; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <div class="form-group">
                                    <button id="panelBtn" type="button" style="margin-top: 15px;" proyect="<?php echo $session['proyecto_activo']; ?>" class="btn btn-danger" type="submit">Volver</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="clear: both; height: 25px;"></div>
            </div>
        </div>
    </div>
</section>