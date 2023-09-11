<?php
/* * To change this template, choose Tools | Templates * and open the template in the editor. */
$ci2 = &get_instance();
//$us = $ci3->load->model("usuarios");
//$ci2 = &get_instance();
$ci2->load->model("vista");

$carteras = explode(";", $session['carteras']);
?>
<section class="main-container">
  <!-- Page header -->
  <div class="header">
    <div class="header-content">
      <div class="page-title">
        <i class="icon-file-empty position-left"></i> Campos adicionales del proyecto - <?php echo $slug; ?>
      </div>
    </div>
  </div>
  <!-- /Page header -->

  <div class="container-fluid page-content">

    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <div class="panel-title">Imagen de <?php echo $slug; ?></div>
          </div>
          <div class="panel-body">
            <form enctype="multipart/form-data" name="imgPry" id="imgPry" action="http://<?php echo $this->config->item('host_cobranzas'); ?>/index.php/admin/uploadimg" method="post">
              <img src="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/img/<?php echo $datos[0]['imagen']; ?>" alt="proyecto" title="proyecto" style="width: 200px;"/>
              <div class="form-group">
                <label>Imagen Proyecto:</label>
                <input type="file" name="userfile" id="userfile" class="form-control"/>
                <input type="hidden" name="proyectoA" id="proyectoA" value="<?php echo $slug; ?>"/>
              </div>
              <div class="form-group">
                <button class="btn btn-success" type="submit">Cargar Imagen</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <div class="panel-title">Campos adicionales de <?php echo $slug; ?></div>
          </div>
          <div class="panel-body">

            <div class="form-group">
              <label>Meta Proyecto:</label>
              <input type="text" name="metaPr" id="metaPr" class="form-control" value="<?php echo $datos[0]['meta']; ?>"/>
            </div>
            <div class="form-group">
              <label>Coordinador:</label>
              <select name="idCoordinador" id="idCoordinador" class="form-control">
                <option value="0">Seleccione...</option>
                <?php foreach($usuarios as $us){
                  $clase = '';
                  if($us['idUsuario'] == $datos[0]['idCoordinador']){
                    $clase = "selected";
                  }
                  ?>
                  <option <?php echo $clase; ?> value="<?php echo $us['idUsuario']; ?>"><?php echo $us['nombre']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label>Campo Saldo:</label>
              <select name="campoSaldo" id="campoSaldo" class="form-control">
                <option value="0">Seleccione...</option>
                <?php foreach($campos as $camp){
                  $clase2 = '';
                  if($camp['Field'] == $datos[0]['campoSaldo']){
                    $clase2 = "selected";
                  }
                  ?>
                  <option <?php echo $clase2; ?> value="<?php echo $camp['Field']; ?>"><?php echo $camp['Field']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label>Campo Producto:</label>
              <select name="campoProducto" id="campoProducto" class="form-control">
                <option value="0">Seleccione...</option>
                <?php foreach($creditos as $cre){
                  $clase2 = '';
                  if($cre['Field'] == $datos[0]['campoProducto']){
                    $clase2 = "selected";
                  }
                  ?>
                  <option <?php echo $clase2; ?> value="<?php echo $cre['Field']; ?>"><?php echo $cre['Field']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label>Correos Electronicos (Separados por comma ( , ) ):</label>
              <textarea class="form-control" name="emails" id="emails"><?php echo $datos[0]['campoEmails']; ?></textarea>
            </div>
            <div class="form-group">
              <label>Campo DUI:</label>
              <select name="campoDUI" id="campoDUI" class="form-control">
                <option value="0">Seleccione...</option>
                <?php foreach($creditos as $cre){
                  $clase2 = '';
                  if($cre['Field'] == $datos[0]['campoDUI']){
                    $clase2 = "selected";
                  }
                  ?>
                  <option <?php echo $clase2; ?> value="<?php echo $cre['Field']; ?>"><?php echo $cre['Field']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label>Campo NIT:</label>
              <select name="campoNit" id="campoNit" class="form-control">
                <option value="0">Seleccione...</option>
                <?php foreach($creditos as $cre){
                  $clase2 = '';
                  if($cre['Field'] == $datos[0]['campoNit']){
                    $clase2 = "selected";
                  }
                  ?>
                  <option <?php echo $clase2; ?> value="<?php echo $cre['Field']; ?>"><?php echo $cre['Field']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label>Campo Salario:</label>
              <select name="campoSalario" id="campoSalario" class="form-control">
                <option value="0">Seleccione...</option>
                <?php foreach($creditos as $cre){
                  $clase2 = '';
                  if($cre['Field'] == $datos[0]['salario']){
                    $clase2 = "selected";
                  }
                  ?>
                  <option <?php echo $clase2; ?> value="<?php echo $cre['Field']; ?>"><?php echo $cre['Field']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label>Campo Empresa:</label>
              <select name="campoEmpresa" id="campoEmpresa" class="form-control">
                <option value="0">Seleccione...</option>
                <?php foreach($creditos as $cre){
                  $clase2 = '';
                  if($cre['Field'] == $datos[0]['empresa']){
                    $clase2 = "selected";
                  }
                  ?>
                  <option <?php echo $clase2; ?> value="<?php echo $cre['Field']; ?>"><?php echo $cre['Field']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label>Campo Saldo En Mora:</label>
              <select name="campoSaldoenMora" id="campoSaldoenMora" class="form-control">
                <option value="0">Seleccione...</option>
                <?php foreach($creditos as $cre){
                  $clase2 = '';
                  if($cre['Field'] == $datos[0]['saldoenmora']){
                    $clase2 = "selected";
                  }
                  ?>
                  <option <?php echo $clase2; ?> value="<?php echo $cre['Field']; ?>"><?php echo $cre['Field']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label>Campo Saldo Capital:</label>
              <select name="campoSaldoCapital" id="campoSaldoCapital" class="form-control">
                <option value="0">Seleccione...</option>
                <?php foreach($creditos as $cre){
                  $clase2 = '';
                  if($cre['Field'] == $datos[0]['saldocapital']){
                    $clase2 = "selected";
                  }
                  ?>
                  <option <?php echo $clase2; ?> value="<?php echo $cre['Field']; ?>"><?php echo $cre['Field']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label>Campo Fecha Otorgamiento:</label>
              <select name="campoFechaOtorgamiento" id="campoFechaOtorgamiento" class="form-control">
                <option value="0">Seleccione...</option>
                <?php foreach($creditos as $cre){
                  $clase2 = '';
                  if($cre['Field'] == $datos[0]['fechaotorgamiento']){
                    $clase2 = "selected";
                  }
                  ?>
                  <option <?php echo $clase2; ?> value="<?php echo $cre['Field']; ?>"><?php echo $cre['Field']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label>Campo Fecha Separacion:</label>
              <select name="campoFechaSeparacion" id="campoFechaSeparacion" class="form-control">
                <option value="0">Seleccione...</option>
                <?php foreach($creditos as $cre){
                  $clase2 = '';
                  if($cre['Field'] == $datos[0]['fechaseparacion']){
                    $clase2 = "selected";
                  }
                  ?>
                  <option <?php echo $clase2; ?> value="<?php echo $cre['Field']; ?>"><?php echo $cre['Field']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label>Campo FUP:</label>
              <select name="campoFUP" id="campoFUP" class="form-control">
                <option value="0">Seleccione...</option>
                <?php foreach($creditos as $cre){
                  $clase2 = '';
                  if($cre['Field'] == $datos[0]['fup']){
                    $clase2 = "selected";
                  }
                  ?>
                  <option <?php echo $clase2; ?> value="<?php echo $cre['Field']; ?>"><?php echo $cre['Field']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label>Campo VUP:</label>
              <select name="campoVUP" id="campoVUP" class="form-control">
                <option value="0">Seleccione...</option>
                <?php foreach($creditos as $cre){
                  $clase2 = '';
                  if($cre['Field'] == $datos[0]['vup']){
                    $clase2 = "selected";
                  }
                  ?>
                  <option <?php echo $clase2; ?> value="<?php echo $cre['Field']; ?>"><?php echo $cre['Field']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label>Variable 1:</label>
              <select name="campoVariable1" id="campoVariable1" class="form-control">
                <option value="0">Seleccione...</option>
                <?php foreach($creditos as $cre){
                  $clase2 = '';
                  if($cre['Field'] == $datos[0]['variable1']){
                    $clase2 = "selected";
                  }
                  ?>
                  <option <?php echo $clase2; ?> value="<?php echo $cre['Field']; ?>"><?php echo $cre['Field']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label>Variable 2:</label>
              <select name="campoVariable2" id="campoVariable2" class="form-control">
                <option value="0">Seleccione...</option>
                <?php foreach($creditos as $cre){
                  $clase2 = '';
                  if($cre['Field'] == $datos[0]['variable2']){
                    $clase2 = "selected";
                  }
                  ?>
                  <option <?php echo $clase2; ?> value="<?php echo $cre['Field']; ?>"><?php echo $cre['Field']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label>Variable 3:</label>
              <select name="campoVariable3" id="campoVariable3" class="form-control">
                <option value="0">Seleccione...</option>
                <?php foreach($creditos as $cre){
                  $clase2 = '';
                  if($cre['Field'] == $datos[0]['variable3']){
                    $clase2 = "selected";
                  }
                  ?>
                  <option <?php echo $clase2; ?> value="<?php echo $cre['Field']; ?>"><?php echo $cre['Field']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label>Variable 4:</label>
              <select name="campoVariable4" id="campoVariable4" class="form-control">
                <option value="0">Seleccione...</option>
                <?php foreach($creditos as $cre){
                  $clase2 = '';
                  if($cre['Field'] == $datos[0]['variable4']){
                    $clase2 = "selected";
                  }
                  ?>
                  <option <?php echo $clase2; ?> value="<?php echo $cre['Field']; ?>"><?php echo $cre['Field']; ?></option>
                <?php } ?>
              </select>
            </div>

            <div class="form-group">
              <input type="hidden" name="proyecto" id="proyecto" value="<?php echo $slug; ?>"/>
              <button name="saveAdicional" id="saveAdicional" class="btn btn-success">Guardar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
