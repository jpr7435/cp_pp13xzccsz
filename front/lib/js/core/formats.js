$(document).ready(function () {

    var url = window.location.href;
    var url2 = url.split("index.php");

    
   $('#valor-acu').formatter({
        pattern: '${{99999999}}'
    });

});