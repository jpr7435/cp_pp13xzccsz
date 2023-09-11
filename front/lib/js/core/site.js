$(document).ready(function() {

    $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        prevText: '< Ant',
        nextText: 'Sig >',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
        weekHeader: 'Sm',
        dateFormat: 'mm/dd/yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['es']);

    var x = document.cookie;
    var y = getCookie("bloqueo");
    if (y == 1) {
        $(".modal-login").css("display", "block");
        cronoCall();
    }
    var url = window.location.href;
    var url2 = url.split("index.php");
    //var hoy = new Date();
    //var date = new Date();
    //var priorDate = new Date().setDate(hoy.getDate()+30);
    //var dateString = date.toISOString().split('T')[0];

    $("#fechas-acuerdos").datepicker({ minDate: -1, maxDate: "+30D", beforeShowDay: $.datepicker.noWeekends });
    $("#fechaIni").datepicker();
    $("#fechaFin").datepicker();
    $("#fecha-prog").datetimepicker();
    $("#fehcalimAcuerdo").datetimepicker();

    //$(".datepicker-here").datepicker({ minDate: -1, maxDate: "+30D", beforeShowDay: $.datepicker.noWeekends });
    $(".datepicker-here").datepicker({ minDate: -1, maxDate: "+30D" });

    /*$('#fechas-acuerdos').datepicker({
  language: 'es',
  minDate: hoy// Now can select only dates, which goes after today
});*/

    $.post(url2[0] + "index.php/getprogcall", {}, function(data) {
        if (data == 0) {

        } else {
            $(".modal-body-prog").html(data);
            modalProg();
        }
    });

    $(".sendMailDesistimiento").click(function() {
        var y = confirm('Seguro desea enviar carta de desistimiento?');
        var doc = $("#documentoActivo").val();
        var corr = $(this).attr("direccion");

        if (y == true) {
            $.post(url2[0] + "index.php/generardesistirpdf", { docu: doc, mail: corr }, function(data) {
                alert("ok");
            });
        }
    });

    $("#guardar-tarea").click(function() {
        var nombre = $("#nombretarea").val();
        var prioridad = $("#prioridadtarea").val();
        var flag = 0;

        if (nombre == "") {
            alert('Debe ingresar el nombre de la tarea.');
            flag += 1;
        } else if (prioridad == '6666') {
            alert('Debe seleccionar la prioridad de la tarea.');
            flag += 1;
        }

        if (flag == 0) {
            $("#create-tarea-form").submit();
        }

    });

    $(".click-tab").click(function() {
        var tab = $(this).attr("tab");

        $("#pagos").css("display", "none");
        $("#acuerdos").css("display", "none");
        $("#ratificaciones").css("display", "none");
        $("#poderes").css("display", "none");
        $("#feedback").css("display", "none");
        $("#cotitular").css("display", "none");


        var id = "#" + tab;
        $(id).css("display", "block");
    });



    $(".whatsapp-action").click(function() {
        var tele = $(this).attr("tele");
        $("#numeroTemplate").val(tele);
        $('#whatsappTemplatemodal').modal({
            backdrop: 'static'
        });
        $('#whatsappTemplatemodal').modal('show');
    });

    $(".loadOtros").click(function() {
        var dir = $(this).attr("direccion");
        $("#mailOtrosSelect").val(dir);
        $('#formatosMailModal').modal({
            backdrop: 'static'
        });
        $('#formatosMailModal').modal('show');
    });



    $(".select-template").click(function() {
        var txt = $(this).attr("texto");
        var tele = $("#numeroTemplate").val();
        var doc = $("#documentoActivo").val();
        var r = confirm("Se va a enviar: " + txt);

        if (r == true) {
            $.post(url2[0] + "index.php/sms/sendwhatsapp", { texto: txt, telefono: tele, docu: doc }, function(data) {
                alert("Se envio correctamente.");
                $('#whatsappTemplatemodal').modal('hide');
            });
        }

    });

    $(".select-template-mailformato").click(function() {
        var txt = $(this).attr("texto");
        var mails = $("#mailOtrosSelect").val();
        var doc = $("#documentoActivo").val();
        var r = confirm("Se va a enviar: " + txt);

        if (r == true) {
            $.post(url2[0] + "index.php/sendformatomail", { texto: txt, mail: mails, docu: doc }, function(data) {
                alert("Se envio correctamente.");
                $('#formatosMailModal').modal('hide');
            });
        }

    });



    $("#campo-tareas").change(function() {
        var tipo = $(this).val().split(".");

        if (tipo[1] == "fechapromesa") {
            $("#select-normal").css("display", "none");
            $("#select-fechas").css("display", "block");
            $("#flag-tareas").val("1");
        } else if (tipo[1] == "FecUltimaGestion") {
            $("#select-normal").css("display", "none");
            $("#select-fechas").css("display", "block");
            $("#flag-tareas").val("1");
        } else {
            $("#select-fechas").css("display", "none");
            $("#select-normal").css("display", "block");
            $("#flag-tareas").val("0");
        }
    });
    $("#saveCriteriosSms").click(function() {
        var flag = 0;
        var campo = $("#campo-tareas").val().split(';');
        var operador = $("#operador-tareas").val();

        var tarea = $("#tarea-tareas").val();
        var bandera = $("#flag-tareas").val();

        if (bandera == "1") {
            var valor = $("#valor2-tareas").val();
        } else {
            var valor = $("#valor-tareas").val();
        }


        if (campo[0] == "0") {
            alert("Debe seleccionar un campo para el criterio.");
            flag += 1;
        } else if (operador == "0") {
            alert("Debe seleccionar un operador para el criterio.");
            flag += 1;
        } else if (valor == "") {
            alert("Debe ingresar un valor para el criterio.");
            flag += 1;
        }

        $.post(url2[0] + "index.php/savecriteriotareasadminsms", { campos: campo[0], operadors: operador, valors: valor, tareas: tarea }, function(data) {
            $("#criterios-table-result").html(data);
            $("#form-criterios").trigger("reset");

        });

    });


    $("#preview-sms").click(function() {
        var tarea = $(this).attr('tarea');
        $.post(url2[0] + "index.php/previewsmsadmin", { tareas: tarea }, function(data) {
            alert(data);
        });
    });

    $("#create-sms").click(function() {
        var tarea = $(this).attr('tarea');
        $.post(url2[0] + "index.php/createsmsadmin", { tareas: tarea }, function(data) {
            alert(data);

        });
    });


    $("#savefielddinamic-btn").click(function() {
        var flag = 0;

        if ($("#name-field").val() == "") {
            alert("Debe ingresar el nombre del campo.");
            flag += 1;
        }

        if (flag == 0) {
            $("#savedinamic").submit();
        }

    });

    $(".guardar-campo").click(function() {
        var flag = $(this).attr("flag");
        var iden = "#options-field" + flag;
        var campo = $(this).attr("idcam");
        var options = $(iden).val();


        $.post(url2[0] + "index.php/admin/saveoptions", { campo: campo, options: options }, function(data) {
            alert("Opciones guardadas con exito.");
        });


    });

    $(".borrar-campo").click(function() {
        var flag = $(this).attr("flag");
        var iden = "#options-field" + flag;
        var campo = $(this).attr("idcam");
        var options = $(iden).val();

        var r = confirm("Seguro que desea eliminar este campo dinamico?");
        if (r == true) {
            $.post(url2[0] + "index.php/admin/dropcampo", { campo: campo, options: options }, function(data) {
                location.reload();
            });
        }
    });


    $(".see-evolutivo").click(function() {
        var obligacion = $(this).attr("oh");
        $('#evolutivoModal').modal({
            backdrop: 'static'
        });
        $.post(url2[0] + "index.php/showevolutivo", { oh: obligacion }, function(data) {
            $("#respuestaEvolutivo").html(data);
            $('#evolutivoModal').modal('show');
        });

    });


    $(".see-asignacion").click(function() {
        var obligacion = $(this).attr("oh");
        $('#asignacionModal').modal({
            backdrop: 'static'
        });
        $.post(url2[0] + "index.php/showasignaciontotal", { oh: obligacion }, function(data) {
            $("#respuestaAsignacion").html(data);
            $('#asignacionModal').modal('show');
        });

    });








    $("#saveinfo-cl").click(function() {
        var doc = $("#documentoActivo").val();
        var text = $("#infocl-box").val();

        $.post(url2[0] + "index.php/saveinfocl", { docu: doc, txt: text }, function(data) {
            alert("Se ha guardado la informacion");
        });
    });

    $("#generaCuotasAcuerdoFinal").click(function() {

        var doc = $("#documentoActivo").val();
        var mail = $("#correoAcuerdoEnvio").val();
        var datas = { 'enviarPdfAcuerdo[]': [], docu: doc, correo: mail };


        $("input:checked").each(function() {
            datas['enviarPdfAcuerdo[]'].push($(this).val());
        });
        $.post(url2[0] + "index.php/generaracuerdopdf", datas, function(data) {
            $("#respuestaCuotasAcuerdoFinal").html(data);
        });
    });

    $("#generaPropuestaFinal").click(function() {

        var doc = $("#documentoActivo").val();
        var mail = $("#correoPropuestaEnvio").val();
        var fecha = $("#fechalimPropuesta").val();
        var valor = $("#valorpagPropuesta").val();
        var piso = parseInt($("#pisoGeneral").val());
        var datas = { docu: doc, correo: mail, fec: fecha, val: valor };
        var flag = 0;

        console.log(piso);
        console.log(valor);

        if (valor < piso) {
            alert("El valor no puede ser menor al valor minimo de negociacion.");
            flag += 1;
        }

        if (flag == 0) {

            $.post(url2[0] + "index.php/generarpropuestapdf", datas, function(data) {
                if (data == 1) {
                    alert('Correo Enviado');
                    $('#enviarPropuestaModal').modal('hide');
                } else {
                    alert('Error');
                }
            });
            
        }
    });


    $(".add-acuerdo").click(function() {
        var obligacion = $(this).attr("oh");
        var piso = $(this).attr("piso");
        var tot = $(this).attr("saldotot");
        var cuotas = $(this).attr("cuotas");
        var cuotasdos = $(this).attr("cuotasdos");
        var cuotastres = $(this).attr("cuotastres");
        var cuotascuatro = $(this).attr("cuotascuatro");
        var idtarifa = $(this).attr("tarifa");
        var capital = $(this).attr("capital");
        $('#acuerdoModal').modal({
            backdrop: 'static'
        });
        $("#ohModalAcuerdo").val(obligacion);
        $("#ModalPiso").val(piso);
        $("#modalSaldo").val(tot);
        $("#ModalCuotas").val(cuotasdos);
        $("#ModalCuotasTres").val(cuotastres);
        $("#ModalCuotasCuatro").val(cuotascuatro);
        $("#ModalCapital").val(capital);
        $("#ModalTarifa").val(idtarifa);
        $('#acuerdoModal').modal('show');
    });


    $("#generaCuotasAcuerdo").click(function() {
        var desc = parseInt($("#vldescuentoAcuerdo").val());
        var saldotot = parseInt($("#modalSaldo").val());
        var judicial = 0;
        var pisos = parseInt($("#ModalPiso").val());
        var fec = $("#fechalimAcuerdo").val();
        var cuotas = $("#cuotasmodalAcuerdo").val();
        var oh = $("#ohModalAcuerdo").val();
        var vlcuodos = $("#ModalCuotas").val();
        var vlcuotres = $("#ModalCuotasTres").val();
        var vlcuocuatro = $("#ModalCuotasCuatro").val();
        var vlacu = parseInt($("#valorpagAcuerdo").val());
        var proba = $("#probabilidadpago").val();
        var tarifa = $("#ModalTarifa").val();
        var flag = 0;

        if (desc == '' || desc == 0) {
            alert("Debe ingresar el valor del acuerdo.");
            flag = +1;
        } else if (fec == '' || fec == 0) {
            alert("Debe seleccionar la fecha del primer pago.");
            flag = +1;
        } else if (cuotas == 0) {
            alert("Debe seleccionar las cuotas del acuerdo.");
            flag = +1;
        } else if (cuotas == 1 && vlacu <= pisos) {
            alert("El valor a negociar del acuerdo esta por debajo del minimo de negociacion.");
            flag = +1;
        } else if (cuotas > 1 && cuotas < 4 && vlacu <= vlcuodos) {
            alert("El valor a negociar del acuerdo esta por debajo del minimo de negociacion.");
            flag = +1;
        } else if (cuotas > 3 && cuotas < 7 && vlacu <= vlcuotres) {
            alert("El valor a negociar del acuerdo esta por debajo del minimo de negociacion.");
            flag = +1;
        } else if (cuotas > 6 && cuotas < 13 && vlacu <= vlcuocuatro) {
            alert("El valor a negociar del acuerdo esta por debajo del minimo de negociacion.");
            flag = +1;
        }else if (proba == 0) {
            alert("Debe seleccionar la probabilidad de pago.");
            flag = +1;
        }

        if ($('#esjudicial').prop('checked')) {
            judicial = 1;
        }



        if (flag == 0) {
            $.post(url2[0] + "index.php/generarCuotasAcuerdo", { fecha: fec, valor: vlacu, cuota: cuotas, obl: oh, piso: pisos, saldototal: saldotot, judi: judicial, idtarifa: tarifa, prob: proba }, function(data) {
                $("#respuestaCuotasAcuerdo").html(data);
            });
        }

    });

    $(".sendMailAcuerdo").click(function() {
        var dir = $(this).attr("direccion");
        $('#enviarAcuerdoModal').modal({
            backdrop: 'static'
        });
        $("#correoAcuerdoEnvio").val(dir);
        $('#enviarAcuerdoModal').modal('show');
    });

    $(".sendMailPropuesta").click(function() {
        var dir = $(this).attr("direccion");
        $('#enviarPropuestaModal').modal({
            backdrop: 'static'
        });
        $("#correoPropuestaEnvio").val(dir);
        $('#enviarPropuestaModal').modal('show');
    });

    $("#dotablas").click(function() {
        var flag = 0;
        if ($('#tablas').val() == '') {
            alert('Debe seleccionar los archivos diarios');
            flag += 1;
        }
        if (flag == 0) {
            $('#cargartablas').submit();

        }

    });


    /*
     *
     * Inicio de action Select
     *
     */
    $("#cerrarSelect").click(function() {
        $("#actionSelect-panel").css("display", "none");
        $("#actionPanel").css("display", "block");
    });
    $("#idOthers").click(function() {
        $("#actionSelect-panel").css("display", "block");
        $("#actionPanel").css("display", "none");
    });

    $("#actionSelect").change(function() {
        var accion = $(this).val();
        var tel = $(this).attr("tel");

        $("#actionPanel").css("display", "none");
        $("#actionSelect-panel").css("display", "none");
        $("#idAccionGlobal").val(accion);

        var acc = $("#idAccionGlobal").val();
        $("#panelGestion-actions").show();
        $("#idContactGest").focus();
        $.post(url2[0] + "index.php/getcontactogestion", { accion: acc }, function(data) {
            $("#idContactGest").css("display", "block");
            $("#idContactGest").empty();
            $("#idContactGest").append('<option value="0">Contacto.</option>');

            $("#idResultadoGest").empty();
            $("#idResultadoGest").append('<option value="0">Resultado.</option>');

            $("#idMotivosGest").val("0");
            $("#idMotivosGest").css("display", "none");
            $("#idContactGest").append(data);
        });

    });
    /*
     *
     * FIN de action Select
     *
     */

    $("#loginBtn-pausa").click(function() {

        var user = $("#username").val();
        var password = $("#password").val();
        var tiempos = $("#hour").text() + ":" + $("#minute").text() + ":" + $("#second").text();
        var intento = 0;
        var flag = 0;

        if (user == "") {
            alert("Debe ingresar su usuario.");
            flag += 1;
        } else if (password == "") {
            alert("Debe ingresar su password.");
            flag += 1;
        }

        if (flag == 0) {
            $.post(url2[0] + "index.php/validate-login", { usuario: user, pass: password, inten: tiempos }, function(data) {
                if (data == '666') {
                    $("#modalSelectPausas").css("display", "none");
                    $(".modal-login").css("display", "none");
                    closeModal();
                    $("#password").val("");
                    cronoStop();
                    $("#hour").val("00");
                    $("#minute").val("00");
                    $("#second").val("00");
                } else {
                    $("#login-options-pausa").html(data);
                }

            });
        }
    });


    $("#detalle-sms-btn").click(function() {

        var msg = $("#msg-envio").val();
        var idn = $("#campana-activa").val();
        $.post(url2[0] + "index.php/sms/savemsg", { mensaje: msg, campana: idn }, function(data) {
            alert("Mensaje actualizado con exito.");
            location.reload(true);
        });
    });

    $("#new-respuesta-sms-btn").click(function() {
        $("#modal-respuesta-sms").css("display", "block");
    });

    $("#cancel-new-respuesta").click(function() {
        $("#modal-respuesta-sms").css("display", "none");
    });

    $("#btn-guardar-respuesta-sms").click(function() {
        var flag = 0;
        if ($("#codigo-new-sms").val() == "") {
            alert("Debe ingresar un codigo para la respuesta.");
            flag += 1;
        }
        if ($("#respuesta-new-sms").val() == "") {
            alert("Debe el texto que se enviara en la respuesta.");
            flag += 1;
        }

        if (flag == 0) {
            $("#new-respuesta-form").submit();
        }
    });

    $("#enviar-sms-btn").click(function() {

        var idn = $("#campana-activa").val();
        location.href = url2[0] + "index.php/smsenvio/" + idn;
    });


    $("#setPausas").click(function() {
        modalPau();
    });
    $("#gestionEfectiva").click(function() {

        var doc = $("#documentoActivo").val();

        $.post(url2[0] + "index.php/getGestion", { docu: doc, flag: 1 }, function(data) {

            $(".gestionAdelantada").html(data);


        });
    });

    $("#gestionJudicial").click(function() {

        var doc = $("#documentoActivo").val();

        $.post(url2[0] + "index.php/getGestion", { docu: doc, flag: 2 }, function(data) {
            $(".gestionAdelantada").html(data);
        });
    });

    $("#gestionSms").click(function() {

        var doc = $("#documentoActivo").val();

        $.post(url2[0] + "index.php/getGestion", { docu: doc, flag: 3 }, function(data) {

            $(".gestionAdelantada").html(data);


        });
    });

    $("#gestionHistorico").click(function() {

        var doc = $("#documentoActivo").val();

        $.post(url2[0] + "index.php/getGestion", { docu: doc, flag: 4 }, function(data) {

            $(".gestionAdelantada").html(data);


        });
    });

    $(".calculador").change(function() {
        var oh = $(this).attr("flag");
        var idtot = "#" + oh + "capTotal";
        var idmora = "#" + oh + "capMora";
        var iddias = "#" + oh + "dias";
        var idacele = "#" + oh + "acelerado";
        var idporc = "#" + oh + "descuento";
        var idmodali = "#" + oh + "modalida";
        var idaprueba = "#" + oh + "autoriza";
        var idvlfinal = "#" + oh + "vlfinal";
        var idnuevocap = "#" + oh + "nuevocap";
        var idgac = "#" + oh + "porcgac";
        var idvlgac = "#" + oh + "vlgac";
        var idvltot = "#" + oh + "vltotal";
        var idsaldotot = "#" + oh + "saldoTotal2";
        var idbenefi = "#" + oh + "beneficio";
        var idcuo2 = "#" + oh + "cuota2";
        var idcuo3 = "#" + oh + "cuota3";

        var tramo = $("#tramos").val();
        var captotal = $(idtot).val();
        var capmora = $(idmora).val();
        var acelerado = $(idacele).val();
        var modalidad = $(idmodali).val();
        var saldotot = $(idsaldotot).val();
        var gac = $(idgac).val();



        var str2 = "Si";
        var i = acelerado.localeCompare(str2)
        var dias = $(iddias).val();
        var flag = 0;
        var nuevocap = 0;

        var descuento = $(idporc).val();

        var vlDescuento = 0;
        var f = 0;

        if (parseInt(dias) < 90) {
            alert("Esta obligacion no tiene descuento.");
            flag += 1;
        } else {

            if (i == 0) {
                f = parseInt(captotal) * parseInt(descuento);
                nuevocap = parseInt(captotal);
                vlDescuento = f / 100;
            } else {
                f = parseInt(captotal) * parseInt(descuento);
                nuevocap = parseInt(captotal);
                vlDescuento = f / 100;
            }

            $.post(url2[0] + "index.php/valida-vectores", { tramos: tramo, descuentos: descuento, vlDescuentos: vlDescuento, modalidads: modalidad, nuevocaps: nuevocap }, function(data) {

                var result;

                result = data.split('-');
                $(idaprueba).val(result[2]);

                var u = Number(result[0]);

                $(idvlfinal).val(addCommas(u.toFixed(0)));

                var d = Number(result[1]);

                $(idnuevocap).val(addCommas(d.toFixed(0)));


                var vlgacs1 = (parseInt(result[1]) * parseInt(gac));
                var vlgacs = vlgacs1 / 100;


                var t = Number(vlgacs);

                $(idvlgac).val(addCommas(t.toFixed(0)));

                var vltotal = parseInt(result[1]) + vlgacs;


                var c = Number(vltotal);

                $(idvltot).val(addCommas(c.toFixed(0)));

                var benfi = parseInt(saldotot) - vltotal;

                var s = Number(benfi);

                $(idbenefi).val(addCommas(s.toFixed(0)));

                var dc = c.toFixed(0) / 2;
                var tc = c.toFixed(0) / 3;


                $(idcuo2).val(addCommas(dc.toFixed(0)));
                $(idcuo3).val(addCommas(tc.toFixed(0)));

                //console.log(data);
                //$(".gestionAdelantada").html(data);


                /*  Sumar Totales */
                var finalTotal = 0;
                var nuevocapitalTotal = 0;
                var vlgacTotal = 0;
                var vltotalTotal = 0;
                var beneficioTotal = 0;
                var cuota2Total = 0;
                var cuota3Total = 0;

                $("#simulador-modal").find(":input").each(function() {

                    var vl = 0;
                    var xx = 0;
                    var clase = $(this).attr("class");

                    if (clase == "vlfinal") {
                        vl = $(this).val();
                        xx = vl.replace(/,/g, "");

                        finalTotal += parseInt(xx);
                    } else if (clase == "nuevocap") {

                        vl = $(this).val();
                        xx = vl.replace(/,/g, "");

                        nuevocapitalTotal += parseInt(xx);

                    } else if (clase == "vlgac") {

                        vl = $(this).val();
                        xx = vl.replace(/,/g, "");

                        vlgacTotal += parseInt(xx);

                    } else if (clase == "vltotal") {

                        vl = $(this).val();
                        xx = vl.replace(/,/g, "");

                        vltotalTotal += parseInt(xx);

                    } else if (clase == "beneficio") {

                        vl = $(this).val();
                        xx = vl.replace(/,/g, "");

                        beneficioTotal += parseInt(xx);

                    } else if (clase == "cuota2") {

                        vl = $(this).val();
                        xx = vl.replace(/,/g, "");

                        cuota2Total += parseInt(xx);

                    } else if (clase == "cuota3") {

                        vl = $(this).val();
                        xx = vl.replace(/,/g, "");

                        cuota3Total += parseInt(xx);

                    }




                });
                $("#totalvlfinal").val(addCommas(finalTotal));
                $("#totalnuevocap").val(addCommas(nuevocapitalTotal));
                $("#totalvlgac").val(addCommas(vlgacTotal));
                $("#totalvltotal").val(addCommas(vltotalTotal));
                $("#totalbeneficio").val(addCommas(beneficioTotal));
                $("#totalcuota2").val(addCommas(cuota2Total));
                $("#totalcuota3").val(addCommas(cuota3Total));





                /*  FIN  Sumar Totales */

            });


        }





    });

    $("#create-campana-btn").click(function() {
        var nombre = $("#nombre-campana").val();
        var descrip = $("#desc-campana").val();
        var flag = 0;

        if (nombre == "") {
            alert("Sebe ingresar el nombre de la campana.");
            flag += 1;
        } else if (descrip == "") {
            alert("Sebe ingresar la descripcion de la campana.");
            flag += 1;
        }

        if (flag == 0) {
            $("#campana-form").submit();
        }
    });

    $("#gestionCompleta").click(function() {
        var doc = $("#documentoActivo").val();

        $.post(url2[0] + "index.php/getGestion", { docu: doc, flag: 0 }, function(data) {

            $(".gestionAdelantada").html(data);


        });
    });
    $(".cerrar-sim").click(function() {
        $("#simulador-modal").css("display", "none");
    });
    $("#simulador-modal").draggable();
    $("#panelGestion").draggable();
    $("#panelGestion-actions").draggable();
    $("#panelDireccion").draggable();
    $("#menu-close").click(function() {
        $(".sidebar").hide("slow");
        $(this).css("display", "none");
        $("#menu-open").css("display", "block");
        $(".main-container").animate({
            marginLeft: "0px",
        }, 500);
    });
    $("#menu-open").click(function() {
        $(".sidebar").show("slow");
        $(this).css("display", "none");
        $("#menu-close").css("display", "block");
        $(".main-container").animate({
            marginLeft: "200px",
        }, 500);
    });

    /**** OPERATIVO ****/
    $("#genera-informe-bbva").click(function() {
        var fechaini = $("#fechaIni").val();
        var fechafin = $("#fechaFin").val();
        var flag = 0;


        if (fechaini == '') {
            alert("Debe seleccionar la fecha de inicio.");
            flag += 1;
        } else if (fechafin == '') {
            alert("Debe seleccionar la fecha de finalizacion.");
            flag += 1;
        }

        if (flag == 0) {
            /*$.post(url2[0] + "index.php/generainformebbva", {fechaIni: fechaini, fechaFin: fechafin}, function (data) {
    $("#resultado-busqueda").html(data);
  });*/
            $("#fechas-bbva").submit();
        }
    });


    $("#genera-informe-llamadas-credivalores").click(function() {
        var fechaini = $("#fechaIni").val();
        var fechafin = $("#fechaFin").val();
        var flag = 0;


        if (fechaini == '') {
            alert("Debe seleccionar la fecha de inicio.");
            flag += 1;
        } else if (fechafin == '') {
            alert("Debe seleccionar la fecha de finalizacion.");
            flag += 1;
        }

        if (flag == 0) {
            /*$.post(url2[0] + "index.php/generainformebbva", {fechaIni: fechaini, fechaFin: fechafin}, function (data) {
    $("#resultado-busqueda").html(data);
  });*/
            $("#fechas-credivalores").submit();
        }
    });


    $("#genera-informe-llamadas").click(function() {
        var fechaini = $("#fechaIni").val();
        var fechafin = $("#fechaFin").val();
        var flag = 0;


        if (fechaini == '') {
            alert("Debe seleccionar la fecha de inicio.");
            flag += 1;
        } else if (fechafin == '') {
            alert("Debe seleccionar la fecha de finalizacion.");
            flag += 1;
        }

        if (flag == 0) {
            /*$.post(url2[0] + "index.php/generainformebbva", {fechaIni: fechaini, fechaFin: fechafin}, function (data) {
    $("#resultado-busqueda").html(data);
  });*/
            $("#fechas-bbva").submit();
        }
    });

    /**** FIN OPERATIVO ****/
    $(".prBox").click(function() {
        var cartera = $(this).attr("cartera");
        var url = url2[0] + "index.php/setpractivo/" + cartera;

        location.href = url;
    });

    $("#buscar-btn").click(function() {
        var criterio = $("#criterio").val();
        var valor = $("#valor").val();
        var flag = 0;

        if (criterio == 0) {
            alert("Debe seleccionar un criterio de busqueda.");
            flag += 1;
        } else if (valor == 0) {
            alert("Debe ingresar un valor para buscar.");
            flag += 1;
        }

        if (flag == 0) {
            $.post(url2[0] + "index.php/resultado-buscar", { crit: criterio, val: valor }, function(data) {
                $("#resultado-busqueda").html(data);
            });
        }
    });

    $("#buscar-evetnos-btn").click(function() {
        $("#modal-load").css("display", "block");
        var criterio = $("#criterio").val();
        var valor = $("#valor").val();
        var flag = 0;

        if (criterio == 0) {
            alert("Debe seleccionar un criterio de busqueda.");
            flag += 1;
        } else if (valor == 0) {
            alert("Debe ingresar un valor para buscar.");
            flag += 1;
        }

        if (flag == 0) {
            $.post(url2[0] + "index.php/resultado-eventos-buscar", { crit: criterio, val: valor }, function(data) {
                $("#resultado-eventos-busqueda").html(data);
                $("#modal-load").css("display", "none");
            });
        }
    });

    $("#next-tarea-btn").click(function() {
        location.href = url2[0] + "index.php/nexttarea";
    });

    $("#cargar-taera-btn").click(function() {

        var flag = 0;

        if ($("#file").val() == "") {
            alert("Debe seleccionar un archivo.");
            flag += 1;
        }

        if (flag == 0) {
            $("#modal-load").css("display", "block");
            $("#upload-file").submit();
        }
    });


    $("#cargar-btn").click(function() {

        var flag = 0;

        if ($("#file").val() == "") {
            alert("Debe seleccionar un archivo.");
            flag += 1;
        }

        if (flag == 0) {
            $("#modal-load").css("display", "block");
            $("#upload-file").submit();
        }
    });
    $("#campos-baseini-btn").click(function() {
        var flag = 0;

        $(".panel-body").find("select").each(function() {
            if ($(this).hasClass("obligatorio")) {
                if ($(this).val() == 0) {
                    alert("Debe seleccionar todos los campos.");
                    $(this).css("backgroundColor", "#FF8888");
                    flag += 1;
                } else {
                    $(this).css("backgroundColor", "#FFF");
                }
            }
        });
        if (flag == 0) {
            $("#modal-load").css("display", "block");
            $("#execute-baseini").submit();
        }
    });


    $("#progCall").click(function() {
        $("#actionPanel").css("display", "none");
        $("#panelProgCall").show("slow", function() {
            // Animation complete.
        });
    });
    /*
     *
     * Telfonos Action
     *
     */
    $("#idMailes").click(function() {
        $("#actionPanel").css("display", "none");
        var accion = $(this).attr("flag");
        $("#idAccionGlobal").val(accion);
        $("#panelCorreos").show("slow", function() {
            // Animation complete.
        });
    });


    $("#sendCall").click(function() {
        $("#actionPanel").css("display", "none");
        var accion = $(this).attr("flag");
        $("#idAccionGlobal").val(accion);
        $("#panelGestion").show("slow", function() {
            // Animation complete.
        });
    });

    $("#idDirecciones").click(function() {
        $("#actionPanel").css("display", "none");
        var accion = $(this).attr("flag");
        $("#idAccionGlobal").val(accion);
        $("#panelDireccion").show("slow", function() {
            // Animation complete.
        });
    });

    $("#add-actions").click(function() {
        $("#add-actions-box").css("display", "block");
    });

    $("#add-contacto").click(function() {
        $("#add-contacto-box").css("display", "block");
    });


    $("#add-resultado").click(function() {
        $("#add-resultado-box").css("display", "block");
    });

    $("#add-motivos").click(function() {
        $("#add-motivos-box").css("display", "block");
    });

    $("#add-relacion").click(function() {
        $("#add-relacion-box").css("display", "block");
    });

    $(".cancel-modal").click(function() {
        $(".modal-arbol").css("display", "none");
    });

    $("#save-new-action").click(function() {

        var accion = $("#new-accion").val();
        var guion = $("#new-accion-guion").val();
        var flag = 0;

        if (accion == "") {
            alert("Debe ingresar una accion.");
            flag += 1;
        }


        if (flag == 0) {
            $.post(url2[0] + "index.php/save-new-action", { action: accion, guio: guion }, function(data) {
                location.reload();
                $("#acciones-front").html(data);
                $(".modal-arbol").css("display", "none");
                $("#add-actions-box").css("display", "none");
            });
        }

    });

    $("#save-new-contacto").click(function() {

        var contacto = $("#new-contacto").val();
        var grupo = $("#new-contacto-grupo").val();
        var guion = $("#new-contacto-guion").val();
        var flag = 0;

        if (contacto == "") {
            alert("Debe ingresar un contacto.");
            flag += 1;
        } else if (grupo == 0) {
            alert("Debe seleccionar un grupo de contacto.");
            flag += 1;
        }


        if (flag == 0) {
            $.post(url2[0] + "index.php/save-new-contacto", { contact: contacto, group: grupo, guio: guion }, function(data) {
                location.reload();
                $("#contacto-front").html(data);
                $(".modal-arbol").css("display", "none");
                $("#add-contacto-box").css("display", "none");
            });
        }

    });

    $("#save-new-resultado").click(function() {

        var resultado = $("#new-resultado").val();
        var nivel = $("#new-resultado-nivel").val();
        var fecha = $("#new-resultado-fecha").val();
        var valor = $("#new-resultado-valor").val();
        var texto = $("#new-texto-nivel").val();
        var guion = $("#new-resultado-guion").val();
        var flag = 0;

        if (resultado == "") {
            alert("Debe ingresar un resultado.");
            flag += 1;
        } else if (isNaN(nivel)) {
            alert("El nivel debe sere valor numerico.");
            flag += 1;
        }


        if (flag == 0) {
            $.post(url2[0] + "index.php/save-new-resultado", { result: resultado, nive: nivel, fech: fecha, valo: valor, text: texto, guio: guion }, function(data) {
                location.reload();
                $("#resultado-front").html(data);
                $(".modal-arbol").css("display", "none");
                $("#add-resultado-box").css("display", "none");
            });
        }

    });

    $("#save-new-motivo").click(function() {

        var motivo = $("#new-motivo").val();

        var flag = 0;

        if (motivo == "") {
            alert("Debe ingresar un motivo de no pago.");
            flag += 1;
        }


        if (flag == 0) {
            $.post(url2[0] + "index.php/save-new-motivo", { motiv: motivo }, function(data) {
                location.reload();
                $("#motivos-front").html(data);
                $(".modal-arbol").css("display", "none");
                $("#add-motivos-box").css("display", "none");
            });
        }

    });

    $("#save-new-relacion").click(function() {

        var accion = $("#new-relacion-accion").val();
        var contacto = $("#new-relacion-contacto").val();
        var resultado = $("#new-relacion-resultado").val();

        var flag = 0;

        if (accion == 0) {
            alert("Debe seleccionar una accion.");
            flag += 1;
        } else if (contacto == 0) {
            alert("Debe seleccionar un contacto.");
            flag += 1;
        } else if (resultado == 0) {
            alert("Debe seleccionar un resultado.");
            flag += 1;
        }


        if (flag == 0) {
            $.post(url2[0] + "index.php/save-new-relacion", { action: accion, contact: contacto, result: resultado }, function(data) {
                location.reload();
                $("#relacion-front").html(data);
                $(".modal-arbol").css("display", "none");
                $("#add-relacion-box").css("display", "none");
            });
        }

    });

    $(".editar-acciones").click(function() {
        var id = $(this).attr("flag");
        var accion = $(this).attr("accion");
        var guion = $(this).attr("guion");

        $("#edit-accion").val(accion);
        $("#edit-accion-guion").val(guion);
        $("#edit-accion-id").val(id);

        $("#editar-actions-box").css("display", "block");

    });


    $(".editar-contacto").click(function() {
        var id = $(this).attr("flag");
        var contacto = $(this).attr("contacto");
        var grupo = $(this).attr("grupo");
        var guion = $(this).attr("guion");

        $("#edit-contacto").val(contacto);
        $("#edit-contacto-grupo option:eq(" + grupo + ")").prop("selected", true);
        $("#edit-contacto-guion").val(guion);
        $("#edit-contacto-id").val(id);

        $("#editar-contacto-box").css("display", "block");

    });

    $(".editar-resultado").click(function() {
        var id = $(this).attr("flag");
        var resultado = $(this).attr("resultado");
        var nivel = $(this).attr("nivel");
        var fecha = $(this).attr("fecha");
        var valor = $(this).attr("valor");
        var texto = $(this).attr("texto");
        var guion = $(this).attr("guion");




        $("#edit-resultado").val(resultado);
        $("#edit-resultado-nivel").val(nivel);
        $("#edit-resultado-fecha option:eq(" + fecha + ")").prop("selected", true);
        $("#edit-resultado-valor option:eq(" + valor + ")").prop("selected", true);
        $("#edit-resultado-texto option:eq(" + texto + ")").prop("selected", true);
        $("#edit-resultado-guion").val(guion);
        $("#edit-resultado-id").val(id);

        $("#editar-resultado-box").css("display", "block");

    });

    $(".editar-motivos").click(function() {
        var id = $(this).attr("flag");
        var motivo = $(this).attr("motivo");


        $("#edit-motivo").val(motivo);
        $("#edit-motivo-id").val(id);

        $("#editar-motivos-box").css("display", "block");

    });





    $("#edit-new-action").click(function() {

        var accion = $("#edit-accion").val();
        var guion = $("#edit-accion-guion").val();
        var id = $("#edit-accion-id").val();
        var flag = 0;

        if (accion == "") {
            alert("Debe ingresar una accion.");
            flag += 1;
        }


        if (flag == 0) {
            $.post(url2[0] + "index.php/edit-new-action", { action: accion, guio: guion, ids: id }, function(data) {
                location.reload();
                $("#acciones-front").html(data);
                $(".modal-arbol").css("display", "none");
                $("#edit-actions-box").css("display", "none");
            });
        }

    });

    $("#edit-new-contacto").click(function() {

        var contacto = $("#edit-contacto").val();
        var grupo = $("#edit-contacto-grupo").val();
        var guion = $("#edit-contacto-guion").val();
        var id = $("#edit-contacto-id").val();
        var flag = 0;

        if (contacto == "") {
            alert("Debe ingresar un contacto.");
            flag += 1;
        } else if (grupo == 0) {
            alert("Debe seleccionar un grupo de contacto.");
            flag += 1;
        }


        if (flag == 0) {
            $.post(url2[0] + "index.php/edit-new-contacto", { contact: contacto, group: grupo, guio: guion, ids: id }, function(data) {
                location.reload();
                $("#contacto-front").html(data);
                $(".modal-arbol").css("display", "none");
                $("#edit-contacto-box").css("display", "none");
            });
        }

    });

    $("#edit-new-resultado").click(function() {

        var resultado = $("#edit-resultado").val();
        var nivel = $("#edit-resultado-nivel").val();
        var fecha = $("#edit-resultado-fecha").val();
        var valor = $("#edit-resultado-valor").val();
        var texto = $("#edit-resultado-texto").val();
        var guion = $("#edit-resultado-guion").val();
        var id = $("#edit-resultado-id").val();
        var flag = 0;

        if (resultado == "") {
            alert("Debe ingresar un resultado.");
            flag += 1;
        } else if (isNaN(nivel)) {
            alert("El nivel debe sere valor numerico.");
            flag += 1;
        }


        if (flag == 0) {
            $.post(url2[0] + "index.php/edit-new-resultado", { result: resultado, nive: nivel, fech: fecha, valo: valor, text: texto, guio: guion, ids: id }, function(data) {
                location.reload();
                $("#resultado-front").html(data);
                $(".modal-arbol").css("display", "none");
                $("#edit-resultado-box").css("display", "none");
            });
        }

    });

    $("#edit-new-motivo").click(function() {

        var motivo = $("#edit-motivo").val();
        var id = $("#edit-motivo-id").val();

        var flag = 0;

        if (motivo == "") {
            alert("Debe ingresar un motivo de no pago.");
            flag += 1;
        }


        if (flag == 0) {
            $.post(url2[0] + "index.php/edit-new-motivo", { motiv: motivo, ids: id }, function(data) {
                location.reload();
                $("#motivos-front").html(data);
                $(".modal-arbol").css("display", "none");
                $("#edit-motivos-box").css("display", "none");
            });
        }

    });


    /* Telefonos */
    $(".unactiveTel").click(function() {
        var tel = $(this).attr("tel");
        var idtel = $(this).attr("idtel");

        $.post(url2[0] + "index.php/unactivatetel", { tele: tel, idtele: idtel }, function(data) {
            $("#actions-content").html(data);
        });
    });

    $(".activeTel").click(function() {
        var tel = $(this).attr("tel");
        var idtel = $(this).attr("idtel");

        $.post(url2[0] + "index.php/activatetel", { tele: tel, idtele: idtel }, function(data) {
            $("#actions-content").html(data);
        });
    });

    $("#seeActivos").click(function() {

        $("#seeInactivos").removeClass("img_selected");
        $("#addPhone").removeClass("img_selected");
        $("#seeActivos").addClass("img_selected");
        var doc = $("#documentoActivo").val();

        $.post(url2[0] + "index.php/activostel", { docu: doc }, function(data) {
            $("#actions-content").html(data);
        });
    });

    $("#seeInactivos").click(function() {

        $("#seeInactivos").addClass("img_selected");
        $("#addPhone").removeClass("img_selected");
        $("#seeActivos").removeClass("img_selected");
        var doc = $("#documentoActivo").val();

        $.post(url2[0] + "index.php/inactivostel", { docu: doc }, function(data) {
            $("#actions-content").html(data);
        });
    });

    $("#addPhone").click(function() {

        $("#addPhone").addClass("img_selected");
        $("#seeActivos").removeClass("img_selected");
        $("#seeInactivos").removeClass("img_selected");


        $(".addtelPanel").show();


    });

    /*   DIRECCIONES  */



    $(".unactiveDir").click(function() {
        var dir = $(this).attr("dir");
        var iddir = $(this).attr("iddir");

        $.post(url2[0] + "index.php/unactivatedir", { dire: dir, iddire: iddir }, function(data) {
            $("#actions-dir-content").html(data);
        });
    });

    $(".activeDir").click(function() {
        var dir = $(this).attr("dir");
        var iddir = $(this).attr("iddir");

        $.post(url2[0] + "index.php/activatedir", { dire: dir, iddire: iddir }, function(data) {
            $("#actions-dir-content").html(data);
        });
    });

    $("#seeActivos-dir").click(function() {

        $("#seeInactivos-dir").removeClass("img_selected");
        $("#addDir").removeClass("img_selected");
        $("#seeActivos-dir").addClass("img_selected");
        var doc = $("#documentoActivo").val();

        $.post(url2[0] + "index.php/activosdir", { docu: doc }, function(data) {
            $("#actions-dir-content").html(data);
        });
    });

    $("#seeInactivos-dir").click(function() {

        $("#seeInactivos-dir").addClass("img_selected");
        $("#addDir").removeClass("img_selected");
        $("#seeActivos-dir").removeClass("img_selected");
        var doc = $("#documentoActivo").val();

        $.post(url2[0] + "index.php/inactivosdir", { docu: doc }, function(data) {
            $("#actions-dir-content").html(data);
        });
    });

    $("#addDir").click(function() {

        $("#addDir").addClass("img_selected");
        $("#seeActivos-dir").removeClass("img_selected");
        $("#seeInactivos-dir").removeClass("img_selected");


        $(".adddirPanel").show();


    });

    /*   EMAILS  */



    $(".unactiveMail").click(function() {
        var mail = $(this).attr("mail");
        var iddir = $(this).attr("iddir");

        $.post(url2[0] + "index.php/unactivatemail", { maile: mail, iddir: iddir }, function(data) {
            $("#actions-mail-content").html(data);
        });
    });

    $(".activeMail").click(function() {
        var mail = $(this).attr("mail");
        var iddir = $(this).attr("iddir");

        $.post(url2[0] + "index.php/activatemail", { maile: mail, iddir: iddir }, function(data) {
            $("#actions-mail-content").html(data);
        });
    });

    $("#seeActivos-mail").click(function() {

        $("#seeInactivos-mail").removeClass("img_selected");
        $("#addMail").removeClass("img_selected");
        $("#seeActivos-mail").addClass("img_selected");
        var doc = $("#documentoActivo").val();

        $.post(url2[0] + "index.php/activosmail", { docu: doc }, function(data) {
            $("#actions-mail-content").html(data);
        });
    });

    $("#seeInactivos-mail").click(function() {

        $("#seeInactivos-mail").addClass("img_selected");
        $("#addMail").removeClass("img_selected");
        $("#seeActivos-mail").removeClass("img_selected");
        var doc = $("#documentoActivo").val();

        $.post(url2[0] + "index.php/inactivosmail", { docu: doc }, function(data) {
            $("#actions-mail-content").html(data);
        });
    });

    $("#addMail").click(function() {

        $("#addMail").addClass("img_selected");
        $("#seeActivos-mail").removeClass("img_selected");
        $("#seeInactivos-mail").removeClass("img_selected");


        $(".addmailPanel").show();


    });

    $("#saveNewMail").click(function() {
        var doc = $("#documentoActivo").val();
        var mail = $("#mail-nuevo").val();

        $.post(url2[0] + "index.php/savenuevomail", { docu: doc, maile: mail }, function(data) {
            $(".addmailPanel").hide();
            $("#seeInactivos").removeClass("img_selected");
            $("#addPhone").removeClass("img_selected");
            $("#seeActivos").addClass("img_selected");

            $.post(url2[0] + "index.php/activosmail", { docu: doc }, function(data) {
                $("#actions-mail-content").html(data);
            });
        });
    });

    $(".click-pausa").click(function() {
        var tarea = $(this).attr("iden");

        $.post(url2[0] + "index.php/set-pausa", { tareas: tarea }, function(data) {
            $("#modalSelectPausas").css("display", "none");
            $(".modal-login").css("display", "block");
            cronoCall();
        });

    });

    $("#saveNewDir").click(function() {
        var doc = $("#documentoActivo").val();
        var dir = $("#dir-nuevo").val();
        var ciudir = $("#ciudadDir").val();

        $.post(url2[0] + "index.php/savenuevodir", { docu: doc, dirre: dir, ciudad: ciudir }, function(data) {
            $(".adddirPanel").hide();
            $("#seeInactivos-dir").removeClass("img_selected");
            $("#addDir").removeClass("img_selected");
            $("#seeActivos-dir").addClass("img_selected");

            $.post(url2[0] + "index.php/activosmail", { docu: doc }, function(data) {
                $("#actions-dir-content").html(data);
            });
        });
    });


    /* MAIL END */



    $("#save-porg-call").click(function() {

        var fec = $("#fecha-prog").val();
        var doc = $("#documentoActivo").val();


        $.post(url2[0] + "index.php/saveprogcall", { fecha: fec, docu: doc }, function(data) {
            $("#actionPanel").show();
            $("#panelProgCall").hide();
        });

    });

    $("#cancelarAddPhone").click(function() {
        $(".addtelPanel").hide();
    });

    $("#saveNewTel").click(function() {
        var doc = $("#documentoActivo").val();
        var tel = $("#telefono-nuevo").val();
        var ciudad = $("#ciudadTel").val();

        $.post(url2[0] + "index.php/savenuevotel", { docu: doc, tele: tel, ciu: ciudad }, function(data) {
            $(".addtelPanel").hide();
            $("#seeInactivos").removeClass("img_selected");
            $("#addPhone").removeClass("img_selected");
            $("#seeActivos").addClass("img_selected");

            $.post(url2[0] + "index.php/activostel", { docu: doc }, function(data) {
                $("#actions-content").html(data);
            });
        });
    });

    $(".recivecall").click(function() {
        var tel = $(this).attr("tel");
        $("#telefonoGlobal").val(tel);
        $("#panelGestion").hide();
        $("#panelGestion-actions").show();
        $("#idAccionGlobal").val(2);

        var acc = $("#idAccionGlobal").val();
        $("#idContactGest").focus();
        $.post(url2[0] + "index.php/getcontactogestion", { accion: acc }, function(data) {
            $("#idContactGest").append(data);
        });
        makeMemo(url2[0]);
        cronoCall();
    });

    $("#cancelGestion").click(function() {

        cleanGest(url2[0]);

    });

    $(".makecall").click(function() {
        var tel = $(this).attr("tel");
        $("#telefonoGlobal").val(tel);
        $("#panelGestion").hide();
        $("#panelGestion-actions").show();
        $("#memoGestion").val("");

        var acc = $("#idAccionGlobal").val();
        $("#idContactGest").focus();
        $.post(url2[0] + "index.php/getcontactogestion", { accion: acc }, function(data) {
            $("#idContactGest").append(data);
        });
        makeMemo(url2[0]);
        cronoCall();
    });

    $("#idContactGest").change(function() {
        var cont = $(this).val();
        var act = $("#proyectoActivo").val();
        $("#idContactoGlobal").val(cont);

        $("#idMotivosGlobal").val("0");
        $("#idActividadGlobal").val("0");
        $("#idResultadooGlobal").val("0");

        $("#preforma").html(" ");

        $("#idResultadoGest").empty();
        $("#idResultadoGest").append('<option value="0">Resultado.</option>');
        if (cont == 1 || cont == 2) { //select-search
            $("#idMotivosGest").css("display", "block");
            if (act != "bbva_especial" && act != "bbva_contacto") {
                $("#idActividad").css("display", "block");
            }

            $("#idMotivosGest").focus();

        } else {
            $("#idMotivosGest").css("display", "none");
            $("#idActividad").css("display", "none");
            var acc = $("#idAccionGlobal").val();
            var cont = $("#idContactoGlobal").val();
            $.post(url2[0] + "index.php/getresultadogestion", { accion: acc, conta: cont }, function(data) {
                $("#idResultadoGest").append(data);
                //$("#idResultadoGest").css("display", "block");
                $("#idResultadoGest").focus();
            });


        }
        makeMemo(url2[0]);
    });

    $("#idMotivosGest").change(function() {
        var acc = $("#idAccionGlobal").val();
        var cont = $("#idContactoGlobal").val();
        $.post(url2[0] + "index.php/getresultadogestion", { accion: acc, conta: cont }, function(data) {
            $("#idResultadoGest").append(data);
            //  $("#idResultadoGest").css("display", "block");
            $("#idResultadoGest").focus();
        });
        //$("#idMotivosGest").css("display", "none");
        //$("#idContactGest").css("display", "none");
        //$("#idResultadoGest").css("display", "block");
        $("#idResultadoGest").focus();

        $("#idMotivosGlobal").val($(this).val());
        makeMemo(url2[0]);
    });

    $("#idActividad").change(function() {
        $("#idActividadGlobal").val($(this).val());
    });



    $("#idResultadoGest").change(function() {
        var res = $(this).val();

        $("#idResultadooGlobal").val(res);
        //$("#idResultadoGest").css("display", "none");

        $.post(url2[0] + "index.php/getfingestion", { resu: res }, function(data) {

            $("#validation").val(data);
            var datas = data.split('-');

            if (datas[0] == 1) {
                if ($("#proyectoActivo").val() != "bbva_especial" && $("#proyectoActivo").val() != "bbva_contacto") {
                    $("#complmento-table").css("display", "block");
                } else if ($("#proyectoActivo").val() == "bbva_especial") {
                    $("#complmento2-table").css("display", "block");
                } else if ($("#proyectoActivo").val() == "bbva_contacto") {
                    $("#complmento3-table").css("display", "block");
                }

                $("#idFechaValor").val("1");
                $("#idValorValor").val("1");

            } else {
                $("#idFechaValor").val("0");
                $("#idValorValor").val("0");
            }

            if (datas[2] == 1) {
                $("#txt-acu").css("display", "block");
            }

            $("#save-gest-action").css("display", "block");

        });

        makeMemo(url2[0]);
    });


    $("#save-gest-action").click(function() {



        var valida = $("#validation").val();
        var field = valida.split('-');
        var fechaac = 0;
        var valorac = 0;
        var txtac = 0;
        var flag = 0;
        var tiempo = $("#hour").html() + ":" + $("#minute").html() + ":" + $("#second").html();
        var bandera = $("#banderas").val();
        var promesas = "";
        var valores = "0";

        var dinamicFlag = $("#totalDinamicos").val();
        var f;
        var dinamicTotal = "";



        if ($("#idFechaValor").val() == 1) {
            for (var i = 1; i <= bandera; i++) {

                if ($("#proyectoActivo").val() != "bbva_especial" && $("#proyectoActivo").val() != "bbva_contacto") {
                    var idObliga = "#obliga" + i;
                    var idFecha = "#fecha" + i;
                    var idValor = "#valor" + i;
                } else if ($("#proyectoActivo").val() == "bbva_especial") {
                    var idObliga = "#obliga2" + i;
                    var idFecha = "#fecha2" + i;
                    var idValor = "#valor2" + i;
                } else if ($("#proyectoActivo").val() == "bbva_contacto") {
                    var idObliga = "#obliga3" + i;
                    var idFecha = "#fecha3" + i;
                    var idValor = "#valor3" + i;
                }


                promesas += $(idObliga).val() + "&" + $(idFecha).val() + "&" + $(idValor).val() + "!";
                if ($(idValor).val() != "Undefined") {
                    valores = valores + parseInt($(idValor).val());
                }
            }
            if ($("#proyectoActivo").val() != "bbva_especial" && $("#proyectoActivo").val() != "bbva_contacto") {
                if (valores == 0) {
                    alert("Debe ingresar los datos de pago.");
                    flag += 1;
                }
            }



        }

        for (f = 0; f < dinamicFlag; f++) {

            var idenD = "#dinamico" + f;
            var valorDin = $(idenD).val();
            var idFieldDin = "#" + valorDin;
            var valorFinalDin = $(idFieldDin).val();

            if (valorFinalDin == 0) {
                alert("Debe seleccionar el campo: " + valorDin);
                flag += 1;
            } else {
                dinamicTotal += valorDin + ":" + valorFinalDin + "|";
            }

        }

        if ($("#idContactoGlobal").val() < 3) {
            if ($("#idMotivosGlobal").val() == 0) {
                alert("Debe Seleccionar un Motivo de No Pago");
                flag += 1;
            }
            if ($("#proyectoActivo").val() != "bbva_especial" && $("#proyectoActivo").val() != "bbva_contacto") {
                if ($("#idActividadGlobal").val() == 0) {
                    alert("Debe Seleccionar una Actividad economica");
                    flag += 1;
                }
            }


        }


        if (flag == 0) {
            var acc = $("#idAccionGlobal").val();
            var cont = $("#idContactoGlobal").val();
            var moti = $("#idMotivosGlobal").val();
            var activ = $("#idActividadGlobal").val();
            var resu = $("#idResultadooGlobal").val();
            var tel = $("#telefonoGlobal").val();
            var adici = $("#memoGestion").val();
            var memo = "";
            var pref = $("#preforma").html();
            var doc = $("#documentoActivo").val();

            memo = pref + " " + adici;

            $.post(url2[0] + "index.php/savegestion", { accion: acc, conta: cont, motiv: moti, result: resu, tele: tel, fec: fechaac, vlo: valorac, txt: txtac, time: tiempo, memog: memo, docu: doc, prom: promesas, acti: activ, flag: bandera, dinamica: dinamicTotal }, function(data) {
                var as = data;
                $.post(url2[0] + "index.php/getGestion", { docu: doc, flag: 0 }, function(data) {

                    $(".gestionAdelantada").html(data);

                    cleanGest(url2[0]);

                    if (as == "1") {
                        var r = confirm("Desea asignarse este cliente!");
                        if (r == true) {
                            $.post(url2[0] + "index.php/gestionasignacion", { docu: doc }, function(data) {

                                if (data == 1) {
                                    alert("Cliente Asignado!");
                                } else {
                                    var msj = "No se puede asignar el cliente, cliente asingado anteriormente en " + data;
                                    alert(msj);
                                }

                            });
                        }
                    }

                });

            });

        }

    });



    $(".nocontesta").click(function() {



        var valida = $("#validation").val();
        var field = valida.split('-');
        var fechaac = 0;
        var valorac = 0;
        var txtac = 0;
        var flag = 0;
        var tiempo = $("#hour").html() + ":" + $("#minute").html() + ":" + $("#second").html();
        var bandera = $("#banderas").val();
        var promesas = "";
        var valores = "0";

        var dinamicFlag = $("#totalDinamicos").val();
        var f;
        var dinamicTotal = "";


        if (flag == 0) {
            var acc = '1';
            var cont = '6';
            var moti = '0';
            var activ = '0';
            var resu = '3';
            var tel = $(this).attr('tel');
            var adici = "Se llama al telefono: " + tel + " pero no contestan.";
            var memo = adici;
            var pref = $("#preforma").html();
            var doc = $("#documentoActivo").val();

            memo = pref + " " + adici;

            $.post(url2[0] + "index.php/savegestion", { accion: acc, conta: cont, motiv: moti, result: resu, tele: tel, fec: fechaac, vlo: valorac, txt: txtac, time: tiempo, memog: memo, docu: doc, prom: promesas, acti: activ, flag: bandera, dinamica: dinamicTotal }, function(data) {
                var as = data;
                $.post(url2[0] + "index.php/getGestion", { docu: doc, flag: 0 }, function(data) {

                    $(".gestionAdelantada").html(data);

                    cleanGest(url2[0]);

                    if (as == "1") {
                        var r = confirm("Desea asignarse este cliente!");
                        if (r == true) {
                            $.post(url2[0] + "index.php/gestionasignacion", { docu: doc }, function(data) {

                                if (data == 1) {
                                    alert("Cliente Asignado!");
                                } else {
                                    var msj = "No se puede asignar el cliente, cliente asingado anteriormente en " + data;
                                    alert(msj);
                                }

                            });
                        }
                    }

                });

            });

        }

    });


    $(".mensajeenbuzon").click(function() {



        var valida = $("#validation").val();
        var field = valida.split('-');
        var fechaac = 0;
        var valorac = 0;
        var txtac = 0;
        var flag = 0;
        var tiempo = $("#hour").html() + ":" + $("#minute").html() + ":" + $("#second").html();
        var bandera = $("#banderas").val();
        var promesas = "";
        var valores = "0";

        var dinamicFlag = $("#totalDinamicos").val();
        var f;
        var dinamicTotal = "";


        if (flag == 0) {
            var acc = '1';
            var cont = '6';
            var moti = '0';
            var activ = '0';
            var resu = '111';
            var tel = $(this).attr('tel');
            var adici = "Se llama al telefono: " + tel + " se deja en buzon.";
            var memo = adici;
            var pref = $("#preforma").html();
            var doc = $("#documentoActivo").val();

            memo = pref + " " + adici;

            $.post(url2[0] + "index.php/savegestion", { accion: acc, conta: cont, motiv: moti, result: resu, tele: tel, fec: fechaac, vlo: valorac, txt: txtac, time: tiempo, memog: memo, docu: doc, prom: promesas, acti: activ, flag: bandera, dinamica: dinamicTotal }, function(data) {
                var as = data;
                $.post(url2[0] + "index.php/getGestion", { docu: doc, flag: 0 }, function(data) {

                    $(".gestionAdelantada").html(data);

                    cleanGest(url2[0]);

                    if (as == "1") {
                        var r = confirm("Desea asignarse este cliente!");
                        if (r == true) {
                            $.post(url2[0] + "index.php/gestionasignacion", { docu: doc }, function(data) {

                                if (data == 1) {
                                    alert("Cliente Asignado!");
                                } else {
                                    var msj = "No se puede asignar el cliente, cliente asingado anteriormente en " + data;
                                    alert(msj);
                                }

                            });
                        }
                    }

                });

            });

        }

    });




    /* FIN Telefonos */

    $("#upload-file-action").click(function() {
        var file = $("#archivo").val();
        var name = $("#nombreFiles").val();

        if (file == "") {
            alert("Debe seleccionar un archivo.");
        } else if (name == "") {
            alert("Debe ingresar el nombre del archivo.");
        } else {
            $("#subir-archivo").submit();
        }
    });


    $(".detalleTarea").click(function() {
        var tarea = $(this).attr("flag");

        $.post(url2[0] + "index.php/resultadotarea", { tareas: tarea }, function(data) {
            $('html,body').animate({ scrollTop: 9999 }, 'slow');
            $("#panel-detalle").html(data);
        });

    });

    $("#saveNewUser").click(function() {
        var flag = 0;
        var nombre = $("#nombre").val();
        var apellido = $("#apellido").val();
        var documento = $("#apellido").val();
        var pass = $("#password").val();
        var password = $("#fuerte").val();
        var conf = $("#confi").val();

        if (nombre == "") {
            alert("Debe ingresar el nombre.");
            flag += 1;
        } else if (apellido == "") {
            alert("Debe ingresar el nombre.");
            flag += 1;
        } else if (documento == "") {
            alert("Debe ingresar el numero de documento.");
            flag += 1;
        } else if (pass == "") {
            alert("Debe ingresar el numero de documento.");
            flag += 1;
        } else if (password < 3) {
            alert("Su password es debil, debe tener mayusculas, minusculas, numeros y caracteres especiales.");
            flag += 1;
        } else if (conf > 0) {
            alert("El password y la confirmacion deben ser iguales.");
            flag += 1;
        }


        if (flag == 0) {
            $("#add-usuario").submit();
        }

    });

    $("#acuerdoBtn").click(function() {
        $("#acuerdopago-modal").css("display", "block");
    });

    $("#CancelaAcuerdoCuotas").click(function() {
        $("#valor-acuerdo").val("");
        $("#cuotas-acuerdo").val("");
        $("#fechas-acuerdos").val("");
        $("#ohacuer").val("");
        $("#acuerdo-preliminar").html("");
        $("#vlminneg").val("0");
        $("#pagcuotasneg").val("0");
        $("#saldototneg").val("0");
        $("#acuerdopago-modal").css("display", "none");
    });

    $("#generaAcuerdoCuotas").click(function() {
        var valor = $("#valor-acuerdo").val();
        var cuotas = $("#cuotas-acuerdo").val();
        var fecha = $("#fechas-acuerdos").val();
        var minimo = $("#vlminneg").val();
        var cuotascreditos = $("#pagcuotasneg").val();
        var obl = $("#ohacuer").val();
        var flag = 0;

        if (valor == "" || valor < 1) {
            alert("Debe ingresar el valor del acuerdo.");
            flag += 1;
        } else if (cuotas == "" || cuotas < 1) {
            alert("Debe ingresar el numero de cuotas del acuerdo.");
            flag += 1;
        } else if (obl == 0) {
            alert("Debe seleccionar la obligacion del acuerdo.");
            flag += 1;
        } else if (cuotas > 1 && cuotascreditos == 0) {
            alert("El acuerdo no puede ser a mas de una cuota.");
            flag += 1;
        }

        if (flag == 0) {
            $.post(url2[0] + "index.php/generaacuotas", { valor: valor, cuotas: cuotas, fec: fecha, oh: obl }, function(data) {
                $("#acuerdo-preliminar").html(data);
                //$("#generaAcuerdoCuotas").css("display", "none");
            });
        }
    });

    $("#ohacuer").change(function() {
        var oh = $(this).val();
        if (oh != "") {
            $.post(url2[0] + "index.php/getdataacuerdooh", { obligacion: oh }, function(data) {
                var elementos = data.split("-");

                $("#vlminneg").val(elementos[0]);
                $("#pagcuotasneg").val(elementos[1]);
                $("#saldototneg").val(elementos[2]);

            });
        } else {
            $("#vlminneg").val("0");
            $("#pagcuotasneg").val("0");
            $("#saldototneg").val("0");
        }

    });




    /// Simulador BCS ///




    $("#simuladorBtn").click(function() {
        $("#simulador-modal").css("display", "block");
    });


    /// FIN SIMULADOR BCS ///






});

