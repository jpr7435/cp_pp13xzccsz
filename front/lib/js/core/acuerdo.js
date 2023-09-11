$(document).ready(function() {
    var url = window.location.href;
    var url2 = url.split("index.php");

    $("#enviaAcuerdoFinal").click(function() {
        var doc = $("#documentoActivo").val();
        $.post(url2[0] + "index.php/enviarAcuerdoFinal", { docu: doc }, function(data) {
            alert("Acuerdo Enviado Con Exito.");
            //location.reload();
        });
    });

    $("#generaAcuerdo").click(function() {
        var desc = parseInt($("#vldescuentoAcuerdo").val());
        var fec = $("#fechalimAcuerdo").val();
        var vlacu = parseInt($("#valorpagAcuerdo").val());
        var vlsaldo = parseInt($("#vlsaldototal").val());
        var cuotas = $("#cuotasmodalAcuerdo").val();
        var proba = $("#probafield").val();
        var doc = $("#documentoActivo").val();
        var mail = $("#correoAcuerdo").val();
        var oh = $("#ohcuotasacuerdo").val();
        var judicial = $("#esjudicialdos").val();
        var tarifa = $("#idtarifa").val();
        var flag = 0;
        var vlmodificado = 0;
        var cadenaAcuerdo = "";
        var hoy = new Date();
        var nuevaAcuerdo = new Date(fec);
        var restAcuerdo = hoy.getTime() - nuevaAcuerdo.getTime();
        var valor1 = Math.round(restAcuerdo / (1000 * 60 * 60 * 24));
        var validacion = 0;
        var abogado = 0;
        var honorarios = 0;


        for (var x = 1; x <= cuotas; x++) {
            var idfecha = "#" + "fechaModal" + x;
            var idvlcuota = "#" + "valorModal" + x;
            vlmodificado += parseInt($(idvlcuota).val());
            /* Valida si alguna fecha genberada es menor que hoy */
            var fechaCuta = new Date($(idfecha).val());
            var restAcuerdo2 = hoy.getTime() - fechaCuta.getTime();
            var valor2 = Math.round(restAcuerdo2 / (1000 * 60 * 60 * 24));
            if (valor2 >= 2) {
                validacion += 1;

            }
            /* FIN Valida si alguna fecha genberada es menor que hoy */

            cadenaAcuerdo += +x + ";" + $(idfecha).val() + ";" + $(idvlcuota).val() + "|";
        }

        if (valor1 >= 2) {
            alert("La fecha del acuerdo no puede ser menor que hoy.");
            flag += 1;

        } else if (validacion > 0) {
            alert("La fecha de las cuotas no puede ser menor que hoy.");
            flag += 1;

        } else if (vlmodificado < desc) {
            alert("El valor del acuerdo no puede ser menor que el valor de descuento.");
            flag += 1;
        } else if (vlmodificado > vlsaldo) {
            alert("El valor del acuerdo no puede ser mayoe que el saldo total.");
            flag += 1;
        } else if (fec == "") {
            alert("Debe seleccionar la fecha limite de pago del acuerdo.");
            flag += 1;
        }


        if (judicial == 1) {

            if ($("#cuenta-abogado").val() == 0) {
                alert("Debe seleccionar el abogado.");
                flag += 1;
            } else if ($("#honorarios").val() == 0) {
                alert("Debe seleccionar la etapa procesal.");
                flag += 1;
            } else {
                abogado = $("#cuenta-abogado").val();
                honorarios = $("#honorarios").val();
            }
        }



        if (flag == 0) {
            $.post(url2[0] + "index.php/generarAcuerdo", { fecha: fec, valor: vlacu, docu: doc, cuota: cuotas, correo: mail, cadena: cadenaAcuerdo, obl: oh, abo: abogado, hono: honorarios, judi: judicial, idtarifa: tarifa, prob: proba }, function(data) {
                $("#respuestaAcuerdo").html(data);
            });
        }
    });

    $("#saveAcuerdoCuotas").click(function() {

        var fechaIni = $("#fechas-acuerdos").val();
        var valorIni = $("#valor-acuerdo").val();
        var cuotasIni = $("#cuotas-acuerdo").val();
        var doc = $("#documentoActivo").val();
        var ohs = $("#ohacuer").val();
        var i = 1;
        var envio = "";


        for (i = 1; i <= cuotasIni; i++) {

            var idFec = "#fecha-cuota-acuerdo" + i;
            var idVal = "#valor-cuota" + i;

            envio += i + ";" + $(idFec).val() + ";" + $(idVal).val() + "!";
        }

        $.post(url2[0] + "index.php/creaacuerdo", { fecha: fechaIni, valor: valorIni, cuotas: cuotasIni, docu: doc, env: envio, oh: ohs }, function(data) {
            $("#acuerdopago-modal").css("display", "none");
        });

    });

    $("#cancelarAcuerdoCuotas").click(function() {
        $("#acuerdopago-modal").css("display", "none");
    });
});