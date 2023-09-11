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
				<i class="icon-file-empty position-left"></i> Detalle Pagos
			</div>
		</div>
	</div>
	<!-- /Page header -->

	<div class="container-fluid page-content">
		<div class="row">
			<div class="panel panel-flat">
				<div class="panel-body">
          <table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
            <thead>
              <tr>
                <th class="footable-visible footable-first-column" data-toggle="true">Documento</th>
                <th class="footable-visible footable-first-column" data-toggle="true">Obligacion</th>
				<th class="footable-visible footable-first-column" data-toggle="true">Nombre</th>
                <th class="footable-visible footable-first-column" data-toggle="true">Fecha</th>
				<th class="footable-visible footable-first-column" data-toggle="true">Valor</th>
				<th class="footable-visible footable-first-column" data-toggle="true">Valor Banco</th>
				<th class="footable-visible footable-first-column" data-toggle="true">GAC</th>
				<th class="footable-visible footable-first-column" data-toggle="true">Territorial</th>
                <th class="footable-visible footable-first-column" data-toggle="true">Asesor</th>
              </tr>
            </thead>
						<?php foreach($totalPagos as $r){
							if($r['idAsesor'] != 0){
								$user = $ci2->vista->getusuario($r['idAsesor'], $session['proyecto_activo']);
							}else{
								$user[0]['usuario'] = "Sin Asesor";
							}

							$cli = $ci2->vista->getDataClienteDoc($r['documento'], $session['proyecto_activo']);
							$url = "http://".$_SERVER['HTTP_HOST']."/modulo_cobranzas/index.php/cliente/".$cli[0]['idCliente'];
							?>
				<tbody>
					<tr style="cursor: pointer;" 
						onclick="location.href='<?php echo $url; ?>' ">
					<td class="footable-visible footable-first-column"><?php echo $r['documento']; ?></td>
					<td class="footable-visible footable-first-column"><?php echo $r['obligacion']; ?></td>
					<td class="footable-visible footable-first-column"><?php echo $cli[0]['nombre']; ?></td>
					<td class="footable-visible footable-first-column"><?php echo $r['fecha']; ?></td>
					<td class="footable-visible footable-first-column"><?php echo number_format($r['valor'],0); ?></td>
					<td class="footable-visible footable-first-column"><?php echo number_format($r['valor_banco'],0); ?></td>
					<td class="footable-visible footable-first-column"><?php echo number_format($r['GAC'],0); ?></td>
					<td class="footable-visible footable-first-column"><?php echo $r['territorial']; ?></td>
					<td class="footable-visible footable-first-column"><?php echo $user[0]['usuario']; ?></td>
				</tr>
			</tbody>
						<?php } ?>
			</table>
				</div>
			</div>
		</div>
	</div>
</section>
