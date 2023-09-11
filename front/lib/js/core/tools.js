$(document).ready(function () {

    var url = window.location.href;
    var url2 = url.split("index.php");

    $("#sendticket").click(function(){
      var flag = 0;
      var dirigi = $("#dirigido").val();
      var descripcion = $("#descripcion").val();

      if(dirigi == 0){
        alert("Debe seleccionar a quien va dirigido el tocket.");
        flag += 1;
      }else if(descripcion == ""){
        alert("Debe ingresar la descripcion del ticket.");
        flag += 1;
      }
      if(flag == 0){
        alert("envio");
      }
    });

    /*$.post(url2[0] + "index.php/getprogcall", {}, function (data) {
        if (data == 0) {

        } else {
            $(".modal-body-prog").html(data);
            modalProg();
        }
    });
*/

});
