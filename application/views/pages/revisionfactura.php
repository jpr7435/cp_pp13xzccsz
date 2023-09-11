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

	<!-- Page header -->
	<div class="header">
		<div class="header-content">
			<div class="page-title">
				<i class="icon-file-empty position-left"></i> Revision Factura
			</div>
		</div>
	</div>
	<!-- /Page header -->

	<div class="container-fluid page-content">
		<div class="row">
			<div class="panel panel-flat">
				<div class="panel-heading">
					<h5 class="panel-title">Pagos que necesitan revisi&oacute;n</h5>
				</div>
				<div class="panel-body">
					<form name="revisionFac" id="revisionFac" method="post" action="http://<?php echo $this->config->item('host_cobranzas'); ?>/index.php/saverevision">
						<table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
							<thead>
								<tr>
									<th class="footable-visible footable-first-column" data-toggle="true">Documento</th>
									<th class="footable-visible footable-first-column" data-toggle="true">Obligacion</th>
									<th class="footable-visible footable-first-column" data-toggle="true">Fecha</th>
									<th class="footable-visible footable-first-column" data-toggle="true">Monto</th>
									<th class="footable-visible footable-first-column" data-toggle="true">% Honorarios</th>
									<th class="footable-visible footable-first-column" data-toggle="true">Honorarios</th>
									<th class="footable-visible footable-first-column" data-toggle="true">Tipo Pago</th>
									<th class="footable-visible footable-first-column" data-toggle="true">Gestor Supervior</th>
									<th class="footable-visible footable-first-column" data-toggle="true">Gestor Smart</th>
									<th class="footable-visible footable-first-column" data-toggle="true">Accion</th>
								</tr>
							</thead>
							<tbody>
								<?php $flag = 0; foreach($factRevision as $r){
									if($r['gestor'] != 0){
										$gestor = $ci2->vista->getusuario($r['gestor'], $session['proyecto_activo']);
									}else{
										$gestor[0]['nombre'] = "Sin Asesor";
									}

									if($r['gestorSmart'] != 0){
										$gestorSmart = $ci2->vista->getusuario($r['gestorSmart'], $session['proyecto_activo']);
									}else{
										$gestorSmart[0]['nombre'] = "Sin Asesor";
									}

									?>
									<tr>
										<td class="footable-visible footable-first-column"><?php echo $r['documento']; ?></td>
										<td class="footable-visible footable-first-column"><?php echo $r['obligacion']; ?></td>
										<td class="footable-visible footable-first-column"><?php echo $r['fecha']; ?></td>
										<td class="footable-visible footable-first-column"><?php echo number_format($r['monto'],0); ?></td>
										<td class="footable-visible footable-first-column"><?php echo $r['porchonorarios']; ?></td>
										<td class="footable-visible footable-first-column"><?php echo $r['honorarios']; ?></td>
										<td class="footable-visible footable-first-column"><?php echo $r['tipopago']; ?></td>
										<td class="footable-visible footable-first-column"><?php echo $gestor[0]['nombre']; ?></td>
										<td class="footable-visible footable-first-column"><?php echo $gestorSmart[0]['nombre']; ?></td>
										<td class="footable-visible footable-first-column">
											<select name="revision<?php echo $flag; ?>" id="revision<?php echo $flag; ?>" class="form-control">
												<option value="<?php echo $r['idFactura']."-0"; ?>">Sin Asesor</option>
												<?php foreach($usPr as $up){ ?>
													<option value="<?php echo $r['idFactura']."-".$up['idUsuario']; ?>"><?php echo $up['nombre']; ?></option>
												<?php } ?>
											</select>
										</td>
									</tr>
									<?php $flag += 1; } ?>
									<?php if($flag > 0){ ?>
									<tr>
										<td colpsan="10" style="text-align: right;"><button type="submit" class="btn btn-success">Guardar revision</button></td>
									</tr>
								<?php } ?>
								</tbody>
							</table>
							<input type="hidden" name="total" id="total" value="<?php echo $flag; ?>"/>
						</form>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="panel panel-flat">
					<div class="panel-heading">
						<h5 class="panel-title">Pagos ajustados automaticamente</h5>
					</div>
					<div class="panel-body">
						<table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
							<thead>
								<?php if($flag == 0){ ?>
									<tr>
										<form name="calcula-factura" id="calcula-factura" action="https://<?php echo $this->config->item("host_cobranzas"); ?>/index.php/generarcalculo" method="post">
											<input type="hidden" name="codigoFac" id="codigoFac" value="<?php echo $codigo; ?>"/>
										</form>
										<form name="exporta-factura" id="exporta-factura" action="https://<?php echo $this->config->item("host_cobranzas"); ?>/index.php/exportarfactura" method="post">
											<input type="hidden" name="codigoFac" id="codigoFac" value="<?php echo $codigo; ?>"/>
										</form>
										<td colpsan="10" style="text-align: right;"><button type="button" id="calcular-factura" class="btn btn-success">Generar calculo</button></td>
										<td colpsan="10" style="text-align: right;"><button type="button" id="exportar-factura" class="btn btn-success">Exportar tabla</button></td>
									</tr>
								<?php } ?>
								<tr>
									<th class="footable-visible footable-first-column" data-toggle="true">Documento</th>
									<th class="footable-visible footable-first-column" data-toggle="true">Obligacion</th>
									<th class="footable-visible footable-first-column" data-toggle="true">Fecha</th>
									<th class="footable-visible footable-first-column" data-toggle="true">Monto</th>
									<th class="footable-visible footable-first-column" data-toggle="true">% Honorarios</th>
									<th class="footable-visible footable-first-column" data-toggle="true">Honorarios</th>
									<th class="footable-visible footable-first-column" data-toggle="true">Tipo Pago</th>
									<th class="footable-visible footable-first-column" data-toggle="true">Gestor Supervior</th>
									<th class="footable-visible footable-first-column" data-toggle="true">Gestor Smart</th>
								</tr>
							</thead>
							<?php foreach($factura as $r){
								if($r['gestor'] != 0){
									$gestor = $ci2->vista->getusuario($r['gestor'], $session['proyecto_activo']);
								}else{
									$gestor[0]['nombre'] = "Sin Asesor";
								}

								if($r['gestorSmart'] != 0){
									$gestorSmart = $ci2->vista->getusuario($r['gestorSmart'], $session['proyecto_activo']);
								}else{
									$gestorSmart[0]['nombre'] = "Sin Asesor";
								}

								?>
								<tbody>
									<tr>
										<td class="footable-visible footable-first-column"><?php echo $r['documento']; ?></td>
										<td class="footable-visible footable-first-column"><?php echo $r['obligacion']; ?></td>
										<td class="footable-visible footable-first-column"><?php echo $r['fecha']; ?></td>
										<td class="footable-visible footable-first-column"><?php echo number_format($r['monto'],0); ?></td>
										<td class="footable-visible footable-first-column"><?php echo $r['porchonorarios']; ?></td>
										<td class="footable-visible footable-first-column"><?php echo $r['honorarios']; ?></td>
										<td class="footable-visible footable-first-column"><?php echo $r['tipopago']; ?></td>
										<td class="footable-visible footable-first-column"><?php echo $gestor[0]['nombre']; ?></td>
										<td class="footable-visible footable-first-column"><?php echo $gestorSmart[0]['nombre']; ?></td>
									</tr>
								</tbody>
							<?php } ?>
						</table>
					</div>
				</div>
			</div>

		</div>
		<div id="respuesta"></div>
	</section>
