<?php
/* * To change this template, choose Tools | Templates * and open the template in the editor. */
$ci2 = &get_instance();
//$us = $ci3->load->model("usuarios");
//$ci2 = &get_instance();
$ci2 -> load -> model("vista");
?>
<section class="main-container">
	<div class="container-fluid page-content">
		<div style="height: 30px;" class="clearfix"></div>
		<div class="row">
			<div class="col-md-6 col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="panel-title">
							Editar Usuario
						</div>
					</div>
					<div class="panel-body">
						<fieldset>
							<div class="form-group">
								<label class="control-label col-lg-4">Usuario <span class="text-danger">*</span></label>
								<div class="col-lg-8">
									<input type="text" readonly="readonly" class="form-control" name="usuario" id="usuario" required="required" aria-required="true" value="<?php echo $user[0]['usuario'] ?>" type="text">
								</div>
							</div>
							<div style="height: 15px;" class="clearfix"></div>
							<div class="form-group">
								<label class="control-label col-lg-4">Nombre <span class="text-danger">*</span></label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="nombre" id="nombre" required="required" aria-required="true" value="<?php echo $user[0]['nombre'] ?>" type="text">
								</div>
							</div>
							<div style="height: 15px;" class="clearfix"></div>
							<div class="form-group">
								<label class="control-label col-lg-4">Documento <span class="text-danger">*</span></label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="documento" id="documento" required="required" aria-required="true" value="<?php echo $user[0]['documento'] ?>" type="text">
								</div>
							</div>
							<div style="height: 15px;" class="clearfix"></div>
							<div class="form-group">
								<label class="control-label col-lg-4">Email <span class="text-danger">*</span></label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="documento" id="documento" required="required" aria-required="true" value="<?php echo $user[0]['email'] ?>" type="text">
								</div>
							</div>
							<div style="height: 15px;" class="clearfix"></div>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>