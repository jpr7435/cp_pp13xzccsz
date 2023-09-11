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
                    <th>Parentesco</th>
                    <th>Intensidad</th>
                    <th>Agregado</th>
                    <th>Whatsapp</th>
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
                    //#fedbdb
                    $claseInt = "";
                    if($tel['intensidad'] == 0){
                      $claseInt = 'style="background: #fedbdb; !important"';
                    }
                    $mostrar = 'style="display: none;"';
                    $tama = strlen($tel['telefono']);
                    if($tama == 10){
                      $inicial = substr($tel['telefono'],0, 1);
                      if($inicial == 3){
                        $mostrar = '';
                      }
                    }

                    if($tel['nivelContacto'] < 400){
                      $claseInt = 'style="background: #d9ffdc; !important"';
                    }
                    ?>
                    <tr id="selectTel" <?php echo $claseInt; ?> tel="<?php echo $tel['telefono']; ?>" idtel="<?php echo $tel['idTelefono']; ?>">
                        <td <?php echo $claseInt; ?>><a href="sip:<?php echo $tel['telefono']; ?>@172.16.20.3"><?php echo $tel['telefono']; ?></a></td>
                        <td <?php echo $claseInt; ?>><?php echo $tel['idCiudad']; ?></td>
                        <td style="width: 100px" <?php echo $claseInt; ?>><?php echo $tel['personaContacto']; ?></td>
                        <td <?php echo $claseInt; ?>><?php echo $tel['intensidad']; ?></td>
                        <td <?php echo $claseInt; ?>><?php echo $agregado; ?></td>
                        <td <?php echo $claseInt; ?>><i tele="<?php echo $tel['telefono']; ?>" <?php echo $mostrar; ?> class="icon icon-bubbles2 whatsapp-action"></i></td>
                        <td <?php echo $claseInt; ?>><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/disbled.png" class="unactiveTel" tel="<?php echo $tel['telefono']; ?>" idtel="<?php echo $tel['idTelefono']; ?>" style="cursor: pointer;" alt="Desactivar" title="Desactivar"/>
                          &nbsp;&nbsp;&nbsp;<img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/call.png" class="makecall" tel="<?php echo $tel['telefono']; ?>" idtel="<?php echo $tel['idTelefono']; ?>" style="cursor: pointer;" alt="Llamar" title="Llamar"/>
                          &nbsp;&nbsp;&nbsp;<img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/nocontesta.png" width= "16" class="nocontesta" tel="<?php echo $tel['telefono']; ?>" idtel="<?php echo $tel['idTelefono']; ?>" style="cursor: pointer;" alt="No contesta" title="No Contesta"/>
                          &nbsp;&nbsp;&nbsp;<img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/msjBuzon.png" width= "16" class="mensajeenbuzon" tel="<?php echo $tel['telefono']; ?>" idtel="<?php echo $tel['idTelefono']; ?>" style="cursor: pointer;" alt="Mensaje Buzon" title="Mensaje Buzon"/></td>
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


