<?php
/* * To change this template, choose Tools | Templates * and open the template in the editor. */
$ci2 = &get_instance();
//$us = $ci3->load->model("usuarios");
//$ci2 = &get_instance();
$ci2 -> load -> model("vista");

$carteras = explode(";", $session['carteras']);

$fila = 0;
$pr = 0;

$telesize = strlen($slug);
$inter = "0";

if($telesize <= 9){
	$inter = "0";
}else{
	$inter = "1";
}

?>
<script src="https://<?php echo $this->config->item("host_cobranzas"); ?>/front/lib/js/core/tiemposCliente.js"></script>
<input type="hidden" name="tamano" id="tamano" value="<?php echo $telesize; ?>"/>
<section class="main-container">
	<h1 style="display:none">Creacion de Ticket</h1>

	<!-- Page header -->
	<div class="header">
		<div class="header-content">
			<div class="page-title">
				<i class="icon-file-empty position-left"></i> Creacion de Ticket &nbsp;&nbsp;&nbsp;&nbsp;
				<span style="font-weight: bold; color: green;">
            <span>Tiempo total de atenci&oacute;n: </span>
            <span id="hour4">00</span>
            <span class="divider">:</span>
            <span id="minute4">00</span>
            <span class="divider">:</span>
            <span id="second4">00</span>
        </span>

			</div>
		</div>
	</div>
	<!-- /Page header -->

	<div class="container-fluid page-content">

	</div>
</section>
<div id="nuevo-ticket-modal">
	<div id="nuevo-ticket-caja">
		<div class="row">
			<div class="panel panel-flat">
				<div class="panel-body">
					<div class="col-lg-6">
						<div class="form-group">

							<label>Telefono:</label>
              <input type="text" class="form-control" style="color: #000;" name="telefono" id="telefono" readonly="readonly" value="<?php echo $slug; ?>"/>
              <label>Prestamo:</label>
              <input type="text" class="form-control" name="solicitud" id="solicitud" />
              <label>DUI:</label>
              <input type="text" class="form-control" name="socio" id="socio" />
              <label>Nombre:</label>
              <input type="text" class="form-control" name="nombre" id="nombre" />
              <label>Categoria:</label>
							<select class="form-control" name="campana" id="campana">
                <option value="0">Seleccione.</option>
                <?php foreach($campaentrada as $cam){ ?>
                  <option value="<?php echo $cam['idCampana']; ?>"><?php echo $cam['idCampana']."-".$cam['descripcion'] ?></option>
                <?php } ?>
              </select>
						</div>
					</div>

					<div class="col-lg-6">
						<div class="form-group">

							<label>Gestion:</label>
              <textarea class="form-control" name="gestion-ticket" id="gestion-ticket"></textarea>
							<input type="hidden" name="subestatus-ticket" id="subestatus-ticket" value="0"/>
							<input type="hidden" name="estatus-ticket" id="estatus-ticket" value="3" />
              <input type="hidden" name="asignar-ticket" id="asignar-ticket" value="<?php echo $session['id']; ?>">
							<?php if($inter == 1){ ?>
								<label>Estado USA:</label>
								<select class="form-control" name="usa-ticket" id="usa-ticket">
	                <option value="0">Seleccione.</option>
	                <?php foreach($usa as $u){ ?>
	                  <option value="<?php echo $u['idEstado']; ?>"><?php echo $u['descripcion'] ?></option>
	                <?php } ?>
	              </select>
								<label>Como se entero:</label>
	              <select class="form-control" name="como-ticket" id="como-ticket">
	                <option value="0">Seleccione.</option>
	                <?php foreach($como as $co){ ?>
	                  <option value="<?php echo $co['idComo']; ?>"><?php echo $co['descripcion'] ?></option>
	                <?php } ?>
	              </select>
							<?php } ?>

							<input type="hidden" name="tipoLlamadaField" id="tipoLlamadaField" value="Entrada"/>
							<input type="hidden" name="idHoraInicio" id="idHoraInicio" value="<?php echo date("H:i:s"); ?>"/>
              <button id="save-ticket"  style="margin-top: 15px;" class="btn btn-success">Guardar</button>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
