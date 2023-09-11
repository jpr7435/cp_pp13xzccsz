<?php
/* * To change this template, choose Tools | Templates * and open the template in the editor. */
$ci2 = &get_instance();
//$us = $ci3->load->model("usuarios");
//$ci2 = &get_instance();
$ci2->load->model("vista");
?>
<style>
.medium-password{background-color: #E4DB11;border:#BBB418 1px solid;}
.weak-password{background-color: #FF6600;border:#AA4502 1px solid;}
.strong-password{background-color: #12CC1A;border:#0FA015 1px solid;}
</style>
<script>
function checkPasswordStrength() {
    var number = /([0-9])/;
    var alphabets = /([a-zA-Z])/;
    var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
    if($('#password').val().length<6) {
      $('#password-strength-status').removeClass();
      $('#password-strength-status').addClass('weak-password');
      $('#password-strength-status').html("Debil (Debe tener por lo menos 6 caracteres.)");
      $("#fuerte").val("1");
    } else {
      if($('#password').val().match(number) && $('#password').val().match(alphabets) && $('#password').val().match(special_characters)) {
        $('#password-strength-status').removeClass();
        $('#password-strength-status').addClass('strong-password');
        $('#password-strength-status').html("Fuerte");
        $("#fuerte").val("3");
      } else {
        $('#password-strength-status').removeClass();
        $('#password-strength-status').addClass('medium-password');
        $('#password-strength-status').html("Medio (Debe incluir letras mayusculas, minusculas, numeros y caracteres especiales.)");
        $("#fuerte").val("2");
      }
    }

    checkPasswordConf();
}

function checkPasswordConf() {

    if($('#password').val() != $('#passwordconf').val()) {
      $('#password-conf-status').removeClass();
      $('#password-conf-status').addClass('weak-password');
      $('#password-conf-status').html("La contrase&ntilde;a y la confirmacion deben ser iguales.");
      $("#confi").val("2");
    } else {
      $('#password-conf-status').removeClass();
      $('#password-conf-status').addClass('strong-password');
      $('#password-conf-status').html("Los password coinciden.");
      $("#confi").val("0");
    }
}
</script>
<section class="main-container">
    <div class="container-fluid page-content">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        Agregar Nuevo Usuario
                    </div>
                </div>
                <div class="panel-body">
                    <form name="add-usuario" class="form-horizontal" id="add-usuario" method="post" action="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/saveuser">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">

                                <label>Nombre: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nombre" id="nombre" required="required"/>
                                <label>Apellido: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="apellido" id="apellido" required="required"/>
                                <label>Documento: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="documento" id="documento" required="required"/>
                                <label>E-mail:</label>
                                <input type="email" data-validation="email" class="form-control" name="email" id="email"/>
                                <label>Meta:</label>
                                <input type="text" class="form-control" name="meta" id="meta"/>
                                </br>
                                <button class="btn btn-success" id="saveNewUser" type="button">Guardar</button>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>Perfil: <span class="text-danger">*</span></label>
                                <select class="form-control" required="required" name="perfil" id="perfil">
                                    <option value="0">Seleccione...</option>
                                    <?php foreach($perfiles as $per){
                                        if($per['idPerfil'] > $session['perfil']){
                                        ?>
                                        <option value="<?php echo $per['idPerfil']; ?>"><?php echo $per['descripcion']; ?></option>
                                        <?php } } ?>
                                </select>
                                <label>Cartera:<span class="text-danger">*</span></label>
                                <select class="form-control" name="carteras[]" id="carteras[]"  required="required" multiple="multiple">
                                    <?php foreach($proyectos as $pro){ ?>
                                    <option value="<?php echo $pro['idProyecto']; ?>"><?php echo $pro['descripcion']; ?></option>
                                    <?php } ?>
                                </select>
                                <label>Password: <span class="text-danger">*</span></label>
                                <input type="password" onKeyUp="checkPasswordStrength();" class="form-control" name="password" id="password"/>
                                <div id="password-strength-status"></div>
                                <label>Confirmar Password: <span class="text-danger">*</span></label>
                                <input type="password" onKeyUp="checkPasswordConf();" class="form-control" required="required" name="passwordconf" id="passwordconf"/>
                                <div id="password-conf-status"></div>
                                <input type="hidden" name="fuerte" id="fuerte" value="0"/>
                                <input type="hidden" name="confi" id="confi" value="0"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