function closeModal() {
    $("#modalSelectPausas").modal('hide');
}

function modalPau() {
    $("#modalSelectPausas").modal();
}

function modalProg() {
    $("#modal_custom").modal();
}

function makeMemo(url) {

    var acc = $("#idAccionGlobal").val();
    var cont = $("#idContactoGlobal").val();
    var moti = $("#idMotivosGlobal").val();
    var resu = $("#idResultadooGlobal").val();
    var tel = $("#telefonoGlobal").val();

    var actmemo = $("#preforma").html();

    $.post(url + "index.php/makememo", { accion: acc, conta: cont, motiv: moti, result: resu, tele: tel, memo: actmemo }, function(data) {
        $("#preforma").html(data);
    });


}


function cleanGest(url) {

    $("#save-gest-action").css("display", "none");

    $("#idAccionGlobal").val("0");
    $("#idContactoGlobal").val("0");
    $("#idMotivosGlobal").val("0");
    $("#idResultadooGlobal").val("0");
    $("#telefonoGlobal").val("0");

    $("#preforma").html(" ");

    $("#idAccionGlobal").val("1");

    $("#idContactGest").css("display", "block");
    $("#idContactGest").empty();
    $("#idContactGest").append('<option value="0">Contacto.</option>');

    $("#idResultadoGest").empty();
    $("#idResultadoGest").append('<option value="0">Resultado.</option>');
    // $("#idResultadoGest").css("display", "none");


    $("#idMotivosGest").val("0");
    $("#idMotivosGest").css("display", "none");


    $("#idContactGest").focus();


    $("#panelGestion").show();
    $("#panelGestion-actions").hide();


}

