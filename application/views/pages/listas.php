<?php
/* * To change this template, choose Tools | Templates * and open the template in the editor. */
$ci2 = &get_instance();
//$us = $ci3->load->model("usuarios");
//$ci2 = &get_instance();
$ci2->load->model("vista");

$carteras = explode(";", $session['carteras']);

$fila = 0;
$pr = 0;

if ($slug == 1) {
    $title = "Proyeccion";
} else if ($slug == 2) {
    $title = "Confirmacion";
}
?>



<section class="main-container">

    <!-- Page header -->
    <div class="header">
        <div class="header-content">
            <div class="page-title">
                <i class="icon-file-empty position-left"></i> <?php echo $title . " - " . $actualM; ?> &nbsp;&nbsp;&nbsp;&nbsp;<a style="text-decoration: underline; color: blue;" href="http://<?php echo $this->config->item('host_cobranzas'); ?>/index.php/exportuno/<?php echo $slug; ?>">Exportar</a>
                </br>
                <!--<button mes="anterior" slug="<?php //echo $slug;              ?>" class="btn btn-danger lista-mes">Mes Anterior</button>&nbsp;&nbsp;&nbsp;&nbsp;<button mes="actual" slug="<?php //echo $slug;              ?>" class="btn btn-warning lista-mes">Mes Actual</button>
                <?php // if ($slug == 1) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<button mes="siguiente" slug="<?php //echo $slug; ?>" class="btn btn-success lista-mes">Mes Siguiente</button><?php //} ?>
            </div>
        </div>
    </div>
                <!-- /Page header -->

                <div class="container-fluid page-content">
                    <div class="row">
                        <div class="panel panel-flat">
                            <div class="panel-body" id="listas-resumen">
                                <div class="col-md-6"> 
                                    <table class="table bg-teal table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Estado</th>
                                                <th>Cuentas</th>
                                                <th>Valor</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($tabla as $tb) {
                                                if (isset($estado)) {
                                                    if (isset($asesorf)) {
                                                        if ($estado == $tb['idCumplido']) {
                                                            $cumpl = $ci2->vista->getCumplido($tb['idCumplido'], $session['proyecto_activo']);
                                                            ?>
                                                            <tr class="bg-teal-600">
                                                                <td><?php echo $cumpl[0]['descripcion']; ?></td>
                                                                <td><?php echo $tb['cuantos']; ?></td>
                                                                <td><?php echo number_format($tb['total'], 2); ?></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    } else {
                                                        if ($estado == $tb['idCumplido']) {
                                                            $cumpl = $ci2->vista->getCumplido($tb['idCumplido'], $session['proyecto_activo']);
                                                            ?>
                                                            <tr class="bg-teal-600">
                                                                <td><?php echo $cumpl[0]['descripcion']; ?></td>
                                                                <td><?php echo $tb['cuantos']; ?></td>
                                                                <td><?php echo number_format($tb['total'], 2); ?></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                } else if (isset($asesorf)) {
                                                    $cumpl = $ci2->vista->getCumplido($tb['idCumplido'], $session['proyecto_activo']);
                                                    ?>
                                                    <tr class="bg-teal-600">
                                                        <td><?php echo $cumpl[0]['descripcion']; ?></td>
                                                        <td><?php echo $tb['cuantos']; ?></td>
                                                        <td><?php echo number_format($tb['total'], 2); ?></td>
                                                    </tr>
                                                    <?php
                                                } else {
                                                    $cumpl = $ci2->vista->getCumplido($tb['idCumplido'], $session['proyecto_activo']);
                                                    ?>
                                                    <tr class="bg-teal-600">
                                                        <td><?php echo $cumpl[0]['descripcion']; ?></td>
                                                        <td><?php echo $tb['cuantos']; ?></td>
                                                        <td><?php echo number_format($tb['total'], 2); ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <form name="filtro-listas-form" id="filtro-listas-form" method="post" action="http://<?php echo $this->config->item('host_cobranzas'); ?>/index.php/listas/<?php echo $slug; ?>">
                                    <div class="col-md-3"> 
                                        <div class="form-group">
                                            <label>Fecha:</label>
                                            <input style="background-color: #e74c3c; color: #FFF;" type="text"name="fechaIni" id="fechaIni" class="form-control datepicker-here" data-language='en'/>
                                            <?php if ($session['perfil'] < 6) { ?>
                                                <label>Asesor:</label>
                                                <select style="background-color:  #9b59b6; color: #FFF;" class="form-control" name="asesor" id="asesor">
                                                    <option value="0">Seleccione...</option>
                                                    <?php
                                                    foreach ($asesores as $a) {
                                                        $uss = $ci2->vista->getusuario($a['idUsuario'], $session['proyecto_activo']);
                                                        ?>
                                                        <option value="<?php echo $uss[0]['idUsuario'] ?>"><?php echo $uss[0]['nombre'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            <?php } ?>
                                            <div style="clear: both; height: 6px;"></div>
                                            <button type="submit" id="list-filter" class="btn btn-warning">Aplicar Filtros</button>
                                            <button type="button" onclick="location.href = 'http://<?php echo $this->config->item('host_cobranzas'); ?>/index.php/listas/<?php echo $slug; ?>'" id="list-filter" class="btn btn-info">Limpiar Filtros</button>
                                        </div>
                                    </div>
                                    <div class="col-md-3"> 
                                        <div class="form-group">
                                            <?php if ($slug == 1) { ?> 
                                                <label>Estado:</label>
                                                <select style="background-color: #2980b9; color: #FFF;" class="form-control" name="estado" id="estado">
                                                    <option value="0">Seleccione...</option>
                                                    <?php foreach ($cumplidos as $c) { ?>
                                                        <option value="<?php echo $c['idCumplido'] ?>"><?php echo $c['descripcion'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            <?php } ?>
                                            <label>Mes:</label>
                                            <select style="background-color:  #28b463; color: #FFF;" class="form-control" name="mes" id="mes">
                                                <option value="1">Mes Actual</option>
                                                <option value="2">Mes Anterior</option>
                                                <option value="3">Proximo Mes</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="panel panel-flat">
                            <div class="panel-body" id="listas-resultado">
                                <table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
                                    <thead>
                                        <tr>
                                            <th class="footable-visible footable-first-column" data-toggle="true">Documento</th>
                                            <th class="footable-visible footable-first-column" data-toggle="true">Nombre</th>
                                            <th class="footable-visible footable-first-column" data-toggle="true">Fecha</th>
                                            <th class="footable-visible footable-first-column" data-toggle="true">Valor</th>
                                            <th class="footable-visible footable-first-column" data-toggle="true">Asesor</th>
                                            <th class="footable-visible footable-first-column" data-toggle="true">Estado</th>
                                            <th class="footable-visible footable-first-column" data-toggle="true">Estado Cuenta</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    foreach ($listado as $list) {

                                        if (isset($estado)) {

                                            if (isset($asesorf)) {

                                                if ($estado == $list['idCumplido'] && $asesorf == $list['idAsesor']) {

                                                    if ($list['idAsesor'] != 0) {
                                                        $user = $ci2->vista->getusuario($list['idAsesor'], $session['proyecto_activo']);
                                                    } else {
                                                        $user[0]['usuario'] = "Sin Asesor";
                                                    }


                                                    $cli = $ci2->vista->getDataClienteDoc($list['documentodos'], $session['proyecto_activo']);
                                                    $cumpl = $ci2->vista->getCumplido($list['idCumplido'], $session['proyecto_activo']);

                                                    $estilo = "";
                                                    if ($list['idCumplido'] == 2) {
                                                        $estilo = "background-color: #F6CECE;";
                                                    } else if ($list['idCumplido'] == 4) {
                                                        $estilo = "background-color: #D8CEF6;";
                                                    } else if ($list['idCumplido'] == 5) {
                                                        $estilo = "background-color: #CEF6CE;";
                                                    } else if ($list['idCumplido'] == 6) {
                                                        $estilo = "background-color: #F5F6CE;";
                                                    }

                                                    $idC = "KK";
                                                    $nombres = "Cliente no encontrado";
                                                    if (isset($cli[0]['idCliente'])) {
                                                        $idC = $cli[0]['idCliente'];
                                                        $nombres = $cli[0]['nombre'];
                                                    }

                                                    $estaoh = $ci2->vista->getEstadoOh($list['obligaciondos'], $session['proyecto_activo']);

                                                    if($estaoh[0]['activo'] == 1){
                                                        $estadoObl = "Activa";
                                                    }else{
                                                        $estadoObl = "Inactiva";
                                                    }
                                                    ?>
                                                    <tbody>
                                                        <tr style="cursor: pointer; <?php echo $estilo; ?>" onclick="location.href = 'https://<?php echo $this->config->item("host_cobranzas"); ?>/index.php/cliente/<?php echo $idC; ?>'">
                                                            <td style="<?php echo $estilo; ?>" class="footable-visible footable-first-column"><?php echo $list['documentodos']; ?></td>
                                                            <td style="<?php echo $estilo; ?>" class="footable-visible footable-first-column"><?php echo $nombres; ?></td>
                                                            <td style="<?php echo $estilo; ?>" class="footable-visible footable-first-column"><?php echo $list['fechaPromesa']; ?></td>
                                                            <td style="<?php echo $estilo; ?>" class="footable-visible footable-first-column"><?php echo number_format($list['valorpromesa'], 2); ?></td>
                                                            <td style="<?php echo $estilo; ?>" class="footable-visible footable-first-column"><?php echo $user[0]['nombre']; ?></td>
                                                            <td style="<?php echo $estilo; ?>" class="footable-visible footable-first-column"><?php echo $cumpl[0]['descripcion']; ?></td>
                                                            <td style="<?php echo $estilo; ?>" class="footable-visible footable-first-column"><?php echo $estadoObl; ?></td>
                                                        </tr>
                                                    </tbody>
                                                    <?php
                                                }
                                            } else if ($estado == $list['idCumplido']) {

                                                if ($list['idAsesor'] != 0) {
                                                    $user = $ci2->vista->getusuario($list['idAsesor'], $session['proyecto_activo']);
                                                } else {
                                                    $user[0]['usuario'] = "Sin Asesor";
                                                }


                                                $cli = $ci2->vista->getDataClienteDoc($list['documentodos'], $session['proyecto_activo']);
                                                $cumpl = $ci2->vista->getCumplido($list['idCumplido'], $session['proyecto_activo']);

                                                $estilo = "";
                                                if ($list['idCumplido'] == 2) {
                                                    $estilo = "background-color: #F6CECE;";
                                                } else if ($list['idCumplido'] == 4) {
                                                    $estilo = "background-color: #D8CEF6;";
                                                } else if ($list['idCumplido'] == 5) {
                                                    $estilo = "background-color: #CEF6CE;";
                                                } else if ($list['idCumplido'] == 6) {
                                                    $estilo = "background-color: #F5F6CE;";
                                                }

                                                $idC = "KK";
                                                $nombres = "Cliente no encontrado";
                                                if (isset($cli[0]['idCliente'])) {
                                                    $idC = $cli[0]['idCliente'];
                                                    $nombres = $cli[0]['nombre'];
                                                }

                                                $estaoh = $ci2->vista->getEstadoOh($list['obligaciondos'], $session['proyecto_activo']);

                                                if($estaoh[0]['activo'] == 1){
                                                    $estadoObl = "Activa";
                                                }else{
                                                    $estadoObl = "Inactiva";
                                                }
                                                ?>
                                                <tbody>
                                                    <tr style="cursor: pointer; <?php echo $estilo; ?>" onclick="location.href = 'https://<?php echo $this->config->item("host_cobranzas"); ?>/index.php/cliente/<?php echo $idC; ?>'">
                                                        <td style="<?php echo $estilo; ?>" class="footable-visible footable-first-column"><?php echo $list['documentodos']; ?></td>
                                                        <td style="<?php echo $estilo; ?>" class="footable-visible footable-first-column"><?php echo $nombres; ?></td>
                                                        <td style="<?php echo $estilo; ?>" class="footable-visible footable-first-column"><?php echo $list['fechaPromesa']; ?></td>
                                                        <td style="<?php echo $estilo; ?>" class="footable-visible footable-first-column"><?php echo number_format($list['valorpromesa'], 2); ?></td>
                                                        <td style="<?php echo $estilo; ?>" class="footable-visible footable-first-column"><?php echo $user[0]['nombre']; ?></td>
                                                        <td style="<?php echo $estilo; ?>" class="footable-visible footable-first-column"><?php echo $cumpl[0]['descripcion']; ?></td>
                                                        <td style="<?php echo $estilo; ?>" class="footable-visible footable-first-column"><?php echo $estadoObl; ?></td>
                                                    </tr>
                                                </tbody>
                                                <?php
                                            }
                                        } else if (isset($asesorf)) {

                                            if ($asesorf == $list['idAsesor']) {

                                                if ($list['idAsesor'] != 0) {
                                                    $user = $ci2->vista->getusuario($list['idAsesor'], $session['proyecto_activo']);
                                                } else {
                                                    $user[0]['usuario'] = "Sin Asesor";
                                                }


                                                $cli = $ci2->vista->getDataClienteDoc($list['documentodos'], $session['proyecto_activo']);
                                                $cumpl = $ci2->vista->getCumplido($list['idCumplido'], $session['proyecto_activo']);

                                                $estilo = "";
                                                if ($list['idCumplido'] == 2) {
                                                    $estilo = "background-color: #F6CECE;";
                                                } else if ($list['idCumplido'] == 4) {
                                                    $estilo = "background-color: #D8CEF6;";
                                                } else if ($list['idCumplido'] == 5) {
                                                    $estilo = "background-color: #CEF6CE;";
                                                } else if ($list['idCumplido'] == 6) {
                                                    $estilo = "background-color: #F5F6CE;";
                                                }

                                                $idC = "KK";
                                                $nombres = "Cliente no encontrado";
                                                if (isset($cli[0]['idCliente'])) {
                                                    $idC = $cli[0]['idCliente'];
                                                    $nombres = $cli[0]['nombre'];
                                                }

                                                $estaoh = $ci2->vista->getEstadoOh($list['obligaciondos'], $session['proyecto_activo']);

                                                if($estaoh[0]['activo'] == 1){
                                                    $estadoObl = "Activa";
                                                }else{
                                                    $estadoObl = "Inactiva";
                                                }
                                                ?>
                                                <tbody>
                                                    <tr style="cursor: pointer; <?php echo $estilo; ?>" onclick="location.href = 'https://<?php echo $this->config->item("host_cobranzas"); ?>/index.php/cliente/<?php echo $idC; ?>'">
                                                        <td style="<?php echo $estilo; ?>" class="footable-visible footable-first-column"><?php echo $list['documentodos']; ?></td>
                                                        <td style="<?php echo $estilo; ?>" class="footable-visible footable-first-column"><?php echo $nombres; ?></td>
                                                        <td style="<?php echo $estilo; ?>" class="footable-visible footable-first-column"><?php echo $list['fechaPromesa']; ?></td>
                                                        <td style="<?php echo $estilo; ?>" class="footable-visible footable-first-column"><?php echo number_format($list['valorpromesa'], 2); ?></td>
                                                        <td style="<?php echo $estilo; ?>" class="footable-visible footable-first-column"><?php echo $user[0]['nombre']; ?></td>
                                                        <td style="<?php echo $estilo; ?>" class="footable-visible footable-first-column"><?php echo $cumpl[0]['descripcion']; ?></td>
                                                        <td style="<?php echo $estilo; ?>" class="footable-visible footable-first-column"><?php echo $estadoObl; ?></td>
                                                    </tr>
                                                </tbody>
                                                <?php
                                            }
                                        } else {

                                            if ($list['idAsesor'] != 0) {
                                                $user = $ci2->vista->getusuario($list['idAsesor'], $session['proyecto_activo']);
                                            } else {
                                                $user[0]['usuario'] = "Sin Asesor";
                                            }


                                            $cli = $ci2->vista->getDataClienteDoc($list['documentodos'], $session['proyecto_activo']);
                                            $cumpl = $ci2->vista->getCumplido($list['idCumplido'], $session['proyecto_activo']);

                                            $estilo = "";
                                            if ($list['idCumplido'] == 2) {
                                                $estilo = "background-color: #F6CECE;";
                                            } else if ($list['idCumplido'] == 4) {
                                                $estilo = "background-color: #D8CEF6;";
                                            } else if ($list['idCumplido'] == 5) {
                                                $estilo = "background-color: #CEF6CE;";
                                            } else if ($list['idCumplido'] == 6) {
                                                $estilo = "background-color: #F5F6CE;";
                                            }

                                            $idC = "KK";
                                            $nombres = "Cliente no encontrado";
                                            if (isset($cli[0]['idCliente'])) {
                                                $idC = $cli[0]['idCliente'];
                                                $nombres = $cli[0]['nombre'];
                                            }
                                            $estaoh = $ci2->vista->getEstadoOh($list['obligaciondos'], $session['proyecto_activo']);

                                            if($estaoh[0]['activo'] == 1){
                                                $estadoObl = "Activa";
                                            }else{
                                                $estadoObl = "Inactiva";
                                            }
                                            ?>
                                            <tbody>
                                                <tr style="cursor: pointer; <?php echo $estilo; ?>" onclick="location.href = 'https://<?php echo $this->config->item("host_cobranzas"); ?>/index.php/cliente/<?php echo $idC; ?>'">
                                                    <td style="<?php echo $estilo; ?>" class="footable-visible footable-first-column"><?php echo $list['documentodos']; ?></td>
                                                    <td style="<?php echo $estilo; ?>" class="footable-visible footable-first-column"><?php echo $nombres; ?></td>
                                                    <td style="<?php echo $estilo; ?>" class="footable-visible footable-first-column"><?php echo $list['fechaPromesa']; ?></td>
                                                    <td style="<?php echo $estilo; ?>" class="footable-visible footable-first-column"><?php echo number_format($list['valorpromesa'], 2); ?></td>
                                                    <td style="<?php echo $estilo; ?>" class="footable-visible footable-first-column"><?php echo $user[0]['nombre']; ?></td>
                                                    <td style="<?php echo $estilo; ?>" class="footable-visible footable-first-column"><?php echo $cumpl[0]['descripcion']; ?></td>
                                                    <td style="<?php echo $estilo; ?>" class="footable-visible footable-first-column"><?php echo $estadoObl; ?></td>
                                                </tr>
                                            </tbody>
                                            <?php
                                        }
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                </section>
