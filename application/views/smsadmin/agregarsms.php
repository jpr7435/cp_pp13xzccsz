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
        <i class="icon-file-empty position-left"></i> Nueva  sms - <?php echo $session['proyecto_activo']; ?>
      </div>
    </div>
  </div>
  <!-- /Page header -->

  <div class="container-fluid page-content">
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">
          <div class="col-lg-12">
            <form class="col-md-7" id="create-tarea-form"  action="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/savesmsadmin" method="post">
              <div class="form-group">
                <label>Nombre SMS:</label>
                <input type="text" name="nombretarea" id="nombretarea" class="form-control"/>
              </div>
              <div class="form-group">
                <label>Prioridad SMS:</label>
                <select name="prioridadtarea" id="prioridadtarea" class="form-control">
                  <option value="6666">Seleccione...</option>
                  <option value="0">Al Inicio...</option>
                  <?php foreach($sms as $tar){ ?>
                  <option value="<?php echo $tar['prioridad']; ?>">Despues de <?php echo $tar['nombre']; ?></option>
                  <?php } ?>
                  <option value="999">Al Final...</option>
                </select>
              </div>
              <div class="form-group">
                <label>Peridiocidad:</label>
                </br>
                <input type="checkbox" name="dias[]" value="Lunes"/>&nbsp;&nbsp;&nbsp;Lunes</br>
                <input type="checkbox" name="dias[]" value="Martes"/>&nbsp;&nbsp;&nbsp;Martes</br>
                <input type="checkbox" name="dias[]" value="Miercoles"/>&nbsp;&nbsp;&nbsp;Miercoles</br>
                <input type="checkbox" name="dias[]" value="Jueves"/>&nbsp;&nbsp;&nbsp;Jueves</br>
                <input type="checkbox" name="dias[]" value="Viernes"/>&nbsp;&nbsp;&nbsp;Viernes</br>
                <input type="checkbox" name="dias[]" value="Sabado"/>&nbsp;&nbsp;&nbsp;Sabado</br>
                <input type="checkbox" name="dias[]" value="Domingo"/>&nbsp;&nbsp;&nbsp;Domingo</br>
              </div>
              <div class="form-group">
                <label>Hora:</label>
                </br>
                <select id="hora-sms" name="hora-sms" class="form-control col-4">
                  <option value="0">Seleccione...</option>
                  <option value="8">8 AM</option>
                  <option value="9">9 AM</option>
                  <option value="10">10 AM</option>
                  <option value="11">11 AM</option>
                  <option value="12">12 PM</option>
                  <option value="13">1 PM</option>
                  <option value="14">2 PM</option>
                  <option value="15">3 PM</option>
                  <option value="16">4 PM</option>
                  <option value="17">5 PM</option>
                  <option value="18">6 PM</option>
                  <option value="19">7 PM</option>
                  <option value="20">8 PM</option>
                </select>
              </div>
              <div class="form-group">
                <label>Campa&ntilde;a:</label>
                </br>
                <select id="campana-sms" name="campana-sms" class="form-control">
                  <option value="0">Seleccione...</option>
                  <?php foreach($campanas as $camp){ ?>
                    <option value="<?php echo $camp['idCampana']; ?>"><?php echo $camp['campana']; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <button type="button" id="guardar-tarea" class="btn btn-success">Guardar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
