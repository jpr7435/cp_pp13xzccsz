<?php
/* * To change this template, choose Tools | Templates * and open the template in the editor. */
$ci2 = &get_instance();
//$us = $ci3->load->model("usuarios");
//$ci2 = &get_instance();
$ci2->load->model("vista");

$carteras = explode(";", $session['carteras']);
$mejor1 = $this->vista->getResultado($cliente[0]['mejorGestion'], $session['proyecto_activo']);
$userG = $this->vista->getusuario($cliente[0]['idAsesor'], $session['proyecto_activo']);
$ultima = $this->vista->getResultado($cliente[0]['ultimaGestion'], $session['proyecto_activo']);
$fila = 0;
$pr = 0;
?>

<section class="main-container">
    <h1 style="display:none"><?php echo $cliente[0]['nombre'] . " " . $cliente[0]['documento']; ?></h1>
    <input type="hidden" id="documentoActivo" name="documentoActivo" value="<?php echo $cliente[0]['documento']; ?>"/>
    <!-- Page header -->
    <div class="header bg-amarillo">
        <div class="header-content">
            <div class="page-title">
                <i class="icon icon-user position-left"></i> <?php echo $cliente[0]['nombre'] . " - " . $cliente[0]['documento'] . " - $" . number_format($cliente[0]['saldoPareto'], 0) . " - <span style='color: #2E2EFE;'>" . $mejor1[0]['descripcion'] . "</span>"; ?>
                <?php
                if ($session['tarea'] != "") {
                    echo '<button class="btn btn-success btn-labeled" id="next-tarea-btn" type="button"><b><i></i></b>Siguiente ' . $session['tarea'] . '</button>';
                }
                ?>
            </div>
        </div>
    </div>
    <!-- /Page header -->

    <div class="container-fluid page-content">
        <div class="row">
            <div style="clear: both; height: 80px;"></div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-flat borde-azul" style="height: 300px; overflow: auto;">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Datos de Cliente
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Nombre:</th>
                                <th>Documento:</th>
                            </tr>
                            <tr>
                                <td><?php echo $cliente[0]['nombre']; ?></td>
                                <td><?php echo $cliente[0]['documento']; ?></td>
                            </tr>
                            <tr>
                                <th>Asesor:</th>
                                <th>Fecha Ultima Gestion:</th>
                            </tr>
                            <tr>
                                <td><?php echo $userG[0]['usuario']; ?></td>
                                <td><?php echo $cliente[0]['FecUltimaGestion']; ?></td>
                            </tr>
                            <tr>
                                <th>Mejor Gestion:</th>
                                <th>Ultima Gestion:</th>
                            </tr>
                            <tr>
                                <td><?php echo $mejor1[0]['descripcion']; ?></td>
                                <td><?php echo $ultima[0]['descripcion']; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-flat borde-amarillo" style="height: 300px; overflow: auto;">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Eventos Recientes
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Evento</th>
                                    <th>Fecha</th>
                                    <th>Usuario</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($eventos as $ev) {
                                    $userEv = $this->vista->getusuario($ev['idUser'], $session['proyecto_activo']);
                                    ?>
                                    <tr>
                                        <td><?php echo $ev['evento']; ?></td>
                                        <td><?php echo $ev['fecha']; ?></td>
                                        <td><?php echo $userEv[0]['usuario']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div style="clear: both; height: 25px;"></div>

        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <div class="panel-title">
                        Biblioteca de Archivos
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label col-lg-4">Cargar Archivo</label>
                        <div class="col-lg-8">
                            <input type="file" name="archivo" id="archivo" class="file-styled-primary-icon">
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success btn-labeled" id="upload-file-action" type="button"><b><i class="icon-floppy-disk"></i></b>Cargar</button>
                    </div>
                    <div id="carrousel" class="file-carrousel">
                        
                    </div>
                </div>
            </div>
        </div>
        <div style="clear: both; height: 15px;"></div>
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body" style="overflow-x: auto;">
                    <table class="table-bordered" style="width: 150% !important;">
                        <thead>
                            <tr>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Obligacion</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Tipo Produco</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Subproducto</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Dias Vencidos</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Franja Obligacion</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">valor Mora</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Capital Activo</th> 
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Saldo Total</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fecha Castigo</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor Minimo Negociacion</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor Desembolso</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Producto</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fecha Mora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $totalmora = 0;
                            $totalcapital = 0;
                            $totalsaldo = 0;
                            $totaldesem = 0;
                            $totalvlmin = 0;
                            $maxdias = 0;
                            foreach ($creditos as $cr) {
                                $totalmora += $cr['valormora'];
                                $totalcapital += $cr['capitalactivo'];
                                $totalsaldo += $cr['saldototal'];
                                $totaldesem += $cr['valordesembolso'];


                                if ($maxdias < $cr['diasvencidos']) {
                                    $maxdias = $cr['diasvencidos'];
                                }


                                /*  Descuento */
                                $capiacti = $cr['capitalactivo']; //$cliente[0]['saldoPareto'];
                                $anocas = $cr['anocastigo'];
                                $precincomillvl = 0;
                                $cincomillvl = 0;

                                if ($cliente[0]['saldoPareto'] < 5000000 && $cliente[0]['saldoPareto'] > 0) {
                                    if ($anocas <= 2015 && $anocas != "") {
                                        $precincomillvl = ($cliente[0]['saldoPareto'] * 35) / 100;
                                        $cincomillvl = $capiacti - $precincomillvl;
                                    } elseif ($anocas > 2015 && $anocas <= 2017) {
                                        $precincomillvl = ($cliente[0]['saldoPareto'] * 30) / 100;
                                        $cincomillvl = $capiacti - $precincomillvl;
                                    } elseif ($anocas == 2018) {
                                        $precincomillvl = ($capiacti * 25) / 100;
                                        $cincomillvl = $capiacti - $precincomillvl;
                                    } else {
                                        $cincomillvl = $cr['saldototal'];
                                    }
                                } elseif ($cliente[0]['saldoPareto'] > 4999999 && $cliente[0]['saldoPareto'] < 25000000) {
                                    if ($anocas <= 2015 && $anocas != "") {
                                        $precincomillvl = ($capiacti * 40) / 100;
                                        $cincomillvl = $capiacti - $precincomillvl;
                                    } elseif ($anocas > 2015 && $anocas <= 2017) {
                                        $precincomillvl = ($capiacti * 35) / 100;
                                        $cincomillvl = $capiacti - $precincomillvl;
                                    } elseif ($anocas == 2018) {
                                        $precincomillvl = ($capiacti * 30) / 100;
                                        $cincomillvl = $capiacti - $precincomillvl;
                                    } else {
                                        $cincomillvl = $cr['saldototal'];
                                    }
                                } elseif ($cliente[0]['saldoPareto'] > 24999999 && $cliente[0]['saldoPareto'] < 100000000) {
                                    if ($anocas <= 2015 && $anocas != "") {
                                        $precincomillvl = ($capiacti * 45) / 100;
                                        $cincomillvl = $capiacti - $precincomillvl;
                                    } elseif ($anocas > 2015 && $anocas <= 2017) {
                                        $precincomillvl = ($capiacti * 40) / 100;
                                        $cincomillvl = $capiacti - $precincomillvl;
                                    } elseif ($anocas == 2018) {
                                        $precincomillvl = ($capiacti * 35) / 100;
                                        $cincomillvl = $capiacti - $precincomillvl;
                                    } else {
                                        $cincomillvl = $cr['saldototal'];
                                    }
                                } elseif ($cliente[0]['saldoPareto'] > 99999999) {
                                    if ($anocas <= 2015 && $anocas != "") {
                                        $precincomillvl = ($capiacti * 55) / 100;
                                        $cincomillvl = $capiacti - $precincomillvl;
                                    } elseif ($anocas > 2015 && $anocas <= 2017) {
                                        $precincomillvl = ($capiacti * 45) / 100;
                                        $cincomillvl = $capiacti - $precincomillvl;
                                    } elseif ($anocas == 2018) {
                                        $precincomillvl = ($capiacti * 35) / 100;
                                        $cincomillvl = $capiacti - $precincomillvl;
                                    } else {
                                        $cincomillvl = $cr['saldototal'];
                                    }
                                }

                                $totalvlmin += $cincomillvl;
                                /* FIN Descuento */
                                ?>
                                <tr>
                                    <td style="text-align: center;"><?php echo $cr['obligacion']; ?></td>
                                    <td style="text-align: center;"><?php echo $cr['tipoproducto']; ?></td>
                                    <td style="text-align: center;"><?php echo $cr['lineasubproducto']; ?></td>
                                    <td style="text-align: center;"><?php echo $cr['diasvencidos']; ?></td>
                                    <td style="text-align: center;"><?php echo $cr['franjaobligacion']; ?></td>
                                    <td style="text-align: center;"><?php echo number_format($cr['valormora'], 0); ?></td>
                                    <td style="text-align: center;"><?php echo number_format($cr['capitalactivo'], 0); ?></td>
                                    <td style="text-align: center;"><?php echo number_format($cr['saldototal'], 0); ?></td>
                                    <td style="text-align: center;"><?php echo $cr['fechacastigo']; ?></td>
                                    <td style="text-align: center; background-color: #F5F6CE;"><?php echo number_format($cincomillvl, 0); ?></td>
                                    <td style="text-align: center;"><?php echo number_format($cr['valordesembolso'], 0); ?></td>
                                    <td style="text-align: center;"><?php echo $cr['producto']; ?></td>

                                    <td><?php echo $cr['fechamora']; ?></td>
                                </tr>
                            <?php } ?>
                            <tr style="background-color: #a4a4a4;">
                                <td style="text-align: center; font-weight: bold;"></td>
                                <td style="text-align: center; font-weight: bold;"></td>
                                <td style="text-align: center; font-weight: bold;"></td>
                                <td style="text-align: center; font-weight: bold;"><?php echo $maxdias; ?></td>
                                <td style="text-align: center; font-weight: bold;"></td>
                                <td style="text-align: center; font-weight: bold;"><?php echo number_format($totalmora, 0); ?></td>
                                <td style="text-align: center; font-weight: bold;"><?php echo number_format($totalcapital, 0); ?></td>
                                <td style="text-align: center; font-weight: bold;"><?php echo number_format($totalsaldo, 0); ?></td>
                                <td style="text-align: center; font-weight: bold;"></td>
                                <td style="text-align: center; font-weight: bold;"><?php echo number_format($totalvlmin, 0); ?></td>
                                <td style="text-align: center; font-weight: bold;"><?php echo number_format($totaldesem, 0); ?></td>
                                <td style="text-align: center; font-weight: bold;"></td>
                                <td style="text-align: center; font-weight: bold;"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <div class="panel-title">
                        Gestion Adelantada
                    </div>
                </div>
                <div class="panel-body">
                    <div class="panel-group accordion" id="accordion-styled">
                        <button type="button" class="btn btn-info btn-xs disabled">Toda</button>&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-success btn-xs">Efectiva</button></br></br>
                        <?php
                        $flag = 0;
                        foreach ($gestion as $ges) {


                            $class = "";
                            $class2 = "in";
                            $color = "";
                            if ($flag > 0) {
                                $class = 'class="collapsed"';
                                $class2 = "";
                            }
                            $result = $this->vista->getResultado($ges['idResultado'], $session['proyecto_activo']);
                            $user = $this->vista->getusuario($ges['idAsesor'], $session['proyecto_activo']);
                            $cont = $this->vista->getContacto($ges['idContacto'], $session['proyecto_activo']);

                            if ($cont[0]['idGrupo'] == 1) {
                                $color = 'style="background-color:  #d9ffdc;"';
                            }if ($cont[0]['idGrupo'] == 2) {
                                $color = 'style="background-color:  #fedbdb;"';
                            }

                            $fecacu = "";

                            if ($ges['fechaAcuerdo'] != "0000-00-00" && $ges['fechaAcuerdo'] != "") {
                                $fecacu = $ges['fechaAcuerdo'];
                            }
                            ?>

                            <div class="panel">
                                <div class="panel-heading" <?php echo $color; ?>>
                                    <div class="panel-title">
                                        <a <?php echo $class; ?> data-toggle="collapse" data-parent="#accordion-styled" href="#<?php echo $ges['idCallhist']; ?>"><?php echo $ges['fechaGestion'] . " - " . $user[0]['usuario'] . " - Tel: " . $ges['telefono'] . " - " . $result[0]['descripcion'] . " - " . $fecacu ?></a>
                                    </div>
                                </div>
                                <div id="<?php echo $ges['idCallhist'] ?>" class="panel-collapse collapse <?php echo $class2; ?>">
                                    <div class="panel-body">
                                        <?php echo $ges['textoGestion']; ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $flag += 1;
                        }
                        ?>
                        <!--<div class="panel">
                            <div class="panel-heading bg-success">
                                <div class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-styled" href="#accordion-styled-group2">Accordion Item #2</a>
                                </div>
                            </div>
                            <div id="accordion-styled-group2" class="panel-collapse collapse">
                                <div class="panel-body">
                                    Тon cupidatat skateboard dolor brunch. Тesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda.
                                </div>
                            </div>
                        </div>

                        <div class="panel">
                            <div class="panel-heading bg-primary">
                                <div class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-styled" href="#accordion-styled-group3">Accordion Item #3</a>
                                </div>
                            </div>
                            <div id="accordion-styled-group3" class="panel-collapse collapse">
                                <div class="panel-body">
                                    3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it.
                                </div>
                            </div>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>