
<!-- ScrolltoTop -->
<!-- <a id="scrollTop" href="#top"><i class="icon-arrow-up12"></i></a>-->
<!-- /ScrolltoTop -->
</div>
<!-- Rightbar -->

<?php

$ci3 = &get_instance();
$ci3->load->model("vista");

$pausasList = $this->vista->getPausasList();


$templatesList = $this->vista->getTemplatesList($session['proyecto_activo']);
?>

<div id="right_sidebar" class="right_bar"></div>
<script>
function open_rightbar() {
  $(window).resize(function () {
    if (($(window).width() < 500)) {
      document.getElementById("right_sidebar").style.width = "100%";
    } else if ($(window).width() > 500) {
      document.getElementById("right_sidebar").style.width = "260px";
    }
  }).resize();
}
function close_rightbar() {
  document.getElementById("right_sidebar").style.width = "0";
}
</script>
<!-- /Rightbar -->

<!-- Layout settings -->
<div class="layout"></div>
<span class="is_hidden" id="jquery_vars">
  <span class="is_hidden switch-active"></span>
  <span class="is_hidden switch-inactive"></span>
  <span class="is_hidden chart-bg"></span>
  <span class="is_hidden chart-gridlines-color"></span>
  <span class="is_hidden chart-legends-text-color"></span>
  <span class="is_hidden chart-grid-text-color"></span>
  <span class="is_hidden chart-data-color-option1"></span>
  <span class="is_hidden chart-data-color-option2"></span>
  <span class="is_hidden chart-data-color-option3"></span>
  <span class="is_hidden chart-data-color-option4"></span>
  <span class="is_hidden chart-data-color-option5"></span>
  <span class="is_hidden chart-data-color-option6"></span>
  <span class="is_hidden chart-data-color-option7"></span>
  <span class="is_hidden chart-data-color-option8"></span>
</span>
<!-- /Layout settings -->

<!-- Global scripts -->

<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/core/jquery/jquery.ui.js"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/core/site.js"></script>

<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/core/progcall.js"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/core/bootstrap/bootstrap.js"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/core/bootstrap/jasny_bootstrap.min.js"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/core/navigation/nav.accordion.js"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/core/hammer/hammerjs.js"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/core/hammer/jquery.hammer.js"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/core/slimscroll/jquery.slimscroll.js"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/extensions/smart-resize.js"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/extensions/blockui.min.js"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/forms/uniform.min.js"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/forms/switchery.js"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/forms/select2.min.js"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/plugins/venobox.js"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/core/app/layouts.js"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/core/app/core.js"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/pages/forms/form_select2.js"></script>
<!-- /Global scripts -->

<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/forms/jquery.validate.js"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/pages/forms/form_validations.js"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/plugins/tables/datatables/datatables.min.js"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/pages/tables/datatable_advanced.js"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/core/jquery-ui-timepicker-addon.min.js"></script>
<!--<script src="http://<?php //echo $_SERVER['HTTP_HOST']; ?>/front/lib/js/forms/datepicker.min.js"></script>
<script src="http://<?php //echo $_SERVER['HTTP_HOST']; ?>/front/lib/js/forms/datepicker.en.js"></script>
<script src="http://<?php //echo $_SERVER['HTTP_HOST']; ?>/front/lib/js/pages/forms/picker_date.js"></script>-->
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/forms/formatter.min.js"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/core/formats.js"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/pages/forms/form_inputs_basic.js"></script>
<?php
$preurl = $_SERVER['PHP_SELF'];
$url = explode("/", $preurl);

