<?php
/* * To change this template, choose Tools | Templates * and open the template in the editor. */
$ci2 = &get_instance();
//$us = $ci3->load->model("usuarios");
//$ci2 = &get_instance();
$ci2->load->model("vista");

$fila = 0;
$pr = 0;

if(!isset($tareas[0]['idtareas'])){
  echo "Error no se encuntra la tarea";
  die();
}

?>

<section class="main-container">
  <!-- Page header -->
  <div class="header">
    <div class="header-content">
      <div class="page-title">
        <i class="icon-file-empty position-left"></i> Editar  tarea - <?php echo $tareas[0]['nombre']; ?>
      </div>
    </div>
  </div>
  <!-- /Page header -->

  <div class="container-fluid page-content">
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-heading">
          <div class="panel-title">
            Crear Criterio
          </div>
        </div>
        <div class="panel-body">
          <div class="col-lg-12">
            <form class="col-md-12" action="" id="form-criterios" method="post">
              <div class="row">
                <div class="form-group col-sm-3">
                  <label>Campo</label>
                  <select name="campo-tareas" id="campo-tareas" class="form-control">
                    <option value="0">Seleccione...</option>
                    <?php foreach($clientes as $clfield){
                      $name = "10_clientes.".$clfield['Field'];
                      $name2 = "clientes -> ".$clfield['Field'];
                      ?>
                      <option value="<?php echo $name; ?>"><?php echo $name2; ?></option>
                    <?php } ?>
                    <?php foreach($creditos as $crfield){
                      $name = "9_cobranzas.".$crfield['Field'];
                      $name2 = "creditos -> ".$crfield['Field'];
                      ?>
                      <option value="<?php echo $name; ?>"><?php echo $name2; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group col-sm-3">
                  <label>Operador</label>
                  <select name="operador-tareas" id="operador-tareas" class="form-control">
                    <option value="0">Seleccione...</option>
                    <option value="=">Igual que...</option>
                    <option value="!=">Diferente que...</option>
                    <option value=">">Mayor que...</option>
                    <option value=">=">Mayor o igual que...</option>
                    <option value="<">Menor que...</option>
                    <option value="<=">Menor o igual que...</option>
                    <option value="like">Contiene...</option>
                  </select>
                </div>
                <div class="form-group col-sm-2" id="select-normal">
                  <label>Valor</label>
                  <input type="text" name="valor-tareas" id="valor-tareas" class="form-control"/>
                </div>
                <div style="display: none;" id="select-fechas" class="form-group col-sm-2">
                  <label>Valor</label>
                  <select name="valor2-tareas" id="valor2-tareas" class="form-control">
                    <option value="0">Seleccione...</option>
                    <option value="hoy">Hoy</option>
                    <option value="ayer">Ayer</option>
                    <option value="menos3">Hoy - 3</option>
                    <option value="menos5">Hoy - 5</option>
                    <option value="mesanterior">Mes Pasado</option>
                  </select>
                </div>
                <div class="form-group col-sm-2">
                  <input type="hidden" name="tarea-tareas" id="tarea-tareas" value="<?php echo $tareas[0]['idtareas']; ?>"/>
                  <input type="hidden" name="flag-tareas" id="flag-tareas" value="0"/>
                  <button type="button" class="btn btn-success" id="saveCriterios">Guardar</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-heading">
          <div class="panel-title">
            Acciones
          </div>
        </div>
        <div class="panel-body">
          <p><button type="button" id="preview-tarea" tarea="<?php echo $tareas[0]['idtareas']; ?>" class="btn btn-warning">Vistaprevia</button>&nbsp;&nbsp;<button id="create-tarea" tarea="<?php echo $tareas[0]['idtareas']; ?>" class="btn btn-success">Ejecutar</button></p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-heading">
          <div class="panel-title">
            Criterios Creados
          </div>
        </div>
        <div class="panel-body">
          <div id="criterios-table-result" class="col-lg-12">
            <table class="table data-table table-bordered">
              <thead>
                <tr>
                  <th>Campo</th>
                  <th>Operador</th>
                  <th>Valor</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($condiciones as $con){ ?>
                <tr>
                  <td><?php echo $con['campo']; ?></td>
                  <td><?php echo $con['operador']; ?></td>
                  <td><?php echo $con['valor']; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
