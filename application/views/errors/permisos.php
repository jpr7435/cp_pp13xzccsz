<!-- Error wrapper -->
<div class="error-container text-center">
	<img src="http://<?php echo $_SERVER['HTTP_HOST'] ?>/front/img/error/503.png" class="error_img" alt=""/>
	<h1 class="text-light m-b-20">Oops, ha ocurrido un error. No tienes permiso para entrar a este sitio!</h1>

	<div class="row-fluid">
		<div class="col-lg-4 col-lg-offset-4 col-sm-6 col-sm-offset-3">
			<form action="#" class="main-search">
				<div class="row m-t-20">
					<div class="col-sm-6">
						<a href="javascript:history.back(1)" class="btn btn-danger btn-labeled btn-block"><b><i class="icon-display4"></i></b> Volver</a>
					</div>
				</div>

			</form>
		</div>
	</div>
