<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="theme-color" content="#1C2B36" />
	<title>Smart Contact</title>

    <!-- Favicon -->
    <link href="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/img/favicon.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
	<link href="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/img/favicon.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
	<link href="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/img/favicon.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
	<link href="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/img/favicon.png" rel="apple-touch-icon" type="image/png">
	<link href="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/img/favicon.png" rel="icon" type="image/png">
	<link href="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/img/favicon.png" rel="shortcut icon">
    <!-- /Favicon -->

    <!-- Global stylesheets -->
	<link type="text/css" rel="stylesheet" href="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/lib/css/bootstrap.css">
    <link type="text/css" rel="stylesheet" href="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/lib/css/animate.min.css">
    <link type="text/css" rel="stylesheet" href="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/lib/css/main.css">
    <!-- /Global stylesheets -->
</head>

<body>
	<input type="hidden" name="intentos" id="intentos" value="0"/>

	<div class="auth-container">
      <img src="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/img/logo_index.png" style="position: absolute; width: 291px; height: 99px; left: 50%; top: 50px; margin-left: -145px;" alt="Gesel" title="Gesel"/>
		<div class="center-block">

			<div class="auth-module">
				<div class="toggle" style="display: none;"></div>
				<!-- Login form -->
				<div class="form" style="text-align: center;">
					<img src="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/img/trebol_80.png" alt="Clover-Team" title="Clover-team"/>
					<!--<h1 class="text-light">Ingrese sus datos</h1>-->
					<form class="form-horizontal autocomplete="off"">
						<div class="form-group">
							<div class="form-group has-feedback has-feedback-left">
								<input type="text" id="username" class="form-control" autocomplete="off" placeholder="Usuario">
								<div class="form-control-feedback">
									<i class="icon-user"></i>
								</div>
							</div>
							<div class="form-group has-feedback has-feedback-left">
								<input type="password" id="password" class="form-control" autocomplete="off" placeholder="Contraseña">
								<div class="form-control-feedback">
									<i class="icon-key"></i>
								</div>
							</div>
							<div style="color: #FA5858;" id="login-options" class="login-options">

							</div>
				  			<button type="button" id="loginBtn" class="btn btn-success">Ingresar</button>
						</div>
					</form>
				</div>
				<!-- /Login form -->
			</div>
			<div class="footer">
				<div class="pull-left">
					© 2018 Clover Team SAS&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;Smart Contact 1.0</div>
			</div>
		</div>
	</div>

<!-- Global scripts -->
<script src="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/lib/js/core/jquery/jquery.js"></script>
<script src="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/lib/js/core/jquery/jquery.ui.js"></script>
<script src="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/lib/js/core/bootstrap/bootstrap.js"></script>
<script src="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/lib/js/core/site.js"></script>
<script src="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/lib/js/core/hammer/hammerjs.js"></script>
<script src="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/lib/js/core/hammer/jquery.hammer.js"></script>
<script src="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/lib/js/core/slimscroll/jquery.slimscroll.js"></script>
<script src="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/lib/js/forms/uniform.min.js"></script>
<script src="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/lib/js/core/app/layouts.js"></script>
<script src="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/lib/js/core/app/core.js"></script>
<!-- /Global scripts -->

<!-- Page scripts -->
<script src="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/lib/js/pages/auth/authentication.js"></script>
<!-- /Page scripts -->

</body>
</html>
