<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$dinamicFlag = 0;
?>

<input type="hidden" name="proyectoActivo" id="proyectoActivo" value="<?php echo $session['proyecto_activo']; ?>"/>
<input type="hidden" name="idAccionGlobal" id="idAccionGlobal" value="0"/>
<input type="hidden" name="telefonoGlobal" id="telefonoGlobal" value="0"/>
<input type="hidden" name="idContactoGlobal" id="idContactoGlobal" value="0"/>
<input type="hidden" name="idMotivosGlobal" id="idMotivosGlobal" value="0"/>
<input type="hidden" name="idActividadGlobal" id="idActividadGlobal" value="0"/>
<input type="hidden" name="idResultadooGlobal" id="idResultadooGlobal" value="0"/>
<input type="hidden" name="idFechaValor" id="idFechaValor" value="0"/>
<input type="hidden" name="idValorValor" id="idValorValor" value="0"/>

<?php foreach ($dinamicos as $dina) { ?>
    <input type="hidden" name="dinamico<?php echo $dinamicFlag; ?>" id="dinamico<?php echo $dinamicFlag; ?>" value="<?php echo $dina['nombreCampo']; ?>"/>
    <?php $dinamicFlag += 1;
} ?>

<div id="actionSelect-panel">
    <a style="position: absolute; right: 5px; top: 1px; font-weight: bold;" id="cerrarSelect">Cerrar</a>
    <select name="actionSelect" id="actionSelect" class="form-control action-select">
        <option value="0">Seleccione una Accion...</option>
        <?php foreach ($accionesSelect as $acsel) { ?>
            <option value="<?php echo $acsel['idAccion']; ?>"><?php echo $acsel['descripcion']; ?></option>
<?php } ?>
    </select>
</div>

<ul id="actionPanel" class="actionPanel">
    <?php
    foreach ($accionesPanel as $acp) {
        $id = "";
        if ($acp['idAccion'] == 1) {
            $id = "sendCall";
        } else if ($acp['idAccion'] == 3) {
            $id = "progCall";
        }else if ($acp['idAccion'] == 4) {
            $id = "idDirecciones";
        }else if ($acp['idAccion'] == 5) {
            $id = "idMailes";
        }
        ?>
        <li id="<?php echo $id; ?>" flag='<?php echo $acp['idAccion']; ?>' title="<?php echo $acp['descripcion']; ?>" data-placement="left"><i style="font-size: 32px;" class="<?php echo $acp['icono']; ?>"></i></li>
    <?php } ?>
    <li id="idOthers" flag='666' title="mas" data-placement="left"><i style="font-size: 32px;" class="icon icon-plus22"></i></li>
<!--<li id="sendVisita"  title="Solicitar Visita" data-placement="left"><i style="font-size: 32px;" class="icon-home"></i></li>
<li id="sendEmail" title="Enviar Emails" data-placement="left"><i style="font-size: 32px;" class="icon-envelop"></i></li>-->
</ul>

