$(document).ready(function() {
    var url = window.location.href;
    var url2 = url.split("index.php");

    $("#enviaAcuerdoFinal").click(function() {
        var doc = $("#documentoActivo").val();
        $.post(url2[0] + "index.php/enviarAcuerdoFinal", { docu: doc }, function(data) {
            location.reload();
        });
    });

    $("#generaAcuerdo2222").click(function() {
        var desc = parseInt($("#vldescuentoAcuerdo").val());
        var fec = $("#fechalimAcuerdo").val();
        var vlacu = parseInt($("#valorpagAcuerdo").val());
        var cuotas = $("#cuotasmodalAcuerdo").val();
        var doc = $("#documentoActivo").val();
        var cuotasValida = $("#ModalCuotas").val();
        var pisoValida = $("#ModalPiso").val();
        var flag = 0;
        var vlmodificado = 0;
        var cadenaAcuerdo = "";

        for (var x = 1; x <= cuotas; x++) {
            var idfecha = "#" + "fechaModal" + x;
            var idvlcuota = "#" + "valorModal" + x;
            vlmodificado += parseInt($(idvlcuota).val());
            cadenaAcuerdo += +x + ";" + $(idfecha).val() + ";" + $(idvlcuota).val() + "|";
        }

        if (cuotas == 1) {
            if (pisoValida > vlmodificado) {
                alert("El valor del acuerdo no puede ser menor que el valor de piso de negociacion.");
                flag += 1;
            }
        } else if (cuotas > 1) {
            if (cuotasValida > vlmodificado) {
                alert("El valor del acuerdo no puede ser menor que el valor de pago a cuotas.");
                flag += 1;
            }
        } else if (fec == "") {
            alert("Debe seleccionar la fecha limite de pago del acuerdo.");
            flag += 1;
        }

        if (flag == 0) {
            $.post(url2[0] + "index.php/generarAcuerdo", { fecha: fec, valor: vlacu, docu: doc, cuota: cuotas, cadena: cadenaAcuerdo }, function(data) {
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