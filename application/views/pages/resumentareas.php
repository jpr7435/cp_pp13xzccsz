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
              <div class="panel-heading">
                  <h5 class="panel-title">Tareas Personales</h5>
              </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="box box-success">
                            <div class="box-body">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Tarea</th>
                                            <th>Total</th>
                                            <th>Faltan</th>
                                            <th>Progreso</th>
                                            <th>% Completado</th>
                                            <th>Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($tareasU as $work) {

                                            $faltan = $ci2->vista->getTareasActivasFaltan($work['tarea'], $session['proyecto_activo']);
                                            if (!$faltan) {
                                                $faltan[0]['faltan'] = 0;
                                            }
                                            $porc = $faltan[0]['faltan'] / $work['total'];
                                            $formatPorc = $porc * 100;
                                            $fal = 100 - $formatPorc;
                                            ?>
                                            <tr>
                                                <td><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/settarea/<?php echo $work['tarea']; ?>"><?php echo $work['tarea']; ?></a></td>
                                                <td style="text-align: center;"><?php echo $work['total']; ?></td>
                                                <td style="text-align: center;"><?php echo $faltan[0]['faltan']; ?></td>
                                                <td style="text-align: center;"><div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-warning" style="width: <?php echo $fal; ?>%"></div>
                                                    </div></td>
                                                <td style="text-align: center;"><span class="badge bg-red"><?php echo number_format($fal, 1); ?> %</span></td>

                                                <td style="text-align: center;">
                                                    <?php if ($session['perfil'] < 5) { ?>
                                                    <a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/deletetarea/<?php echo $work['tarea']; ?>"><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/delete.png" alt="Borrar" title="Borrar Tarea"/></a>&nbsp;&nbsp;<img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/list.png" flag="<?php echo $work['tarea']; ?>" class="detalleTarea" style="cursor: pointer;" alt="Detalle" title="Detalle Tarea"/>
                                                    <?php } ?>
                                                </td>
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
        <div class="row">
            <div class="panel panel-flat">
              <div class="panel-heading">
                  <h5 class="panel-title">Tareas Generales</h5>
              </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="box box-success">
                            <div class="box-body">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Tarea</th>
                                            <th>Total</th>
                                            <th>Faltan</th>
                                            <th>Progreso</th>
                                            <th>% Completado</th>
                                            <th>Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($tareas as $work) {

                                            $faltan = $ci2->vista->getTareasActivasFaltan($work['tarea'], $session['proyecto_activo']);
                                            if (!$faltan) {
                                                $faltan[0]['faltan'] = 0;
                                            }
                                            $porc = $faltan[0]['faltan'] / $work['total'];
                                            $formatPorc = $porc * 100;
                                            $fal = 100 - $formatPorc;
                                            ?>
                                            <tr>
                                                <td><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/settarea/<?php echo $work['tarea']; ?>"><?php echo $work['tarea']; ?></a></td>
                                                <td style="text-align: center;"><?php echo $work['total']; ?></td>
                                                <td style="text-align: center;"><?php echo $faltan[0]['faltan']; ?></td>
                                                <td style="text-align: center;"><div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-warning" style="width: <?php echo $fal; ?>%"></div>
                                                    </div></td>
                                                <td style="text-align: center;"><span class="badge bg-red"><?php echo number_format($fal, 1); ?> %</span></td>

                                                <td style="text-align: center;">
                                                    <?php if ($session['perfil'] < 5) { ?>
                                                    <a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/deletetarea/<?php echo $work['tarea']; ?>"><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/delete.png" alt="Borrar" title="Borrar Tarea"/></a>&nbsp;&nbsp;<img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/list.png" flag="<?php echo $work['tarea']; ?>" class="detalleTarea" style="cursor: pointer;" alt="Detalle" title="Detalle Tarea"/>
                                                    <?php } ?>
                                                </td>
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
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title">Detalle Tarea</h5>
                </div>
                <div class="panel-body" id="panel-detalle">
                    <div class="col-md-12">
                        <div class="box box-success">
                            <div class="box-body">

                            </div>
                        </div>
                    </div>
                </div>
                <div style="clear: both; height: 25px;"></div>
            </div>
        </div>
    </div>
</section>
