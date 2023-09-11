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
                <i class="icon-file-empty position-left"></i> Campa&ntilde;as SMS
            </div>
        </div>
    </div>
    <!-- /Page header -->

    <div class="container-fluid page-content">
        <div style="clear: both; height: 25px;"></div>
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/sms/createcampana"><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/add.png" alt="Agregar" title="Agregar"/>&nbsp;&nbsp;&nbsp;Agregar Campa&ntilde;a</a>
                    <table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
                        <thead>
                            <tr>
                                <th class="footable-visible footable-first-column" data-toggle="true">id Campa&ntilde;a</th>
                                <th class="footable-visible footable-first-column" data-toggle="true">Nombre</th>
                                <th class="footable-visible footable-first-column" data-toggle="true">Descripcion</th>
                                <th class="footable-visible footable-first-column" data-toggle="true">Mensaje</th>
                                <th class="footable-visible footable-first-column" data-toggle="true">Creado Por</th>
                                <th class="footable-visible footable-first-column" data-toggle="true">Fecha Creacion</th>
                            </tr>
                        </thead>
                        <?php
                        foreach ($campanas as $cam) {
                            
                            ?>
                            <tbody>
                                <tr style="cursor: pointer;" onclick="location.href='https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/smsdetallecampana/<?php echo $cam['idCampana']; ?>'">
                                    <td class="footable-visible footable-first-column"><?php echo $cam['idCampana']; ?></td>
                                    <td class="footable-visible footable-first-column"><?php echo $cam['campana']; ?></td>
                                    <td class="footable-visible footable-first-column"><?php echo substr($cam['concepto'],0, 100)." ..."; ?></td>
                                    <td class="footable-visible footable-first-column"><?php echo substr($cam['mensaje'],0, 100)." ..."; ?></td>
                                    <td class="footable-visible footable-first-column"><?php echo $cam['idUsuario']; ?></td>
                                    <td class="footable-visible footable-first-column"><?php echo $cam['fechaCreacion']; ?></td>
                                </tr>
                            </tbody>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>