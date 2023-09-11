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
        <i class="icon-file-empty position-left"></i> Listado de Visitas - <?php echo $session['proyecto_activo']; ?>
      </div>
    </div>
  </div>

  <div class="container-fluid page-content">

    <div style="clear: both; height: 25px;"></div>

    <div class="panel panel-flat">
      <div class="panel-body">

        <div class="tabbable">
          <ul class="nav nav-tabs nav-tabs-highlight nav-justified">
            <li class="active">
              <a href="#pendientes" data-toggle="tab">Pendientes</a>
            </li>
            <li>
              <a href="#proceso" data-toggle="tab">En proceso</a>
            </li>
            <li>
              <a href="#realizadas" data-toggle="tab">Realizadas</a>
            </li>
          </ul>
          <div class="tab-content">
            <div id="pendientes" class="tab-pane active">
              <form name="generaVisita" id="generaVisita" method="post" action="http://<?php echo $this->config->item('host_cobranzas'); ?>/index.php/generavisitasfile">
                <input type="hidden" name="metodo" id="metodo" value="0" />
                <div class="col-sm-2">
                  <button type="button" style="margin-top: 30px;" id="generaVisitasFileBtn" class="btn btn-success">Generar Archivo</button>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Fecha de Visitas:</label>
                    <input type="text" name="fechaIni" id="fechaIni" class="form-control datepicker-here" data-language='en' />
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Usuario asignado:</label>
                    <select name="visitador" id="visitador" class="form-control">
                      <option value="0">Seleccione...</option>
                      <?php foreach($usuarios as $us){ ?>
                        <option value="<?php echo $us['idUsuario']; ?>"><?php echo $us['nombre']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-2">
                  <button type="button" style="margin-top: 30px;" id="enviarVisitasFileBtn" class="btn btn-danger">Enviar Archivo Automatico</button>
                </div>
                <div style="clear: both; height: 10px;"></div>
                <table class="table table-bordered table-hover table-xxs table-responsive">
                  <thead>
                    <tr>
                      <th>Generar</th>
                      <th>Documento</th>
                      <th>Direccion</th>
                      <th>Departamento</th>
                      <th>Municipio</th>
                      <th>Colonia</th>
                      <th>Comentario</th>
                      <th>Fecha Solicitud</th>
                      <th>Asesor</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($listado as $li){ ?>
                      <tr>
                        <td><input type="checkbox" class="checkvisitas" name="generar[]" id="generar" value="<?php echo $li['idVisitas']; ?>" /></td>
                        <td><?php echo $li['documento']; ?></td>
                        <td><?php echo $li['direccion']; ?></td>
                        <td><?php echo $li['departamento']; ?></td>
                        <td><?php echo $li['municipio']; ?></td>
                        <td><?php echo $li['colonia']; ?></td>
                        <td><?php echo $li['comentario']; ?></td>
                        <td><?php echo $li['fechaPreliminar']; ?></td>
                        <td><?php echo $li['idAsesor']; ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </form>
            </div>
            <div id="proceso" class="tab-pane">
              dos
            </div>
            <div id="realizadas" class="tab-pane">
              tres
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
