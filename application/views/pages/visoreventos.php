<?php
/* * To change this template, choose Tools | Templates * and open the template in the editor. */
$ci2 = &get_instance();
//$us = $ci3->load->model("usuarios");
//$ci2 = &get_instance();
$ci2 -> load -> model("vista");

$carteras = explode(";", $session['carteras']);

$fila = 0;
$pr = 0;
?>

<section class="main-container">
	<h1 style="display:none">Visor de Log de Eventos</h1>

	<!-- Page header -->
	<div class="header">
		<div class="header-content">
			<div class="page-title">
				<i class="icon-file-empty position-left"></i> Criterios de busqueda
			</div>
		</div>
	</div>
	<!-- /Page header -->

	<div class="container-fluid page-content">
		<div class="row">
			<div class="panel panel-flat">
				<div class="panel-body">
					<div class="col-lg-4">
						<div class="form-group">

							<select id="criterio" name="criterio" class="select-fixed-single">
								<optgroup label="Criterio de busqueda">
									<option value="0">Seleccione.</option>
									<option value="1">Fecha</option>
									<option value="2">Documento</option>
									<option value="3">Asesor</option>
									<option value="4">Direccion IP</option>
								</optgroup>
							</select>
						</div>
					</div>
					<div class="col-lg-7">
						<div class="form-group">
							<div class="input-group input-group-lg">
								<input class="form-control input-lg" placeholder="Valor a buscar" name="valor" id="valor" type="text">
								<span class="input-group-btn">
									<button class="btn btn-default" id="buscar-evetnos-btn" type="button">
										<i class="icon icon-search4"></i>
									</button> </span>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
		<div style="clear: both; height: 25px;"></div>
		<div class="row">
			<div class="panel panel-flat">
				<div class="panel-body">
					<div id="resultado-eventos-busqueda">

					</div>
				</div>
			</div>
		</div>
	</div>
</section>