<div class="panel panel-info" id="panelDireccion">
    <div class="panel-heading">
        <div class="panel-title">Direcciones</div>
    </div>
    <div class="panel-body" id="actions-dir-content">
        <div class="adddirPanel" class="form-group" style="display: none;">
            <label class="control-label col-lg-4">Direccion: <span class="text-danger">*</span></label>
            <div class="col-lg-8">
                <input type="text" style="margin-bottom: 10px;" class="form-control" name="dir-nuevo" id="dir-nuevo" required="required"  aria-required="true" aria-invalid="true"/>
            </div>
            <div style="clear: both;"></div>
            <label class="control-label col-lg-4">Ciudad: <span class="text-danger">*</span></label>
            <div class="col-lg-8">
                <select class="form-control" style="margin-bottom: 10px;" name="ciudadDir" id="ciudadDir">
                    <option value='0'>Seleccione..</option>
                    <option value='Acacias'>Acacias</option>
                    <option value='Aguachica'>Aguachica</option>
                    <option value='Agustin Codazzi'>Agustin Codazzi</option>
                    <option value='Apartado'>Apartado</option>
                    <option value='Arauca'>Arauca</option>
                    <option value='Arauquita'>Arauquita</option>
                    <option value='Arjona'>Arjona</option>
                    <option value='Armenia'>Armenia</option>
                    <option value='Baranoa'>Baranoa</option>
                    <option value='Barbacoas'>Barbacoas</option>
                    <option value='Barbosa'>Barbosa</option>
                    <option value='Barrancabermeja'>Barrancabermeja</option>
                    <option value='Barranquilla'>Barranquilla</option>
                    <option value='Bello'>Bello</option>
                    <option value='Bogota'>Bogota</option>
                    <option value='Bucaramanga'>Bucaramanga</option>
                    <option value='Buenaventura'>Buenaventura</option>
                    <option value='Buga'>Buga</option>
                    <option value='Cajica'>Cajica</option>
                    <option value='Calarca'>Calarca</option>
                    <option value='Caldas'>Caldas</option>
                    <option value='Cali'>Cali</option>
                    <option value='Candelaria'>Candelaria</option>
                    <option value='Carepa'>Carepa</option>
                    <option value='Cartagena De Indias'>Cartagena De Indias</option>
                    <option value='Cartago'>Cartago</option>
                    <option value='Caucasia'>Caucasia</option>
                    <option value='Cerete'>Cerete</option>
                    <option value='Chaparral'>Chaparral</option>
                    <option value='Chia'>Chia</option>
                    <option value='Chigorodo'>Chigorodo</option>
                    <option value='Chinchina'>Chinchina</option>
                    <option value='Chiquinquira'>Chiquinquira</option>
                    <option value='Cienaga'>Cienaga</option>
                    <option value='Cienaga De Oro'>Cienaga De Oro</option>
                    <option value='Copacabana'>Copacabana</option>
                    <option value='Corozal'>Corozal</option>
                    <option value='Cucuta'>Cucuta</option>
                    <option value='Cumaribo'>Cumaribo</option>
                    <option value='Cundinamarca'>Cundinamarca</option>
                    <option value='Dosquebradas'>Dosquebradas</option>
                    <option value='Duitama'>Duitama</option>
                    <option value='El Bagre'>El Bagre</option>
                    <option value='El Banco'>El Banco</option>
                    <option value='El Carmen De Bolivar'>El Carmen De Bolivar</option>
                    <option value='El Carmen De Viboral'>El Carmen De Viboral</option>
                    <option value='El Cerrito'>El Cerrito</option>
                    <option value='El Tambo'>El Tambo</option>
                    <option value='Envigado'>Envigado</option>
                    <option value='Espinal'>Espinal</option>
                    <option value='Facatativa'>Facatativa</option>
                    <option value='Florencia'>Florencia</option>
                    <option value='Florida'>Florida</option>
                    <option value='Floridablanca'>Floridablanca</option>
                    <option value='Fundacion'>Fundacion</option>
                    <option value='Funza'>Funza</option>
                    <option value='Fusagasuga'>Fusagasuga</option>
                    <option value='Galapa'>Galapa</option>
                    <option value='Garzon'>Garzon</option>
                    <option value='Girardot'>Girardot</option>
                    <option value='Girardota'>Girardota</option>
                    <option value='Giron'>Giron</option>
                    <option value='Granada'>Granada</option>
                    <option value='Guarne'>Guarne</option>
                    <option value='Ibague'>Ibague</option>
                    <option value='Inirida'>Inirida</option>
                    <option value='Ipiales'>Ipiales</option>
                    <option value='Itagüi'>Itagüi</option>
                    <option value='Jamundi'>Jamundi</option>
                    <option value='La Ceja'>La Ceja</option>
                    <option value='La Dorada'>La Dorada</option>
                    <option value='La Estrella'>La Estrella</option>
                    <option value='La Jagua De Ibirico'>La Jagua De Ibirico</option>
                    <option value='La Plata'>La Plata</option>
                    <option value='Leticia'>Leticia</option>
                    <option value='Lorica'>Lorica</option>
                    <option value='Los Patios'>Los Patios</option>
                    <option value='Madrid'>Madrid</option>
                    <option value='Magangue'>Magangue</option>
                    <option value='Maicao'>Maicao</option>
                    <option value='Malambo'>Malambo</option>
                    <option value='Manaure'>Manaure</option>
                    <option value='Manizales'>Manizales</option>
                    <option value='Marinilla'>Marinilla</option>
                    <option value='Medellin'>Medellin</option>
                    <option value='Medellin'>Medellin</option>
                    <option value='Mitu'>Mitu</option>
                    <option value='Mocoa'>Mocoa</option>
                    <option value='Montelibano'>Montelibano</option>
                    <option value='Monteria'>Monteria</option>
                    <option value='Mosquera'>Mosquera</option>
                    <option value='Neiva'>Neiva</option>
                    <option value='Ocaña'>Ocaña</option>
                    <option value='Palmira'>Palmira</option>
                    <option value='Pamplona'>Pamplona</option>
                    <option value='Pasto'>Pasto</option>
                    <option value='Pereira'>Pereira</option>
                    <option value='Piedecuesta'>Piedecuesta</option>
                    <option value='Pitalito'>Pitalito</option>
                    <option value='Planeta Rica'>Planeta Rica</option>
                    <option value='Plato'>Plato</option>
                    <option value='Popayan'>Popayan</option>
                    <option value='Puerto Asis'>Puerto Asis</option>
                    <option value='Puerto Carreno'>Puerto Carreno</option>
                    <option value='Puerto Colombia'>Puerto Colombia</option>
                    <option value='Quibdo'>Quibdo</option>
                    <option value='Riohacha'>Riohacha</option>
                    <option value='Rionegro'>Rionegro</option>
                    <option value='Riosucio'>Riosucio</option>
                    <option value='Riosucio'>Riosucio</option>
                    <option value='Sabanalarga'>Sabanalarga</option>
                    <option value='Sabaneta'>Sabaneta</option>
                    <option value='Sahagun'>Sahagun</option>
                    <option value='San Andres'>San Andres</option>
                    <option value='San Gil'>San Gil</option>
                    <option value='San Jose De Cucuta'>San Jose De Cucuta</option>
                    <option value='San Jose Del Guaviare'>San Jose Del Guaviare</option>
                    <option value='San Juan De Pasto'>San Juan De Pasto</option>
                    <option value='San Marcos'>San Marcos</option>
                    <option value='San Onofre'>San Onofre</option>
                    <option value='San Pelayo'>San Pelayo</option>
                    <option value='San Vicente Del Caguan'>San Vicente Del Caguan</option>
                    <option value='Santa Marta'>Santa Marta</option>
                    <option value='Santa Rosa De Cabal'>Santa Rosa De Cabal</option>
                    <option value='Santander De Quilichao'>Santander De Quilichao</option>
                    <option value='Saravena'>Saravena</option>
                    <option value='Sincelejo'>Sincelejo</option>
                    <option value='Soacha'>Soacha</option>
                    <option value='Sogamoso'>Sogamoso</option>
                    <option value='Soledad'>Soledad</option>
                    <option value='Tibu'>Tibu</option>
                    <option value='Tierralta'>Tierralta</option>
                    <option value='Tuchin'>Tuchin</option>
                    <option value='Tulua'>Tulua</option>
                    <option value='Tumaco'>Tumaco</option>
                    <option value='Tunja'>Tunja</option>
                    <option value='Turbaco'>Turbaco</option>
                    <option value='Turbo'>Turbo</option>
                    <option value='Uraba'>Uraba</option>
                    <option value='Uribia'>Uribia</option>
                    <option value='Valledupar'>Valledupar</option>
                    <option value='Villa Del Rosario'>Villa Del Rosario</option>
                    <option value='Villamaria'>Villamaria</option>
                    <option value='Villavicencio'>Villavicencio</option>
                    <option value='Yopal'>Yopal</option>
                    <option value='Yumbo'>Yumbo</option>
                    <option value='Zipaquira'>Zipaquira</option>
                </select>
            </div>
            <div style="clear: both;"></div>
            <button class="btn btn-success" id="saveNewDir" style="margin-left: 10px; margin-right: 10px;" type="button">Guardar</button>
            <button class="btn btn-danger" type="button" id="cancelarAddPhone">Cancelar</button>
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
                    <th>Ciudad</th>
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
                    <tr id="selectTel" dir="<?php echo $dir['direccion']; ?>" iddir="<?php echo $dir['idDireccion']; ?>">
                        <td><?php echo $dir['direccion']; ?></td>
                        <td><?php echo $dir['idCiudad']; ?></td>
                        <td><?php echo $agregado; ?></td>
                        <td><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/disbled.png" class="unactiveDir" dir="<?php echo $dir['direccion']; ?>" iddir="<?php echo $dir['idDireccion']; ?>" style="cursor: pointer;" alt="Desactivar" title="Desactivar"/></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div class="panel panel-info" id="panelCorreos">
    <div class="panel-heading">
        <div class="panel-title">Correos</div>
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
                    <tr id="selectMail" dir="<?php echo $corr['email']; ?>" idmail="<?php echo $corr['idEmail']; ?>">
                        <td><?php echo $corr['email']; ?></td>
                        <td><?php echo $agregado; ?></td>
                        <td><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/disbled.png" class="unactiveMail" mail="<?php echo $corr['email']; ?>" iddir="<?php echo $corr['idEmail']; ?>" style="cursor: pointer;" alt="Desactivar" title="Desactivar"/>
                        &nbsp;&nbsp;<img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/acuerdo_icon.png" class="sendMailAcuerdo" direccion="<?php echo $corr['email']; ?>" style="cursor: pointer; width: 20px;" alt="Acuerdo de Pago" title="Acuerdo de Pago"/>
                        &nbsp;&nbsp; <img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/propuesta_icon.png" class="sendMailPropuesta" direccion="<?php echo $corr['email']; ?>" style="cursor: pointer; width: 20px;" alt="Propuesta de Pago" title="Propuesta de Pago"/>
                        &nbsp;&nbsp;<img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/desistimiento.png" class="sendMailDesistimiento" direccion="<?php echo $corr['email']; ?>" style="cursor: pointer; width: 20px;" alt="Desisitimiento" title="Desisitimiento"/>
                        &nbsp;&nbsp;<span class="loadOtros" direccion="<?php echo $corr['email']; ?>" style="cursor: pointer; font-weight: bold; font-size: 25px; color: #a9dfbf;">+</span></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
