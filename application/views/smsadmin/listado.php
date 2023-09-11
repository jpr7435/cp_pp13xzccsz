<?php
/* * To change this template, choose Tools | Templates * and open the template in the editor. */
$ci2 = &get_instance();
//$us = $ci3->load->model("usuarios");
//$ci2 = &get_instance();
$ci2->load->model("vista");

$fila = 0;
$pr = 0;
?>

<section class="main-container">
  <h1 style="display:none">Listado de sms - <?php echo $session['proyecto_activo']; ?></h1>

  <!-- Page header -->
  <div class="header">
    <div class="header-content">
      <div class="page-title">
        <i class="icon-file-empty position-left"></i> Administracion de sms - <?php echo $session['proyecto_activo']; ?>
      </div>
    </div>
  </div>
  <!-- /Page header -->

  <div class="container-fluid page-content">
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-heading">
          <div class="panel-title">
            SMS Disponible
          </div>
        </div>
        <div class="panel-body">
          <div style="margin-bottom: 15px;" class="col-lg-12">
            <a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/agregarsmsadmin" style="margin-bottom: 10px;"><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/add.png" alt="Agregar" title="Agregar"/>&nbsp;&nbsp;&nbsp;AGREGAR SMS</a>
          </div>
          <div class="col-lg-12">
            <table style="width: 100%;" class="table data-table table-bordered">
              <tr>
                <th>Nombre</th>
                <th>Peridiocidad</th>
                <th>Fecha Creacion</th>
                <th>Hora</th>
                <th>Campana</th>
                <th>Accion</th>
              </tr>
              <?php foreach($sms as $t){
                $campana = $ci2->vista->getCampanaUno($t['campana']);

                if(!isset($campana[0]['campana'])){
                  $campana[0]['campana'] = "Sin Campana";
                }
                 ?>
                <tr>
                  <td><?php echo $t['nombre']; ?></td>
                  <td><?php echo $t['peridiocidad']; ?></td>
                  <td><?php echo $t['fechacreacion']; ?></td>
                  <td><?php echo $t['hora']; ?></td>
                  <td><?php echo $campana[0]['campana']; ?></td>
                  <td>
                    <a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/editarsmsadmin/<?php echo $t['idtareas']; ?>"><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/edit.png" alt="Editar" title="Editar"/></a>&nbsp;&nbsp;&nbsp;
                    <a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/eliminartareasadmin"><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/delete.png" alt="Borrar" title="Borrar"/></a>
                  </td>
                </tr>
              <?php } ?>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div style="clear: both; height: 25px;"></div>
  </div>
</section>
