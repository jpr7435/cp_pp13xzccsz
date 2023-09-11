<?php
/* * To change this template, choose Tools | Templates * and open the template in the editor. */
$ci2 = &get_instance();
//$us = $ci3->load->model("usuarios");
//$ci2 = &get_instance();
$ci2->load->model("vista");

$carteras = explode(";", $session['carteras']);
$mejor1 = $this->vista->getResultado($cliente[0]['mejorGestion'], $session['proyecto_activo']);
$userG = $this->vista->getusuario($cliente[0]['idAsesor'], $session['proyecto_activo']);
$ultima = $this->vista->getResultado($cliente[0]['ultimaGestion'], $session['proyecto_activo']);
//$extracto = $this->vista->getExtracto($cliente[0]['documento'], $session['proyecto_activo']);
$fila = 0;
$pr = 0;
?>

<section class="main-container">
  <h1 style="display:none"><?php echo $cliente[0]['nombre'] . " " . $cliente[0]['documento']; ?></h1>
  <input type="hidden" id="documentoActivo" name="documentoActivo" value="<?php echo $cliente[0]['documento']; ?>"/>
  <!-- Page header -->
  <div class="header bg-amarillo">
    <div class="header-content">
      <div style="font-weight: bold;" class="page-title">
        <i class="icon icon-user position-left"></i> <?php echo $cliente[0]['nombre'] . " - " . $cliente[0]['documento'] . " - $" . number_format($cliente[0]['saldoPareto'], 0) . " - <span style='color: #2E2EFE; font-weight: bold; font-size: 14px;'>" . $mejor1[0]['descripcion'] . "</span>"
        ."- <span style='color: #FF0000; font-weight: bold; font-size: 14px;'>".$cliente[0]['estrategia']."</span>"; ?>
        <?php
        if ($session['tarea'] != "") {
          echo '<button class="btn btn-success btn-labeled" id="next-tarea-btn" type="button"><b><i></i></b>Siguiente ' . $session['tarea'] . '</button>';
        }
        ?>
      </div>
    </div>
  </div>
  <!-- /Page header -->

  <div class="container-fluid page-content">
    <div style="clear: both; height: 60px;"></div>
    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-flat borde-azul" style="height: 300px; margin-bottom: 5px !important; overflow: auto;">
          <div class="panel-heading">
            <div class="panel-title">
              Datos de Cliente
            </div>
          </div>
          <div class="panel-body">
            <table class="table table-bordered">
              <tr>
                <th>Nombre:</th>
                <th>Documento:</th>
              </tr>
              <tr>
                <td><?php echo $cliente[0]['nombre']; ?></td>
                <td><?php echo $cliente[0]['documento']; ?></td>
              </tr>
              <tr>
                <th>Asesor:</th>
                <th>Fecha Ultima Gestion:</th>
              </tr>
              <tr>
                <td><?php echo $userG[0]['usuario']; ?></td>
                <td><?php echo $cliente[0]['FecUltimaGestion']; ?></td>
              </tr>
              <tr>
                <th>Mejor Gestion:</th>
                <th>Ultima Gestion:</th>
              </tr>
              <tr>
                <td><?php echo $mejor1[0]['descripcion']; ?></td>
                <td><?php echo $ultima[0]['descripcion']; ?></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="panel panel-flat borde-amarillo" style="height: 300px; margin-bottom: 5px !important; overflow: auto;">
          <div class="panel-heading">
            <div class="panel-title">
              Biblioteca de archivos
            </div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="form-group col-sm-8">
                <form name="subir-archivo" id="subir-archivo" method="post" enctype="multipart/form-data" action="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/subirarchivo">

                  <label class="control-label col-lg-4">Nombre archivo:</label>
                  <div class="col-lg-8">
                    <input type="text" placeholder="Nombre del archivo" name="nombreFiles" id="nombreFiles" class="form-control" />
                  </div>
                  <label class="control-label col-lg-4">Cargar Archivo</label>
                  <div class="col-lg-8">
                    <input type="file" name="archivo" id="archivo" class="file-styled-primary-icon">
                    <input type="hidden" id="documentoArchivo" name="documentoArchivo" value="<?php echo $cliente[0]['documento']; ?>"/>
                    <input type="hidden" id="idArchivo" name="idArchivo" value="<?php echo $cliente[0]['idCliente']; ?>"/>
                  </div>
                </form>
              </div>
              <div class="form-group  col-sm-4">
                <button class="btn btn-success btn-labeled" id="upload-file-action" type="button"><b><i class="icon-floppy-disk"></i></b>Cargar</button>
              </div>
            </div>
            <div style="clear: both; height: 2px;"></div>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Tipo</th>
                  <th>Nombre</th>
                  <th>Fecha</th>
                  <th>Asesor</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($archivoscl as $fi) {
                  $imgfl = "text.png";
                  if ($fi['extension'] == ".xls" || $fi['extension'] == ".xlsx") {
                    $imgfl = "excel.png";
                  } else if ($fi['extension'] == ".doc" || $fi['extension'] == ".docx") {
                    $imgfl = "word.png";
                  } else if ($fi['extension'] == ".ppt" || $fi['extension'] == ".pptx") {
                    $imgfl = "powerpoint.png";
                  } else if ($fi['extension'] == ".pdf") {
                    $imgfl = "pdf.png";
                  } else if ($fi['extension'] == ".rar" || $fi['extension'] == ".zip") {
                    $imgfl = "zip.png";
                  } else if ($fi['extension'] == ".jpg" || $fi['extension'] == ".jepg" || $fi['extension'] == ".tif" || $fi['extension'] == ".bmp" || $fi['extension'] == ".png") {
                    $imgfl = "image.png";
                  }
                  $userBi = $this->vista->getusuario($fi['idAsesor']);
                  ?>
                  <tr>
                    <td><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/<?php echo $imgfl; ?>" width="20" alt="<?php echo $fi['extension']; ?>" title="<?php echo $fi['extension']; ?>"/></td>
                    <td><a target="_blank" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/uploads/clientes/<?php echo $cliente[0]['documento']; ?>/<?php echo $fi['archivo']; ?>"><?php echo $fi['archivo']; ?></a></td>
                    <td><?php echo $fi['fechacargue']; ?></td>
                    <td><?php echo $userBi[0]['usuario']; ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body" style="overflow-x: auto;">
          <table class="table-bordered" style="width: 150% !important;">
            <thead>
              <tr>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Obligacion</th>
                <!--<th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Cartera</th>-->
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Linea</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Subproducto</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fondeador</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Entidad</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Saldo</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor Mora Inicial</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Dias Mora Inicial</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor Mora Actual</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Dias Mora Actual</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Estado</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Oficina</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Regional</th>
                <!--<th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Asesor_Lib</th>-->
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Rango</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Rango_Ant</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Saldo_Mil</th>
                <!--<th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Empresa</th>-->
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor Cuota</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Saldo en Mora</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Intereses Mora</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fecha Desembolso</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor Desembolso</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Plazo</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">% TASA</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">% GAC</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Cuotas Pagas</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Intereses Corrientes</th>                
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Saldo_Ant</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fch Prox Vto</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Vlr Ult Pago</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fch Ult Pago</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Restructurado</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Juridico</th>
                <!--<th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Abogado</th>-->
                <!--<th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Asesor CAR</th>-->
                <!--<th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Estado CRE</th>-->
                <!--<th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Cod Ciudad</th>-->
                <!--<th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Cod Linea</th>-->
                <!--<th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Cod Entidad</th>-->
                <!--<th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Cod Oficina</th>-->
                <!--<th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Cod Regional</th>-->
                <!--<th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fecha SYS</th>-->
                <!--<th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Usuario SYS</th>-->
                <!--<th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fecha Apertura</th>-->
                <!--<th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Edad Mora</th>-->
                <!--<th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Edad Mora Ant</th>-->
                <!--<th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Ult Pag Ent</th>-->
                <!--<th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fch Ult Pag Ent</th>-->
                <!--<th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Con Fondo G</th>-->
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Vendido</th>
                <!--<th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Cap Pag Mes</th>-->
                <!--<th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Total Pag Mes</th>-->
                <!--<th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Tip_Compra</th>-->
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fch Vencimiento</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">NUMID</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Cod Canal</th>
                <!--<th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Nombre Canal</th>-->
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Ult_Pag_Ent_Nom</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Tipo Cartera</th>
              </tr>
            </thead>
            <tbody>

              <?php
              $totalcapital = 0;
              $totalsldmora = 0;
              $totalcuotas = 0;
              $totalMora = 0;
              $totalsldant = 0;
              $totalultimo = 0;
              $totalcap_pagmes = 0;
              $totaltot_pagmes = 0;
              $totalintmora2 = 0;
              $totalintCte = 0; 
;

              foreach ($creditos as $cr){

              $totalcapital += $cr['valor'];
              $totalsldmora += $cr['valor_mora'];
              $totalcuotas += $cr['valor_cuo'];
              $totalMora += $cr['saldomora'];
              $totalsldant += $cr['saldoant'];
              $totalultimo += $cr['vlrultpago'];
              $totalcap_pagmes += $cr['cap_pagmes'];
              $totaltot_pagmes += $cr['tot_pagmes'];
              $totalintmora2 += $cr['interesmora'];
              $totalintCte +=$cr['intCorriente'];

              ?>
                <tr>
                  <td nowrap style="text-align: center;"><?php echo $cr['obligacion']; ?></td>
                  <!--<td nowrap style="text-align: center;"><?php echo $cr['cartera']; ?></td>-->
                  <td nowrap style="text-align: center;"><?php echo $cr['linea']; ?></td>
                  <td nowrap style="text-align: center;"><?php echo $cr['subproducto']; ?></td>
                  <td nowrap style="text-align: center;"><?php echo $cr['fondeador']; ?></td>
                  <td nowrap style="text-align: center;"><?php echo $cr['entidad']; ?></td>
                  <td nowrap style="text-align: center;"><?php echo number_format($cr['valor'], 0); ?></td>
                  <td nowrap style="text-align: center;"><?php echo number_format($cr['valor_mora'], 0); ?></td>
                  <td nowrap style="text-align: center;"><?php echo $cr['diasmora']; ?></td>
				  <td nowrap style="text-align: center;"><?php echo number_format($cr['valormoraactual'], 0); ?></td>
                  <td nowrap style="text-align: center;"><?php echo $cr['diasmoraactual']; ?></td>
                  <td nowrap style="text-align: center;"><?php echo $cr['estado']; ?></td>
                  <td nowrap style="text-align: center;"><?php echo $cr['oficina']; ?></td>
                  <td nowrap style="text-align: center;"><?php echo $cr['regional']; ?></td>
                  <!--<td nowrap style="text-align: center;"><?php echo $cr['asesor_lib']; ?></td>-->
                  <td nowrap style="text-align: center;"><?php echo $cr['rango']; ?></td>
                  <td nowrap style="text-align: center;"><?php echo $cr['rangoant']; ?></td>
                  <td nowrap style="text-align: center;"><?php echo $cr['saldomil']; ?></td>
                  <!--<td nowrap style="text-align: center;"><?php echo $cr['empresa']; ?></td>-->
                  <td nowrap style="text-align: center;"><?php echo number_format($cr['valor_cuo'], 0); ?></td>
                  <td nowrap style="text-align: center;"><?php echo number_format($cr['saldomora'], 0); ?></td>
                  <td nowrap style="text-align: center;"><?php echo number_format($cr['interesmora'], 0); ?></td>
                  <td nowrap style="text-align: center;"><?php echo $cr['fecha_desembolso']; ?></td>
                  <td nowrap style="text-align: center;"><?php echo number_format($cr['vr_desembolso'], 0); ?></td>
                  <td nowrap style="text-align: center;"><?php echo $cr['plazo']; ?></td>
                  <td nowrap style="text-align: center;"><?php echo $cr['tasa']; ?></td>
                  <td nowrap style="text-align: center;"><?php echo $cr['porc_gac']; ?></td>
                  <td nowrap style="text-align: center;"><?php echo $cr['cuotas_pagas']; ?></td>
                  <td nowrap style="text-align: center;"><?php echo number_format($cr['intCorriente'], 0); ?></td>                
                  <td nowrap style="text-align: center;"><?php echo number_format($cr['saldoant'], 0); ?></td>
                  <td nowrap style="text-align: center;"><?php echo $cr['fecproxvenc']; ?></td>
                  <td nowrap style="text-align: center;"><?php echo number_format($cr['vlrultpago'], 0); ?></td>
                  <td nowrap style="text-align: center;"><?php echo $cr['fecultpago']; ?></td>
                  <td nowrap style="text-align: center;"><?php echo $cr['restructurado']; ?></td>
                  <td nowrap style="text-align: center;"><?php echo $cr['juridico']; ?></td>
                  <!--<td nowrap style="text-align: center;"><?php echo $cr['nom_abogado']; ?></td>-->
                  <!--<td nowrap style="text-align: center;"><?php echo $cr['asesorcar']; ?></td>-->
                  <!--<td nowrap style="text-align: center;"><?php echo $cr['estado_cre']; ?></td>-->
                  <!--<td nowrap style="text-align: center;"><?php echo $cr['cod_ciudad']; ?></td>-->
                  <!--<td nowrap style="text-align: center;"><?php echo $cr['cod_linea']; ?></td>-->
                  <!--<td nowrap style="text-align: center;"><?php echo $cr['cod_entidad']; ?></td>-->
                  <!--<td nowrap style="text-align: center;"><?php echo $cr['cod_oficina']; ?></td>-->
                  <!--<td nowrap style="text-align: center;"><?php echo $cr['cod_regional']; ?></td>-->
                  <!--<td nowrap style="text-align: center;"><?php echo $cr['fecha_sys']; ?></td>-->
                  <!--<td nowrap style="text-align: center;"><?php echo $cr['usua_sys']; ?></td>-->
                  <!--<td nowrap style="text-align: center;"><?php echo $cr['fecha_ap']; ?></td>-->
                  <!--<td nowrap style="text-align: center;"><?php echo $cr['edadmora']; ?></td>-->
                  <!--<td nowrap style="text-align: center;"><?php echo $cr['edadmoraant']; ?></td>-->
                  <!--<td nowrap style="text-align: center;"><?php echo $cr['ultpagent']; ?></td>-->
                  <!--<td nowrap style="text-align: center;"><?php echo $cr['fecultpagent']; ?></td>-->
                  <!--<td nowrap style="text-align: center;"><?php echo $cr['confondog']; ?></td>-->
                  <td nowrap style="text-align: center;"><?php echo $cr['vendido']; ?></td>
                  <!--<td nowrap style="text-align: center;"><?php echo number_format($cr['cap_pagmes'], 0); ?></td>-->
                  <!--<td nowrap style="text-align: center;"><?php echo number_format($cr['tot_pagmes'], 0); ?></td>-->
                  <!--<td nowrap style="text-align: center;"><?php echo $cr['tip_compra']; ?></td>-->
                  <td nowrap style="text-align: center;"><?php echo $cr['fecvencimiento']; ?></td>
                  <td nowrap style="text-align: center;"><?php echo $cr['numid']; ?></td>
                  <td nowrap style="text-align: center;"><?php echo $cr['cod_canal']; ?></td>
                  <!--<td nowrap style="text-align: center;"><?php echo $cr['nom_canal']; ?></td>-->
                  <td nowrap style="text-align: center;"><?php echo $cr['ultpagentnom']; ?></td>
                  <td nowrap style="text-align: center;"><?php echo $cr['tipoCartera']; ?></td>

                </tr>
              <?php } ?>

              <tr>
                <td style="text-align: center; font-weight: bold;"></td>
                <!--<td style="text-align: center; font-weight: bold;"></td>-->
                <td style="text-align: center; font-weight: bold;"></td>
                <td style="text-align: center; font-weight: bold;"></td>
                <td style="text-align: center; font-weight: bold;"></td>
                <td style="text-align: center; font-weight: bold;"></td>
                <td style="text-align: center; font-weight: bold; background-color: #a4a4a4;"><?php echo number_format($totalcapital, 0); ?></td>
                <td style="text-align: center; font-weight: bold; background-color: #a4a4a4;"><?php echo number_format($totalsldmora, 0); ?></td>
                <td style="text-align: center; font-weight: bold;"></td>
                <td style="text-align: center; font-weight: bold;"></td>
                <td style="text-align: center; font-weight: bold;"></td>
                <!--<td style="text-align: center; font-weight: bold;"></td>-->
                <td style="text-align: center; font-weight: bold;"></td>
                <td style="text-align: center; font-weight: bold;"></td>
                <td style="text-align: center; font-weight: bold;"></td>
                <!--<td style="text-align: center; font-weight: bold;"></td>-->
                <td style="text-align: center; font-weight: bold; background-color: #a4a4a4;"><?php echo number_format($totalcuotas, 0); ?></td>
                <td style="text-align: center; font-weight: bold; background-color: #a4a4a4;"><?php echo number_format($totalMora, 0); ?></td>
                <td style="text-align: center; font-weight: bold; background-color: #a4a4a4;"><?php echo number_format($totalintmora2, 0); ?></td>
                <td style="text-align: center; font-weight: bold;"></td>
                <td style="text-align: center; font-weight: bold;"></td>	
                <td style="text-align: center; font-weight: bold;"></td>
                <td style="text-align: center; font-weight: bold;"></td>
                <td style="text-align: center; font-weight: bold;"></td>
                <td style="text-align: center; font-weight: bold;"></td>
                <td style="text-align: center; font-weight: bold; background-color: #a4a4a4;"><?php echo number_format($totalintCte, 0); ?></td>
                <td style="text-align: center; font-weight: bold;"></td>
                <td style="text-align: center; font-weight: bold; background-color: #a4a4a4;"><?php echo number_format($totalsldant, 0); ?></td>
                <td style="text-align: center; font-weight: bold;"></td>
                <td style="text-align: center; font-weight: bold; background-color: #a4a4a4;"><?php echo number_format($totalultimo, 0); ?></td>
                <td style="text-align: center; font-weight: bold;"></td>
                <td style="text-align: center; font-weight: bold;"></td>
                <td style="text-align: center; font-weight: bold;"></td>
                <!--<td style="text-align: center; font-weight: bold;"></td>-->
                <!--<td style="text-align: center; font-weight: bold;"></td>-->
                <!--<td style="text-align: center; font-weight: bold;"></td>-->
                <!--<td style="text-align: center; font-weight: bold;"></td>-->
                <!--<td style="text-align: center; font-weight: bold;"></td>-->
                <!--<td style="text-align: center; font-weight: bold;"></td>-->
                <!--<td style="text-align: center; font-weight: bold;"></td>-->
                <!--<td style="text-align: center; font-weight: bold;"></td>-->
                <!--<td style="text-align: center; font-weight: bold;"></td>-->
                <!--<td style="text-align: center; font-weight: bold;"></td>-->
                <!--<td style="text-align: center; font-weight: bold;"></td>-->
                <!--<td style="text-align: center; font-weight: bold;"></td>-->
                <!--<td style="text-align: center; font-weight: bold;"></td>-->
                <!--<td style="text-align: center; font-weight: bold;"></td>-->
                <!--<td style="text-align: center; font-weight: bold;"></td>-->
                <!--<td style="text-align: center; font-weight: bold;"></td>-->
                <td style="text-align: center; font-weight: bold;"></td>
                <!--<td style="text-align: center; font-weight: bold; background-color: #a4a4a4;"><?php echo number_format($totalcap_pagmes, 0); ?></td>-->
                <!--<td style="text-align: center; font-weight: bold; background-color: #a4a4a4;"><?php echo number_format($totaltot_pagmes, 0); ?></td>-->
                <!--<td style="text-align: center; font-weight: bold;"></td>-->
                <td style="text-align: center; font-weight: bold;"></td>
                <td style="text-align: center; font-weight: bold;"></td>
                <td style="text-align: center; font-weight: bold;"></td>
                <!--<td style="text-align: center; font-weight: bold;"></td>-->
                <td style="text-align: center; font-weight: bold;"></td>
                <td style="text-align: center; font-weight: bold;"></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">
          <div class="panel-group accordion" id="accordion-styled">
            <div class="panel">
              <div class="panel-heading">
                <div class="panel-title">
                  <a data-toggle="collapse" data-parent="#accordion-styled" href="#pagos">Pagos</a>
                </div>
              </div>
              <div id="pagos" class="panel-collapse collapse">
                <div class="panel-body" style="overflow-x: auto;">
                  <table class="table-bordered" style="width: 100% !important;">
                    <thead>
                      <tr>
                        <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Obligacion</th>
                        <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor Pago</th>
                        <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fecha Aplicacion</th>
                        <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fecha Pago</th>
                        <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Concepto Recaudo</th>
                        <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Medio Pago</th>
                        <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Entidad</th>
                        <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Asesor</th>
                        <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fecha Cargue</th>
                        <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Gestion</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($pagos as $pg) {
                        $asesorP = $this->vista->getusuario($pg['idasesor'], $session['proyecto_activo']);
                        ?>
                        <tr>
                          <td style="text-align: center;"><?php echo $pg['obligacion']; ?></td>
                          <td style="text-align: center;"><?php echo number_format($pg['valor'], 0); ?></td>
                          <td style="text-align: center;"><?php echo $pg['fecha_aplicacion_recaudo']; ?></td>
                          <td style="text-align: center;"><?php echo $pg['fecha']; ?></td>
                          <td style="text-align: center;"><?php echo $pg['concepto_recaudo']; ?></td>
                          <td style="text-align: center;"><?php echo $pg['medio_pago']; ?></td>
                          <td style="text-align: center;"><?php echo $pg['entidad']; ?></td>
                          <td style="text-align: center;"><?php echo $asesorP[0]['usuario']; ?></td>
                          <td style="text-align: center;"><?php echo $pg['fechacarguepolaris']; ?></td>
                          <td style="text-align: center;"><?php echo $pg['gestion']; ?></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>


            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-heading">
          <div class="panel-title">
            Gestion Adelantada
          </div>
        </div>
        <div class="panel-body">
          <button type="button" id="gestionCompleta" class="btn btn-info btn-xs">Toda</button>&nbsp;&nbsp;&nbsp;<button type="button" id="gestionEfectiva" class="btn btn-success btn-xs">Efectiva</button></br></br>
          <div class="panel-group accordion gestionAdelantada" id="accordion-styled">
            <?php
            $flag = 0;
            foreach ($gestion as $ges) {


              $class = "";
              $class2 = "in";
              $color = "";
              if ($flag > 0) {
                $class = 'class="collapsed"';
                $class2 = "";
              }
              $result = $this->vista->getResultado($ges['idResultado'], $session['proyecto_activo']);
              $user = $this->vista->getusuario($ges['idAsesor'], $session['proyecto_activo']);
              $cont = $this->vista->getContacto($ges['idContacto'], $session['proyecto_activo']);

              if ($cont[0]['idGrupo'] == 1) {
                $color = 'style="background-color:  #d9ffdc;"';
              }
              if ($cont[0]['idGrupo'] == 2) {
                $color = 'style="background-color:  #fedbdb;"';
              }
              if ($ges['idResultado'] == 46) {
                $color = 'style="background-color:  #ffc81b;"';
              }

              $fecacu = "";

              if ($ges['fechaAcuerdo'] != "0000-00-00" && $ges['fechaAcuerdo'] != "") {
                $fecacu = $ges['fechaAcuerdo'];
              }

              $archivoGarabacion = "";

              $primer = substr($ges['grabacion'], 1);

              if ($primer == "/") {
                $pre1 = explode('asterisk', $ges['grabacion']);
                $archivoGarabacion = $pre1[1];
              } else {
                $preFe = explode(" ", $ges['fechaGestion']);
                $preFec2 = explode("-", $preFe[0]);
                $archivoGarabacion = "/monitor/" . $preFec2[0] . "/" . $preFec2[1] . "/" . $preFec2[2] . "/" . $ges['grabacion'];
              }
              ?>

              <div class="panel">
                <div class="panel-heading" <?php echo $color; ?>>
                  <div class="panel-title">
                    <a <?php echo $class; ?> data-toggle="collapse" data-parent="#accordion-styled" href="#<?php echo $ges['idCallhist']; ?>"><?php
                    echo $ges['fechaGestion'] . " - " . $user[0]['usuario'] . " - Tel: " . $ges['telefono'] . " - " . $result[0]['descripcion'] . " - " . $fecacu;
                    if ($session['perfil'] < 6) {
                      if ($ges['grabacion'] != NULL) {
                        echo '<a href="http://172.16.0.3' . $archivoGarabacion . '"><img src="http://' . $_SERVER['HTTP_HOST'] . '/front/img/speaker.png" alt="Grabacion" title="Grabacion" /></a>';
                      }
                    }
                    ?></a>
                  </div>
                </div>
                <div id="<?php echo $ges['idCallhist'] ?>" class="panel-collapse collapse <?php echo $class2; ?>">
                  <div class="panel-body">
                    <?php echo $ges['textoGestion']; ?>
                  </div>
                </div>
              </div>
              <?php
              $flag += 1;
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div id="acuerdopago-modal">
  <table class="table">
    <thead>
      <tr>
        <th style="width: 180px;">Obligacion</th>
        <th style="width: 150px;">Fecha Pago</th>
        <th style="width: 150px;">Valor</th>
        <th>Cuotas</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <select name="ohacuer" id="ohacuer" class="form-control">
            <option value="0">Seleccione..</option>
            <?php foreach ($creditos as $cr2) { ?>
              <option value="<?php echo $cr2['obligacion']; ?>"><?php echo $cr2['obligacion']; ?></option>
            <?php } ?>
          </select>
        </td>
        <td><input type="text" readonly="readonly" style="color: #000;" name="fechas-acuerdos" id="fechas-acuerdos" class="form-control datepicker-here" data-position="bottom left" data-language='en'/></td>
        <td><input type="text" name="valor-acuerdo" id="valor-acuerdo" class="form-control"/></td>
        <td><input type="text" name="cuotas-acuerdo" id="cuotas-acuerdo" class="form-control"/></td>
      </tr>
      <tr>
        <td></td>
        <td><input type="text" readonly="readonly" style="width: 50px; display: none;" name="vlminneg" id="vlminneg"/></td>
        <td><input type="text" readonly="readonly" style="width: 50px; display: none;" name="pagcuotasneg" id="pagcuotasneg"/></td>
        <td><input type="text" readonly="readonly" style="width: 50px; display: none;" name="saldototneg" id="saldototneg"/></td>
      </tr>
      <tr>
        <td><button class="btn btn-success" id="generaAcuerdoCuotas" type="button">Generar</button></td>
        <td><button class="btn btn-danger" id="CancelaAcuerdoCuotas" type="button">Cancelar</button></td>
        <td></td>
        <td></td>
      </tr>
    </tbody>
  </table>
  <div id="acuerdo-preliminar" style="width: 100%;"></div>
</div>
<!--<input type="hidden" name="pisoGeneral" id="pisoGeneral" value="<?php echo $totalpiso; ?>"/>-->