<div class="panel panel-info" id="panelGestion">
    <div class="panel-heading">
        <div class="panel-title">Ingreso de Gestion</div>
    </div>
    <div class="panel-body" id="actions-content">
        <div class="addtelPanel" class="form-group" style="display: none;">
            <label class="control-label col-lg-4">Télefono: <span class="text-danger">*</span></label>
            <div class="col-lg-8">
                <input type="text" style="margin-bottom: 10px;" data-validation="number" maxlength="15" onkeypress='return ((event.charCode >= 48 && event.charCode <= 57) || event.charCode == 8)' class="form-control" name="telefono-nuevo" id="telefono-nuevo" required="required" placeholder="Ingrese solo números." aria-required="true" aria-invalid="true"/>
            </div>
            <div style="clear: both;"></div>
            <label class="control-label col-lg-4">Ciudad: <span class="text-danger">*</span></label>
            <div class="col-lg-8">
              <select class="form-control" style="margin-bottom: 10px;" name="ciudadTel" id="ciudadTel">
                  <option value='0'>Seleccione..</option>
                  <?php foreach($ciudades as $ciu){ ?>
                    <option value="<?php echo $ciu['ciudad']; ?>"><?php echo $ciu['ciudad']; ?></option>
                  <?php } ?>
              </select>
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
                    <th>Ciudad</th>
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
                        <td><a href="sip:<?php echo $tel['telefono']; ?>@172.16.0.3"><?php echo "XXXX".substr($tel['telefono'], -3); ?></a></td>
                        <td><?php echo $tel['idCiudad']; ?></td>
                        <td><?php echo $agregado; ?></td>
                        <td><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/disbled.png" class="unactiveTel" tel="<?php echo $tel['telefono']; ?>" idtel="<?php echo $tel['idTelefono']; ?>" style="cursor: pointer;" alt="Desactivar" title="Desactivar"/>&nbsp;&nbsp;&nbsp;<img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/call.png" class="makecall" tel="<?php echo $tel['telefono']; ?>" idtel="<?php echo $tel['idTelefono']; ?>" style="cursor: pointer;" alt="Llamar" title="Llamar"/>&nbsp;&nbsp;&nbsp;<i style="cursor: pointer;" id="sendSMS" class="icon icon-bubbles2"></i></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
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
            <option value="0">Contacto.</option>
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
          <select name="idActividad" style="display: none; margin-top: 4px;" id="idActividad" class="form-control">
          <option value="0">Actividad Economica.</option>
          <?php foreach ($actividades as $activ) { ?>
          <option value="<?php echo $activ['homologacion']; ?>"><?php echo $activ['actividad']; ?></option>
          <?php } ?>
        </select>
      </td>
      </tr>
      <tr>
        <td>
          <select name="idResultadoGest" style="margin-top: 4px;" id="idResultadoGest" class="form-control">
            <option value="0">Resultado.</option>
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
        <td><input style="width: 80px; font-size: 10px;" type="text" name="fecha<?php echo $bandera; ?>" readonly="readonly" class="datepicker-here" data-language='en' data-position='top left' data-autoclose='true' id="fecha<?php echo $bandera; ?>" /></td>
        <td><input style="width: 80px; font-size: 10px;" type="text" name="valor<?php echo $bandera; ?>" id="valor<?php echo $bandera; ?>" value="0" /></td>
      </tr>
    <?php  } ?>
    <input type="hidden" name="banderas" id="banderas" value="<?php echo $bandera; ?>"/>
    </table>

    <table id="complmento2-table" style="width: 44%; float: right; top: 0px; position: absolute; right: 0px; display: none;">
      <tr>
        <td style="color: #FFF;">Obligacion:</td>
        <td style="color: #FFF;">Meses Gracia:</td>
        <td style="color: #FFF;">Plazo Diferir:</td>
      </tr>
      <?php
      $bandera = 0;
      foreach($creditos as $ohpr){
          $bandera += 1;
          $limite = 0;
          $gracia = 0;

          if($session['proyecto_activo'] == "bbva_especial"){
            $pl = $this->vista->getplazos($ohpr['linea'], $session['proyecto_activo']);
            if(isset($pl[0]['plazomaximo'])){
              $limite = $pl[0]['plazomaximo'];
            }

            if(isset($pl[0]['gracia'])){
              if($pl[0]['linea'] == "LIBRE INVERSION" || $pl[0]['linea'] == "VEHICULO"){
                if($ohpr['saldo_total'] > 30000000){
                  $gracia = 6;
                }else{
                  $gracia = $pl[0]['gracia'];
                }
              }else{
                $gracia = $pl[0]['gracia'];
              }
            }
          }



        ?>
      <tr>
        <td><input style="width: 90px; font-size: 8px;" type="text" name="obliga2<?php echo $bandera; ?>" id="obliga2<?php echo $bandera; ?>" value="<?php echo $ohpr['obligacion']; ?>" /></td>
        <td><select style="width: 80px; font-size: 10px;" type="text" name="fecha2<?php echo $bandera; ?>" id="fecha2<?php echo $bandera; ?>">
              <?php for($i = 0; $i <= $gracia; $i++){ ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
              <?php } ?>
            </select></td>
        <td><select style="width: 80px; font-size: 10px;" type="text" name="valor2<?php echo $bandera; ?>" id="valor2<?php echo $bandera; ?>">
          <?php for($i = 0; $i <= $limite; $i++){ ?>
            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
          <?php } ?>
            </select></td>
      </tr>
    <?php  } ?>
    <input type="hidden" name="banderas" id="banderas" value="<?php echo $bandera; ?>"/>
    </table>



<input type="hidden" name="totalDinamicos" id="totalDinamicos" value="<?php echo $dinamicFlag; ?>"/>
<div class="dinamicFields">
    <table>
        <?php
        foreach ($dinamicos as $din) {
            $opti = explode(";", $din['contenido']);
            ?>
            <tr>
                <td><label style="color: #FFF;"><?php echo $din['nombreCampo']; ?></label></td>
            </tr>
            <tr>
                <td><select name="<?php echo $din['nombreCampo']; ?>" style="margin-top: 5px;" id="<?php echo $din['nombreCampo']; ?>" class="form-control">
                        <option value="0">Seleccione...</option>
                        <?php foreach ($opti as $key => $value) { ?>
                            <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                          <?php } ?>
                    </select></td>
            </tr>
          <?php } ?>
    </table>

</div>




    <table id="complmento3-table" style="width: 44%; float: right; top: 0px; position: absolute; right: 0px; display: none;">
      <tr>
        <td style="color: #FFF;">Documento:</td>
        <td style="color: #FFF;">Correo:</td>
        <td style="color: #FFF;">Celular:</td>
      </tr>
      <?php
      $bandera = 0;
      foreach($creditos as $ohpr){
          $bandera += 1;

        ?>
      <tr>
        <td><input style="width: 90px; font-size: 8px;" type="text" name="obliga3<?php echo $bandera; ?>" id="obliga3<?php echo $bandera; ?>" /></td>
        <td><input style="width: 80px; font-size: 10px;" type="text" name="fecha3<?php echo $bandera; ?>" id="fecha3<?php echo $bandera; ?>" /></td>
        <td><input style="width: 80px; font-size: 10px;" type="text" name="valor3<?php echo $bandera; ?>" id="valor3<?php echo $bandera; ?>" /></td>
      </tr>
    <?php  } ?>
    <input type="hidden" name="banderas" id="banderas" value="<?php echo $bandera; ?>"/>
    </table>

  </div>

</div>




<div class="panel panel-info" id="panelProgCall">
    <div class="panel-heading">
        <div class="panel-title">Programar LLamada</div>
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
                    <td><button class="btn btn-success btn-labeled" id="save-porg-call" type="button"><b><i class="icon-floppy-disk"></i></b>Programar</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
