$(document).ready(function () {

    var url = window.location.href;
    var url2 = url.split("index.php");

     setInterval(function () {
        $.post(url2[0] + "index.php/getprogcall", {}, function (data) {
            if (data == 0) {
                
            }else{
                $(".modal-body-prog").html(data);
                modalProg();
            }
        });
    }, 30000);
});