if ($url[3] == "asignacion") {
  ?>
  <script>
  $("#asignacion-table").DataTable({
    "ajax": {
      "method": "POST",
      "url": "https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/getlistado"
    },
    "language": {
      "url": "https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/core/Spanish.json"
    },
    "dom": '<"top"f>rt<"bottom"p><"clear">',
    stateSave: true,
    serverSide: true,
    pageLength: 50,
    autoWidth: true,
    initComplete: function () {
      this.api().columns().every(function () {
        var column = this;
        var select = $('<select><option value="">Aplicar Filtro</option></select>')
        .appendTo($(column.header()).empty())
        .on('change', function () {
          var val = $.fn.dataTable.util.escapeRegex(
            $(this).val()
          );
          column
          .search(val ? '^' + val + '$' : '', true, false)
          .draw();
        });
        column.data().unique().sort().each(function (d, j) {
          select.append('<option value="' + d + '">' + d + '</option>')
        });
      });
    },
    "columns": [
      {"data": "documento"},
      {"data": "nombre"},
      {"data": "saldoPareto"},
      {"data": "mejorGestion"},
      {"data": "ultimaGestion"},
      {"data": "FecUltimaGestion"},
      {"data": "franja_obligacion_actual"},
      {"data": "estrategia"},
      {"data": "territorial_mayor"}
    ]
  });



  $("#ranking").DataTable({
    "ajax": {
      "method": "POST",
      "url": "https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/getlistado"
    },
    "language": {
      "url": "https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/core/Spanish.json"
    },
    "dom": '<"top"f>rt<"bottom"p><"clear">',
    stateSave: true,
    aaSorting: [[4, 'asc']],
    serverSide: true,
    pageLength: 50,
    autoWidth: true,
    initComplete: function () {
      this.api().columns().every(function () {
        var column = this;
        var select = $('<select><option value="">Aplicar Filtro</option></select>')
        .appendTo($(column.header()).empty())
        .on('change', function () {
          var val = $.fn.dataTable.util.escapeRegex(
            $(this).val()
          );
          column
          .search(val ? '^' + val + '$' : '', true, false)
          .draw();
        });
        column.data().unique().sort().each(function (d, j) {
          select.append('<option value="' + d + '">' + d + '</option>')
        });
        
      });
      aaSorting: [[4, 'asc']]
    },
    "columns": [
      {"data": "asesor"},
      {"data": "totalGAC"},
      {"data": "saldoPareto"},
      {"data": "mejorGestion"},
      {"data": "ultimaGestion"},
      {"data": "FecUltimaGestion"},
      {"data": "franja_obligacion_actual"},
      {"data": "estrategia"},
      {"data": "territorial_mayor"}
    ]
  });



  </script>

<?php } ?>
<div id="modalSelectPausas" class="modal fade">
  <div class="seleccione-pausa">
    <table class="table table-hover" style="position: relative; width: 80%; margin: 20px auto;">
      <thead>
        <tr>
          <th>Listado de Pausas</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($pausasList as $pl){ ?>
          <tr>
            <td style="cursor: pointer;" class="click-pausa" iden="<?php echo $pl['idPausa']; ?>"><?php echo $pl['descripcion']; ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>
<div class="modal-login">

  <div class="auth-container">
		<div class="center-block">
			<div class="auth-module">
				<div class="toggle" style="display: none;"></div>

				<!-- Login form -->
				<div class="form" style="text-align: center;">
          <div style="float: center; margin: 0 auto; text-align: center;" id='timer'>
              <div style="margin: 0 auto; width: 100%;" class="container2">
                  <div id="hour">00</div>
                  <div class="divider">:</div>
                  <div id="minute">00</div>
                  <div class="divider">:</div>
                  <div id="second">00</div>
              </div>
          </div>
          <div style="clear: both; width: 100%"></div>
					<img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/front/img/trebol_80.png" alt="Clover-Team" title="Clover-team"/>
					<!--<h1 class="text-light">Ingrese sus datos</h1>-->
					<form class="form-horizontal">
						<div class="form-group">
							<div class="form-group has-feedback has-feedback-left">
                                                            <input type="text" readonly="readonly" id="username" class="form-control" value="<?php echo $session['usuario']; ?>">
								<div class="form-control-feedback">
									<i class="icon-user"></i>
								</div>
							</div>
							<div class="form-group has-feedback has-feedback-left">
								<input type="password" id="password" class="form-control" placeholder="Contraseña">
								<div class="form-control-feedback">
									<i class="icon-key"></i>
								</div>
							</div>
							<div style="color: #FA5858;" id="login-options-pausa" class="login-options">

							</div>
				  			<button type="button" id="loginBtn-pausa" class="btn btn-info btn-block">Ingresar</button>
						</div>
					</form>
				</div>
				<!-- /Login form -->

			</div>
			<div class="footer">
				<div class="pull-left">
					© 2017 Clover Team SAS&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;Polaris Web Collector 3.0</div>
			</div>
		</div>
	</div>



</div>
<div id="modal-load">
  <img class="img-load" src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/loading.png" alt="Cargando" title="Cargando"/>
</div>

<div id="modal_custom" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content bg-indigo">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="modal-title">Llamadas vencidas</div>
      </div>
      <div class="modal-body modal-body-prog">

      </div>
    </div>
  </div>
</div>




<div class="modal fade" id="acuerdoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Acuerdo de Pago</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="respuestaAcuerdo" class="modal-body">
        <div class="row">
          <div class="form-group col-sm-4">
            <label>Obligacion:</label>
            <input type="text" style="color: #707070;" readonly class="form-control" name="ohModalAcuerdo" id="ohModalAcuerdo"/>
          </div>
          <div class="form-group col-sm-4">
            <label>Es Judicial?: <input type="checkbox" class="form-control" name="esjudicial" id="esjudicial" value="0"/></label>
          </div>
          <div class="form-group col-sm-4">
            <label>Probabilidad de Pago:</label>
            <select name="probabilidadpago" id="probabilidadpago" class="form-control">
              <option value="0">Seleccione...</option>
              <option value="Baja">Baja</option>
              <option value="Media">Media</option>
              <option value="Alta">Alta</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-sm-4">
            <label>Fecha Limite de Pago:</label>
            <input type="date" class="form-control" name="fehcalimAcuerdo" id="fechalimAcuerdo" min="<?php echo date('Y-m-d'); ?>"/>
            <!--<input type="text" class="form-control datepicker-here" readonly name="fehcalimAcuerdo" id="fechalimAcuerdo" min="<?php //echo date('Y-m-d'); ?>"/>-->
          </div>
          <div class="form-group col-sm-4">
            <label>Cuotas:</label>
            <select name="cuotasmodalAcuerdo" id="cuotasmodalAcuerdo" class="form-control">
              <option value="0">0</option>
              <?php for($i = 1; $i <= 12; $i++){ ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group col-sm-4">
            <label>Valor Pago con Descuento:</label>
            <input type="number" class="form-control" name="valorpagAcuerdo" id="valorpagAcuerdo"/>
          </div>
        </div>
        <?php if(isset($creditosv[0]['descuento'])){
          $descAc = $creditosv[0]['descuento'];
        }else{
          $descAc = 0;
        }

        ?>
        <div class="form-group">
          <input type="hidden" name="ModalPiso" id="ModalPiso" />
          <input type="hidden" name="modalSaldo" id="modalSaldo" />
          <input type="hidden" name="ModalCuotas" id="ModalCuotas" />
          <input type="hidden" name="ModalCapital" id="ModalCapital" />
          <input type="hidden" name="ModalCuotasTres" id="ModalCuotasTres" />
          <input type="hidden" name="ModalCuotasCuatro" id="ModalCuotasCuatro" />
          <input type="hidden" name="ModalTarifa" id="ModalTarifa" />
          <button type="button" id="generaCuotasAcuerdo" class="btn btn-success">Generar</button>
        </div>
        <div id="respuestaCuotasAcuerdo" class="row">

        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="evolutivoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog2 modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Evolutivo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="respuestaEvolutivo" class="modal-body">

      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="asignacionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog2 modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Información Total Archivo Asignación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="respuestaAsignacion" class="modal-body">

      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="enviarAcuerdoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Envio de Acuerdo de Pago</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="respuestaCuotasAcuerdoFinal" class="modal-body">
        <div class="row">
          <div class="form-group col-sm-4">
            <label>Dirección:</label>
            <input type="text" style="color: #707070;" readonly class="form-control" name="correoAcuerdoEnvio" id="correoAcuerdoEnvio"/>
          </div>
        </div>
        <div class="clear: both;" style="height: 25px; width: 100%"></div>
        <div class="row">
          <div id="listadoAcuerdosEnvio" class="form-group col-sm-4">
            <table class="table table-bordered">
              <tr>
                <th>Enviar</th>
                <th>Obligación</th>
              </tr>
              <?php foreach($acuerdos as $acenv){ ?>
              <tr>
                <td><input type="checkbox" name="enviarPdfAcuerdo[]" value="<?php echo $acenv['obligacion']; ?>" class="form-control"/></td>
                <td><?php echo $acenv['obligacion']; ?></td>
              </tr>
              <?php } ?>
            </table>
          </div>
        </div>
        <div class="clear: both;" style="height: 25px; width: 100%"></div>
        <div class="form-group">
          <button type="button" id="generaCuotasAcuerdoFinal" class="btn btn-success">Revisar y Enviar</button>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="enviarPropuestaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Envio de Propuesta de Pago</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="respuestaCuotasAcuerdoFinal" class="modal-body">
        <div class="row">
          <div class="form-group col-sm-4">
            <label>Dirección:</label>
            <input type="text" style="color: #707070;" readonly class="form-control" name="correoPropuestaEnvio" id="correoPropuestaEnvio"/>
          </div>
          <div class="form-group col-sm-4">
            <label>Fecha Limite de Pago:</label>
            <input type="date" class="form-control" name="fehcalimPropuesta" id="fechalimPropuesta"/>
          </div>
          <div class="form-group col-sm-4">
            <label>Valor Pago con Descuento:</label>
            <input type="number" class="form-control" name="valorpagPropuesta" id="valorpagPropuesta" value="0"/>
          </div>
        </div>
        <div class="clear: both;" style="height: 25px; width: 100%"></div>
        <div class="form-group">
          <input type="hidden" name="propuestaPiso" id="propuestaPiso" />
          <button type="button" id="generaPropuestaFinal" class="btn btn-success">Enviar</button>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="whatsappTemplatemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Envio de mensaje whatsapp</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div  class="modal-body">
        <div class="row">
          <table class="table table-bordered">
            <?php foreach($templatesList as $temp){ ?>
            <tr>
              <td style="cursor: pointer; border-color: #aeb6bf;" class="select-template" texto="<?php echo $temp['template']; ?>"><?php echo $temp['template']; ?></td>
            </tr>
            <?php } ?>
          </table>
        </div>
        <div class="clear: both;" style="height: 25px; width: 100%"></div>
        <div class="form-group">
          <input type="hidden" name="numeroTemplate" id="numeroTemplate" />
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="formatosMailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Formatos Mail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div  class="modal-body">
        <div class="row">
          <table class="table table-bordered">
            <tr>
              <td style="cursor: pointer;" class="select-template-mailformato" texto="carta_impago">Carta Impago</td>
            </tr>
            <tr>
              <td style="cursor: pointer;" class="select-template-mailformato" texto="propuesta_pago_total">Negacion Propuesta Pago Total</td>
            </tr>
            <tr>  
              <td style="cursor: pointer;" class="select-template-mailformato" texto="pazysalvo">Paz y Salvo</td>
            </tr>
          </table>
        </div>
        <div class="clear: both;" style="height: 25px; width: 100%"></div>
        <div class="form-group">
          <input type="hidden" name="mailOtrosSelect" id="mailOtrosSelect" />
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$('#fecha-acuerdo').data('datepicker')
</script>
<div id="pausaScreen">
  <div class="auth-container">
    <div class="center-block">
      <div class="auth-module">
        <div class="form display-block text-center">
          <img src="img/demo/img1.jpg" alt="img" class="img-circle img-30"/>
          <h1 class="m-t-10 no-margin-b text-center"><?php $session['usuario']; ?></h1>
          <p class="no-padding m-b-20">Unlock your dashboard</p>
          <form class="form-horizontal">
            <div class="form-group">
              <div class="form-group has-feedback has-feedback-left">
                <input type="password" class="form-control" placeholder="Password">
                <div class="form-control-feedback">
                  <i class="icon-key"></i>
                </div>
              </div>
              <button class="btn btn-success btn-block">Desbloquear</button>
            </div>
          </form>
        </div>
      </div>
      <div class="footer">
        <div class="pull-left">
          © 2018 Polaris - Web Collector&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;</div>
          <div class="pull-right">
            <div class="label label-info">Version: 3.0</div>
          </div>
        </div>
      </div>
    </div>
  </div>





</body>
</html>
