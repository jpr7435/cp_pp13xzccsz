$(document).ready(function () {

    var url = window.location.href;
    var url2 = url.split("index.php");

    /* Telefonos */
    $(".unactiveTel").click(function () {
        var tel = $(this).attr("tel");
        var idtel = $(this).attr("idtel");

        $.post(url2[0] + "index.php/unactivatetel", {tele: tel, idtele: idtel}, function (data) {
            $("#telefonos-panel").html(data);
        });
    });
    
    $(".activeTel").click(function () {
        var tel = $(this).attr("tel");
        var idtel = $(this).attr("idtel");

        $.post(url2[0] + "index.php/activatetel", {tele: tel, idtele: idtel}, function (data) {
            $("#telefonos-panel").html(data);
        });
    });
    
    $("#seeActivos").click(function () {
        
        $("#seeInactivos").removeClass("img_selected");
        $("#seeActivos").addClass("img_selected");
        var doc = $("#documentoActivo").val();
        
        $.post(url2[0] + "index.php/activostel", {docu: doc}, function (data) {
            $("#telefonos-panel").html(data);
        });
    });
    
    $("#seeInactivos").click(function () {
        
        $("#seeInactivos").addClass("img_selected");
        $("#seeActivos").removeClass("img_selected");
        var doc = $("#documentoActivo").val();
        
        $.post(url2[0] + "index.php/inactivostel", {docu: doc}, function (data) {
            $("#telefonos-panel").html(data);
        });
    });
    
    $("#addPhone").click(function () {

        $("#addPhone").addClass("img_selected");
        $("#seeActivos").removeClass("img_selected");
        $("#seeInactivos").removeClass("img_selected");


        $(".addtelPanel").show();


    });

    $("#cancelarAddPhone").click(function () {
        $(".addtelPanel").hide();
    });

    $("#saveNewTel").click(function () {
        var doc = $("#documentoActivo").val();
        var tel = $("#telefono-nuevo").val();
        var ciudad = $("#ciudadTel").val();

        $.post(url2[0] + "index.php/savenuevotel", {docu: doc, tele: tel, ciu: ciudad}, function (data) {
            $(".addtelPanel").hide();
            $("#seeInactivos").removeClass("img_selected");
            $("#addPhone").removeClass("img_selected");
            $("#seeActivos").addClass("img_selected");

            $.post(url2[0] + "index.php/activostel", {docu: doc}, function (data) {
                $("#telefonos-panel").html(data);
            });
        });
    });
    
     $(".makecall").click(function () {
      var tel = $(this).attr("tel");
      $("#telefonoGlobal").val(tel);
      $("#panelGestion").hide();
      $("#panelGestion-actions").show();
      $("#memoGestion").val("");

        var acc = $("#idAccionGlobal").val();
        $("#idContactGest").focus();
        $.post(url2[0] + "index.php/getcontactogestion", {accion: acc}, function (data) {
            $("#idContactGest").append(data);
        });
        makeMemo(url2[0]);
        cronoCall();
    });
    
    /* FIN Telefonos */
    
    
    /*   DIRECCIONES  */
    
    
    
    $(".unactiveDir").click(function () {
        var dir = $(this).attr("dir");
        var iddir = $(this).attr("iddir");

        $.post(url2[0] + "index.php/unactivatedir", {dire: dir, iddire: iddir}, function (data) {
            $("#actions-dir-content").html(data);
        });
    });

    $(".activeDir").click(function () {
        var dir = $(this).attr("dir");
        var iddir = $(this).attr("iddir");

        $.post(url2[0] + "index.php/activatedir", {dire: dir, iddire: iddir}, function (data) {
            $("#actions-dir-content").html(data);
        });
    });

    $("#seeActivos-dir").click(function () {

        $("#seeInactivos-dir").removeClass("img_selected");
        $("#addDir").removeClass("img_selected");
        $("#seeActivos-dir").addClass("img_selected");
        var doc = $("#documentoActivo").val();

        $.post(url2[0] + "index.php/activosdir", {docu: doc}, function (data) {
            $("#actions-dir-content").html(data);
        });
    });

    $("#seeInactivos-dir").click(function () {

        $("#seeInactivos-dir").addClass("img_selected");
        $("#addDir").removeClass("img_selected");
        $("#seeActivos-dir").removeClass("img_selected");
        var doc = $("#documentoActivo").val();

        $.post(url2[0] + "index.php/inactivosdir", {docu: doc}, function (data) {
            $("#actions-dir-content").html(data);
        });
    });

    $("#addDir").click(function () {

        $("#addDir").addClass("img_selected");
        $("#seeActivos-dir").removeClass("img_selected");
        $("#seeInactivos-dir").removeClass("img_selected");


        $(".adddirPanel").show();


    });
    
    
    

});
function cronoCall() {
    var tiempo = {
        hora: 0,
        minuto: 0,
        segundo: 0
    };

    var tiempo_corriendo = null;


        tiempo_corriendo = setInterval(function () {
            // Segundos
            tiempo.segundo++;
            if (tiempo.segundo >= 60)
            {
                tiempo.segundo = 0;
                tiempo.minuto++;
            }

            // Minutos
            if (tiempo.minuto >= 60)
            {
                tiempo.minuto = 0;
                tiempo.hora++;
            }

            $("#hour").text(tiempo.hora < 10 ? '0' + tiempo.hora : tiempo.hora);
            $("#minute").text(tiempo.minuto < 10 ? '0' + tiempo.minuto : tiempo.minuto);
            $("#second").text(tiempo.segundo < 10 ? '0' + tiempo.segundo : tiempo.segundo);
        }, 1000);

        //clearInterval(tiempo_corriendo);

}