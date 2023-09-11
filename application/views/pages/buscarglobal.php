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
    <h1 style="display:none">Formulario de busqueda</h1>

    <!-- Page header -->
    <div class="header">
        <div class="header-content">
            <div class="page-title">
                <i class="icon-file-empty position-left"></i> Formulario de busqueda
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
                        <label>Obligacion:</label>
                        <input type="text" class="form-control" name="obligacion-buscar" id="obligacion-buscar"/>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="col-lg-4">
                        <label>Documento:</label>
                        <input type="text" class="form-control" name="documento-buscar" id="documento-buscar"/>
                    </div>
                    <div class="col-lg-4">
                        <label>Aesor:</label>
                        <select class="form-control" name="asignado-buscar" id="asignado-buscar">
                            <option value="0">Seleccione..</option>
                            <?php foreach ($usuarios as $usu) { ?>
                                <option value="<?php echo $usu['idUsuario']; ?>"><?php echo $usu['nombre']; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-lg-4">
                        <label>DUI</label>
                        <input type="text" name="dui-buscar" id="dui-buscar" class="form-control"/>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="col-lg-4">
                        <label>Telefono:</label>
                        <input type="text" class="form-control" name="telefono-buscar" id="telefono-buscar"/>
                    </div>
                    <div class="col-lg-4">
                        <label>Cartera:</label>
                        <select class="form-control" name="cartera-buscar" id="cartera-buscar">
                            <option value="0">Seleccione..</option>
                            <?php foreach ($proyectos as $proy) { ?>
                                <option value="<?php echo $proy['descripcion']; ?>"><?php echo $proy['descripcion']; ?></option>
                            <?php } ?>
                        </select>
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
                        <button type="button" class="btn btn-success" name="buscarGlobal-btn" id="buscarGlobal-btn">Buscar</button>
                    </div>

                </div>
            </div>
        </div>
        <div style="clear: both; height: 25px;"></div>
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div id="resultado-busqueda">

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