function cronoCall() {
    var tiempo = {
        hora: 0,
        minuto: 0,
        segundo: 0
    };

    var tiempo_corriendo = null;


    tiempo_corriendo = setInterval(function() {
        // Segundos
        tiempo.segundo++;
        if (tiempo.segundo >= 60) {
            tiempo.segundo = 0;
            tiempo.minuto++;
        }

        // Minutos
        if (tiempo.minuto >= 60) {
            tiempo.minuto = 0;
            tiempo.hora++;
        }

        $("#hour").text(tiempo.hora < 10 ? '0' + tiempo.hora : tiempo.hora);
        $("#minute").text(tiempo.minuto < 10 ? '0' + tiempo.minuto : tiempo.minuto);
        $("#second").text(tiempo.segundo < 10 ? '0' + tiempo.segundo : tiempo.segundo);
    }, 1000);

    //clearInterval(tiempo_corriendo);

}

$("#carga-predictivo").click(function() {

    var fechaini = $("#fechaIni").val();
    var fechafin = $("#fechaFin").val();
    var flag = 0;


    if (fechaini == '') {
        alert("Debe seleccionar la fecha de inicio.");
        flag += 1;
    } else if (fechafin == '') {
        alert("Debe seleccionar la fecha de finalizacion.");
        flag += 1;
    }

    if (flag == 0) {



        $("#fechas-predictivo").submit();
    }


    function addCommas(nStr) {


        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }


});


