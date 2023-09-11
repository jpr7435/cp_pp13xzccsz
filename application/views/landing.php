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
	<h1 style="display:none">Seleccione un Proyecto</h1>

	<!-- Page header -->
	<div class="header">
		<div class="header-content">
			<div class="page-title">
				<i class="icon-file-empty position-left"></i> Seleccione un proyecto
			</div>
		</div>
	</div>
	<!-- /Page header -->

	<div class="container-fluid page-content">
		<div class="panel panel-flat">
			<div class="panel-body">

				<!-- Current stocks -->
				<?php foreach($carteras as $ca){

					$prUno = $ci2->vista->getProyectData($carteras[$pr]);
					
					if($fila == 0){
						echo '<div class="row">';
					}
				?>
				<div  class="col-md-4 col-sm-6 prBox" cartera="<?php echo $prUno[0]['descripcion']; ?>" style="cursor: pointer;">
					<div class="panel panel-flat">
						<div class="panel-heading no-padding-bottom">
							<h5 class="text-uppercase text-semibold no-margin-top"><?php echo $prUno[0]['descripcion']; ?></h5>
						</div>
						<div style="min-height: 100px;" class="panel-body">
							<div style="text-align: center;" class="row">
								<img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/carteras/<?php echo $prUno[0]['descripcion']; ?>.png" style="width: 180px;" title="<?php echo $prUno[0]['descripcion']; ?>" alt="<?php echo $prUno[0]['descripcion']; ?>"/>
							</div>
						</div>
					</div>
				</div>
				<?php

				$fila += 1;
				$pr += 1;
					if ($fila == 3) {
						echo '</div>';
						$fila = 0;
					}

				}
				?>
				<!-- /Current stocks -->
			</div>
		</div>
	</div>
</section>
<!-- /Page Container ends -->

<!--main-container-part
<div id="content" style="margin-left: 0px !important;">
<div id="content-header">
<h1>Seleccion un proyecto para inciar:</h1>
</div>
<div class="container-fluid">
<hr>

<div class="span4 prBox" cartera="<?php echo $prUno[0]['descripcion']; ?>" style="cursor: pointer;">
<div class="widget-box">
<div class="widget-title">
<span class="icon"> <i class="icon-eye-open"></i> </span>
<h5><?php echo $prUno[0]['descripcion']; ?><
/h5>
</div>
<div class="widget-content" style="text-align: center;">
<img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/carteras/<?php echo $prUno[0]['descripcion']; ?>.png" title="<?php echo $prUno[0]['descripcion']; ?>" alt="<?php echo $prUno[0]['descripcion']; ?>"/>
</div>
</div>
</span>
</div>

</div>
</div>
