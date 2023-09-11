<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 $dinamicFlag = 0;
?>


<input type="hidden" name="idAccionGlobal" id="idAccionGlobal" value="0"/>
<input type="hidden" name="telefonoGlobal" id="telefonoGlobal" value="0"/>
<input type="hidden" name="idContactoGlobal" id="idContactoGlobal" value="0"/>
<input type="hidden" name="idMotivosGlobal" id="idMotivosGlobal" value="0"/>
<input type="hidden" name="idResultadooGlobal" id="idResultadooGlobal" value="0"/>
<input type="hidden" name="idPredictivaGlobal" id="idPredictivaGlobal" value="0"/>
<?php  foreach($dinamicos as $dina){ ?>
  <input type="hidden" name="dinamico<?php echo $dinamicFlag; ?>" id="dinamico<?php echo $dinamicFlag; ?>" value="<?php echo $dina['nombreCampo']; ?>"/>
<?php $dinamicFlag += 1; } ?>

<div id="prox-gestion">
   <div class="col-lg-6">
        <h5 style="font-weight: bold;">Proxima Gestion</h5>
        <div class="form-group">
          <label>Proxima accion:</label>
          <select class="form-control" id="prox-gest" name="prox-gest">
            <option value="0">Seleccione....</option>
            <?php foreach($proxima as $px){ ?>
              <option value="<?php echo $px['idProxima']; ?>"><?php echo $px['descripcion']; ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <label>Fecha proxima accion:</label>
          <input type="text" name="prox-gest-fec" id="prox-gest-fec" class="form-control"/>
        </div>
        <div id="prox-gest-dir-field" style="display: none;" class="form-group">
          <label>Direccion:</label>
          <select name="prox-gest-dir" id="prox-gest-dir" class="form-control">
            <option value="0">Seleccione...</option>
            <?php foreach ($direcciones as $dir2) { ?>
              <option value="<?php echo $dir2['direccion']; ?>"><?php echo $dir2['direccion']; ?></option>
            <?php } ?>
          </select>
        </div>
        <div id="prox-gest-phone-field" style="display: none;" class="form-group">
          <label>Telefono:</label>
          <select name="prox-gest-phone" id="prox-gest-phone" class="form-control">

          </select>
        </div>
        <div id="prox-gest-mail-field" style="display: none;" class="form-group">
          <label>Mail:</label>
          <select name="prox-gest-mail" id="prox-gest-mail" class="form-control">
            <option value="0">Seleccione...</option>
            <?php foreach ($correos as $corp) { ?>
              <option value="<?php echo $corp['email']; ?>"><?php echo $corp['email']; ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <button name="save-prx-gest" id="save-prx-gest" class="btn btn-success">Guardar</button>&nbsp;&nbsp;&nbsp;<button name="cancel-prx-gest" id="cancel-prx-gest" class="btn btn-danger">Cancelar</button>
        </div>
      </div>


      <div class="col-lg-6">
        <h5 style="font-weight: bold;">Sugerir Gestion</h5>
        <div class="form-group">
          <label>Accion Sugerida:</label>
          <select class="form-control" id="sug-gest" name="sug-gest">
            <option value="0">Seleccione....</option>
            <?php foreach($proxima as $px){ ?>
              <option value="<?php echo $px['idProxima']; ?>"><?php echo $px['descripcion']; ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <label>Fecha proxima accion:</label>
          <input type="text" name="sug-gest-fec" id="sug-gest-fec" class="form-control"/>
        </div>
        <div id="sug-gest-dir-field" style="display: none;" class="form-group">
          <label>Direccion:</label>
          <select name="sug-gest-dir" id="sug-gest-dir" class="form-control">
          </select>
        </div>
        <div id="sug-gest-phone-field" style="display: none;" class="form-group">
          <label>Telefono:</label>
          <select name="sug-gest-phone" id="sug-gest-phone" class="form-control">

          </select>
        </div>
        <div id="sug-gest-mail-field" style="display: none;" class="form-group">
          <label>Mail:</label>
          <select name="sug-gest-mail" id="sug-gest-mail" class="form-control">
          </select>
        </div>
        <div class="form-group">
          <button name="save-suge-gest" id="save-suge-gest" class="btn btn-success">Guardar Sugerencia</button>
        </div>
      </div>

</div>


<input type="hidden" name="totalDinamicos" id="totalDinamicos" value="<?php echo $dinamicFlag; ?>"/>

<div id="actionSelect-panel">
    <select name="actionSelect" id="actionSelect" class="form-control action-select">
        <option value="0">Seleccione una Accion...</option>
        <?php foreach ($accionesSelect as $acsel) { ?>
            <option value="<?php echo $acsel['idAccion']; ?>"><?php echo $acsel['descripcion']; ?></option>
        <?php } ?>
    </select>
</div>

<!--<ul id="actionPanel" class="actionPanel">
    <?php
    /*foreach ($accionesPanel as $acp) {
        $id = "";
        if ($acp['idAccion'] == 1) {
            $id = "sendCall3";
        } else if ($acp['idAccion'] == 3) {
            $id = "progCall3";
        }else if ($acp['idAccion'] == 4) {
            $id = "idDirecciones3";
        }else if ($acp['idAccion'] == 5) {
            $id = "idMailes3";
        }*/
        ?>
        <li id="<?php //echo $id; ?>" flag='<?php //echo $acp['idAccion']; ?>' title="<?php //echo $acp['descripcion']; ?>" data-placement="left"><i style="font-size: 32px;" class="<?php //echo $acp['icono']; ?>"></i></li>-->
    <?php // } ?>
<!--<li id="sendVisita"  title="Solicitar Visita" data-placement="left"><i style="font-size: 32px;" class="icon-home"></i></li>
<li id="sendEmail" title="Enviar Emails" data-placement="left"><i style="font-size: 32px;" class="icon-envelop"></i></li>-->
</ul>

<div class="panel panel-info" id="panelGestion">
    <div class="panel-heading">
        <div class="panel-title">Ingreso de Gestion <i style="float: right; cursor: pointer;" id="closeGestion" class="icon icon-cross2"></i></div>
    </div>
    <div class="panel-body" id="actions-content">
        <div class="addtelPanel" class="form-group" style="display: none;">
            <label class="control-label col-lg-4">Télefono: <span class="text-danger">*</span></label>
            <div class="col-lg-8">
                <input type="text" style="margin-bottom: 10px;" data-validation="number" maxlength="15" onkeypress='return ((event.charCode >= 48 && event.charCode <= 57) || event.charCode == 8)' class="form-control" name="telefono-nuevo" id="telefono-nuevo" required="required" placeholder="Ingrese solo números." aria-required="true" aria-invalid="true"/>
            </div>
            <div style="clear: both;"></div>
            <label class="control-label col-lg-4">Referencia Telefono: <span class="text-danger">*</span></label>
            <div class="col-lg-8">
              <input type="text" class="form-control" style="margin-bottom: 10px;" name="ciudadTel" id="ciudadTel">
            </div>
            <div style="clear: both;"></div>
            <button class="btn btn-success" id="saveNewTel" style="margin-left: 10px; margin-right: 10px;" type="button">Guardar</button>
            <button class="btn btn-danger" type="button" id="cancelarAddPhone">Cancelar</button>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th style="text-align: center;"><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/add.png" style="cursor: pointer;" id="addPhone" alt="Agregar" title="Agregar"/></th>
                    <th style="text-align: center;"><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/active.png" style="cursor: pointer;" class="img_selected" id="seeActivos" alt="Activos" title="Activos"/></th>
                    <th style="text-align: center;"><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/disbled.png" style="cursor: pointer;" alt="Inactivos" id="seeInactivos" title="inactivos"/></th>
                    <th style="text-align: center;"><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/incomingcall.png" style="cursor: pointer;" class="recivecall" alt="Recibir Llamada" title="Recibir Llamada"/></th>
                </tr>
                <tr class="bg-primary">
                    <th>Telefono</th>
                    <th>Informacion</th>
                    <th>Agregado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($telefonos as $tel) {
                    if ($tel['agregado'] == "1") {
                        $agregado = "Si";
                    } else {
                        $agregado = "No";
                    }
                    ?>
                    <tr id="selectTel" tel="<?php echo $tel['telefono']; ?>" idtel="<?php echo $tel['idTelefono']; ?>">
                        <td><a href="sip:<?php echo $tel['telefono']; ?>@172.16.0.3"><?php echo $tel['telefono']; ?></a></td>
                        <td><?php echo $tel['idCiudad']; ?></td>
                        <td><?php echo $agregado; ?></td>
                        <td><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/disbled.png" class="unactiveTel" tel="<?php echo $tel['telefono']; ?>" idtel="<?php echo $tel['idTelefono']; ?>" style="cursor: pointer;" alt="Desactivar" title="Desactivar"/>&nbsp;&nbsp;&nbsp;<img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/call.png" class="makecall" tel="<?php echo $tel['telefono']; ?>" idtel="<?php echo $tel['idTelefono']; ?>" style="cursor: pointer;" alt="Llamar" title="Llamar"/></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>


<!--<div class="panel panel-success" id="panelGestion-actions">
    <div class="panel-heading" >
        <div class="panel-title">Ingreso de Gestion</div>
    </div>
    <div class="panel-body" id="calificacion-panel">
        <div id='timer'>
            <div class="container2">
                <div id="hour">00</div>
                <div class="divider">:</div>
                <div id="minute">00</div>
                <div class="divider">:</div>
                <div id="second">00</div>
            </div>
        </div>
        <div style="clear: both; height: 5px;"></div>
        <select name="idContactGest" id="idContactGest" class="form-control">
            <option value="0">Contacto.</option>
        </select>
        <select name="idMotivosGest" style="display: none;" id="idMotivosGest" class="form-control">
            <option value="0">Motivos de no pago.</option>
            <?php //foreach ($motivos as $mot) { ?>
                <option value="<?php// echo $mot['idMotivo']; ?>"><?php //echo $mot['descripcion']; ?></option>
            <?php //} ?>
        </select>
        <select name="idResultadoGest" style="display: none;" id="idResultadoGest" class="form-control">
            <option value="0">Resultado.</option>
        </select>
        <table>
            <tr>
                <td><label>Fecha:</label></br><input type="text" readonly="readonly" name="fecha-acu" id="fecha-acu" style="display: none; margin-right: 4px;" class="form-control datepicker-here" data-language='en'/></td>
                <td><label>Valor:</label></br><input type="text" name="valor-acu" id="valor-acu" style="display: none;" class="form-control"/></td>
            </tr>
            <tr>
                <td><input type="text" name="txt-acu" id="txt-acu" style="display: none; margin-right: 4px;" class="form-control"/></td>
                <td></td>
            </tr>
        </table>
        <input type="hidden" name="validation" id="validation" value="0"/>
        <div id="preforma" style="clear: both; height: 70px;"></div>
        <div style="clear: both; height: 5px;"></div>
        <textarea name="memoGestion" id="memoGestion" style="height: 90px;" class="form-control"></textarea>

        <div style="clear: both; height: 5px;"></div>
        <table>
            <tr>
                <td><button class="btn btn-success btn-labeled" style="display: none;" id="save-gest-action" type="button"><b><i class="icon-floppy-disk"></i></b>Guardar</button></td>
                <td><button class="btn btn-danger btn-labeled" id="cancelGestion"  type="button"><b><i class="icon-cross2"></i></b>Volver</button></td>
            </tr>
        </table>
    </div>
</div>-->


<div class="panel panel-success" id="panelGestion-actions">
  <div class="gesttxt">
    <div id='timer'>
      <div class="container2">
        <div style="visibility: hidden;" id="hour">00</div>

        <div id="minute">00</div>
        <div class="divider">:</div>
        <div id="second">00</div>
      </div>
    </div>
    <input type="hidden" name="validation" id="validation" value="0"/>
    <div id="preforma" style="clear: both; height: 30px; line-height: 11px; color: #FFF; font-size: 10px;"></div>
    <div style="clear: both; height: 5px;"></div>
    <textarea name="memoGestion" id="memoGestion" style="height: 60%;" maxlength="2000"  class="form-control"></textarea>
  </div>
  <div class="gestactions">
    <div style="clear: both; height: 5px;"></div>
    <table style="width: 50%;">
      <tr>
        <td>
          <select name="idContactGest" id="idContactGest" class="form-control">
            <option value="0">Status.</option>
          </select>
        </td>
      </tr>
      <tr>
        <td>
        <select name="idMotivosGest" style="display: none; margin-top: 4px;" id="idMotivosGest" class="form-control">
          <option value="0">Motivos de no pago.</option>
          <?php foreach ($motivos as $mot) { ?>
          <option value="<?php echo $mot['idMotivo']; ?>"><?php echo $mot['descripcion']; ?></option>
          <?php } ?>
        </select>
      </td>
      </tr>
      <tr>
        <td>
          <select name="idResultadoGest" style="margin-top: 4px;" id="idResultadoGest" class="form-control">
            <option value="0">Logros.</option>
          </select>
        </td>
      </tr>
    </table>
    <div style="clear: both; height: 3px;"></div>
    <table>
      <tr>
        <td><button class="btn btn-success btn-labeled" style="display: none; margin-right: 5px;" id="save-gest-action" type="button"><b><i class="icon-floppy-disk"></i></b>Guardar</button></td>
        <td><button class="btn btn-danger btn-labeled" id="cancelGestion"  type="button"><b><i class="icon-cross2"></i></b>Volver</button></td>
      </tr>
    </table>

    <table id="complmento-table" style="width: 44%; float: right; top: 0px; position: absolute; right: 0px; display: none;">
      <tr>
        <td style="color: #FFF;">Obligacion:</td>
        <td style="color: #FFF;">Fecha:</td>
        <td style="color: #FFF;">Valor:</td>
      </tr>
      <?php
      $bandera = 0;
      foreach($creditos as $ohpr){
          $bandera += 1;
        ?>
      <tr>
        <td><input style="width: 90px; font-size: 8px;" type="text" name="obliga<?php echo $bandera; ?>" id="obliga<?php echo $bandera; ?>" value="<?php echo $ohpr['obligacion']; ?>" /></td>
        <td><input style="width: 80px; font-size: 10px;" type="text" name="fecha<?php echo $bandera; ?>" readonly="readonly" data-position='top left' data-autoclose='true' id="fecha<?php echo $bandera; ?>" /></td>
        <td><input style="width: 80px; font-size: 10px;" type="text" name="valor<?php echo $bandera; ?>" id="valor<?php echo $bandera; ?>" value="0" /></td>
      </tr>
    <?php  } ?>
    <input type="hidden" name="banderas" id="banderas" value="<?php echo $bandera; ?>"/>
    </table>

    <table id="complmento2-table" style="width: 44%; float: right; top: 0px; position: absolute; right: 0px; display: none;">
      <tr>
        <td style="color: #FFF;">Obligacion:</td>
        <td style="color: #FFF;">Fecha:</td>
        <td style="color: #FFF;">Valor:</td>
      </tr>
      <?php
      $bandera = 0;
      foreach($creditos as $ohpr){
          $bandera += 1;
        ?>
      <tr>
        <td><input style="width: 90px; font-size: 8px;" type="text" name="confirmobliga<?php echo $bandera; ?>" id="confirmobliga<?php echo $bandera; ?>" value="<?php echo $ohpr['obligacion']; ?>" /></td>
        <td><input style="width: 80px; font-size: 10px;" type="text" name="confirm<?php echo $bandera; ?>" readonly="readonly" data-position='top left' data-autoclose='true' id="confirm<?php echo $bandera; ?>" /></td>
        <td><input style="width: 80px; font-size: 10px;" type="text" name="confirmvalor<?php echo $bandera; ?>" id="confirmvalor<?php echo $bandera; ?>" value="0" /></td>
      </tr>
    <?php  } ?>
    <input type="hidden" name="banderas" id="banderas" value="<?php echo $bandera; ?>"/>
    </table>

  </div>
  <div class="dinamicFields">
    <table>
      <?php foreach($dinamicos as $din){
        $opti = explode(";", $din['contenido']);
        ?>
        <tr>
          <td><label style="color: #FFF;"><?php echo $din['nombreCampo']; ?></label></td>
        </tr>
      <tr>
        <td><select name="<?php echo $din['nombreCampo']; ?>" style="margin-top: 5px;" id="<?php echo $din['nombreCampo']; ?>" class="form-control">
        <option value="0">Seleccione...</option>
        <?php foreach($opti as $key => $value){  ?>
          <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
        <?php } ?>
        </select></td>
      </tr>
      <?php } ?>
    </table>

  </div>

</div>

<div class="panel panel-info" id="panelProgCall">
    <div class="panel-heading">
        <div class="panel-title">Programar LLamada <i style="float: right; cursor: pointer;" id="closeProgcall" class="icon icon-cross2"></i></div>
    </div>
    <div class="panel-body" id="actions-content">

        <table class="table table-hover">
            <thead>
                <tr class="bg-primary">
                    <th>Fecha y Hora de Programacion</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" readonly="readonly" name="fecha-prog" id="fecha-prog" style="margin-right: 4px; font-weight: bold; color: #000;" class="form-control datepicker-here" sty data-time-format="hh:ii" data-position="top left" data-timepicker="true" data-language='en'/></td>
                </tr>
                <tr>
                  <td><label>Hora Llamada</label></td>
                </tr>
                <tr>
                    <td><select class="form-control" name="horapr" id="horapr">
                          <option value="00">HH:MM</option>
                          <?php for($i = 5; $i <= 22; $i++){
                            for($m = 0; $m <= 59; $m++){
                            $valor = "";
                            $valorm = "";
                            if($i < 10){
                              $valor = "0".$i;
                            }else{
                              $valor = $i;
                            }

                            if($m < 10){
                              $valorm = "0".$m;
                            }else{
                              $valorm = $m;
                            }
                            ?>
                            <option value="<?php echo $valor.":".$valorm; ?>"><?php echo $valor.":".$valorm; ?></option>
                          <?php } } ?>
                        </select></td>
                </tr>
                <tr>
                    <td><button class="btn btn-success btn-labeled" id="save-porg-call" type="button"><b><i class="icon-floppy-disk"></i></b>Programar</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<div class="panel panel-info" id="panelDireccion">
    <div class="panel-heading">
        <div class="panel-title">Direcciones <i style="float: right; cursor: pointer;" id="closeDirpanel" class="icon icon-cross2"></i></div>
    </div>
    <div class="panel-body" id="actions-dir-content">
        <div class="adddirPanel" class="form-group" style="display: none;">
            <label class="control-label col-lg-4">Direccion: <span class="text-danger">*</span></label>
            <div class="col-lg-8">
                <input type="text" style="margin-bottom: 10px;" class="form-control" name="direccion-nuevo" id="direccion-nuevo" required="required"/>
            </div>
            <div style="clear: both;"></div>
            <label class="control-label col-lg-4">Colonia:</label>
            <div class="col-lg-8">
                <input type="text" style="margin-bottom: 10px;" class="form-control" name="colonia-nuevo" id="colonia-nuevo" required="required"/>
            </div>
            <div style="clear: both;"></div>
            <label class="control-label col-lg-4">Municipio:</label>
            <div class="col-lg-8">
                <input type="text" style="margin-bottom: 10px;" class="form-control" name="municipio-nuevo" id="municipio-nuevo" required="required"/>
            </div>
            <div style="clear: both;"></div>
            <label class="control-label col-lg-4">Departamento:</label>
            <div class="col-lg-8">
                <input type="text" style="margin-bottom: 10px;" class="form-control" name="departamento-nuevo" id="departamento-nuevo" required="required"/>
            </div>
            <div style="clear: both;"></div>
            <label class="control-label col-lg-4">Zona:</label>
            <div class="col-lg-8">
                <input type="text" style="margin-bottom: 10px;" class="form-control" name="zona-nuevo" id="zona-nuevo" required="required"/>
            </div>
            <div style="clear: both;"></div>
            <label class="control-label col-lg-4">Tipo direccion:</label>
            <div class="col-lg-8">
              <select name="tipoDomi-nuevo" id="tipoDomi-nuevo" class="form-control">
                <option value="0">Seleccione...</option>
                <?php foreach ($tipodir as $tdir) { ?>
                <option value="<?php echo $tdir['idTipodomicilio']; ?>"><?php echo $tdir['descripcion']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div style="clear: both;"></div>
            <button class="btn btn-success" id="saveNewDir" style="margin-left: 10px; margin-right: 10px;" type="button">Guardar</button>
            <button class="btn btn-danger" type="button" id="cancelarAddDir">Cancelar</button>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th style="text-align: center;"><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/add.png" style="cursor: pointer;" id="addDir" alt="Agregar" title="Agregar"/></th>
                    <th style="text-align: center;"><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/active.png" style="cursor: pointer;" class="img_selected" id="seeActivos-dir" a-dirlt="Activos" title="Activos"/></th>
                    <th style="text-align: center;"><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/disbled.png" style="cursor: pointer;" alt="Inactivos" id="seeInactivos-dir" title="inactivos"/></th>
                </tr>
                <tr class="bg-primary">
                    <th>Direccion</th>
                    <th>Colonia</th>
                    <th>Municipio</th>
                    <th>Departamento</th>
                    <th>Zona</th>
                    <th>Tipo Domicilio</th>
                    <th>Agregado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($direcciones as $dir) {
                    if ($dir['agregado'] == "1") {
                        $agregado = "Si";
                    } else {
                        $agregado = "No";
                    }
                    ?>
                    <tr class="dirAction"  dir="<?php echo $dir['direccion']; ?>" iddir="<?php echo $dir['idDireccion']; ?>">
                        <td style="cursor: pointer;"><p style="font-size: 9px;"><?php echo $dir['direccion']; ?></p></td>
                        <td><p style="font-size: 9px;"><?php echo $dir['barrio']; ?></p></td>
                        <td><p style="font-size: 9px;"><?php echo $dir['municipio']; ?></p></td>
                        <td><p style="font-size: 9px;"><?php echo $dir['departamento']; ?></p></td>
                        <td><p style="font-size: 9px;"><?php echo $dir['zona']; ?></p></td>
                        <td><p style="font-size: 9px;"><?php echo $dir['tipoDomicilio']; ?></p></td>
                        <td><p style="font-size: 9px;"><?php echo $agregado; ?></p></td>
                        <td><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/disbled.png" class="unactiveDir" dir="<?php echo $dir['direccion']; ?>" iddir="<?php echo $dir['idDireccion']; ?>" style="cursor: pointer;" alt="Desactivar" title="Desactivar"/></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div class="panel panel-info" id="panelCorreos">
    <div class="panel-heading">
        <div class="panel-title">Correos <i style="float: right; cursor: pointer;" id="closeMailpanel" class="icon icon-cross2"></i></div>
    </div>
    <div class="panel-body" id="actions-mail-content">
        <div class="addmailPanel" class="form-group" style="display: none;">
            <label class="control-label col-lg-4">Correo: <span class="text-danger">*</span></label>
            <div class="col-lg-8">
                <input type="text" style="margin-bottom: 10px;" class="form-control" name="mail-nuevo" id="mail-nuevo" required="required"/>
            </div>
            <div style="clear: both;"></div>
            <button class="btn btn-success" id="saveNewMail" style="margin-left: 10px; margin-right: 10px;" type="button">Guardar</button>
            <button class="btn btn-danger" type="button" id="cancelarAddMail">Cancelar</button>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th style="text-align: center;"><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/add.png" style="cursor: pointer;" id="addMail" alt="Agregar" title="Agregar"/></th>
                    <th style="text-align: center;"><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/active.png" style="cursor: pointer;" class="img_selected" id="seeActivos-mail" a-dirlt="Activos" title="Activos"/></th>
                    <th style="text-align: center;"><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/disbled.png" style="cursor: pointer;" alt="Inactivos" id="seeInactivos-mail" title="inactivos"/></th>
                </tr>
                <tr class="bg-primary">
                    <th>E-Mail</th>
                    <th>Agregado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($correos as $corr) {
                    if ($corr['agregado'] == "1") {
                        $agregado = "Si";
                    } else {
                        $agregado = "No";
                    }
                    ?>
                    <tr class="mailAction" dir="<?php echo $corr['email']; ?>" idmail="<?php echo $corr['idEmail']; ?>">
                        <td style="cursor: pointer;"><?php echo $corr['email']; ?></td>
                        <td><?php echo $agregado; ?></td>
                        <td><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/disbled.png" class="unactiveMail" mail="<?php echo $corr['email']; ?>" iddir="<?php echo $corr['idEmail']; ?>" style="cursor: pointer;" alt="Desactivar" title="Desactivar"/></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
