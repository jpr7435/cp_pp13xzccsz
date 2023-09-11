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
            </div>
        </div>
    </div>
    <!-- /Page header -->

    <div class="container-fluid page-content">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-flat borde-azul">
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
                <div class="panel panel-flat borde-amarillo">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Eventos Recientes
                        </div>
                    </div>
                    <div class="panel-body">

                    </div>
                </div>
            </div>
        </div>
        <div style="clear: both; height: 25px;"></div>
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="background-color: #9EC54C; color: #FFF; font-weight: lighter;">Obligacion</th>
                                <th style="background-color: #9EC54C; color: #FFF; font-weight: lighter;">Dias Mora</th>
                                <th style="background-color: #9EC54C; color: #FFF; font-weight: lighter;">Capital</th>
                                <th style="background-color: #9EC54C; color: #FFF; font-weight: lighter;">Saldo Inicial</th>
                                <th style="background-color: #9EC54C; color: #FFF; font-weight: lighter;">Saldo Total</th>
                                <th style="background-color: #9EC54C; color: #FFF; font-weight: lighter;">Detalle Cartera</th>
                                <th style="background-color: #9EC54C; color: #FFF; font-weight: lighter;">Estado Actual</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($creditos as $cr) { ?>
                                <tr>
                                    <td><?php echo $cr['obligacion']; ?></td>
                                    <td><?php echo number_format($cr['diasMora'], 0); ?></td>
                                    <td><?php echo number_format($cr['capital'], 0); ?></td>
                                    <td><?php echo number_format($cr['valororiginal'], 0); ?></td>
                                    <td><?php echo number_format($cr['saldo'], 0); ?></td>
                                    <td><?php echo $cr['detalleCartera']; ?></td>
                                    <td><?php echo $cr['estadoActual']; ?></td>
                                </tr>
                            <?php } ?>
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
                       <?php
                       $flag = 0;
                       foreach($gestion as $ges){ 
                           
                           
                           $class="";
                           $class2 = "in";
                           $color = "";
                           if($flag > 0){
                               $class='class="collapsed"';
                               $class2="";
                           }
                           $result = $this->vista->getResultado($ges['idResultado'], $session['proyecto_activo']);
                           $user = $this->vista->getusuario($ges['idAsesor'], $session['proyecto_activo']);
                           $cont = $this->vista->getContacto($ges['idContacto'], $session['proyecto_activo']);
                           
                           if($cont[0]['idGrupo'] == 1){
                               $color = 'style="background-color:  #d9ffdc;"';
                           }if($cont[0]['idGrupo'] == 2){
                               $color = 'style="background-color:  #fedbdb;"';
                           }
                           ?>
                        
                        <div class="panel">
                            <div class="panel-heading" <?php echo $color; ?>>
                                <div class="panel-title">
                                    <a <?php echo $class; ?> data-toggle="collapse" data-parent="#accordion-styled" href="#<?php echo $ges['idCallhist']; ?>"><?php echo $user[0]['usuario']." - Tel: ".$ges['telefono']." - ".$result[0]['descripcion']." - ".$ges['fechaGestion']; ?></a>
                                </div>
                            </div>
                            <div id="<?php echo $ges['idCallhist'] ?>" class="panel-collapse collapse <?php echo $class2; ?>">
                                <div class="panel-body">
                                    <?php echo $ges['textoGestion']; ?>
                                </div>
                            </div>
                        </div>
                       <?php $flag += 1; } ?>
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