var tiempo_corriendo = null;

function cronoCall() {
    var tiempo = {
        hora: 0,
        minuto: 0,
        segundo: 0
    };




    tiempo_corriendo = setInterval(function() {
        // Segundos
        tiempo.segundo++;
        if (tiempo.segundo >= 60) {
            tiempo.segundo = 0;
            tiempo.minuto++;
        }

        // Minutos
        if (tiempo.minuto >= 60) {
            tiempo.minuto = 0;
            tiempo.hora++;
        }

        $("#hour").text(tiempo.hora < 10 ? '0' + tiempo.hora : tiempo.hora);
        $("#minute").text(tiempo.minuto < 10 ? '0' + tiempo.minuto : tiempo.minuto);
        $("#second").text(tiempo.segundo < 10 ? '0' + tiempo.segundo : tiempo.segundo);
    }, 1000);

    //clearInterval(tiempo_corriendo);

}

function cronoStop() {

    clearInterval(tiempo_corriendo);

}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}


$("#carga-predictivo").click(function() {

    var fechaini = $("#fechaIni").val();
    var fechafin = $("#fechaFin").val();
    var flag = 0;


    if (fechaini == '') {
        alert("Debe seleccionar la fecha de inicio.");
        flag += 1;
    } else if (fechafin == '') {
        alert("Debe seleccionar la fecha de finalizacion.");
        flag += 1;
    }

    if (flag == 0) {



        $("#fechas-predictivo").submit();
    }



});