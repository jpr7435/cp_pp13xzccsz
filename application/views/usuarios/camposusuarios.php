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
        <i class="icon-file-empty position-left"></i> Campos adicionales para usuarios
      </div>
    </div>
  </div>
  <!-- /Page header -->
  <div id="result"></div>

  <div class="container-fluid page-content">
    <div class="col-md-12" style="height: 300px; overflow-y: auto; margin-bottom: 25px; margin-top: 25px;">
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="panel-title">Grupos</div>
          <div class="elements">
            <ul class="icons-list">
              <li><a data-action="Agregar" data-popup="tooltip" title="" id="add-grupos" flag="grupos" data-original-title="Agregar"><i class="icon icon-plus2"></i></a></li>
            </ul>
          </div>
        </div>
        <div class="panel-body" id="grupos-front">
          <table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
            <thead>
              <tr>
                <th>id Grupo</th>
                <th>Nombre</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($grupos as $gr) { ?>
                <tr>
                  <td><?php echo $gr['idgrupo']; ?></td>
                  <td><?php echo $gr['descripcion']; ?></td>
                  <td>
                    <img src="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/img/edit.png" class="editar editar-grupos" flag="<?php echo $gr['idgrupo']; ?>" grupo="<?php echo $gr['descripcion']; ?>"  tabla="acciones" alt="Editar" title="Editar"/>
                    &nbsp;&nbsp;&nbsp;<img src="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/img/delete.png" flag="<?php echo $gr['idgrupo']; ?>" tabla="acciones" class="borrar borrar-grupo" alt="Borrar" title="Borrar"/>
                  </td>
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
          <div class="panel-title">Tipos</div>
          <div class="elements">
            <ul class="icons-list">
              <li><a data-action="Agregar" data-popup="tooltip" title="" id="add-tipo" data-original-title="Agregar"><i class="icon icon-plus2"></i></a></li>
            </ul>
          </div>
        </div>
        <div class="panel-body" id="tipos-front">
          <table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
            <thead>
              <tr>
                <th>Id Tipo</th>
                <th>Tipo</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($tipos as $ti) {?>
                <tr>
                  <td><?php echo $ti['idtipo']; ?></td>
                  <td><?php echo $ti['descripcion']; ?></td>
                  <td><img src="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/img/edit.png" class="editar editar-tipo" flag="<?php echo $ti['idtipo']; ?>" tipo="<?php echo $ti['descripcion']; ?>" tabla="contacto" alt="Editar" title="Editar"/>
                  &nbsp;&nbsp;&nbsp;<img src="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/img/delete.png" flag="<?php echo $ti['idtipo']; ?>" tabla="contacto" class="borrar borrar-tipo" alt="Borrar" title="Borrar"/></td>
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
          <div class="panel-title">Niveles</div>
          <div class="elements">
            <ul class="icons-list">
              <li><a data-action="Agregar" data-popup="tooltip" title="" id="add-nivel" data-original-title="Agregar"><i class="icon icon-plus2"></i></a></li>
            </ul>
          </div>
        </div>
        <div class="panel-body" id="niveles-front">
          <table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
            <thead>
              <tr>
                <th>Id Nivel</th>
                <th>Nivel</th>
                <th>Piso</th>
                <th>% Maximo</th>
                <th><=79.99%</th>
                <th>80% a 99.99%</th>
                <th>100% a 109.99%</th>
                <th>110% a 124.99%</th>
                <th>>=125%</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($nivel as $ni) {?>
                <tr>
                  <td><?php echo $ni['idnivel']; ?></td>
                  <td><?php echo $ni['descripcion']; ?></td>
                  <td><?php echo $ni['piso']; ?></td>
                  <td><?php echo $ni['factura']; ?></td>
                  <td><?php echo $ni['menos79']; ?></td>
                  <td><?php echo $ni['80a99']; ?></td>
                  <td><?php echo $ni['100a109']; ?></td>
                  <td><?php echo $ni['110a124']; ?></td>
                  <td><?php echo $ni['mas125']; ?></td>
                  <td><img src="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/img/edit.png" class="editar editar-nivel"
                    flag="<?php echo $ni['idnivel']; ?>"
                    nivel="<?php echo $ni['descripcion']; ?>"
                    piso="<?php echo $ni['piso']; ?>"
                    factura="<?php echo $ni['factura']; ?>"
                    menos79="<?php echo $ni['menos79']; ?>"
                    80a99="<?php echo $ni['80a99']; ?>"
                    100a109="<?php echo $ni['100a109']; ?>"
                    110a124="<?php echo $ni['110a124']; ?>"
                    mas125="<?php echo $ni['mas125']; ?>"
                    tabla="resultado" alt="Editar" title="Editar"/>
                  &nbsp;&nbsp;&nbsp;<img src="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/img/delete.png" flag="<?php echo $ni['idnivel']; ?>" tabla="resultado" class="borrar borrar-nivel" alt="Borrar" title="Borrar"/></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
<div id="add-grupos-box" class="modal-arbol">
  <div class="panel panel-default">
    <div class="panel-heading">
      <div class="panel-title">Agregar Grupos</div>
    </div>
    <div class="panel-body">
      <table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
        <tr>
          <td colspan="2"><label>Nombre Grupo</label></td>
        </tr>
        <tr>
          <td colspan="2"><input type="text" name="new-grupo" id="new-grupo" class="form-control"/></td>
        </tr>
        <tr>
          <td><button class="btn btn-success btn-labeled" id="save-new-grupo" type="button"><b><i class="icon-floppy-disk"></i></b>Guardar</button></td>
          <td><button class="btn btn-danger btn-labeled cancel-modal"  type="button"><b><i class="icon-cross2"></i></b>Cancelar</button></td>
        </tr>
      </table>
    </div>
  </div>
</div>
<div id="add-tipos-box" class="modal-arbol">
  <div class="panel panel-default">
    <div class="panel-heading">
      <div class="panel-title">Agregar Tipos</div>
    </div>
    <div class="panel-body">
      <table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
        <tr>
          <td colspan="2"><label>Nombre Tipo</label></td>
        </tr>
        <tr>
          <td colspan="2"><input type="text" name="new-tipo" id="new-tipo" class="form-control"/></td>
        </tr>
        <tr>
          <td><button class="btn btn-success btn-labeled" id="save-new-tipo" type="button"><b><i class="icon-floppy-disk"></i></b>Guardar</button></td>
          <td><button class="btn btn-danger btn-labeled cancel-modal"  type="button"><b><i class="icon-cross2"></i></b>Cancelar</button></td>
        </tr>
      </table>
    </div>
  </div>
</div>
<div id="add-niveles-box" class="modal-arbol">
  <div class="panel panel-default">
    <div class="panel-heading">
      <div class="panel-title">Agregar Niveles</div>
    </div>
    <div class="panel-body" id="nivel-front">
      <table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
        <tr>
          <td colspan="3"><label>Nombre Nivel</label></td>
        </tr>
        <tr>
          <td colspan="3"><input type="text" name="new-nivel" id="new-nivel" class="form-control"/></td>
        </tr>
        <tr>
          <td><label>% Factura</label></td>
          <td><input type="text" name="new-nivel-factura" id="new-nivel-factura" class="form-control"/></td>
        </tr>
        <tr>
          <td><label class="col-sm-6">Piso</label></td>
          <td><input type="text" name="new-nivel-piso" id="new-nivel-piso" class="form-control col-sm-5"/></p></td>
        </tr>
        <tr>
          <td><label><=79.99%</label></td>
          <td><input type="text" name="new-nivel-menos79" id="new-nivel-menos79" class="form-control"/></td>
        </tr>
        <tr>
          <td><label>88% a 99.99%</label></td>
          <td><input type="text" name="new-nivel-88a99" id="new-nivel-88a99" class="form-control"/></td>
        </tr>
        <tr>
          <td><label>100% a 109.99%</label></td>
          <td><input type="text" name="new-nivel-100a109" id="new-nivel-100a109" class="form-control"/></td>
        </tr>
        <tr>
          <td><label>110% a 124.99%</label></td>
          <td><input type="text" name="new-nivel-110a124" id="new-nivel-110a124" class="form-control"/></td>
        </tr>
        <tr>
          <td><label>>=125%</label></td>
          <td><input type="text" name="new-nivel-mas125" id="new-nivel-mas125" class="form-control"/></td>
        </tr>
        <tr>
          <td><button class="btn btn-success btn-labeled" id="save-new-nivel" type="button"><b><i class="icon-floppy-disk"></i></b>Guardar</button></td>
          <td><button class="btn btn-danger btn-labeled cancel-modal"  type="button"><b><i class="icon-cross2"></i></b>Cancelar</button></td>
        </tr>
      </table>
    </div>
  </div>
</div>





<!---- ********************** EDITAR  ****************************** -->



<div id="editar-grupos-box" class="modal-arbol">
  <div class="panel panel-default">
    <div class="panel-heading">
      <div class="panel-title">Editar Grupos</div>
    </div>
    <div class="panel-body">
      <table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
        <tr>
          <td colspan="2"><label>Nombre</label></td>
        </tr>
        <tr>
          <td colspan="2"><input type="text" name="edit-grupo" id="edit-grupo" class="form-control"/></td>
        </tr>
        <tr>
          <td><input type="hidden" value="" name="edit-grupo-id" id="edit-grupo-id" class="form-control"/><button class="btn btn-success btn-labeled" id="edit-grupo-action" type="button"><b><i class="icon-floppy-disk"></i></b>Guardar</button></td>
          <td><button class="btn btn-danger btn-labeled cancel-modal"  type="button"><b><i class="icon-cross2"></i></b>Cancelar</button></td>
        </tr>
      </table>
    </div>
  </div>
</div>

<div id="editar-tipo-box" class="modal-arbol">
  <div class="panel panel-default">
    <div class="panel-heading">
      <div class="panel-title">Editar Tipos</div>
    </div>
    <div class="panel-body">
      <table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
        <tr>
          <td colspan="2"><label>Tipo</label></td>
        </tr>
        <tr>
          <td colspan="2"><input type="text" name="edit-tipo" id="edit-tipo" class="form-control"/></td>
        </tr>
        <tr>
          <td><input type="hidden" name="edit-tipo-id" id="edit-tipo-id" class="form-control" value="0"><button class="btn btn-success btn-labeled" id="edit-new-tipo" type="button"><b><i class="icon-floppy-disk"></i></b>Guardar</button></td>
          <td><button class="btn btn-danger btn-labeled cancel-modal"  type="button"><b><i class="icon-cross2"></i></b>Cancelar</button></td>
        </tr>
      </table>
    </div>
  </div>
</div>
<div id="editar-niveles-box" class="modal-arbol">
  <div class="panel panel-default">
    <div class="panel-heading">
      <div class="panel-title">Editar Niveles</div>
    </div>
    <div class="panel-body">
      <table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
        <tr>
          <td colspan="3"><label>Nombre Nivel</label></td>
        </tr>
        <tr>
          <td colspan="3"><input type="text" name="edit-nivel" id="edit-nivel" class="form-control"/></td>
        </tr>
        <tr>
          <td><label>% Factura</label></td>
          <td><input type="text" name="edit-nivel-factura" id="edit-nivel-factura" class="form-control"/></td>
        </tr>
        <tr>
          <td><label class="col-sm-6">Piso</label></td>
          <td><input type="text" name="edit-nivel-piso" id="edit-nivel-piso" class="form-control col-sm-5"/></p></td>
        </tr>
        <tr>
          <td><label><=79.99%</label></td>
          <td><input type="text" name="edit-nivel-menos79" id="edit-nivel-menos79" class="form-control"/></td>
        </tr>
        <tr>
          <td><label>88% a 99.99%</label></td>
          <td><input type="text" name="edit-nivel-88a99" id="edit-nivel-88a99" class="form-control"/></td>
        </tr>
        <tr>
          <td><label>100% a 109.99%</label></td>
          <td><input type="text" name="edit-nivel-100a109" id="edit-nivel-100a109" class="form-control"/></td>
        </tr>
        <tr>
          <td><label>110% a 124.99%</label></td>
          <td><input type="text" name="edit-nivel-110a124" id="edit-nivel-110a124" class="form-control"/></td>
        </tr>
        <tr>
          <td><label>>=125%</label></td>
          <td><input type="text" name="edit-nivel-mas125" id="edit-nivel-mas125" class="form-control"/></td>
        </tr>
        <tr>
          <td><input type="hidden" name="edit-nivel-id" id="edit-nivel-id" class="form-control" value="0"><button class="btn btn-success btn-labeled" id="save-edit-nivel" type="button"><b><i class="icon-floppy-disk"></i></b>Guardar</button></td>
          <td><button class="btn btn-danger btn-labeled cancel-modal"  type="button"><b><i class="icon-cross2"></i></b>Cancelar</button></td>
        </tr>
      </table>
    </div>
  </div>
</div>
