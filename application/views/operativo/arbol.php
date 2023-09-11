<?php
/* * To change this template, choose Tools | Templates * and open the template in the editor. */
$ci2 = &get_instance();
//$us = $ci3->load->model("usuarios");
//$ci2 = &get_instance();
$ci2->load->model("vista");

$carteras = explode(";", $session['carteras']);
$gruposC2 = $ci2->vista->getGruposContacto($session['proyecto_activo']);

$fila = 0;
$pr = 0;
?>

<section class="main-container">
    <!-- Page header -->
    <div class="header">
        <div class="header-content">
            <div class="page-title">
                <i class="icon-file-empty position-left"></i> Arbol de gestion - <?php echo $session['proyecto_activo']; ?>
            </div>
        </div>
    </div>
    <!-- /Page header -->

    <div class="container-fluid page-content">
        <div class="col-md-12" style="height: 300px; overflow-y: auto; margin-bottom: 25px; margin-top: 25px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">Acciones</div>
                    <div class="elements">
                        <ul class="icons-list">
                            <li><a data-action="Agregar" data-popup="tooltip" title="" id="add-actions" flag="acciones" data-original-title="Agregar"><i class="icon icon-plus2"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body" id="acciones-front">
                    <table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
                        <thead>
                            <tr>
                                <th>Id Acción</th>
                                <th>Acción</th>
                                <th>Guión</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($acciones as $acc) { ?>
                                <tr>
                                    <td><?php echo $acc['idAccion']; ?></td>
                                    <td><?php echo $acc['descripcion']; ?></td>
                                    <td><?php echo $acc['guion']; ?></td>
                                    <?php if ($acc['idAccion'] > 5) { ?>
                                        <td><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/edit.png" class="editar editar-acciones" flag="<?php echo $acc['idAccion']; ?>" accion="<?php echo $acc['descripcion']; ?>" guion="<?php echo $acc['guion']; ?>" tabla="acciones" alt="Editar" title="Editar"/>&nbsp;&nbsp;&nbsp;<img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/delete.png" flag="<?php echo $acc['idAccion']; ?>" tabla="acciones" class="borrar" alt="Borrar" title="Borrar"/></td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-12" style="height: 300px; overflow-y: auto; margin-bottom: 25px; margin-top: 25px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">Contacto</div>
                    <div class="elements">
                        <ul class="icons-list">
                            <li><a data-action="Agregar" data-popup="tooltip" title="" id="add-contacto" data-original-title="Agregar"><i class="icon icon-plus2"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body" id="contacto-front">
                    <table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
                        <thead>
                            <tr>
                                <th>Id Contacto</th>
                                <th>Contacto</th>
                                <th>Grupo</th>
                                <th>Guión</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($contacto as $cont) { 
                                $grupoC = $ci2->vista->getGruposContactoUno($cont['idGrupo'], $session['proyecto_activo']);
                                ?>
                                <tr>
                                    <td><?php echo $cont['idContacto']; ?></td>
                                    <td><?php echo $cont['descripcion']; ?></td>
                                    <td><?php echo $grupoC[0]['descripcion']; ?></td>
                                    <td><?php echo $cont['guion']; ?></td>
                                    <td><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/edit.png" class="editar editar-contacto" flag="<?php echo $cont['idContacto']; ?>" contacto="<?php echo $cont['descripcion']; ?>" grupo="<?php echo $cont['idGrupo']; ?>" guion="<?php echo $cont['guion']; ?>" tabla="contacto" alt="Editar" title="Editar"/>&nbsp;&nbsp;&nbsp;<img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/delete.png" flag="<?php echo $cont['idContacto']; ?>" tabla="contacto" class="borrar" alt="Borrar" title="Borrar"/></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>    
        <div class="col-md-12" style="height: 300px; overflow-y: auto; margin-bottom: 25px; margin-top: 25px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">Resultado</div>
                    <div class="elements">
                        <ul class="icons-list">
                            <li><a data-action="Agregar" data-popup="tooltip" title="" id="add-resultado" data-original-title="Agregar"><i class="icon icon-plus2"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body" id="resultado-front">
                    <table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
                        <thead>
                            <tr>
                                <th>Id Resultado</th>
                                <th>Resultado</th>
                                <th>Nivel</th>
                                <th>Fecha</th>
                                <th>Valor</th>
                                <th>Texto</th>
                                <th>Guion</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($resultado as $resu) {

                                if ($resu['fecha'] == 1) {
                                    $fecha = "SI";
                                } else {
                                    $fecha = "NO";
                                }

                                if ($resu['valor'] == 1) {
                                    $valor = "SI";
                                } else {
                                    $valor = "NO";
                                }

                                if ($resu['texto'] == 1) {
                                    $texto = "SI";
                                } else {
                                    $texto = "NO";
                                }
                                ?>
                                <tr>
                                    <td><?php echo $resu['idCodres']; ?></td>
                                    <td><?php echo $resu['descripcion']; ?></td>
                                    <td><?php echo $resu['nivel']; ?></td>
                                    <td><?php echo $fecha; ?></td>
                                    <td><?php echo $valor; ?></td>
                                    <td><?php echo $texto; ?></td>
                                    <td><?php echo $resu['guion']; ?></td>
                                    <td><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/edit.png" class="editar editar-resultado" resultado="<?php echo $resu['descripcion']; ?>" nivel="<?php echo $resu['nivel']; ?>" fecha="<?php echo $resu['fecha']; ?>" valor="<?php echo $resu['valor']; ?>" texto="<?php echo $resu['texto']; ?>" guion="<?php echo $resu['guion']; ?>" flag="<?php echo $resu['idCodres']; ?>" tabla="resultado" alt="Editar" title="Editar"/>&nbsp;&nbsp;&nbsp;<img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/delete.png" flag="<?php echo $resu['idCodres']; ?>" tabla="resultado" class="borrar" alt="Borrar" title="Borrar"/></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12" style="height: 300px; overflow-y: auto; margin-bottom: 25px; margin-top: 25px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">Motivos no pago</div>
                    <div class="elements">
                        <ul class="icons-list">
                            <li><a data-action="Agregar" data-popup="tooltip" title="" id="add-motivos" data-original-title="Agregar"><i class="icon icon-plus2"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body" id="motivos-front">
                    <table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
                        <thead>
                            <tr>
                                <th>Id Motivo</th>
                                <th>Motivo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($motivos as $moti) { ?>
                                <tr>
                                    <td><?php echo $moti['idMotivo']; ?></td>
                                    <td><?php echo $moti['descripcion']; ?></td>
                                    <td><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/edit.png" class="editar editar-motivos" flag="<?php echo $moti['idMotivo']; ?>" motivo="<?php echo $moti['descripcion']; ?>" tabla="motivos" alt="Editar" title="Editar"/>&nbsp;&nbsp;&nbsp;<img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/delete.png" flag="<?php echo $moti['idMotivo']; ?>" tabla="motivos" class="borrar" alt="Borrar" title="Borrar"/></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12" style="height: 300px; overflow-y: auto; margin-bottom: 25px; margin-top: 25px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">Relación de codigos</div>
                    <div class="elements">
                        <ul class="icons-list">
                            <li><a data-action="Agregar" data-popup="tooltip" title="" id="add-relacion" data-original-title="Agregar"><i class="icon icon-plus2"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body" id="relacion-front">
                    <table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
                        <thead>
                            <tr>
                                <th>Id Relación</th>
                                <th>Accion</th>
                                <th>Contacto</th>
                                <th>Resultado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($relaciones as $rel) { 
                                $accionR = $ci2->vista->getAccion($rel['idAccion'], $session['proyecto_activo']);
                                $contactoR = $ci2->vista->getContacto($rel['idContacto'], $session['proyecto_activo']);
                                $resultadoR = $ci2->vista->getResultado($rel['idResultado'], $session['proyecto_activo']);
                                ?>
                                <tr>
                                    <td><?php echo $rel['idRelacion']; ?></td>
                                    <td><?php echo $accionR[0]['descripcion']; ?></td>
                                    <td><?php echo $contactoR[0]['descripcion']; ?></td>
                                    <td><?php echo $resultadoR[0]['descripcion']; ?></td>
                                    <td><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/delete.png" flag="<?php echo $rel['idRelacion']; ?>" tabla="relacion" class="borrar" alt="Borrar" title="Borrar"/></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
    </div>
</section>
<div id="add-actions-box" class="modal-arbol">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">Agregar Acciones</div>
        </div>
        <div class="panel-body">
            <table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
                <tr>
                    <td colspan="2"><label>Accion</label></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="text" name="new-accion" id="new-accion" class="form-control"/></td>
                </tr>
                <tr>
                    <td colspan="2"><label>Guion</label></td>
                </tr>
                <tr>
                    <td colspan="2"><textarea name="new-accion-guion" id="new-accion-guion" class="form-control"></textarea></td>
                </tr>
                 <tr>
                     <td><button class="btn btn-success btn-labeled" id="save-new-action" type="button"><b><i class="icon-floppy-disk"></i></b>Guardar</button></td>
                     <td><button class="btn btn-danger btn-labeled cancel-modal"  type="button"><b><i class="icon-cross2"></i></b>Cancelar</button></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div id="add-contacto-box" class="modal-arbol">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">Agregar Contacto</div>
        </div>
        <div class="panel-body">
            <table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
                <tr>
                    <td colspan="2"><label>Contacto</label></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="text" name="new-contacto" id="new-contacto" class="form-control"/></td>
                </tr>
                <tr>
                    <td colspan="2"><label>Grupo</label></td>
                </tr>
                <tr>
                    <td colspan="2"><select name="new-contacto-grupo" id="new-contacto-grupo" class="form-control">
                            <option value="0">Seleccione....</option>
                            <?php foreach($gruposC2 as $gr){ ?>
                            <option value="<?php echo $gr['idGrupo']; ?>"><?php echo $gr['descripcion']; ?></option>
                            <?php } ?>
                        </select></td>
                </tr>
                <tr>
                    <td colspan="2"><label>Guion</label></td>
                </tr>
                <tr>
                    <td colspan="2"><textarea name="new-contacto-guion" id="new-contacto-guion" class="form-control"></textarea></td>
                </tr>
                 <tr>
                     <td><button class="btn btn-success btn-labeled" id="save-new-contacto" type="button"><b><i class="icon-floppy-disk"></i></b>Guardar</button></td>
                     <td><button class="btn btn-danger btn-labeled cancel-modal"  type="button"><b><i class="icon-cross2"></i></b>Cancelar</button></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div id="add-resultado-box" class="modal-arbol">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">Agregar Resultado</div>
        </div>
        <div class="panel-body" id="reaultado-front">
            <table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
                <tr>
                    <td colspan="3"><label>Resultado</label></td>
                </tr>
                <tr>
                    <td colspan="3"><input type="text" name="new-resultado" id="new-resultado" class="form-control"/></td>
                </tr>
                <tr>
                    <td colspan="3"><label>Nivel</label></td>
                </tr>
                <tr>
                    <td colspan="3"><input type="text" name="new-resultado-nivel" id="new-resultado-nivel" class="form-control"/></td>
                </tr>
                <tr>
                    <td><label>Fecha</label></td>
                    <td><label>Valor</label></td>
                    <td><label>Texto</label></td>
                </tr>
                <tr>
                    <td><select name="new-resultado-fecha" id="new-resultado-fecha" class="form-control">
                            <option value="0">NO</option>
                            <option value="1">SI</option>
                        </select></td>
                        <td><select name="new-resultado-valor" id="new-resultado-valor" class="form-control">
                            <option value="0">NO</option>
                            <option value="1">SI</option>
                        </select></td>
                        <td><select name="new-resultado-texto" id="new-resultado-texto" class="form-control">
                            <option value="0">NO</option>
                            <option value="1">SI</option>
                        </select></td>
                </tr>
                               
                <tr>
                    <td colspan="3"><label>Guion</label></td>
                </tr>
                <tr>
                    <td colspan="3"><textarea name="new-resultado-guion" id="new-resultado-guion" class="form-control"></textarea></td>
                </tr>
                 <tr>
                     <td><button class="btn btn-success btn-labeled" id="save-new-resultado" type="button"><b><i class="icon-floppy-disk"></i></b>Guardar</button></td>
                     <td><button class="btn btn-danger btn-labeled cancel-modal"  type="button"><b><i class="icon-cross2"></i></b>Cancelar</button></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div id="add-motivos-box" class="modal-arbol">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">Agregar Motivos de no pago</div>
        </div>
        <div class="panel-body">
            <table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
                <tr>
                    <td colspan="2"><label>Motivo</label></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="text" name="new-motivo" id="new-motivo" class="form-control"/></td>
                </tr>
                 <tr>
                     <td><button class="btn btn-success btn-labeled" id="save-new-motivo" type="button"><b><i class="icon-floppy-disk"></i></b>Guardar</button></td>
                     <td><button class="btn btn-danger btn-labeled cancel-modal"  type="button"><b><i class="icon-cross2"></i></b>Cancelar</button></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div id="add-relacion-box" class="modal-arbol">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">Agregar relación de codigos</div>
        </div>
        <div class="panel-body">
            <table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
                <tr>
                    <td colspan="2"><label>Accion</label></td>
                </tr>
                <tr>
                    <td colspan="2"><select name="new-relacion-accion" id="new-relacion-accion" class="form-control">
                            <option value="0">Seleccione...</option>
                            <?php foreach($acciones as $ac){ ?>
                            <option value="<?php echo $ac['idAccion']; ?>"><?php echo $ac['descripcion']; ?></option>
                            <?php } ?>
                        </select></td>
                </tr>
                <tr>
                    <td colspan="2"><label>Contacto</label></td>
                </tr>
                <tr>
                    <td colspan="2"><select name="new-relacion-contacto" id="new-relacion-contacto" class="form-control">
                            <option value="0">Seleccione...</option>
                            <?php foreach($contacto as $co){ ?>
                            <option value="<?php echo $co['idContacto']; ?>"><?php echo $co['descripcion']; ?></option>
                            <?php } ?>
                        </select></td>
                </tr>
                <tr>
                    <td colspan="2"><label>Resultado</label></td>
                </tr>
                <tr>
                    <td colspan="2"><select name="new-relacion-resultado" id="new-relacion-resultado" class="form-control">
                           <option value="0">Seleccione...</option>
                            <?php foreach($resultado as $re){ ?>
                            <option value="<?php echo $re['idCodres']; ?>"><?php echo $re['descripcion']; ?></option>
                            <?php } ?> 
                        </select></td>
                </tr>
                 <tr>
                     <td><button class="btn btn-success btn-labeled" id="save-new-relacion" type="button"><b><i class="icon-floppy-disk"></i></b>Guardar</button></td>
                     <td><button class="btn btn-danger btn-labeled cancel-modal"  type="button"><b><i class="icon-cross2"></i></b>Cancelar</button></td>
                </tr>
            </table>
        </div>
    </div>
</div>



<!---- ********************** EDITAR  ****************************** -->



<div id="editar-actions-box" class="modal-arbol">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">Editar Acciones</div>
        </div>
        <div class="panel-body">
            <table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
                <tr>
                    <td colspan="2"><label>Accion</label></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="text" name="edit-accion" id="edit-accion" class="form-control"/></td>
                </tr>
                <tr>
                    <td colspan="2"><label>Guion</label></td>
                </tr>
                <tr>
                    <td colspan="2"><textarea name="edit-accion-guion" id="edit-accion-guion" class="form-control"></textarea></td>
                </tr>
                 <tr>
                     <td><input type="hidden" value="" name="edit-accion-id" id="edit-accion-id" class="form-control"/><button class="btn btn-success btn-labeled" id="edit-new-action" type="button"><b><i class="icon-floppy-disk"></i></b>Guardar</button></td>
                     <td><button class="btn btn-danger btn-labeled cancel-modal"  type="button"><b><i class="icon-cross2"></i></b>Cancelar</button></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div id="editar-contacto-box" class="modal-arbol">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">Editar Contacto</div>
        </div>
        <div class="panel-body">
            <table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
                <tr>
                    <td colspan="2"><label>Contacto</label></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="text" name="edit-contacto" id="edit-contacto" class="form-control"/></td>
                </tr>
                <tr>
                    <td colspan="2"><label>Grupo</label></td>
                </tr>
                <tr>
                    <td colspan="2"><select name="edit-contacto-grupo" id="edit-contacto-grupo" class="form-control">
                            <option value="0">Seleccione....</option>
                            <?php foreach($gruposC2 as $gr){ ?>
                            <option value="<?php echo $gr['idGrupo']; ?>"><?php echo $gr['descripcion']; ?></option>
                            <?php } ?>
                        </select></td>
                </tr>
                <tr>
                    <td colspan="2"><label>Guion</label></td>
                </tr>
                <tr>
                    <td colspan="2"><textarea name="edit-contacto-guion" id="edit-contacto-guion" class="form-control"></textarea></td>
                </tr>
                 <tr>
                     <td><input type="hidden" name="edit-contacto-id" id="edit-contacto-id" class="form-control" value="0"><button class="btn btn-success btn-labeled" id="edit-new-contacto" type="button"><b><i class="icon-floppy-disk"></i></b>Guardar</button></td>
                     <td><button class="btn btn-danger btn-labeled cancel-modal"  type="button"><b><i class="icon-cross2"></i></b>Cancelar</button></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div id="editar-resultado-box" class="modal-arbol">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">Editar Resultado</div>
        </div>
        <div class="panel-body" id="reaultado-front">
            <table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
                <tr>
                    <td colspan="3"><label>Resultado</label></td>
                </tr>
                <tr>
                    <td colspan="3"><input type="text" name="edit-resultado" id="edit-resultado" class="form-control"/></td>
                </tr>
                <tr>
                    <td colspan="3"><label>Nivel</label></td>
                </tr>
                <tr>
                    <td colspan="3"><input type="text" name="edit-resultado-nivel" id="edit-resultado-nivel" class="form-control"/></td>
                </tr>
                <tr>
                    <td><label>Fecha</label></td>
                    <td><label>Valor</label></td>
                    <td><label>Texto</label></td>
                </tr>
                <tr>
                    <td><select name="edit-resultado-fecha" id="edit-resultado-fecha" class="form-control">
                            <option value="0">NO</option>
                            <option value="1">SI</option>
                        </select></td>
                        <td><select name="edit-resultado-valor" id="edit-resultado-valor" class="form-control">
                            <option value="0">NO</option>
                            <option value="1">SI</option>
                        </select></td>
                        <td><select name="edit-resultado-texto" id="edit-resultado-texto" class="form-control">
                            <option value="0">NO</option>
                            <option value="1">SI</option>
                        </select></td>
                </tr>
                               
                <tr>
                    <td colspan="3"><label>Guion</label></td>
                </tr>
                <tr>
                    <td colspan="3"><input type="hidden" name="edit-resultado-id" id="edit-resultado-id" class="form-control" value=""/><textarea name="edit-resultado-guion" id="edit-resultado-guion" class="form-control"></textarea></td>
                </tr>
                 <tr>
                     <td><button class="btn btn-success btn-labeled" id="edit-new-resultado" type="button"><b><i class="icon-floppy-disk"></i></b>Guardar</button></td>
                     <td><button class="btn btn-danger btn-labeled cancel-modal"  type="button"><b><i class="icon-cross2"></i></b>Cancelar</button></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div id="editar-motivos-box" class="modal-arbol">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">Editar Motivos de no pago</div>
        </div>
        <div class="panel-body">
            <table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
                <tr>
                    <td colspan="2"><label>Motivo</label></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="text" name="edit-motivo" id="edit-motivo" class="form-control"/></td>
                </tr>
                 <tr>
                     <td><input type="hidden" name="edit-motivo-id" id="edit-motivo-id" class="form-control" value="0"/><button class="btn btn-success btn-labeled" id="edit-new-motivo" type="button"><b><i class="icon-floppy-disk"></i></b>Guardar</button></td>
                     <td><button class="btn btn-danger btn-labeled cancel-modal"  type="button"><b><i class="icon-cross2"></i></b>Cancelar</button></td>
                </tr>
            </table>
        </div>
    </div>
</div>