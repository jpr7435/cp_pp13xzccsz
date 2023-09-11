
<!-- ScrolltoTop -->
<!-- <a id="scrollTop" href="#top"><i class="icon-arrow-up12"></i></a>-->
<!-- /ScrolltoTop -->
</div>
<!-- Rightbar -->

<?php

$ci3 = &get_instance();
$ci3->load->model("vista");

$pausasList = $this->vista->getPausasList();
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
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/core/jquery/jquery.js"></script>
<!--<script src="http://<?php //echo $_SERVER['HTTP_HOST']; ?>/front/lib/js/core/jquery/jquery.ui.js"></script>-->
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/core/jquery-ui.js"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/core/site.js"></script>

<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/core/strength.js"></script>

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
<!--<script src="http://<?php //echo $_SERVER['HTTP_HOST']; ?>/front/lib/js/forms/datepicker.min.js"></script>
<script src="http://<?php //echo $_SERVER['HTTP_HOST']; ?>/front/lib/js/forms/datepicker.en.js"></script>
<script src="http://<?php //echo $_SERVER['HTTP_HOST']; ?>/front/lib/js/pages/forms/picker_date.js"></script>-->
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/forms/formatter.min.js"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/core/formats.js"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/pages/forms/form_inputs_basic.js"></script>

<script>
$.datepicker.setDefaults($.datepicker.regional["es"]);
var dateToday = new Date();
$( "#prox-gest-fec" ).datepicker();
$( "#fechaIni" ).datepicker();
$( "#fechaFin" ).datepicker();
$( "#fecha1" ).datepicker({
        showButtonPanel: true,
        minDate: dateToday
});
$( "#fecha2" ).datepicker({
        showButtonPanel: true,
        minDate: dateToday
});
$( "#fecha3" ).datepicker({
        showButtonPanel: true,
        minDate: dateToday
});
$( "#fecha4" ).datepicker({
        showButtonPanel: true,
        minDate: dateToday
});
$( "#fecha5" ).datepicker({
        showButtonPanel: true,
        minDate: dateToday
});
$( "#fecha6" ).datepicker({
        showButtonPanel: true,
        minDate: dateToday
});
$( "#fecha7" ).datepicker({
        showButtonPanel: true,
        minDate: dateToday
});
$( "#fecha8" ).datepicker({
        showButtonPanel: true,
        minDate: dateToday
});
$( "#fecha9" ).datepicker({
        showButtonPanel: true,
        minDate: dateToday
});
$( "#fecha10" ).datepicker({
        showButtonPanel: true,
        minDate: dateToday
});
$( "#fecha11" ).datepicker({
        showButtonPanel: true,
        minDate: dateToday
});
$( "#fecha-prog" ).datepicker({
        showButtonPanel: true,
        minDate: dateToday
});


$( "#confirm1" ).datepicker({
        showButtonPanel: true,
        maxDate: dateToday
});
$( "#confirm2" ).datepicker({
        showButtonPanel: true,
        maxDate: dateToday
});
$( "#confirm3" ).datepicker({
        showButtonPanel: true,
        maxDate: dateToday
});
$( "#confirm4" ).datepicker({
        showButtonPanel: true,
        maxDate: dateToday
});
$( "#confirm5" ).datepicker({
        showButtonPanel: true,
        minDate: dateToday
});
$( "#confirm6" ).datepicker({
        showButtonPanel: true,
        maxDate: dateToday
});
$( "#confirm7" ).datepicker({
        showButtonPanel: true,
        maxDate: dateToday
});
$( "#confirm8" ).datepicker({
        showButtonPanel: true,
        minDate: dateToday
});
$( "#confirm9" ).datepicker({
        showButtonPanel: true,
        maxDate: dateToday
});
$( "#confirm10" ).datepicker({
        showButtonPanel: true,
        maxDate: dateToday
});
$( "#confirm11" ).datepicker({
        showButtonPanel: true,
        maxDate: dateToday
});

</script>

<script>
$('#password').strength({
            strengthClass: 'strength',
            strengthMeterClass: 'strength_meter',
            strengthButtonClass: 'button_strength',
            strengthButtonText: 'Show Password',
            strengthButtonTextToggle: 'Hide Password'
        });

</script>
<?php
$preurl = $_SERVER['PHP_SELF'];
$url = explode("/", $preurl);

if ($url[2] == "asignacion") {
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
                  <td style="cursor: pointer;" iden="<?php echo $pl['idPausa']; ?>"><?php echo $pl['descripcion']; ?></td>
               </tr>
             <?php } ?>
            </tbody>
        </table>
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
          © 2018 Smart Contact&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;</div>
        <div class="pull-right">
          <div class="label label-info">Version: 1.0</div>
        </div>
      </div>
    </div>
  </div>
</div>


</body>
</html>
