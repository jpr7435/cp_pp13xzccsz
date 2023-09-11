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
                <i class="icon-file-empty position-left"></i> Listado de asignacion
            </div>
        </div>
    </div>
    <!-- /Page header -->

    <div class="container-fluid page-content">
        <div class="panel panel-flat">
            <div class="panel-body">
                <div class="col-lg-4">
                    <div class="form-group">

                        <select id="criterio" name="criterio" class="select-fixed-single">
                            <optgroup label="Criterio de busqueda">
                                <option value="0">Seleccione.</option>
                                <option value="DOC">Documento</option>
                                <option value="OBL">Obligacion</option>
                                <option value="NOM">Nombre</option>
                                <option value="TEL">Telefono</option>
                            </optgroup>
                        </select>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="form-group">
                        <div class="input-group input-group-lg">
                            <input class="form-control input-lg" placeholder="Valor a buscar" name="valor" id="valor" type="text">
                            <span class="input-group-btn">
                                <button class="btn btn-default" id="buscar-btn" type="button">
                                    <i class="icon icon-search4"></i>
                                </button> </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div style="clear: both; height: 25px;"></div>
        <!-- Individual column searching (selects) -->
        <div class="panel panel-flat" style="overflow-x: auto;">
            <div class="panel-heading">
                <div class="panel-title">Listado de asignación</div>
            </div>
            <table id="asignacion-table" style="width: 100% !important;" class="table datatable datatable-column-search-selects">
                <thead>
                    <tr>
                        <th class="col-md-2">Documento</th>
                        <th class="col-md-6">Nombre</th>
                        <th class="col-md-2">Saldo Pareto</th>
                        <th class="col-md-3">Mejor Gestion</th>
                        <th class="col-md-3">Ultima Gestion</th>
                        <th class="col-md-2">Fecha Ultima Gestion</th>
                        <th class="col-md-6">Franja</th>
                        <th class="col-md-6">Estrategia</th>
                        <th class="col-md-6">Territorial Mayor</th>
                        <th class="col-md-1 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
        <!-- /Individual column searching (Selects) -->
    </div>

</section>
