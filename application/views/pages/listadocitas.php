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
                <h3>Listado de citas</h3>
            </div>
        </div>
    </div>
    <!-- /Page header -->

    <div class="container-fluid page-content">

        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="col-lg-4">
                        <label>Nombres:</label>
                        <input type="text" class="form-control" name="nombre-buscar" id="nombre-buscar"/>
                    </div>
                    <div class="col-lg-4">
                        <label>Apellidos:</label>
                        <input type="text" class="form-control" name="apellidos-buscar" id="apellidos-buscar"/>
                    </div>
                    <div class="col-lg-4">
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="col-lg-4">
                        <label>Logro:</label>
                        <select class="form-control" name="estatus-buscar" id="estatus-buscar">
                            <option value="0">Seleccione..</option>
                            <?php foreach ($logros as $est) { ?>
                                <option value="<?php echo $est['idCodres']; ?>"><?php echo $est['descripcion']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label>Fecha creacion</label>
                        <input type="text" name="fechaFin" style="color: #000;" id="fechaFin" readonly="readonly" class="form-control datepicker-here" data-language='en' />
                    </div>
                    <?php if ($session['perfil'] < 6) { ?>
                        <div class="col-lg-4">
                            <label>Aesor:</label>
                            <select class="form-control" name="asignado-buscar" id="asignado-buscar">
                                <option value="0">Seleccione..</option>
                                <?php foreach ($usuarios as $usu) { ?>
                                    <option value="<?php echo $usu['idUsuario']; ?>"><?php echo $usu['nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php } else { ?>
                        <div class="col-lg-4">
                            <input type="hidden" name="asignado-buscar" id="asignado-buscar" value="<?php echo $session['id']; ?>"/>
                        </div>   
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="col-lg-4">
                        <button type="button" class="btn btn-success" name="buscarCitas-btn" id="buscarCitas-btn">Buscar</button>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body" id="respuesta-citas">
                    <table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
                        <thead>
                            <tr>
                                <th class="footable-visible footable-first-column" data-toggle="true">Documento</th>
                                <th class="footable-visible footable-first-column" data-toggle="true">Nombre</th>
                                <th class="footable-visible footable-first-column" data-toggle="true">Fecha</th>
                                <th class="footable-visible footable-first-column" data-toggle="true">Logro</th>
                                <th class="footable-visible footable-first-column" data-toggle="true">Asesor</th>
                            </tr>
                        </thead>
                        <?php
                        foreach ($listado as $list) {

                            $cli = $ci2->vista->getDataClienteDoc($list['documento'], $session['proyecto_activo']);
                            $logro = $ci2->vista->getResultado($cli[0]['mejorGestion'], $session['proyecto_activo']);
                            $asesor = $ci2->vista->getusuario($list['idAsesor'], $session['proyecto_activo']);
                            ?>
                            <tbody>
                                <tr style="cursor: pointer;" onclick="location.href = 'https://<?php echo $this->config->item("host_cobranzas"); ?>/index.php/cliente/<?php echo $cli[0]['idCliente']; ?>'">
                                    <td class="footable-visible footable-first-column"><?php echo $list['documento']; ?></td>
                                    <td class="footable-visible footable-first-column"><?php echo $cli[0]['nombre']; ?></td>
                                    <td class="footable-visible footable-first-column"><?php echo $list['fecha']; ?></td>
                                    <td class="footable-visible footable-first-column"><?php echo $logro[0]['descripcion']; ?></td>
                                    <td class="footable-visible footable-first-column"><?php echo $asesor[0]['nombre']; ?></td>
                                </tr>
                            </tbody>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
