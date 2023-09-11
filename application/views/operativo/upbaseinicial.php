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
                <i class="icon-file-empty position-left"></i> Seleccione los campos a cargar para - <?php echo $session['proyecto_activo']; ?>
            </div>
        </div>
    </div>
    <!-- /Page header -->

    <div class="container-fluid page-content">
        <div style="clear: both; height: 25px;"></div>
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <form name="execute-baseini" id="execute-baseini" method="post" action="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/executebaseinicial/<?php echo $session['proyecto_activo']; ?>">
                        <h1>Clientes:</h1>
                        <table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
                            <tr>
                                <td>Documento <span style="color: #FF0000;">*</span></td>
                                <td>
                                    <select name="documento" class="obligatorio" id="documento">
                                        <option value="0">Seleccione...</option>
                                        <?php foreach ($campos as $c) { ?>
                                            <option value="<?php echo $fila; ?>"><?php echo $c; ?></option>
                                        <?php $fila++; } $fila = 0;?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Nombre <span style="color: #FF0000;">*</span></td>
                                <td>
                                    <select name="nombre" class="obligatorio" id="nombre">
                                        <option value="0">Seleccione...</option>
                                        <?php foreach ($campos as $c) { ?>
                                            <option value="<?php echo $fila; ?>"><?php echo $c; ?></option>
                                        <?php $fila++; } $fila = 0; ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <h1>Obligaciones:</h1>
                        <table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
                            <?php
                            foreach ($creditos as $cr) {

                                if ($cr['Field'] != 'idCreditos' && $cr['Field'] != 'documento' && $cr['Field'] != 'fechacargue' && $cr['Field'] != 'activo' && $cr['Field'] != 'fechaActualizacion' && $cr['Field'] != 'estadoActual' && $cr['Field'] != 'equipo') {
                                    ?>
                                    <tr>
                                        <td><?php echo $cr['Field']; ?> <span style="color: #FF0000;">*</span></td>
                                        <td>
                                            <select name="<?php echo $cr['Field']; ?>" id="<?php echo $cr['Field']; ?>">
                                                <option value="0">Seleccione...</option>
                                                <?php foreach ($campos as $c) {
                                                  $sele = "";
                                                  if(strtolower($cr['Field']) == strtolower($c)){
                                                      $sele = "selected";
                                                  }
                                                  ?>
                                                    <option <?php echo $sele; ?> value="<?php echo $fila; ?>"><?php echo $c; ?></option>
                                                <?php $fila++; } $fila = 0; ?>
                                            </select>
                                        </td>
                                    </tr>
                                <?php }
                            } ?>
                        </table>
                        <h1>Demograficos:</h1>
                        <table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
                            <tr>
                                <td>Ciudad <span style="color: #FF0000;">*</span></td>
                                <td>
                                    <select name="ciudadOri" id="ciudadOri">
                                        <option value="0">Seleccione...</option>
                                        <?php foreach ($campos as $c) { ?>
                                            <option value="<?php echo $fila; ?>"><?php echo $c; ?></option>
                                        <?php $fila++; } $fila = 0; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Telefono1 <span style="color: #FF0000;">*</span></td>
                                <td>
                                    <select name="telefono1" class="obligatorio" id="telefono1">
                                        <option value="0">Seleccione...</option>
                                        <?php foreach ($campos as $c) { ?>
                                            <option value="<?php echo $fila; ?>"><?php echo $c; ?></option>
                                        <?php $fila++; } $fila = 0;?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Telefono2 <span style="color: #FF0000;">*</span></td>
                                <td>
                                    <select name="telefono2" id="telefono2">
                                        <option value="0">Seleccione...</option>
                                        <?php foreach ($campos as $c) { ?>
                                            <option value="<?php echo $fila; ?>"><?php echo $c; ?></option>
                                        <?php $fila++; } $fila = 0; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Telefono3 <span style="color: #FF0000;">*</span></td>
                                <td>
                                    <select name="telefono3" id="telefono3">
                                        <option value="0">Seleccione...</option>
                                        <?php foreach ($campos as $c) { ?>
                                            <option value="<?php echo $fila; ?>"><?php echo $c; ?></option>
                                        <?php $fila++; } $fila = 0; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Telefono4 <span style="color: #FF0000;">*</span></td>
                                <td>
                                    <select name="telefono4" id="telefono4">
                                        <option value="0">Seleccione...</option>
                                        <?php foreach ($campos as $c) { ?>
                                            <option value="<?php echo $fila; ?>"><?php echo $c; ?></option>
                                        <?php $fila++; } $fila = 0; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Telefono5 <span style="color: #FF0000;">*</span></td>
                                <td>
                                    <select name="telefono5" id="telefono5">
                                        <option value="0">Seleccione...</option>
                                        <?php foreach ($campos as $c) { ?>
                                            <option value="<?php echo $fila; ?>"><?php echo $c; ?></option>
                                        <?php $fila++; } $fila = 0; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Telefono6 <span style="color: #FF0000;">*</span></td>
                                <td>
                                    <select name="telefono6" id="telefono6">
                                        <option value="0">Seleccione...</option>
                                        <?php foreach ($campos as $c) { ?>
                                            <option value="<?php echo $fila; ?>"><?php echo $c; ?></option>
                                        <?php $fila++; } $fila = 0; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Telefono7 <span style="color: #FF0000;">*</span></td>
                                <td>
                                    <select name="telefono7" id="telefono7">
                                        <option value="0">Seleccione...</option>
                                        <?php foreach ($campos as $c) { ?>
                                            <option value="<?php echo $fila; ?>"><?php echo $c; ?></option>
                                        <?php $fila++; } $fila = 0; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Telefono8 <span style="color: #FF0000;">*</span></td>
                                <td>
                                    <select name="telefono8" id="telefono8">
                                        <option value="0">Seleccione...</option>
                                        <?php foreach ($campos as $c) { ?>
                                            <option value="<?php echo $fila; ?>"><?php echo $c; ?></option>
                                        <?php $fila++; } $fila = 0; ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        </br>
                        <input type="hidden" name="archivos" id="archivos" value="<?php echo $archivo; ?>"/>
                        <button type="button" id="campos-baseini-btn" class="btn btn-success btn-lg">Cargar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
